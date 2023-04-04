@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/ventas/nuevaCompra.js')}}"></script>
    <title>Nueva Compra</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/ventas.png')}}" alt="Imagen de ventas" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Nueva Compra</h4>
            </div>
        </div>
        <form id="generarVenta" class="form-row">
            <div class="form-group col-12">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Compra</legend>
                        <div class="col-12 col-md-6 form-group">
                            <label for="idCompraProveedor" class="col-form-label col-form-label-sm">Proveedor</label>
                            <select name="proveedorFk" id="idCompraProveedor" class="form-control form-control-sm select2-simple" required data-placeholder="Seleccione un proveedor">
                                <option value=""></option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{$proveedor->id}}">{{$proveedor->nombre_proveedor}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 form-group">
                            <label for="idCompraComprobante" class="col-form-label col-form-label-sm">Comprobante</label>
                            <select name="tipoComprobanteFk" id="idCompraComprobante" class="form-control form-control-sm select2-simple" required data-placeholder="Seleccione un comprobante">
                                @foreach ($comprobantes as $comprobante)
                                    <option value="{{$comprobante->id}}">{{$comprobante->comprobante}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2 form-group">
                            <label for="idComprarNroComprobante" class="col-form-label col-form-label-sm">Número</label>
                            <input type="text" id="idComprarNroComprobante" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-12 col-md-2 form-group">
                            <label for="idCompraFecha" class="col-form-label col-form-label-sm">Fecha</label>
                            <input type="date" required id="idCompraFecha" name="fechaVenta" class="form-control form-control-sm" value="{{date('Y-m-d')}}">
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
                                <option value="{{$producto->id}}" data-codigo="{{empty($producto->codigoBarra) ? $producto->id : $producto->codigoBarra}}" data-url="{{$producto->urlImagen}}">{{$producto->nombreProducto}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
            </div>
            <div class="form-group col-12">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Detalle venta</legend>
                    <div class="col-12 table-responsive">
                        <table class="table table-sm table-bordered table-striped" id="tablaDetalleVenta">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th style="width: 100px; max-width: 100px;">Precio</th>
                                    <th style="width: 100px; max-width: 100px;">Cantidad</th>
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
                                    <td colspan="5">SubTotal</td>
                                    <td colspan="2" id="tDetalleSubTotal"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">IGV</td>
                                    <td colspan="2" id="tDetalleIgv"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Descuento</td>
                                    <td colspan="2" id="tDetalleDescuento"></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td colspan="2" id="tDetalleTotal"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </fieldset>
            </div>
        
            <div class="form-group col-12">
                <div class="px-3 d-flex justify-content-center align-items-center flex-wrap text-center" style="gap: 15px; font-size: 0.8rem;">
                    <div class="dinero bg-white p-2 border" title="El monto es en general, el pago total de los productos más el envio">
                        <i class="far fa-money-bill-alt text-danger"></i>
                        <b>TOTAL A PAGAR</b>
                        <span id="totalApagarEnvio" class="d-block">S/ 0.00</span>
                    </div>
                    <div class="dinero bg-white p-2 border">
                        <i class="far fa-money-bill-alt text-warning"></i>
                        <b>RECIBIDO</b>
                        <input type="number" style="max-width: 100px;" name="montoPagado" id="idMontoDado" step="0.01" min="0" value="0.00" class="form-control form-control-sm text-center" required>
                    </div>
                    <div class="dinero bg-white p-2 border">
                        <i class="far fa-money-bill-alt text-success"></i>
                        <b>VUELTO</b>
                        <span id="vueltoAdar" class="d-block">S/ 0.00</span>
                    </div>
                </div>
            </div>
            <div class="col-12 form-group text-center">
                <button type="submit" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-shopping-basket"></i>
                    <span>Agregar venta</span>
                </button>
            </div>
        </form>
    </section>
@endsection