@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/ventas/nuevaVenta.js')}}"></script>
    <title>Nueva venta</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/ventas.png')}}" alt="Imagen de ventas" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Nueva Venta</h4>
            </div>
        </div>
        <form action="" class="form-row">
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del Comprobante</legend>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="txtcliente" class="col-form-label col-form-label-sm">Comprobante</label>
                            <select name="comprobanteFk" id="" class="form-control form-control-sm" required>
                                @foreach ($comprobantes as $comprobante)
                                    <option value="{{$comprobante->id}}">{{$comprobante->comprobante}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-lg-3 form-group">
                            <label for="txtcliente" class="col-form-label col-form-label-sm">Serie</label>
                            <input type="text" value="{{$numeroComprobante->serie}}" class="form-control form-control-sm" disabled required>
                        </div>
                        <div class="col-6 col-lg-3 form-group">
                            <label for="txtcliente" class="col-form-label col-form-label-sm">Número</label>
                            <input type="text" value="{{str_pad($numeroComprobante->inicio + $numeroComprobante->utilizados,strlen($numeroComprobante->fin),"0",STR_PAD_LEFT)}}" disabled class="form-control form-control-sm" required>
                        </div>
                        <div class="col-12 form-group">
                            <label for="" class="col-form-label col-form-label-sm">Fecha emitida</label>
                            <input type="date" class="form-control form-control-sm" value="{{date('Y-m-d')}}">
                        </div>                    
                </fieldset>
            </div>
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del Cliente</legend>
                        <div class="col-12 form-group">
                            <label for="txtcliente" class="col-form-label col-form-label-sm">Nombres</label>
                            <select name="clienteFk" id="" required class="form-control form-control-sm select2-new" data-placeholder="Seleccione un cliente">
                                <option value=""></option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nombreCliente}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" class="col-form-label col-form-label-sm">Tipo Documento</label>
                            <select name="" id="" disabled class="form-control form-control-sm">
                                <option value=""></option>
                                @foreach ($tiposDocumentos as $tipoDocumento)
                                    <option value="{{$tipoDocumento->id}}">{{$tipoDocumento->documento}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" class="col-form-label col-form-label-sm">N° Documento</label>
                            <input type="tel" disabled class="form-control form-control-sm">
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
                                <option value="{{$producto->id}}" data-venta="{{$producto->precioVenta}}" data-venta-mayor="{{$producto->precioVentaPorMayor}}" data-codigo="{{empty($producto->codigoBarra) ? $producto->id : $producto->codigoBarra}}" data-url="{{$producto->urlImagen}}">{{$producto->nombreProducto}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="estado" class="custom-control-input change-switch" data-selected="PRODUCTO AL POR MENOR" data-noselected="PRODUCTO AL POR MAYOR" 
                            checked id="idVentaPorMenor">
                            <label class="custom-control-label" for="idVentaPorMenor">PRODUCTO AL POR MENOR</label>
                        </div>
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
                                    <th style="width: 100px; max-width: 100px;">Descuento<br>S/</th>
                                    <th style="width: 130px; max-width: 130px;">Vencimiento</th>
                                    <th style="width: 100px; max-width: 100px;">Importe<br>S/</th>
                                    <th style="width: 100px; max-width: 100px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                                </tr>
                            </tbody>
                            <tfoot class="text-right">
                                <tr>
                                    <td colspan="7">SubTotal</td>
                                    <td colspan="2" id="tDetalleSubTotal"></td>
                                </tr>
                                <tr>
                                    <td colspan="7">IGV</td>
                                    <td colspan="2" id="tDetalleIgv"></td>
                                </tr>
                                <tr>
                                    <td colspan="7">Descuento</td>
                                    <td colspan="2" id="tDetalleDescuento"></td>
                                </tr>
                                <tr>
                                    <td colspan="7">Total</td>
                                    <td colspan="2" id="tDetalleTotal"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="form-group col-12">
            <fieldset class="bg-white col-12 px-3 border mb-4 form-row">
                <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Pago</legend>
                <div class="form-group col-12">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="estado" class="custom-control-input change-switch" data-selected="VENTA AL CONTADO" data-noselected="VENTA AL CREDITO" 
                        checked id="idVentaContado">
                        <label class="custom-control-label" for="idVentaContado">VENTA AL CONTADO</label>
                    </div>
                </div>
                <div class="form-group col-12 col-md-3 form-group">
                    <label for="" class="col-form-label col-form-label-sm">Metodo de pago</label>
                    <select name="" id="" class="form-control form-control-sm" required>
                        <option value="EN EFECTIVO">En efectivo</option>
                        <option value="DEPOSITO EN CUENTA">Deposito en cuenta</option>
                        <option value="CON TARJETA">Con tarjeta</option>
                        <option value="BILLETERAS DIGITALES">Billeteras digitales</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-3 form-group" hidden>
                    <label for="" class="col-form-label col-form-label-sm">Billeteras digitales</label>
                    <select name="" id="" class="form-control form-control-sm" disabled>
                        <option value="YAOE">Yape</option>
                        <option value="PLIM">Plim</option>
                        <option value="AGORA PAY">Agora PAY</option>
                        <option value="BIM">Bim</option>
                        <option value="OTROS">OTROS</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-3 col-xl-2 form-group" hidden>
                    <label for="" class="col-form-label col-form-label-sm">N° de operación</label>
                    <input type="text" class="form-control form-control-sm" disabled>
                </div>
                <div class="form-group col-12 col-md-3 col-xl-2 form-group">
                    <label for="" class="col-form-label col-form-label-sm">Metodo de envio</label>
                    <select name="" id="" class="form-control form-control-sm" required>
                        <option value="EN EFECTIVO">Envio a domicilio</option>
                        <option value="DEPOSITO EN CUENTA">Recojo en tienda</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-3 col-xl-2 form-group">
                    <label for="" class="col-form-label col-form-label-sm">Envio S/</label>
                    <input type="number" step="0.01" min="0" value="0.00" class="form-control form-control-sm">
                </div>
            </fieldset>
            </div>
        </form>
    </section>
@endsection