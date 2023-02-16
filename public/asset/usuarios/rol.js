function loadPage(){
    const general = new General();
    const tablaRol = document.querySelector("#tablaRol");
    const tablaRolDataTable = $(tablaRol).DataTable({
        ajax: {
            url: 'rol/accion',
            method: 'POST',
            headers: general.requestJson,
            data: function (d) {
                d.accion = 'obtener';
            }
        },
        columns: [{
            data: 'id',
            render: function(data,type,row, meta){
                return meta.row + 1;
            }
        },
        {
            data: 'nombreRol'
        },
            { data: 'claseIcono'},
        {
            data: 'fechaCreada'
        },
        {
            data: 'fechaActualizada'
        },
        {
            data: 'id',
            render : function(data){
                return `<div class="d-flex justify-content-center" style="gap:5px;"><button class="btn btn-sm btn-outline-info p-1" data-rol="${data}">
                    <small>
                    <i class="fas fa-pencil-alt"></i>
                    Editar
                    </small>
                </button>
                <button class="btn btn-sm btn-outline-danger p-1" data-rol="${data}">
                    <small>    
                    <i class="fas fa-trash-alt"></i>
                        Eliminar
                    </small>
                </button></div>`
            }
        },
        ]
    });
    const txtRol = document.querySelector("#txtRol");
    const txtIcono = document.querySelector("#txtIcono");
    const formRol = document.querySelector("#formRol");
    const btnGuardarForm = document.querySelector("#btnGuardarForm");
    let idRol = null;
    tablaRol.onclick = async function(e){
        if (e.target.classList.contains("btn-outline-info")){
            let data = new FormData();
            data.append("accion","mostarEditar");
            data.append("rol",e.target.dataset.rol);
            try {
                const response = await general.funcfetch("rol/accion",data);
                if(response.session){
                    return alertify.alert([...alertaSesion],() => {window.location.reload()});
                }
                if(response.success){
                    alertify.success("pendiente para editar");
                    const rol = response.success;
                    txtRol.value = rol.nombreRol;
                    txtIcono.value = rol.claseIcono;
                    idRol = rol.id;
                    btnGuardarForm.querySelector("span").textContent = "Editar";
                }
            } catch (error) {
                idRol = null;
                console.error(error);
                alertify.error("error al obtener ")
            }

        }
        if (e.target.classList.contains("btn-outline-danger")) {

        }
    }
    formRol.onreset = function(e){
        btnGuardarForm.querySelector("span").textContent = "Guardar";
        idRol = null;
    }
    formRol.onsubmit = async function(e){
        e.preventDefault();
        let datos = new FormData(this);
        datos.append("accion", idRol != null ? "editarRol" : 'nuevoRol');
        if(idRol != null){
            datos.append("rolId", idRol);
        }
        try {
            const response = await general.funcfetch("rol/accion", datos);
            if (response.session) {
                return alertify.alert([...alertaSesion], () => { window.location.reload() });
            }
            if (response.success) {
                alertify.success(response.success);
                tablaRolDataTable.draw();
                formRol.reset();
                idRol = null;
            }
        } catch (error) {
            idRol = null;
            console.error(error);
            alertify.error(idRol != null ? "error al editar el rol" : 'error al agregar un rol')
        }

    }
}
window.addEventListener("DOMContentLoaded",loadPage);