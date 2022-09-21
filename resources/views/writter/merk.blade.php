@extends('writter.template.main')
@section('title','Writter Dashboard')

@section('page-name','Merk Page')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}" />
@endsection

@section('content')
<!-- Button trigger modal -->
<button type="button" class="mb-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
    <i class="fas fa-plus"></i>&nbsp;Data
</button>

<table class="table" id="table">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Merk</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($merks as $result)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $result->name }}</td>
            <td>
                <button class="btn btn-primary" type="button"><i class="fas fa-pen"></i></button>
                <button type="button" class="btn btn-danger" onclick="deleteData()"><i
                        class="fas fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-group">
                        <label>Nama Merk</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <img src="{{ asset('loader.gif') }}" style="width: 50px;height: 50px; display: none;"
                            id="loader">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->



@endsection


@section('js')
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function deleteData(id) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route("writter.merk.delete") }}',
                        type: 'POST',
                        data: {
                            'id': id,
                        },
                        success: function (data) {
                            swal({
                                'title': 'Success',
                                'text': 'Data Berhasil Dihapus',
                                'icon': 'success'
                            });
                            setInterval(function () {
                                location.reload();
                            }, 2000);
                        },
                    })
                } else {
                    swal({
                        'title': 'Cancel',
                        'text': 'Data Batal Dihapus',
                        'icon': 'error'
                    });
                }
            });
    }
    $(document).ready(function () {
        $('#table').DataTable();
    });
    $('#loader').hide();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#form').submit(function (e) {
        e.preventDefault();
        $('.err').remove();
        $('#submit').attr('disabled', true);
        $.ajax({
            url: "{{ route('writter.merk.insert') }}",
            type: "POST",
            data: $('#form').serialize(),
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (response) {
                swal({
                    'title': 'Success',
                    'text': 'Berhasil Menambahkan Data',
                    'icon': 'success'
                });
                setInterval(function () {
                    location.reload();
                }, 2000);
            },
            error: function (error) {
                $('#submit').attr('disabled', false);
                if (error.status == 422) {
                    swal({
                        'title': 'Error',
                        'text': 'Error Validasi',
                        'icon': 'error'
                    });
                    $.each(error.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span style="color:red;" class="err">' + error[0] + '</span>'));
                    });
                } else if (error.status == 500) {
                    swal({
                        'title': 'Error',
                        'text': 'Kesalahan Server',
                        'icon': 'error'
                    });
                } else {
                    swal({
                        'title': 'Error',
                        'text': error.responseJSON.message,
                        'icon': 'error'
                    });
                }
                $('#loader').hide();
            }
        });
    });
</script>
@endsection
