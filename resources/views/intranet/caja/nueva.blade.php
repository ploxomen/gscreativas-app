@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <script src="{{asset('asset/ventas/caja.js')}}"></script>
    <title>Caja</title>
@endsection
@section('body')
    <section class="container">
                <div class="bg-white p-3">
                    <div class="form-group">
                        @if(empty($caja))
                            <img src="{{asset('asset/img/modulo/caja_abierta.png')}}" alt="Imagen de abrir caja" width="160px" class="img-fluid d-block m-auto">
                        @else
                            <img src="{{asset('asset/img/modulo/caja_cerrada.png')}}" alt="Imagen de cerrar caja" width="160px" class="img-fluid d-block m-auto">
                        @endif
                    </div>
                    <div class="form-group">
                        <h3 class="text-center">{{$fechaLarga}}</h3>
                    </div>
                    <div class="form-group text-center">
                        @if(empty($caja))
                            <button class="btn btn-lg btn-success" id="btnAbrirCaja">
                                <i class="fas fa-door-open"></i>
                                <span>Abrir Caja</span>
                            </button>
                        @endif
                        @if (!empty($caja) && !is_null($caja->fecha_hr_inicio) && is_null($caja->fecha_hr_termino))
                            <button class="btn btn-lg btn-danger" id="btnCerrarCaja">
                                <i class="fas fa-door-closed"></i>
                                <span>Cerrar caja</span>
                            </button>
                        @endif
                        @if (!empty($caja) && !is_null($caja->fecha_hr_inicio) && !is_null($caja->fecha_hr_termino))
                            <h5 class="text-center text-danger">La caja a sido cerrada</h5>
                            <h5 class="text-center text-success">Venta total</h5>
                            <h4 class="text-center text-success">S/. {{number_format($caja->total,2,'.',',')}}</h4>
                            <button class="btn btn-lg btn-success" id="btnAbrirCaja">
                                <i class="fas fa-door-open"></i>
                                <span>Abrir Caja</span>
                            </button>
                        @endif
                    </div>
        </div>
    </section>
@endsection