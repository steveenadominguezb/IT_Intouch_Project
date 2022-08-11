<!doctype html>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IT Inventory') }}</title>
    <link href="{{ asset('css/styleIndex.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,600;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{ asset('img/247logo1.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
    <section class="header">
        <nav>
            <a href="index.html"><img src="{{ asset('img/247logo1.png') }}"></a>
        </nav>

        <div class="text-box">
            <h1>IT</h1>
            <p>For storage management</p>
            <a href="#login-col" class="hero-btn">Login</a>
        </div>
    </section>
    <section class="login">
        <h1 class="ITLogo">IT Inventory</h1>
        <div class="row">
            <div class="login-col" id="login-col">
                <h1>Log In</h1>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h3 for="username">{{ __('Username: ') }}

                        <input id="username" type="text" placeholder="Enter your username"
                            style="align-content: center" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autocomplete="username">

                        <div class="">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </h3>
                    <h3 for="password">{{ __('Password: ') }}

                        <input id="password" type="password" placeholder="Enter your password"
                            style="align-content: center" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </h3>

                    <p>If you forgot your password, please contact the support manager</p>
                    <button type="submit" class="btn-log">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
            <div class="login-col">
                <h1>Registration</h1>
                <p>If you want to start your registration in the application, please contact the support administrator
                </p>
            </div>
        </div>
    </section>
    <section id="footer" class="footer">
        <h4>About Us</h4>
        <p>24-7 Intouch is a global customer care and technology company, providing value-driven solutions for over 20
            years.</p>
        <div class="icons">
            <a href="https://www.facebook.com/247intouch/"> <i class="fa fa-facebook"></i></a>
            <a href="https://twitter.com/247intouch"><i class="fa fa-twitter"></i></a>
            <a href="https://www.instagram.com/24_7intouch/"><i class="fa fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/24-7-intouch"><i class="fa fa-linkedin"></i></a>
        </div>
        <p>Made with <i class="fa fa-heart-o"></i> by Steveen Dominguez & Virginia Pe&ntilde;a</p>
    </section>
</body>
<script>
    $(document).ready(function() {
        $('a[href^="#"]').click(function() {
            var destino = $(this.hash); //this.hash lee el atributo href de este
            $('html, body').animate({
                scrollTop: destino.offset().top
            }, 700); //Llega a su destino con el tiempo deseado
            return false;
        });
    });
</script>

</html>
