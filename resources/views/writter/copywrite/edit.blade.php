@extends('writter.template.main')
@section('title','Writter Dashboard')

@section('page-name','Copywriter')


@section('content')
<form id="form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Nama Produk : </label>
                        <input type="text" name="nama_produk" class="form-control" value="{{ $product->nama_produk }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Deskripsi : </label>
                        <textarea name="description" id="editor"
                            class="form-control">{!! $product->deskripsi !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label>Upload Gambar</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>
            <p class="text-center mt-4 fw-bold">Gambar Sebelumnya</p>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Aksi</th>
                        <th scope="col">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($images as $image)
                    <tr>
                        <th scope="row"><button class="btn btn-danger" type="button"
                                onclick="deleteImg('{{$image->id}}')"><i class="fas fa-trash"></i></button></th>
                        <td><img src="{{ asset('/storage/product/'.$image->name) }}" class="img-fluid"
                                style="max-height:200px;width:auto;"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $images->links() !!}
        </div>
    </div>
    <button class="btn btn-primary" type="submit" name="submit" id="submit">submit</button>
    <img src="{{ asset('loader.gif') }}" style="width: 50px;height: 50px; display: none;" id="loader">
</form>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script>
    function deleteImg(id) {
        swal({
            title: "Yakin?",
            text: "Apakah anda ingin menghapus gambar ini?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('writter.product.image.delete') }}",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function (data) {
                            swal({
                                title: "Success",
                                text: "Gambar berhasil dihapus",
                                icon: "success",
                            });
                            setInterval(function () {
                                location.reload();
                            }, 2000);
                        },
                        error: function (data) {
                            swal({
                                title: "Error",
                                text: "Gambar gagal dihapus",
                                icon: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Cancel",
                        text: "Gambar batal dihapus",
                        icon: "error",
                    });
                }
            });
    }
    $(document).ready(function () {

        CKEDITOR.replace('editor');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form').submit(function (e) {
            e.preventDefault();
            $('.err').remove();
            $('#submit').attr('disabled', true);
            // replace editor with id editor
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances.editor.updateElement();
            }
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('writter.product.edit',$product->id) }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loader').show();
                },
                success: (data) => {
                    $('#loader').hide();
                    this.reset();
                    swal({
                        title: "Succes",
                        text: "Data Berhasil Disimpan",
                        icon: "success",
                    });
                    setInterval(function () {
                        location.reload();
                    }, 2000);
                },
                error: function (err) {
                    $('#submit').attr('disabled', false);
                    if (err.status == 422) {
                        swal({
                            title: "Error",
                            text: "Terjadi Kesalahan",
                            icon: "error",
                        });
                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="err" style="color: red;">' + error[0] + '</span>'));
                        });
                    } else if (err.status == 500) {
                        swal({
                            title: "Error",
                            text: "Kesalahan Server",
                            icon: "error",
                        });
                    }
                    $('#loader').hide();
                }

            });


        });
    });
</script>
@endsection
