@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/compras/administracionCompras.js')}}"></script>
    <title>Mis Compras</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/compras.png')}}" alt="Imagen de compras" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Administración de compras</h4>
            </div>
        </div>
       <div class="bg-white p-3 border">
        <table class="table table-sm table-bordered" id="tablaCompras">
            <thead class="text-center">
                <tr>
                    <th>N° Compra</th>
                    <th>Fecha Comprobante</th>
                    <th>N° Comprobante</th>
                    <th>Proveedor</th>
                    <th>Sub. Total</th>
                    <th>I.G.V</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
       </div>
    </section>
    @include('intranet.compras.modales.editarCompra')
@endsection