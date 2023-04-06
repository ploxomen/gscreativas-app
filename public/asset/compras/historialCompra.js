function loadPage() {
    let general = new General();
    const tablaHisotial = document.querySelector("#tablaHistorial");
    const tablaHisotialDataTable = $(tablaHisotial).DataTable({
        ajax: {
            url: 'historial/listar',
            method: 'POST',
            headers: general.requestJson,
            data:function(d){
                d.productos = $("#productoBuscar").val();
            }
        },
        columns: [
        {
            data: 'nroCompra'
        },
        {
            data: 'fechaComp'
        },
        {
            data: 'nombreProducto'
        },
        {
            data: 'nombreMarca'
        },
        {
            data: 'nombrePresentacion'
        },
        {
            data: 'nombre_proveedor'
        },
        {
            data: 'precio',
            render : function (dato) {  
                return !dato ? 'Sin precio' : general.monedaSoles(dato); 
            }
        }
        ]
    });
    $('#productoBuscar').on("select2:select",function(e){
        tablaHisotialDataTable.draw();
    })
}
window.addEventListener("DOMContentLoaded", loadPage);