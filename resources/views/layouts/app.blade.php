<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'APES') }}</title>

    <!-- Scripts -->    
    <script src="{{ asset('js/app.js') }}" defer></script>                

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->           
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet"> 
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body>
    <header>
        <nav class="nav">
            <div class="container">
                <div class="logo">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    <a class="nombre_logo" href="#">APES</a>
                </div>                                
                <div id="mainListDiv" class="main_list">                     
                    <!-- Right Side Of Navbar -->
                    <ul class="navlinks">
                        <!-- Authentication Links -->
                        @guest
                            <li>
                                <a href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}">{{ __('Registrarme') }}</a>
                                </li>
                            @endif     
                                <li>
                                    <a href="">¿Quiénes Somos?</a>
                                </li>                       
                        @else
                            <li>
                                <a>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <span class="navTrigger">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </div>
        </nav>
    </header>
    <main class="main py-4">
        @yield('content')
    </main>
    

    <!-- Script -->
    <script src="{{ asset('js/welcome.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>                                       
</body>
</html>