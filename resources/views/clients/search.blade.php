<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Asisten Marketing</title>
    <link href="{{ asset('clients/assets/images/logokuning.png') }}" rel="icon">
    <link href="{{ asset('clients/assets/images/logokuning.png') }}" rel="apple-touch-icon">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('clients/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('clients/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('clients/assets/css/templatemo-space-dynamic.css') }}">
    <link rel="stylesheet" href="{{ asset('clients/assets/css/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('clients/assets/css/owl.css') }}">

    <!---->
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            <img src="{{ asset('clients/assets/images/logoasistenmarketing.png') }}" alt="">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="{{ route('clients.index') }}"
                                    class="{{ (url()->current() == route('clients.index')) ? 'active' : '' }}">Home</a>
                            </li>
                            <li class="scroll-to-section"><a href="{{ route('clients.search.index') }}"
                                    class="{{ (url()->current() == route('clients.search.index')) ? 'active' : '' }}">Cari
                                    Barang</a>
                            </li>
                            <li class="scroll-to-section"><a href="#services"
                                    class="btn btn-warning text-white rounded px-3 py-0">Login</a>
                            </li>
                            <!-- <li class="scroll-to-section"><a href="#portfolio">Pilihan</a></li> -->
                            <!-- <li class="scroll-to-section"><a href="#contact">Pesan</a></li> -->
                            <li class="scroll-to-section">
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- content -->
    <div class="container" style="margin-top:110px;">
        <div class="row">
            <div class="col-md-12">
                <div class="card py-3 box-shadow" style="border: none;">
                    <form id="search">
                        <div class="container">
                            <label>Cari barang</label>
                            <div class="row">
                                <div class="col-lg-10">
                                    <input type="text" name="keyword" id="" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" name="submit" id="submit"
                                        class="btn btn-warning text-white">Cari</button>
                                </div>
                            </div>
                            <div class="text-center" id="loader" style="display: none;">
                                <img src="{{ asset('loader2.gif') }}" style="width: 50px;height: 50px;">
                            </div>
                        </div>
                    </form>
                    <div class="container mt-3" id="result">

                    </div>
                </div>
            </div>
        </div>
        <!-- content -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.25s">
                        <p>© Copyright 2022 AsistenMarketing.com. All Rights Reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="{{ asset('clients/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('clients/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('clients/assets/js/owl-carousel.js') }}"></script>
        <script src="{{ asset('assets/js/animation.js') }}"></script>
        <script src="{{ asset('clients/assets/js/imagesloaded.js') }}"></script>
        <script src="{{ asset('clients/assets/js/templatemo-custom.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#search').submit(function (e) {
                    $('.result').remove();
                    e.preventDefault();
                    var search = $('input[name=keyword]').val();
                    $.ajax({
                        url: "{{ route('clients.search.query') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            keyword: search
                        },
                        beforeSend: function () {
                            $('#loader').show();
                            $('#submit').attr('disabled', true);
                        },
                        success: function (data) {
                            $('#loader').hide();
                            $('#submit').attr('disabled', false);
                            if (jQuery.isEmptyObject(data)) {
                                console.log(data);
                                $('#result').append(
                                    '<div class="result"><h3 class="text-center">Tidak ada hasil</h3></div>'
                                );
                            } else {
                                $.each(data.data, function (index, value) {
                                    console.log(value.nama_produk);
                                    $('#result').append(
                                        '<div class="row mt-2 result">' +
                                        '<div class="col-md-12">' +
                                        '<div class="card box-shadow" style="border: none;height:auto;max-height:250px">' +
                                        '<div class="container">' +
                                        '<div class="row">' +
                                        '<div class="col-md-3">' +
                                        '<img src="{{ asset("storage/product/") }}/' + value.image + '" alt="" style="width: auto; max-height: 40%;">' +
                                        '</div>' +
                                        '<div class="col-md-9">' +
                                        '<h3>' + value.nama_produk + '</h3>' +
                                        '<p>' + value.deskripsi + '.......</p><br/>' +
                                        '<a href="{{ route("clients.detail", "") }}/' + value.id + '" class="btn btn-warning text-white">Detail</a>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>'
                                    );
                                });
                            }
                        }
                    });
                });
            });
        </script>

</body>

</html>
