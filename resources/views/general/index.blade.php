<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('iconos/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('asset/general.css')}}">
    <link rel="stylesheet" href="{{asset('library/bootstrap/bootstrap.min.css')}}">
    <script src="{{asset('library/jquery/external/jquery/jquery.js')}}"></script>
    <script src="{{asset('library/bootstrap/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('library/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('library/select2/select2-bootstrap.min.css')}}">
    <script src="{{asset('library/select2/select2.min.js')}}"></script>
    <script src="{{asset('library/select2/es.js')}}"></script>
    <link rel="stylesheet" href="{{asset('library/alertify/alertify.min.css')}}">
    <script src="{{asset('library/alertify/alertify.min.js')}}"></script>
    <link rel="stylesheet" href="st{{asset('library/pagination/pagination.css')}}">
    <script src="{{asset('library/pagination/pagination.js')}}"></script>
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    <div class="contenedor">
        <div class="navegacion">
            <div class="mi-logo">
            </div>
            <ul class="menu">
                <li class="">
                    <a href="{{route('home')}}" class="menu-prin">
                        <span class="icono material-icons">home</span>
                        <span class="title">Inicio</span>
                    </a>
                </li>  
                {{-- <li class="hover-menu">
                    <a href="javascript:void(0)" class="active-panel">
                        <span class="icono material-icons">groups</span>
                        <span class="title">Usuario</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="{{route('users')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar usuarios</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="{{route('listarUsuario')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Mis usuarios</span>
                        </a>
                    </li>
                </ul> --}}
                 <li class="hover-menu">
                    <a href="javascript:void(0)" class="active-panel">
                        <span class="icono material-icons">groups</span>
                        <span class="title">Productos</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="{{route('addProduct')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar producto</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="{{route('listarProductos')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Mis productos</span>
                        </a>
                    </li>
                </ul>
                <li>
                    <a href="" class="active-panel">
                        <span class="icono material-icons">shopping_cart</span>
                        <span class="title">Ventas</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="{{route('agregarVentas')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar venta</span>
                        </a>
                    </li>
                </ul>
                <li class="hover-menu">
                    <a href="javascript:void(0)" class="active-panel">
                        <span class="icono material-icons">groups</span>
                        <span class="title">Usuarios</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="{{route('usuarioRol')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Rol</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="{{route('usuarioArea')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Area</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="{{route('listarUsuario')}}">
                            <span class="icono material-icons">add</span>
                            <span class="title">Usuario</span>
                        </a>
                    </li>
                </ul>
                <li>
                    <a href="{{route('cerrarSesion')}}">
                        <span class="icono material-icons">logout</span>
                        <span class="title">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel">
            <div class="box-serch" hidden>
                <input type="search">
            </div>
            <div class="info-person">
                <div class="btn-menu">
                    <button class="btn-info-menu">
                        <span class="material-icons">menu</span>
                    </button>
                    <button class="btn-info-menu">
                        <span class="material-icons">search</span>
                    </button>
                </div>
                <div class="box-my">
                    <button class="btn-info-menu">
                        <span class="material-icons">notifications</span>
                    </button>
                    <img src="" alt="">
                </div>
               
            </div>
        </div>
        <div class="cuerpo-panel">
            @yield('body')
        </div>
    </div>
</body>
</html>