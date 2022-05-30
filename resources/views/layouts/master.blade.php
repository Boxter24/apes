@php
    $colores = DB::table('colores')
    ->first();
@endphp

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('img/detalles/'.$detalles->logo_institucion) }}">
    <title>APES</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Styles-->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/contenido.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/master.css')}}"> 

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet"> 
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light border-bottom" style="{{ $colores->color }}">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <!--<div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>-->
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/home" class="brand-link">
                <img src="{{ asset('img/detalles/'.$detalles->logo_institucion) }}" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">{{ $detalles->nombre_institucion }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/profile/'.Auth::user()->foto) }}" class="img-circle elevation-2" alt="User">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{Auth::user()->name}}
                            <p>{{Auth::user()->tipo}}</p>
                        </a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/home" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                                <p>
                                    Inicio                                    
                                </p>
                            </router-link>
                        </li>
                        @can('isAdmin')
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-cog green"></i>
                                    <p>
                                        Administración
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview adminlink ml-4">
                                    <li class="nav-item">
                                        <router-link to="/usuarios" class="nav-link">
                                            <i class="fas fa-users nav-icon"></i>
                                            <p>Usuarios</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/desarrollador" class="nav-link">
                                            <i class="nav-icon fas fa-cogs purple"></i>
                                            <p>
                                                Desarrolladores                                    
                                            </p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/crearFacultad" class="nav-link">
                                            <i class="nav-icon fas fa-home pink"></i>
                                            <p>
                                                Facultades                                    
                                            </p>
                                        </router-link>
                                    </li> 
                                    <li class="nav-item">                                
                                        <router-link to="/crearCarrera" class="nav-link">
                                            <i class="nav-icon fa-solid fa-school cyan"></i>
                                            <p>
                                                Carreras                                    
                                            </p>
                                        </router-link>
                                    </li>    
                                    <li class="nav-item">
                                        <router-link to="/crearCategoria" class="nav-link">
                                            <i class="nav-icon fas fa-list-alt teal"></i>
                                            <p>
                                                Categorias                                    
                                            </p>
                                        </router-link>
                                    </li>      
                                    <li class="nav-item">
                                        <router-link to="/crearSeccion" class="nav-link">
                                            <i class="nav-icon fas fa-clipboard-list brown"></i>
                                            <p>                                            
                                                Secciones                                    
                                            </p>
                                        </router-link>
                                    </li>   
                                    <li class="nav-item">
                                        <router-link to="/crearInformacion" class="nav-link">
                                            <i class="nav-icon fa-solid fa-circle-info yellow"></i>
                                            <p>                                            
                                                Informaciones                                    
                                            </p>
                                        </router-link>
                                    </li> 
                                    <li class="nav-item">
                                        <router-link to="/crearGuia" class="nav-link">
                                            <i class="nav-icon fa-solid fa-chalkboard"></i>
                                            <p>                                            
                                                Guías                                    
                                            </p>
                                        </router-link>
                                    </li>                                                                                                   
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-pen-to-square nav-icon"></i>
                                    <p>
                                        Personalización
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview adminlink ml-4">
                                    <li class="nav-item">
                                        <router-link to="/carrusel" class="nav-link">
                                            <i class="fa-solid fa-images nav-icon"></i>
                                            <p>Carrusel de Imagenes</p>
                                        </router-link>
                                    </li>                                                                                                                                   
                                    <li class="nav-item">
                                        <router-link to="/detalles" class="nav-link">
                                            <i class="fa-solid fa-a nav-icon"></i>
                                            <p>Detalles</p>
                                        </router-link>
                                    </li>  
                                    <li class="nav-item">
                                        <router-link to="/colores" class="nav-link">
                                            <i class="fa-solid fa-palette nav-icon mixto"></i>
                                            <p>Colores</p>
                                        </router-link>
                                    </li>                         
                                </ul>
                            </li>                                                                                                
                        @endcan
                        <li class="nav-item">
                            <router-link to="/perfil" class="nav-link">
                                <i class="nav-icon fas fa-user orange"></i>
                                <p>
                                    Perfil                                    
                                </p>
                            </router-link>
                        </li> 

                        <li class="nav-item">
                            <router-link to="/facultades" class="nav-link">
                                <i class="nav-icon fas fa-home pink"></i>
                                <p>
                                    Facultades                                    
                                </p>
                            </router-link>
                        </li>                                              
                        <li class="nav-item">
                            <router-link to="/informaciones" class="nav-link">
                                <i class="nav-icon fa-solid fa-circle-info yellow"></i>
                                <p>
                                    Información                                  
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/foros" class="nav-link">
                                <i class="nav-icon fa-solid fa-message blue"></i>
                                <p>
                                    Foros                                  
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/guias" class="nav-link">
                                <i class="nav-icon fa-solid fa-chalkboard"></i>
                                <p>
                                    Guias                                  
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                <i class="nav-icon fa fa-power-off red"></i>
                                <p>
                                    {{ __('Logout') }}
                                </p>
                             </a>
            
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                    </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">            
            <!--MAIN CONTENT-->
            <div class="content">
                <div class="container-fluid">
                    <vue-progress-bar> </vue-progress-bar>
                    <v-app style="padding: 10px">
                        <router-view></router-view>
                    </v-app>                    
                </div>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>


        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                {{ $detalles->nombre_institucion }}
            </div>
            <strong>Copyright &copy; 2022 <a href="https://github.com/Boxter24/CodeTeka">{{ $detalles->nombre_institucion }}.com</a>.</strong> All rights reserved.
        </footer>
    </div>

    @auth
        <script>
            window.user = @json(auth()->user())
        </script>
    @endauth

    <script src="/js/app.js"></script>
</body>
</html>