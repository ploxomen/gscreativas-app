@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/ventas/nuevaCotizacion.js')}}"></script>
    <title>Nueva cotización</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/pagoCotizacion.png')}}" alt="Imagen de cotizacion" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Nueva Cotización</h4>
            </div>
        </div>
        <form id="generarCotizacion" class="form-row">
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del Cliente</legend>
                        <div class="col-12 form-group">
                            <label for="txtNombreCliente" class="col-form-label col-form-label-sm">Nombres Completos</label>
                            <input type="text" class="form-control" name="cliente" id="txtNombreCliente">
                        </div>
                </fieldset>
            </div>
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Envío y pago</legend>
                    <div class="form-group col-12 col-md-6">
                        <label for="idMetodoEnvio" class="col-form-label col-form-label-sm">Metodo de envio</label>
                        <select name="metodoEnvio" id="idMetodoEnvio" class="form-control form-control-sm" required>
                            <option value="ENVIO A DOMICILIO">Envío a domicilio</option>
                            <option value="RECOJO EN TIENDA" selected>Recojo en tienda</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="idVentaEnvio" class="col-form-label col-form-label-sm">Envío S/</label>
                        <input type="number" name="envio" id="idVentaEnvio" step="0.01" min="0" value="0.00" class="form-control form-control-sm">
                    </div>
                    <div class="form-group col-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="tipoPago" class="custom-control-input change-switch" data-selected="AL CONTADO" data-noselected="A CREDITO" checked id="idModalestado">
                            <label class="custom-control-label" for="idModalestado">AL CONTADO</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-group col-12">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Productos</legend>
                    <div class="col-12 form-group">
                        <label for="productoBuscar" class="col-form-label col-form-label-sm">Buscar producto</label>
                        <select id="productoBuscar" class="form-control form-control-sm">
                            <option value=""></option>
                            @foreach ($productos as $producto)
                                <option value="{{$producto->id}}" data-venta="{{$producto->precioVenta}}" data-venta-mayor="{{$producto->precioVentaPorMayor}}" data-codigo="{{empty($producto->codigoBarra) ? $producto->id : $producto->codigoBarra}}" data-url="{{$producto->urlImagen}}" {{$producto->cantidad > 0 ? "" : "disabled"}}>{{$producto->nombreProducto}}</option>
                            @endforeach
                        </select>
                        <small class="text-info">Los productos mostrados que no se pueden seleccionar es porque no hay stock</small>
                    </div>
                    <div class="form-group col-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input change-switch" data-selected="PRODUCTO AL POR MENOR" data-noselected="PRODUCTO AL POR MAYOR" 
                            checked id="idVentaPorMenor">
                            <label class="custom-control-label" for="idVentaPorMenor">PRODUCTO AL POR MENOR</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-group col-12">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Detalle Productos</legend>
                    <div class="col-12 table-responsive">
                        <table class="table table-sm table-bordered table-striped" id="tablaDetalleVenta">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th style="width: 100px; max-width: 100px;">Precio</th>
                                    <th style="width: 100px; max-width: 100px;">Cantidad</th>
                                    <th style="width: 100px; max-width: 100px;">Descuento<br>S/</th>
                                    <th style="width: 100px; max-width: 100px;">Importe<br>S/</th>
                                    <th style="width: 100px; max-width: 100px;">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                                </tr>
                            </tbody>
                            <tfoot class="text-right">
                                <tr>
                                    <td colspan="6">SubTotal</td>
                                    <td colspan="2" id="tDetalleSubTotal">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6">IGV</td>
                                    <td colspan="2" id="tDetalleIgv">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6">Descuento</td>
                                    <td colspan="2" id="tDetalleDescuento">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6">Envío</td>
                                    <td colspan="2" id="tDetalleEnvio">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="6">Total</td>
                                    <td colspan="2" id="tDetalleTotal">S/ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="col-12 form-group text-center">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-shopping-basket"></i>
                    <span>Generar Cotización</span>
                </button>
            </div>
        </form>
    </section>
@endsection