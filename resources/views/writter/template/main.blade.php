@php
$writter = DB::table('writters')->where('id',session('writterId'))->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') &mdash; asistenmarketing.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <script src="https://kit.fontawesome.com/1d954ea888.js"></script>
    @yield('style')

</head>

<body>
    <div id="app">
        @include('writter.template.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="row justify-content-between">
                    <div class="col-xl-4">
                        <h3>@yield('page-name')</h3>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-end">{{ $writter->name }}</p>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>@yield('page-name')</h4>
                            </div>
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>&copy; 2022 asistenmarketing.com</p>
                </div>
                <div class="float-end">

                </div>
            </div>
        </footer>
    </div>
    </div>
    <!-- <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @yield('js')


</body>

</html>
