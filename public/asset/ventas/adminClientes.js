function loadPage(){
    let gen = new General();
    for (const swhitchOn of document.querySelectorAll(".change-switch")) {
        swhitchOn.addEventListener("change",gen.switchs);
    }
    const tablaClientes = document.querySelector("#tablaClientes");
    const tablaClientesDatatable = $(tablaClientes).DataTable({
        ajax: {
            url: 'clientes/listar',
            method: 'POST',
            headers: gen.requestJson
        },
        columns: [{
            data: 'id',
            render: function(data,type,row, meta){
                return meta.row + 1;
            }
        },
        {
            data: 'tipo_documento',
            render : data => gen.validarVacio(!data ? null : data.documento)
        },
        {
            data: 'nroDocumento',
            render : gen.validarVacio
        },
        {
            data: 'nombreCliente',
            render : gen.validarVacio
        },
        {
            data: 'celular',
            render : gen.validarVacio
        },
        {
            data: 'telefono',
            render : gen.validarVacio
        },
        {
            data: 'correo',
            render : gen.validarVacio
        },
        {
            data: 'direccion',
            render : gen.validarVacio
        },
        {
            data: 'limteCredito',
            render : gen.validarVacio
        },
        {
            data : 'estado',
            render : function(data){
                if(data === 1){
                    return '<span class="badge badge-success">Activo</span>';
                }else if(data === 0){
                    return '<span class="badge badge-danger">Descontinuado</span>';
                }else{
                    return '<span class="text-danget">No establecido</span>';
                }
            }
        },
        {
            data: 'id',
            render : function(data){
                return `<div class="d-flex justify-content-center" style="gap:5px;"><button class="btn btn-sm btn-outline-info p-1" data-cliente="${data}">
                    <small>
                    <i class="fas fa-pencil-alt"></i>
                    Editar
                    </small>
                </button>
                <button class="btn btn-sm btn-outline-danger p-1" data-cliente="${data}">
                    <small>    
                    <i class="fas fa-trash-alt"></i>
                        Eliminar
                    </small>
                </button></div>`
            }
        },
        ]
    });
    let idCliente = null;
    const btnModalSave = document.querySelector("#btnGuardarFrm");
    const formCliente = document.querySelector("#formCliente");
    formCliente.addEventListener("submit",async function(e){
        e.preventDefault();
        let datos = new FormData(this);
        try {
            gen.cargandoPeticion(btnModalSave, gen.claseSpinner, true);
            const response = await gen.funcfetch(idCliente ? "clientes/editar/" + idCliente : "clientes/crear",datos);
            if(response.session){
                return alertify.alert([...alertaSesion],() => {window.location.reload()});
            }
            if(response.error){
                return alertify.alert("Error",response.error);
            }
            alertify.success(response.success);
            tablaClientesDatatable.draw();
            $('#agregarCliente').modal("hide");
        } catch (error) {
            console.error(error);
            alertify.error("error al agregar un cliente");
        }finally{
            gen.cargandoPeticion(btnModalSave, 'fas fa-save', false);
        }
    });
    const modalTitulo = document.querySelector("#titulocliente");
    $('#agregarCliente').on("hidden.bs.modal",function(e){
        idCliente = null;
        modalTitulo.textContent = "Crear cliente";
        switchEstado.disabled = true;
        switchEstado.checked = true;
        switchEstado.parentElement.querySelector("label").textContent = "VIGENTE";
        formCliente.reset();
        $('#agregarCliente .select2-simple').trigger("change");
    });
    const switchEstado = document.querySelector("#idModalestado");
    btnModalSave.onclick = e => document.querySelector("#btnFrmEnviar").click();
    tablaClientes.addEventListener("click",async function(e){
        if (e.target.classList.contains("btn-outline-info")){
            btnModalSave.querySelector("span").textContent = "Editar";
            try {
                gen.cargandoPeticion(e.target, gen.claseSpinner, true);
                const response = await gen.funcfetch("clientes/listar/" + e.target.dataset.cliente,null,"GET");
                gen.cargandoPeticion(e.target, 'fas fa-pencil-alt', false);
                if (response.session) {
                    return alertify.alert([...gen.alertaSesion], () => { window.location.reload() });
                }
                modalTitulo.textContent = "Editar cliente";
                idCliente = e.target.dataset.cliente;
                for (const key in response.cliente) {
                    if (Object.hasOwnProperty.call(response.cliente, key)) {
                        const valor = response.cliente[key];
                        const dom = document.querySelector("#idModal" + key);
                        if (key == "estado"){
                            switchEstado.checked = valor === 1 ? true : false;
                            switchEstado.parentElement.querySelector("label").textContent = valor === 1 ? "VIGENTE" : "DESCONTINUADO";
                            continue;
                        }
                        dom.value = valor;
                    }
                }
                $('#agregarCliente .select2-simple').trigger("change");
                switchEstado.disabled = false;
                $('#agregarCliente').modal("show");
            } catch (error) {
                gen.cargandoPeticion(e.target, 'fas fa-pencil-alt', false);
                console.error(error);
                alertify.error("error al obtener el cliente");
            }
        }
        if (e.target.classList.contains("btn-outline-danger")) {
            alertify.confirm("Alerta","¿Estás seguro de eliminar este cliente?",async ()=>{
                try {
                    gen.cargandoPeticion(e.target, gen.claseSpinner, true);
                    const response = await gen.funcfetch("clientes/eliminar/" + e.target.dataset.cliente, null,"DELETE");
                    gen.cargandoPeticion(e.target, 'fas fa-trash-alt', false);
                    if (response.session) {
                        return alertify.alert([...gen.alertaSesion], () => { window.location.reload() });
                    }
                    tablaClientesDatatable.draw();
                    return alertify.success(response.success);
                } catch (error) {
                    gen.cargandoPeticion(e.target, 'fas fa-trash-alt', false);
                    console.error(error);
                    alertify.error("error al eliminar el usuario");
                }
            },()=>{});
            
        }
    })
}
window.addEventListener("DOMContentLoaded",loadPage);

