<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/preloader.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}" media="screen,projection" />
    <link rel="icon" href="{{ asset('img/247logo1.ico') }}">

    <style>
        .box1 {
            margin-left: 10%;
            width: 35%;
            display: inline-block;
        }

        .box2 {
            margin-left: 10%;
            width: 35%;
            display: inline-block;
            justify-items: center;
        }

        .but-register {
            margin: auto;
            margin-top: 5%;
            width: 25%;
        }

        .father {
            height: 100%;
            margin-top: 15%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-login {
            /* background-color: #b7e4c7; */
            padding: 50px;
            border: lightcyan;
            border-radius: 30px;
        }

        .login {
            margin-right: 20px;
        }
    </style>
</head>

<body>
    <div class="content_preloader" id="content_preloader">
        <div class="preloader-wrapper big active big">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="app" id="app">
        <div class="back_menu" id="back_menu"></div>
        <nav class="navegation" id="navegation">
            <a class="navegation-brand" href="{{ url('/home') }}">
                IT-Intouch
            </a>

            @guest
            @else
                @if (Auth::user()->privilege == 10001)
                    <a class="navegation-link" href="{{ route('computers.list') }}">{{ __('Computers') }}</a>
                    <a class="navegation-link" href="{{ route('users.list') }}">{{ __('Users') }}</a>
                    <a class="navegation-link" href="/attrition">{{ __('Attrition') }}</a>
                @endif
            @endguest
            @guest
                @if (Route::has('login'))
                    <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif
            @else
                <a id="navbarDropdown" class="navegation-user dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="{{ url('/home') }}" class="dropdown-item">Home</a>
                    @if (Auth::user()->privilege == 10001)
                        <a class="dropdown-item" href="{{ route('register-employee.index') }}" onclick="">
                            {{ __('Register Employee') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('register-computer.index') }}" onclick="">
                            {{ __('Register Computer') }}
                        </a>
                    @endif

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endguest
        </nav>
        <nav class="navegation-responsive" id="navegation-responsive">
            <a class="navegation-brand" href="{{ url('/home') }}">
                IT-Intouch
            </a>
            <button class="icon-menu" id="icon-menu"><i class="material-icons">menu</i></button>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
</body>

</html>
