@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-items/form/new')}}" class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> Master Items Baru
                </a>
                <a href="{{url('master-items/export-csv')}}" class="btn btn-success">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Download CSV/Excel
                </a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Master Items</div>

                <div class="card-body">
                    @include('master_items.index.filter')
                    @include('master_items.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('master_items.index.js')
@endsection
