<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        // Filter harga - handle berbagai kombinasi harga min dan max
        if (!empty($hargamin) && !empty($hargamax)) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin)
                                       ->where('harga_beli', '<=', $hargamax);
        } elseif (!empty($hargamin)) {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategori_items'] = \App\Models\KategoriItem::all();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($data_item->foto && file_exists(public_path('uploads/master_items/' . $data_item->foto))) {
                unlink(public_path('uploads/master_items/' . $data_item->foto));
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $kode . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/master_items'), $fileName);
            $data_item->foto = $fileName;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        // Sync kategori items
        if ($request->has('kategori_items')) {
            $data_item->kategoriItems()->sync($request->kategori_items);
        } else {
            $data_item->kategoriItems()->sync([]);
        }

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::find($id);

        // Delete foto if exists
        if ($item->foto && file_exists(public_path('uploads/master_items/' . $item->foto))) {
            unlink(public_path('uploads/master_items/' . $item->foto));
        }

        $item->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }

    public function exportCsv()
    {
        $items = MasterItem::with('kategoriItems')->orderBy('id')->get();

        $filename = 'master_items_' . now()->format('YmdHis') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');

            // Set BOM untuk UTF-8 agar karakter Indonesia ditampilkan dengan benar di Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Tambahkan separator hint agar Excel tahu menggunakan semicolon
            fwrite($file, "sep=;\n");

            // Header CSV dengan semicolon sebagai delimiter
            fputcsv($file, ['No', 'Nama Kategori', 'Nama Item', 'Supplier', 'Harga', 'Laba (%)', 'Harga Jual'], ';');

            // Data rows
            $no = 1;
            foreach ($items as $item) {
                // Ambil semua nama kategori, dipisahkan dengan koma
                $kategori_names = $item->kategoriItems->pluck('nama')->implode(', ');
                if (empty($kategori_names)) {
                    $kategori_names = '-';
                }

                // Hitung harga jual
                $harga_jual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

                fputcsv($file, [
                    $no++,
                    $kategori_names,
                    $item->nama,
                    $item->supplier,
                    $item->harga_beli,
                    $item->laba,
                    round($harga_jual)
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
