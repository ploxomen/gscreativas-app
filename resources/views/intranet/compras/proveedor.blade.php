@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/compras/proveedoresAdmin.js')}}"></script>
    <title>Proveedores</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/proveedor.png')}}" alt="Imagen de categorias" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Administración de proveedores</h4>
            </div>
        </div>
        <div class="form-group text-right">
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#agregarProveedor" id="btnAbrirNuevoProveedor">
                <i class="fas fa-plus"></i>
                <span>Agregar</span>
            </button>
        </div>
       <div class="bg-white p-3 border">
        <table class="table table-sm table-bordered" id="tablaProveedores">
            <thead class="text-center">
                <tr>
                    <th>N°</th>
                    <th>Tipo Documento</th>
                    <th>N° Documento</th>
                    <th>Proveedor</th>
                    <th>Teléfono</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
       </div>
    </section>
    @include('intranet.compras.modales.proveedor')
    @include('intranet.compras.modales.contactosProveedor')
@endsection