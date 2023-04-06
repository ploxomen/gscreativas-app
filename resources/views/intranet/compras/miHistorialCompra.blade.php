@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/compras/historialCompra.js')}}"></script>
    <title>Historial de precios</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/listaCompra.png')}}" alt="Imagen de historial de precios" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Historial de precios</h4>
            </div>
        </div>
        <div class="bg-white p-3 border">
            <form action="">
                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label for="productoBuscar" class="col-form-label col-form-label-sm">Producto</label>
                    <select id="productoBuscar" class="form-control form-control-sm select2-simple" data-placeholder="Seleccione un producto">
                        @foreach ($productos as $producto)
                            <option value="{{$producto->id}}">{{$producto->nombreProducto}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
       <div class="bg-white p-3 border">
        <table class="table table-sm table-bordered" id="tablaHistorial">
            <thead class="text-center">
                <tr>
                    <th>N° Compra</th>
                    <th>Fecha Comprobante</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Presentación</th>
                    <th>Proveedor</th>
                    <th>Precio</th>
                </tr>
            </thead>
        </table>
       </div>
    </section>
@endsection