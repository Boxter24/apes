<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'APES') }}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- Styles -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">        
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">        

        <!-- Iconos -->
        <script src="https://kit.fontawesome.com/72ffbb4e9b.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    </head>
    <body>
        <header>
            <nav class="nav">
                <div class="container">
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                        <a class="nombre_logo" href="#">APES</a>
                    </div>
                    @if (Route::has('login'))
                        <div id="mainListDiv" class="main_list">                            
                            <ul class="navlinks">
                                @auth
                                    <li><a href="{{ url('/home') }}">Home</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Registrarme</a></li>
                                    @endif
                                    <li><a href="#">¿Quiénes Somos?</a></li>
                                @endauth                                
                            </ul>
                        </div>
                    @endif
                    <span class="navTrigger">
                        <i></i>
                        <i></i>
                        <i></i>
                    </span>
                </div>
            </nav>       
        </header>
        <main class="main">
            
        </main>

        <!-- Script -->
        <script src="{{ asset('js/welcome.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>                                       
    </body>
</html>
