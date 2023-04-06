<div class="modal fade" id="editarCompra" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloProveedor">Editar Compra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="form-row" id="formCompra">
                <div class="form-group col-12">
                    <label for="idModalproveedorFk">Proveedor</label>
                    <select name="proveedorFk" id="idModalproveedorFk" class="form-control select2-simple" required data-placeholder="Seleccione un proveedor">
                        <option value=""></option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->nombre_proveedor}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="idModalcomprobanteFk">Comprobante</label>
                    <select name="comprobanteFk" class="form-control select2-simple" id="idModalcomprobanteFk" required data-placeholder="Seleccione un comprobante">
                        <option value=""></option>
                        @foreach ($comprobantes as $comprobante)
                            <option value="{{$comprobante->id}}">{{$comprobante->comprobante}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="idModalnroComprobante">N° Comprobante</label>
                    <input type="text" name="nroComprobante" class="form-control" required id="idModalnroComprobante" required>
                </div>
                <div class="form-group col-12">
                    <label for="idModalfechaComprobante">Fecha Comprobante</label>
                    <input type="date" name="fechaComprobante" class="form-control" required id="idModalfechaComprobante">
                </div>
                <div class="form-group col-12">
                    <label for="productoBuscar" class="col-form-label col-form-label-sm">Buscar producto</label>
                    <select id="productoBuscar" class="form-control form-control-sm select2-simple" data-placeholder="Seleccione un producto">
                        <option value=""></option>
                        @foreach ($productos as $producto)
                            <option value="{{$producto->id}}" data-codigo="{{empty($producto->codigoBarra) ? $producto->id : $producto->codigoBarra}}" data-url="{{$producto->urlImagen}}">{{$producto->nombreProducto}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped" id="tablaDetalleVenta" style="font-size: 0.8rem;">
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
                            </tbody>
                            <tfoot class="text-right">
                                <tr>
                                    <td colspan="5">SubTotal</td>
                                    <td colspan="2" id="idModalimporte">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="5">IGV</td>
                                    <td colspan="2" id="idModaligv">S/ 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="5">Total</td>
                                    <td colspan="2" id="idModaltotal">S/ 0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                </div>
                <input type="submit" hidden id="btnFrmEnviar">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" id="btnGuardarFrm">
                <i class="fas fa-save"></i>
                <span>Actualizar</span>
            </button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                <i class="fas fa-eraser"></i>
                <span>Cancelar</span>
            </button>
        </div>
      </div>
    </div>
  </div>