@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/ventas/nuevaVenta.js')}}"></script>
    <title>Nueva venta</title>
@endsection
@section('body')
    <section class="p-2">
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
                            <input type="text" value="{{$numeroComprobante->serie}}" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6 col-lg-3 form-group">
                            <label for="txtcliente" class="col-form-label col-form-label-sm">Número</label>
                            <input type="text" value="{{str_pad($numeroComprobante->inicio + $numeroComprobante->utilizados,strlen($numeroComprobante->fin),"0",STR_PAD_LEFT)}}" class="form-control form-control-sm" required>
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
                            <select name="" id="" class="form-control form-control-sm">
                                <option value=""></option>
                                @foreach ($tiposDocumentos as $tipoDocumento)
                                    <option value="{{$tipoDocumento->id}}">{{$tipoDocumento->documento}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="" class="col-form-label col-form-label-sm">N° Documento</label>
                            <input type="tel" class="form-control form-control-sm">
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
                                <option value="{{$producto->id}}" data-venta="{{$producto->precioVenta}}" data-venta-mayor="{{$producto->procioVentaPorMayor}}" data-codigo="{{empty($producto->codigoBarra) ? $producto->id : $producto->codigoBarra}}" data-url="{{$producto->urlImagen}}">{{$producto->nombreProducto}}</option>
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
                                    <th style="width: 100px; max-width: 100px;">Precio<br>Unitario</th>
                                    <th style="width: 100px; max-width: 100px;">Cantidad</th>
                                    <th style="width: 100px; max-width: 100px;">Descuento<br>S/</th>
                                    <th style="width: 100px; max-width: 100px;">Subtotal<br>S/</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </fieldset>
            </div>
            <div class="form-group col-12">
            <fieldset class="bg-white col-12 px-3 border mb-4 form-row">
                <legend class="d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Otros</legend>
                <div class="form-group col-12 col-md-4 form-group">
                    <label for="">Metodo de pago:</label>
                    <select name="" id="" class="form-control">
                        <option value="">Deposito en cuenta</option>
                        <option value="">Pago en efectivo</option>
                        <option value="">Pago contra entrega</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-4 form-group">
                    <label for="">N° de operación:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group col-12 col-md-4 form-group">
                    <label for="">Monto pagado:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group col-12">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                        <label class="custom-control-label" for="customControlAutosizing">Recojo en tienda</label>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row" style="width: 100%; max-width: 500px; margin-left: auto;">
                        <label for="" class="col-5 form-group">Total a pagar</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                        <label for="" class="col-5 form-group">Total pagado</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                        <label for="" class="col-5 form-group">Vuelto</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </fieldset>
            </div>
            {{-- <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar venta</button>
            </div> --}}
        </form>
    </section>
@endsection