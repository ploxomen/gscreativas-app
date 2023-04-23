@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/ventas/misCotizaciones.js')}}"></script>
    <title>Mis Cotizaciones</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/cotizacionAdmin.png')}}" alt="Imagen de cotizaciones" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Administración de Cotizaciones</h4>
            </div>
        </div>
       <div class="bg-white p-3 border">
        <table class="table table-sm table-bordered" id="tablaVentas">
            <thead class="text-center">
                <tr>
                    <th>N° COTIZACIÓN</th>
                    <th>FECHA COTIZACIÓN</th>
                    <th>COTIZADOR</th>
                    <th>CLIENTE</th>
                    <th>MÉTODO ENVIO</th>
                    <th>MÉTODO PAGO</th>
                    <th>SUBTOTAL</th>
                    <th>I.G.V</th>
                    <th>DESCUENTO</th>
                    <th>ENVÍO</th>
                    <th>TOTAL</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
        </table>
       </div>
    </section>
@endsection