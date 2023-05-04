@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
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
                            <button class="btn btn-lg btn-success">
                                <i class="fas fa-door-open"></i>
                                <span>Abrir Caja</span>
                            </button>
                        @endif
                        @if (!empty($caja) && !is_null($caja->fecha_hr_inicio))
                            <button class="btn btn-lg btn-danger">
                                <i class="fas fa-door-closed"></i>
                                <span>Cerrar caja</span>
                            </button>
                        @endif
                        @if (!empty($caja) && !is_null($caja->fecha_hr_inicio) && !is_null($caja->fecha_hr_termino))
                            <h5 class="text-center">La caja a sido cerrada</h5>
                        @endif
                    </div>
        </div>
    </section>
@endsection