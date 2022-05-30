@php
    $colores = DB::table('colores')
    ->first();    
@endphp


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'APES') }}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SCRIPT -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet"> 
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet"> 
        <script src="{{ asset('js/app.js') }}" defer></script> 
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- Styles -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">        
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">           
        <link href="{{ asset('css/redes_sociales.css') }}" rel="stylesheet">       
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">                 

        <!-- Iconos -->
        <script src="https://kit.fontawesome.com/72ffbb4e9b.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/detalles/'.$detalles->logo_institucion) }}">
    </head>
    <body>        
        <div id="app">
            <div class="loader" style="{{ $colores->color }}"><img src="{{ asset('img/logo.png') }}"></div>            
            <header>
                <nav class="nav">
                    <div class="container">
                        <div class="logo">
                            <img src="{{ asset('img/detalles/'.$detalles->logo_institucion) }}" alt="Logo">
                            <a class="nombre_logo" href="#">{{ $detalles->nombre_institucion }}</a>
                        </div>
                        @if (Route::has('login'))
                            <div id="mainListDiv" class="main_list">                            
                                <ul class="navlinks">
                                    @auth
                                        @if(Auth::user()->tipo == "admin")
                                            <li><a href="{{ url('/home') }}">Home</a></li>
                                        @else
                                            <li><a href="{{ url('/inicio') }}">Home</a></li>
                                        @endif                                            

                                        <li><option-navbar></option-navbar></li>
                                            
                                        <li><a style="hover: rgb(65, 3, 15)" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        
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
            <main class="mainFondo">
                <div class="content-wrapper main">            
                    <!--MAIN CONTENT-->
                    <div class="content">
                        <div class="container-fluid">                                
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </main>                
            <footer class="footer-section">
                <div class="container">
                    <div class="footer-cta pt-5 pb-5">
                        <div class="row">
                            <div class="col-xl-4 col-md-4 mb-30">
                                <div class="single-cta">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="cta-text">
                                        <h4>Encuéntranos</h4>
                                        <span>{{ $detalles->direccion_institucion }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-30">
                                <div class="single-cta">
                                    <i class="fas fa-phone"></i>
                                    <div class="cta-text">
                                        <h4>LLámanos</h4>
                                        <span>{{ $detalles->telefono_institucion }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 mb-30">
                                <div class="single-cta">
                                    <i class="far fa-envelope-open"></i>
                                    <div class="cta-text">
                                        <h4>Correo Electrónico</h4>
                                        <span>{{ $detalles->correo_institucion }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    <div class="footer-content pt-5 pb-5">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 mb-50">
                                <div class="footer-widget">
                                    <div class="footer-logo mt-2">
                                        <a href="/"><img src="{{ asset('img/detalles/'.$detalles->logo_institucion) }}" class="img-circle elevation-4" alt="logo"></a>
                                    </div>
                                    <div class="footer-text">
                                        <p>{{ $detalles->descripcion_institucion }}</p>
                                    </div>
                                    <div class="footer-social-icon">
                                        <span>Siguenos</span>
                                        <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                        <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                                        <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                <div class="footer-widget">
                                    <div class="footer-widget-heading">
                                        <h3>Servicios</h3>
                                    </div>
                                    <ul>
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">about</a></li>
                                        <li><a href="#">services</a></li>
                                        <li><a href="#">portfolio</a></li>
                                        <li><a href="#">Contact</a></li>
                                        <li><a href="#">About us</a></li>
                                        <li><a href="#">Our Services</a></li>
                                        <li><a href="#">Expert Team</a></li>
                                        <li><a href="#">Contact us</a></li>
                                        <li><a href="#">Latest News</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                                <div class="footer-widget">
                                    <div class="footer-widget-heading">
                                        <h3>Subscríbete</h3>
                                    </div>
                                    <div class="footer-text mb-25">
                                        <p>Envíanos un correo si tienes alguna duda o iquietud.</p>
                                    </div>
                                    <div class="subscribe-form">
                                        <form action="#">
                                            <input type="text" placeholder="Email Address">
                                            <button><i class="fab fa-telegram-plane"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-area">
                    <div class="container">
                        <div class="row">
                            <div class="text-center text-lg-left">
                                <div class="copyright-text">
                                    <p>Copyright &copy; 2022, All Right Reserved</p>
                                </div>
                            </div>
                            <div class="text-center text-lg-right">
                                <div class="footer-menu">
                                    <ul>
                                        <li><a href="#">Home</a></li>
                                        <li class="margin-ul"><a href="#">Términos</a></li>
                                        <li class="margin-ul"><a href="#">Privacidad</a></li>
                                        <li class="margin-ul"><a href="#">Política</a></li>
                                        <li class="margin-ul"><a href="#">Contacto</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>             
        </div>   
        <!--<div class="redes_sociales">
            <ul class="ul">
                <li>
                    <a href="javascript:void(0);" target="_blank" title="Facebook" class="links fa fa-facebook"></a>
                </li>
                
                <li>
                    <a href="javascript:void(0);" target="_blank" title="Twitter" class="links fa fa-twitter"></a>
                </li>
                
                <li>
                    <a href="javascript:void(0);" target="_blank" title="Instagram" class="links fa fa-instagram"></a>
                </li>
                
                <li>
                    <a href="javascript:void(0);" target="_blank" title="Google +" class="links fa fa-google"></a>
                </li>
                
                <li>
                    <a href="javascript:void(0);" target="_blank" title="Email" class="links fa fa-envelope"></a>
                </li>
            </ul>
        </div> -->   
        <!-- Script -->
        <script src="{{ asset('js/welcome.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>                                       
        <script type="text/javascript">                        
            $(window).on('load', function(){
                $(".loader").fadeOut("slow");
            });
        </script>       
    </body>
</html>
