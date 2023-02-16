@extends('general.index')
@section('head')
    <title>Agregar venta</title>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/general.js')}}"></script>
    <script src="{{asset('asset/productos/misProductos.js')}}"></script>
@endsection
@section('body')
    <section class="bg-white p-2">
        <form action="">
            <fieldset class="px-3 border mb-4 form-row">
                <legend class="d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del cliente</legend>
                <div class="col-11 form-group">
                    <label for="txtcliente">Nombres:</label>
                    <input type="text" class="form-control" id="txtcliente">
                </div>
                <div class="col-md-2 col-lg-1 form-group d-flex justify-content-center align-items-center">
                    <button class="btn btn-danger btn-sm"><span class="material-icons">search</span></button>
                </div>
                <div class="col-12 col-md-3 form-group">
                    <label for="">Tipo de documento:</label>
                    <select name="" id="" class="form-control">
                        <option value="">DNI</option>
                        <option value="">RUC</option>
                        <option value="">Carnet de extrangeria</option>
                        <option value="">Pasaporte</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 form-group">
                    <label for="">N° de documento:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-12 col-md-3 form-group">
                    <label for="">Celular:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-12 col-md-3 form-group">
                    <label for="">Email:</label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-12 form-group">
                    <label for="">Dirección:</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control"></textarea>
                </div>
            </fieldset>
            <fieldset class="px-3 border mb-4 form-row">
                <legend class="d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Mis Productos</legend>
                <div class="col-md-10 col-lg-11 form-group mb-5">
                    <label for="">Buscar producto:</label>
                    <input type="text" class="form-control">
                    <small class="text-secondary">Busque y seleccione un producto</small>
                </div>
                <div class="col-md-2 col-lg-1 mb-5 d-flex justify-content-center align-items-center">
                    <button class="btn btn-danger btn-sm"><span class="material-icons">search</span></button>
                </div>
                <div class="col-12 form-group pl-4">
                    <ul>
                        <li class="form-group">
                            <div class="form-row">
                                <div class="col-7">
                                    <label for="">Producto:</label>
                                    <input type="text" class="form-control" value="Crema de fideos" disabled>
                                </div>
                                <div class="col-1">
                                    <label for="">Cantidad:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-1">
                                    <label for="">Valor Unitario:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-1">
                                    <label for="">Descuento(%):</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-1">
                                    <label for="">Subtotal:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-danger btn-sm"><span class="material-icons">delete</span></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="row" style="width: 100%; max-width: 300px; margin-left: auto;">
                        <label for="" class="col-5 form-group">Descuentos</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                        <label for="" class="col-5 form-group">Envio</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                        <label for="" class="col-5 form-group">Total</label>
                        <div class="col-7 form-group">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="px-3 border mb-4 form-row">
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
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar venta</button>
            </div>
        </form>
    </section>
@endsection