<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <title>Iniciar sesión</title>
</head>
<body>
    <style>
        
        
        body{
            overflow: hidden;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .contenido-login{
            display: flex;
            width: 100%;
            max-width: 1500px;
            margin: auto;
            height: 700px;
        }
        .contenido-login article{
            height: 100%;
            padding: 10px;
        }
        .baner-log{
            width: 60%;
        }
        .baner-init{
            width: 40%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .baner-init .children{
            width: 100%;
            max-width: 450px;
        }
        .title{
            text-align: center;
            margin-bottom: 30px;
            font-size: 40px
        }
        .baner-log{
            position: relative;
        }
        .baner-log::before{
            content: '';
            position: absolute;
            top: -5%;
            left: -120%;
            display: block;
            width: 2000px;
            border-radius: 50%;
            transform: translateY(-50%);
            height: 2000px;
            z-index: -2;
            transition: all .3s ease-in-out;
            background: linear-gradient(-45deg, #4481eb 0%, #04befe 100%);
        }
        .baner-log img{
            display: block;
            width: 450px;
            position: absolute;
            bottom: 0;
            left: 100px;
            z-index: -1;
        }
        .input-file {
            position: relative;
            margin-bottom: 20px;
        }
        .input-file span{
            color: #ADACAD;
            position: absolute;
            left: 15px;
            top: 50%;
            user-select: none;
            pointer-events: none;
            transform: translateY(-50%);
            transition: color .3s ease-in-out;
        }
        .input-file > input{
            outline: none;
            border-radius: 50px;
            border: 1px solid transparent;
            background: #F1EFF1;
            padding: 10px 5px 10px 45px;
            font-weight: bold;
            width: 100%;
            font-size: 14px;
            color: #49484A;
            transition: background,border-color .3s ease-in-out;
        }
        .input-file > input:focus + span{
            color: #5395FB;
        }
        .input-file > input:focus{
            background: #fff;
            border: 1px solid #5395FB;
        }
        .restore-pass{
            text-decoration: none;
            color: #49484A;
            font-weight: bold;
        }
        .button-login{
            display: flex;
            width: 100%;
            outline: none;
            border: none;
            background: #5395FB;
            color: white;
            border-radius: 50px;
            max-width: 200px;
            align-items: center;
            justify-content: center;
            padding: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: auto;
            transition: background .3s ease-in-out;
        }
        .button-login span{
            margin-right: 7px;
        }
        .button-login:hover{
            background: rgba(121, 116, 226, 0.994);
        }
        .system-info{
            color: #F1EFF1;
            padding: 50px;
            text-align: center;
        }
        .checkbox{
            display: flex;
            align-items: center;
        }
        .checkbox .icon{
            display: block;
            width: 20px;
            height: 20px;
            border-radius: 5px;
            padding: 5px;
            margin-right: 5px;
            border: 2px solid #5395FB;
            position: relative;
        }
        .input-check{
            opacity: 0;
        }
        .input-check:focus + .icon {
            box-shadow: 0 0 0 0.05em #fff, 0 0 0.15em 0.1em #5395FB;
        }
        .input-check:checked + .icon span {
            transform: translate(-50%,-50%) scale(1);
        }
        .checkbox .icon span {
            transition: transform 0.1s ease-in 25ms;
            transform-origin: bottom left;
            color: #5395FB;
            font-size: 15px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%) scale(0);
        }
        @media screen and (max-width: 1460px){
            .baner-log::before{
                left: -150%;
            }
            .system-info{
                max-width: 600px;
            }
        }
        @media screen and (max-width: 1310px){
            .baner-log::before{
                top: -10%;
                left: -170%;
            }
        }
        @media screen and (max-width: 1210px){
            .baner-log::before{
                top: -5%;
                left: -190%;
            }
        }
        @media screen and (max-width: 1130px){
            .baner-log::before{
                top: 0;
                left: -210%;
            }
        }
        @media screen and (max-width: 1060px){
            .baner-log::before{
                height: 150%;
                transform: translateY(0);
                top: -60%;
                left: -40%;
                width: 250%;
            }
            .contenido-login{
                display: block;
                height: auto;
            }
            .contenido-login article{
                width: 100%;
                margin-bottom: 15px;
                overflow: hidden;
            }
            .baner-log .system-info{
                width: 100%;
                padding: 20px;
                max-width: 100%;
            }
            .baner-log img{
                display: block;
                width: 100%;
                position: initial;
                bottom:0;
                max-width: 350px;
                margin: auto;
            }
            body{
                overflow: auto;
                height: auto;
            }
        }
    </style>
    <section class="contenido-login">
        <article class="baner-log">
            <div class="system-info">
                <h3>Sistema integrado</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus modi pariatur unde molestias quo cumque illo et. Corrupti, eius qui quidem animi ad excepturi eveniet asperiores, sit commodi suscipit ea.</p>
            </div>
            <img src="{{asset('asset/img/log.svg')}}" alt="">
        </article>
        <article class="baner-init">
            <form class="children">
                <h1 class="title">Inicar sesión</h1>
                <div class="box-input">
                    <div class="input-file">
                        <input type="text" required placeholder="Usuario">
                        <span class="material-icons">person</span>                    
                    </div>
                    <div class="input-file">
                        <input type="password" required placeholder="Contraseña">
                        <span class="material-icons">lock</span>
                    </div>
                    <div class="input-file">
                        <label for="id-recordar" class="checkbox">
                            <input type="checkbox" name="remember" id="id-recordar" class="input-check">
                            <div class="icon">
                               <span class="material-icons">check</span>
                            </div>
                            <div><b>Recordarme</b></div> 
                        </label>
                    </div>
                    <div class="input-file" style="text-align: right;">
                        <a href="" class="restore-pass">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div>
                        <button class="button-login" type="submit"><span class="material-icons">login</span>Ingresar</button>
                    </div>
                </div>
            </form>
        </article>
    </section>
    
</body>
</html>