<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <optio @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <optio @if($selected == 'Umum') selected @endif>Umum</option>
            <optio @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group">
        <label>Foto</label>
        @if($method == 'edit' && isset($item->foto) && $item->foto)
            <div class="mb-2">
                <img src="{{asset('uploads/master_items/' . $item->foto)}}" alt="Foto Item" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                <p class="text-muted small">Foto saat ini</p>
            </div>
        @endif
        <input type="file" class="form-control" name="foto" accept="image/*">
        <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Max: 2MB</small>
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <div class="border p-2" style="max-height: 200px; overflow-y: auto;">
            @if(count($kategori_items) > 0)
                @foreach($kategori_items as $kategori)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kategori_items[]"
                               value="{{$kategori->id}}" id="kategori_{{$kategori->id}}"
                               @if($method == 'edit' && $item->kategoriItems->contains($kategori->id)) checked @endif>
                        <label class="form-check-label" for="kategori_{{$kategori->id}}">
                            {{$kategori->kode}} - {{$kategori->nama}}
                        </label>
                    </div>
                @endforeach
            @else
                <p class="text-muted small mb-0">Belum ada kategori. <a href="{{url('kategori-items/form/new')}}" target="_blank">Buat kategori baru</a></p>
            @endif
        </div>
        <small class="form-text text-muted">Pilih satu atau lebih kategori untuk item ini</small>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
