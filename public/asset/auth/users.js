window.onload = loadPage;
function loadPage(){
    let gen = new General();
    const tablaUsuarios = document.querySelector("#tablaUsuarios");
    const tablaUsuariosData = $(tablaUsuarios).DataTable({
        ajax: {
            url: 'usuarios/accion',
            method: 'POST',
            headers: gen.requestJson,
            data: function (d) {
                d.acciones = 'obtener';
                d.area = $("#cbArea").val();
                d.rol = $("#cbRol").val();
            }
        },
        columns: [{
            data: 'id',
            render: function(data,type,row, meta){
                return meta.row + 1;
            }
        },
        {
            data: 'apellidosNombres'
        },{
            data: 'celular'
        },
        {
            data: 'correo'
        },
        {
            data : 'area.nombreArea',
            name : 'area.nombreArea'
        },
        {
            data : 'estado',
            render : function(data){
                switch (data) {
                    case 1:
                        return '<span class="text-success">Activo</span>'    
                    break;
                    case 2:
                        return '<span class="text-danger">Por activar</span>'    
                    break;
                    default:
                        return '<span class="text-danget">No establecido</span>'    
                    break;
                }
            }
        },
        {
            data: 'id',
            render : function(data){
                return `<div class="d-flex justify-content-center" style="gap:5px;"><button class="btn btn-sm btn-outline-info p-1" data-usuario="${data}">
                    <small>
                    <i class="fas fa-pencil-alt"></i>
                    Editar
                    </small>
                </button>
                <button class="btn btn-sm btn-outline-danger p-1" data-usuario="${data}">
                    <small>    
                    <i class="fas fa-trash-alt"></i>
                        Eliminar
                    </small>
                </button></div>`
            }
        },
        ]
    });
    const btnGuardar = document.querySelector("#btnGuardarFrm");
    btnGuardar.onclick = e => document.querySelector("#btnFrmEnviar").click();
    const frmUsuario = document.querySelector("#frmUsuario");
    frmUsuario.addEventListener("submit",async function(e){
        e.preventDefault();
        gen.cargandoPeticion(btnGuardar,'fas fa-spinner fa-spin',true);
        let datos = new FormData(this);
        datos.append("acciones","agregar");
        try {
            const response = await gen.funcfetch("usuarios/accion",datos);
            gen.cargandoPeticion(btnGuardar,'fas fa-save',false);
            if(response.session){
                return alertify.alert([...alertaSesion],() => {window.location.reload()});
            }
            if(response.error){
                return alertify.error("error al guardar el usuario");
            }
            if(response.alerta){
                return alertify.alert("Alerta",response.alerta);
            }
            alertify.alert("Mensaje",response.success);
            $('#usurioModal').modal("hide");
        } catch (error) {
            gen.cargandoPeticion(btnGuardar,'fas fa-save',false);
            alertify.error("error al guardar el usuario");
        }
    })

    $('.select2').select2({
        theme: 'bootstrap',
        width: '100%',
    }).on("change",function(e){
        tablaUsuariosData.draw();
    });
}
