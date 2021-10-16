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
    <link rel="stylesheet" href="{{asset('asset/general.css')}}">
    <title>@yield('title')</title>
</head>
<body>
    <div class="contenedor">
        <div class="navegacion">
            <div class="mi-logo">

            </div>
            <ul class="menu">
                <li class="">
                    <a href="javascript:void(0)" class="menu-prin">
                        <span class="icono material-icons">home</span>
                        <span class="title">Inicio</span>
                    </a>
                </li>  
                <li class="hover-menu">
                    <a href=" " class="active-panel">
                        <span class="icono material-icons">groups</span>
                        <span class="title">Clientes</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar clientes</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
                            <span class="icono material-icons">add</span>
                            <span class="title">Mis clientes</span>
                        </a>
                    </li>
                </ul>
                 <li class="hover-menu">
                    <a href=" " class="active-panel">
                        <span class="icono material-icons">groups</span>
                        <span class="title">Productos</span>
                        <span class="material-icons">expand_more</span>
                    </a>
                </li>
                <ul class="sub-menu">
                    <li class="hover-menu">
                        <a href="">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar producto</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
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
                        <a href="">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar venta</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
                            <span class="icono material-icons">add</span>
                            <span class="title">Registrar venta (R)</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
                            <span class="title">Preventas</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
                            <span class="title">Ventas del día</span>
                        </a>
                    </li>
                    <li class="hover-menu">
                        <a href="">
                            <span class="title">Ventas en general</span>
                        </a>
                    </li>
                </ul>
                <li>
                    <a href="">
                        <span class="icono material-icons">logout</span>
                        <span class="title">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel">
            <div class="info-person">
                <div class="btn-menu">
                    <button>
                        <span class="material-icons">menu</span>
                    </button>
                </div>
                <div class="box-serch">
                    <input type="search">
                </div>
                <div class="box-my">
                    <img src="" alt="">
                </div>
            </div>
        </div>
    </div>
</body>
</html>