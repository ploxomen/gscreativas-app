<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="{{asset('asset/general.css')}}">
    <link rel="stylesheet" href="{{asset('asset/login/lestilos.css')}}">
    <link rel="stylesheet" href="{{asset('library/alertify/alertify.min.css')}}">
    <script src="{{asset('library/alertify/alertify.min.js')}}"></script>
    <script src="{{asset('asset/auth/home.css')}}"></script>
    <script src="{{asset('asset/general.js')}}"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="{{asset('asset/auth/login.js')}}"></script>
    <title>Iniciar sesión</title>
</head>
<body>
    <section class="contenido-login">
        <article class="baner-log">
            <div class="system-info">
                <h3>Sistema integrado</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus modi pariatur unde molestias quo cumque illo et. Corrupti, eius qui quidem animi ad excepturi eveniet asperiores, sit commodi suscipit ea.</p>
            </div>
            <img src="{{asset('asset/img/log.svg')}}" alt="">
        </article>
        <article class="baner-init">
            <form class="children" id="frmLogin">
                <h1 class="title">Inicar sesión</h1>
                <div class="box-input">
                    <div class="input-file">
                        <input type="email" name="correo" required placeholder="Usuario">
                        <span class="material-icons">person</span>                    
                    </div>
                    <div class="input-file">
                        <input type="password" name="password" required placeholder="Contraseña">
                        <span class="material-icons">lock</span>
                    </div>
                    <div class="input-file">
                        <label for="id-recordar" class="checkbox">
                            <input type="checkbox" name="recordar" id="id-recordar" class="input-check">
                            <div class="icon">
                               <span class="material-icons">check</span>
                            </div>
                            <div><b>Recordarme</b></div> 
                        </label>
                    </div>
                    <div class="input-file" style="text-align: right;">
                        <a class="restore-pass">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div>
                        <button type="submit" class="button-login">
                            <span class="material-icons">login</span>
                            Ingresar
                        </button>
                    </div>
                </div>
            </form>
        </article>
    </section>
    
</body>
</html>