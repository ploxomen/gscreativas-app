function loadPage() {
    let gen = new General();
    const formatoListaProductos = function(producto){
        if(!producto.id){
            return producto.text;
        }
        let urlProducto = window.location.origin + "/intranet/storage/productos/" + producto.element.dataset.url;
        let precioVenta = isNaN(parseFloat(producto.element.dataset.venta)) ? "No establecido" : gen.monedaSoles(producto.element.dataset.venta);
        let precioVentaMayor = isNaN(parseFloat(producto.element.dataset.ventaMayor)) ? "No establecido" : gen.monedaSoles(producto.element.dataset.ventaMayor);
        let $producto = $(
            `<div class="d-flex" style="gap:5px;">
                <div>
                    <img src="${urlProducto}" width="60px" height="60px" class="select2-img">
                </div>
                <div>
                    <p class="mb-0" style="font-size: 0.8rem;">
                        <span>${producto.text}</span><br>
                        <span><b>Precio Venta:</b> ${precioVenta}</span><br>
                        <span><b>Precio Venta Mayor:</b> ${precioVentaMayor}</span>
                    </p>
                </div>
                
            </div>`
        );
        return $producto;
    }
    function matchCustom(params, data) {
        if ($.trim(params.term) === '') {
          return data;
        }
        if (typeof data.text === 'undefined') {
          return null;
        }
        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1 || (data.element.dataset.codigo && data.element.dataset.codigo.indexOf(params.term) > -1 )) {
          return $.extend({}, data, true);
        }
        return null;
    }
    let listaProductos = [];
    let tablaDetalleVenta = document.querySelector("#tablaDetalleVenta tbody");
    $('#productoBuscar').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: "Busque y seleccione un producto",
        templateResult : formatoListaProductos,
        matcher: matchCustom
    }).on("select2:select",async function(e){
        try {
            const response = await gen.funcfetch("administrador/listar/" + $(this).val(),null,"GET");
            if(response.alerta){
                return alertify.alert("Alerta",response.alerta);
            }
            const indexProducto = listaProductos.findIndex(p => p.idProducto == $(this).val());
            if(response.producto && indexProducto < 0){
                if(!listaProductos.length){
                    tablaDetalleVenta.innerHTML = "";
                }
                let detalleTr = agregarDetalleVenta(tablaDetalleVenta.children.length + 1,response.producto.id,response.producto.urlProductos,response.producto.nombreProducto,response.producto.precioVenta);
                tablaDetalleVenta.append(detalleTr);
                listaProductos.push({
                    idProducto : response.producto.id,
                    precio: parseFloat(response.producto.precioVenta),
                    descuento: 0,
                    cantidad : 1,
                    subtotal: parseFloat(response.producto.precioVenta)
                });
                for (const cambio of detalleTr.querySelectorAll(".cambio-detalle")) {
                    cambio.addEventListener("change",modificarCantidad);
                }
            }else if(response.producto && indexProducto >= 0){
                const cantidad = tablaDetalleVenta.querySelector("#detalle-venta-producto-" + response.producto.id);
                listaProductos[indexProducto].cantidad++;
                cantidad.value = isNaN(parseInt(cantidad.value)) ? 1 : parseInt(cantidad.value) + 1;
            }
            // console.log(listaProductos);
            $('#productoBuscar').val("").trigger("change");
        } catch (error) {
            alertify.error("error al obtener el producto");
            console.error(error);
        }
    });

    function agregarDetalleVenta(indice,id,urlImagenProducto,nombreProducto,precio){
        let tr = document.createElement("tr");
        tr.dataset.producto = id;
        tr.innerHTML = `
        <td>${indice}</td>
        <td><img src="${urlImagenProducto}" class="tdimagen-producto" /></td>
        <td>${nombreProducto}</td>
        <td>${gen.resetearMoneda(precio)}</td>
        <td><input type="number" min="1" data-tipo="cantidad" id="detalle-venta-producto-${id}" class="form-control form-control-sm cambio-detalle" value="1"/></td>
        <td><input type="number" min="0" data-tipo="descuento" step="0.01" class="form-control form-control-sm cambio-detalle" value="0.00"/></td>
        <td><input step="0.01" id="detalle-venta-subtotal-${id}" readonly type="number" class="form-control form-control-sm" value="${precio}"/></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> <span>Elimar</span></button></td>
        `
        return tr;
    }
    function modificarCantidad(e){
        const tr = e.target.parentElement.parentElement;
        const indexProducto = listaProductos.findIndex(p => p.idProducto == tr.dataset.producto);
        if(indexProducto < 0){
            alertify.error("producto no encontrado");
        }
        let valor = e.target.step ? parseFloat(e.target.value) : parseInt(e.target.value);
        if(isNaN(valor)){
            valor = 1;
        }
        const txtSubTotal = tr.querySelector("#detalle-venta-subtotal-" + tr.dataset.producto);

        switch (e.target.dataset.tipo) {
            case 'cantidad':
                listaProductos[indexProducto].cantidad = valor;
                listaProductos[indexProducto].subtotal = (listaProductos[indexProducto].precio * valor) - listaProductos[indexProducto].descuento;
            break;
            case 'descuento':
                listaProductos[indexProducto].descuento = valor;
                listaProductos[indexProducto].subtotal = (listaProductos[indexProducto].precio * listaProductos[indexProducto].cantidad) - valor;
            break;
        }
        if(listaProductos[indexProducto].subtotal < 0){
            listaProductos[indexProducto].cantidad = 1;
            listaProductos[indexProducto].subtotal = listaProductos[indexProducto].precio;
            listaProductos[indexProducto].descuento = 0;
            tr.querySelector(`[data-tipo="cantidad"]`).value = "1";
            tr.querySelector(`[data-tipo="descuento"]`).value = "0.00";
        }
        txtSubTotal.value = listaProductos[indexProducto].subtotal.toFixed(2);
    }
    // $('#productoBuscar').select2("open");
}
window.addEventListener("DOMContentLoaded",loadPage);