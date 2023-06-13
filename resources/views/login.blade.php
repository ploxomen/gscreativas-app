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
    <link rel="stylesheet" href="{{asset('library/alertify/alertify.min.css')}}">
    <link rel="stylesheet" href="{{asset('library/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/login/login.css')}}">
    <script src="{{asset('library/alertify/alertify.min.js')}}"></script>
    <script src="{{asset('asset/auth/home.css')}}"></script>
    <link rel="icon" href="/asset/login/logo-intelecta.png">
    <script src="{{asset('asset/general.js')}}"></script>
    <script src="{{asset('asset/auth/login.js')}}"></script>
    <title>Iniciar sesión</title>
</head>
<body>
    <div class="container login">
        <div class="row justify-content-center">
            <div class="col-10 col-md-5 col-lg-5 formulario">
                <div class="mb-3 logo">
                    <img src="/asset/login/logo-intelecta.png" alt="" class="img-fluid">
                </div>

                <div class="mb-4 text-center">
                    <h2 class="titulo">Iniciar Sesión</h2>
                    <p>Ingresa a la Plataforma Virtual</p>
                </div>
                <form id="frmLogin">
                    <div class="mb-3">
                      <label for="txtCorreo" class="form-label">Usuario</label>
                      <input type="email" name="correo" required class="form-control form-control-lg" id="txtCorreo">                      
                    </div>

                    <div class="mb-3">
                      <label for="txtContra" class="form-label">Contraseña</label>
                      <input type="password" name="password" required class="form-control form-control-lg" id="txtContra">
                    </div>
                    <div class="mb-3 custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="recordar" id="id-recordar">
                        <label class="custom-control-label" for="id-recordar">Recordarme</label>
                      </div>
                    <button type="submit" class="btn w-100 btn-acceder btn-lg">Acceder</button>
                  </form>
            </div>
        </div>
    </div>
</body>
</html>