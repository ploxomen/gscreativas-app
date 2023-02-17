<div class="modal fade" id="usurioModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Crear usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="form-row" id="frmUsuario">
                <div class="col-12">
                    <h5 class="text-primary">
                        <i class="fas fa-caret-right"></i>
                        Datos personales
                    </h5>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="type_document">Tipo de documento</label>
                    <select name="tipoDocumento" id="type_document" class="form-control">
                        <option value="">Ninguno</option>
                        <option value="D.N.I">D.N.I</option>
                        <option value="CARNET DE EXTRANJERÍA">CARNET DE EXTRANJERÍA</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <option value="R.U.C">R.U.C</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="n_document">N° de documento</label>
                    <input type="tel" name="nroDocumento" id="n_document" class="form-control">
                </div>
                <div class="form-group col-12 col-md-6 form-required">
                    <label for="name">Nombres</label>
                    <input type="text" required name="nombres" id="name" class="form-control">
                </div>
                <div class="form-group col-12 col-md-6 form-required">
                    <label for="last_name">Apellidos</label>
                    <input type="text" required name="apellidos" id="last_name" class="form-control">
                </div>
                <div class="form-group col-12 form-required">
                    <label for="email">Correo</label> 
                    <input type="email" required class="form-control" name="correo" id="email">
                    <small class="form-text text-muted">Con este correo se inicia sesión en el sistema</small>
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="phone">Celular</label> 
                    <input type="tel" class="form-control" name="celular" id="phone">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="direction">Telefono</label>
                    <input type="tel"  name="telefono" id="last_name" class="form-control">
                </div>
                <div class="form-group col-12">
                    <label for="direction">Direccion</label>
                    <input type="text"  name="direccion" id="last_name" class="form-control">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="txtFechaNacimiento">Fecha Nacimiento</label> 
                    <input type="date" class="form-control" name="fechaNacimiento" id="txtFechaNacimiento">
                </div>
                <div class="form-group col-12 col-md-6">
                    <label for="idSexo">Sexo</label> 
                    <select name="sexo" id="idSexo" class="form-control">
                        <option value="">Ninguno</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="col-12">
                    <h5 class="text-primary">
                        <i class="fas fa-caret-right"></i>
                        Datos del sistema
                    </h5>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-4 form-required">
                    <label for="areas">Área</label>
                    <select name="areaFk" class="form-control" id="areas" required>
                        <option></option>
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->nombreArea}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6 col-lg-8 form-required">
                    <label for="roles">Roles</label>
                    <select name="roles[]" class="form-control" multiple id="roles" required>
                        @foreach ($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->nombreRol}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 form-required">
                    <label for="txtContrasena">Contraseña</label> 
                    <input type="text" required class="form-control" name="contrasena" id="txtContrasena" minlength="8" value="sistema{{date('Y')}}">
                    <small class="form-text text-muted">Esta contraseña es temporal hasta que el usuario ingrese por primera vez</small>
                </div>
                <input type="submit" hidden id="btnFrmEnviar">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" id="btnGuardarFrm">
                <i class="fas fa-save"></i>
                <span>Guardar</span>
            </button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-eraser"></i>
                    <span>Cancelar</span>
            </button>
        </div>
      </div>
    </div>
  </div>