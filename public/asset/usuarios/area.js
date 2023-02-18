function loadPage(){
    const general = new General();
    const tablaArea = document.querySelector("#tablaArea");
    const tablaAreaDataTable = $(tablaArea).DataTable({
        ajax: {
            url: 'area/accion',
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
            data: 'nombreArea'
        },{
            data: 'fechaCreada'
        },
        {
            data: 'fechaActualizada'
        },
        {
            data: 'id',
            render : function(data){
                return `<div class="d-flex justify-content-center" style="gap:5px;"><button class="btn btn-sm btn-outline-info p-1" data-area="${data}">
                    <small>
                    <i class="fas fa-pencil-alt"></i>
                    Editar
                    </small>
                </button>
                <button class="btn btn-sm btn-outline-danger p-1" data-area="${data}">
                    <small>    
                    <i class="fas fa-trash-alt"></i>
                        Eliminar
                    </small>
                </button></div>`
            }
        },
        ]
    });
    const txtArea = document.querySelector("#txtArea");
    const formArea = document.querySelector("#formArea");
    const btnGuardarForm = document.querySelector("#btnGuardarForm");
    let idArea = null;
    tablaArea.onclick = async function(e){
        if (e.target.classList.contains("btn-outline-info")){
            let data = new FormData();
            data.append("accion","mostarEditar");
            data.append("area",e.target.dataset.area);
            try {
                general.cargandoPeticion(e.target, general.claseSpinner, true);
                const response = await general.funcfetch("area/accion",data);
                general.cargandoPeticion(e.target, 'fas fa-pencil-alt', false);
                if(response.session){
                    return alertify.alert([...alertaSesion],() => {window.location.reload()});
                }
                if(response.success){
                    alertify.success("pendiente para editar");
                    const area = response.success;
                    txtArea.value = area.nombreArea;
                    idArea = area.id;
                    btnGuardarForm.querySelector("span").textContent = "Editar";
                }
            } catch (error) {
                general.cargandoPeticion(e.target, 'fas fa-pencil-alt', false);
                idArea = null;
                console.error(error);
                alertify.error("error al obtener la área")
            }

        }
        if (e.target.classList.contains("btn-outline-danger")) {
            alertify.confirm("Alerta","¿Deseas eliminar esta área?",async () => {
                let data = new FormData();
                data.append("accion", "eliminar");
                data.append("area", e.target.dataset.area);
                try {
                    general.cargandoPeticion(e.target, general.claseSpinner, true);
                    const response = await general.funcfetch("area/accion",data);
                    general.cargandoPeticion(e.target, 'fas fa-trash-alt', true);
                    if (response.session) {
                        return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
                    }
                    if(response.alerta){
                        return alertify.alert("Alerta",response.alerta);
                    }
                    if (response.error) {
                        return alertify.alert("Alerta", response.error);
                    }
                    tablaAreaDataTable.draw();
                    return alertify.success(response.success);
                } catch (error) {
                    general.cargandoPeticion(e.target, 'fas fa-trash-alt', true);
                    console.error(error);
                    alertify.error('error al eliminar la área');
                }
            },() => {})
        }
    }
    formArea.onreset = function(e){
        btnGuardarForm.querySelector("span").textContent = "Guardar";
        idArea = null;
    }
    formArea.onsubmit = async function(e){
        e.preventDefault();
        let datos = new FormData(this);
        datos.append("accion", idArea != null ? "editarArea" : 'nuevaArea');
        if(idArea != null){
            datos.append("areaId", idArea);
        }
        try {
            general.cargandoPeticion(btnGuardarForm, general.claseSpinner, true);
            const response = await general.funcfetch("area/accion", datos);
            general.cargandoPeticion(e.target, 'fas fa-save', false);
            if (response.session) {
                return alertify.alert([...alertaSesion], () => { window.location.reload() });
            }
            if (response.success) {
                alertify.success(response.success);
                tablaAreaDataTable.draw();
                formArea.reset();
                idArea = null;
            }
        } catch (error) {
            idArea = null;
            console.error(error);
            alertify.error(idArea != null ? "error al editar el rol" : 'error al agregar una área')
        }

    }
}
window.addEventListener("DOMContentLoaded",loadPage);