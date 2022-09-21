@extends('writter.template.main')
@section('title','Writter Dashboard')

@section('page-name','Dashboard')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}" />
@endsection

@section('content')
<a href="{{ route('writter.product.insert') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i>&nbsp;Data</a>
<table class="table" id="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Merk</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $result)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $result->nama_produk }}</td>
            <td>{{ $result->id_merk }}</td>
            <td>
                <a href="" class="btn btn-primary"><i class="fas fa-info"></i></a>
                <a href="{{ route('writter.product.edit',$result->id) }}" class="btn btn-warning"><i
                        class="fas fa-pen"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection


@section('js')
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>
@endsection
