<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://unpkg.com/gojs/release/go-debug.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    <main class="">
        <div class="wrapper">
            <nav id="sidebar">
                <ul class="list-unstyled components">

                    <li class="active">
                        <a href="{{ route('admin.maintenance') }}">Maintenance</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}">Users</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payments') }}">Payments</a>
                    </li>
                </ul>
            </nav>


            <div class="main-part">
                <div class="container-fluid">
                    <div class="row">
                        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm col-md-12">
                            <div class="container">
                                <button class="navbar-toggler" type="button" id="sidebarCollapse"
                                        aria-controls="navbarSupportedContent" aria-expanded="false"
                                        aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <a class="navbar-brand" href="{{ url('/') }}">
                                    {{ config('app.name', 'Laravel') }}
                                </a>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                    <!-- Right Side Of Navbar -->
                                    <ul class="navbar-nav ml-auto">
                                        <!-- Authentication Links -->
                                        @guest
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                            @if (Route::has('register'))
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            @endif
                                        @else

                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('home') }}">{{ __('Member dashboard') }}</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('prototype') }}">{{ __('Prototype') }}</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </li>
                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>


                <div id="content" class="container m-4 p-4">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-primary" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@stack('scripts')

<script>
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

    });
</script>
</body>
</html>
