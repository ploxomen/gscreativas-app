@extends('general.index')
@section('head')
    <link rel="stylesheet" href="{{asset('asset/home/administrador.css')}}">
@endsection
@section('body')
    <div class="p-3 bg-white">
        <div class="px-3 py-5">
            <div>
                <div class="p-3">
                    <img src="{{asset('asset/img/erp.png')}}" alt="Imagen ERP" width="230px" class="img-fluid d-block m-auto">
                </div>
                
                <h1 class="text-center">¡BIENVENIDOS A LA ERP - <span class="text-primary">GSCREATIVAS</span>!</h1>
            </div>
        </div>
    </div>
@endsection