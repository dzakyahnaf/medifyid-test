<form method="POST">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Kategori</label>
        <input type="text" class="form-control" name="kode" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <button class="btn btn-primary mt-3">
        <i class="bi bi-check-circle"></i> Submit
    </button>

</form>
