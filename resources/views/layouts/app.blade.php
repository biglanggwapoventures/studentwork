<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('fancybox/jquery.fancybox.min.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fancybox/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-success navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if(Auth::user()->isRole('admin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('advisers') }}">Teachers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('areas') }}">Areas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('projects') }}">Projects</a>
                                </li>
                            @endif

                            @if(Auth::user()->isRole('student'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('my-projects') }}">My Projects</a>
                                </li>
                            @endif

                            @if(Auth::user()->isRole('adviser'))
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ url('my-handled-projects') }}">Handled Projects</a>
                                </li>
                            @endif

                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }} <span class="caret"></span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">
                                       My Profile
                                    </a>
                                    <form id="logout-form" action="{{ url('logout') }}">
                                        <a class="dropdown-item" href="#" onclick="confirmLogout()" class="text-danger">
                                            Logout
                                        </a>
                                    </form>
                                    
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(session('loginMessage'))
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        {{ session('loginMessage') }}
                    </div>
                </div>
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>
</body>
@stack('js')
<script>
    function confirmLogout() {
    var x = confirm("Are you sure you want to logout?");
        if (x){
            $("#logout-form").submit();
        }
        else {
            return;
        }
    }
</script>
</html>
