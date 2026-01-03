@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{url('kategori-items')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Detail Kategori</div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="200">Kode</th>
                            <td>:</td>
                            <td>{{$data->kode}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                    </table>
                    <a class="btn btn-info" href="{{url('kategori-items/form/edit')}}/{{$data->id}}">Edit</a>
                    <a class="btn btn-danger" href="{{url('kategori-items/delete')}}/{{$data->id}}" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Delete</a>
                    <a class="btn btn-success" href="{{url('kategori-items/download-pdf')}}/{{$data->kode}}">
                        <i class="bi bi-file-pdf"></i> Download PDF
                    </a>

                    <hr class="my-4">

                    <h5>Master Items dengan Kategori ini</h5>
                    @if($data->masterItems->count() > 0)
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Item</th>
                                    <th>Harga Beli</th>
                                    <th>Supplier</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->masterItems as $item)
                                <tr>
                                    <td>{{$item->kode}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                    <td>{{$item->supplier}}</td>
                                    <td>
                                        <a href="{{url('master-items/view')}}/{{$item->kode}}" class="btn btn-md btn-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Belum ada master item dengan kategori ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
