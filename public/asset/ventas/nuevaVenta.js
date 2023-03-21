function loadPage() {
    let gen = new General();
    let swtichProductoMenor = document.querySelector("#idVentaPorMenor");
    for (const swhitchOn of document.querySelectorAll(".change-switch")) {
        swhitchOn.addEventListener("change", gen.switchs);
    }
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
    tablaDetalleVenta.addEventListener("click",function (e) {  
        if (e.target.classList.contains("btn-outline-danger")){
            const tr = e.target.parentElement.parentElement;
            const producto = tr.dataset.pormenor == "true" ? true : false;
            listaProductos = listaProductos.filter( p => {
                if(p.idProducto === parseInt(tr.dataset.producto)){
                    if (p.porMenor !== producto){
                        return p;
                    }
                    return
                }
                return p;
            });
            tr.remove();
            if (!listaProductos.length) {
                tablaDetalleVenta.innerHTML = `<tr>
                    <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                </tr>`;
            }
            sumarTotalDetalle();
        }
    });
    $('#productoBuscar').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: "Busque y seleccione un producto",
        templateResult : formatoListaProductos,
        matcher: matchCustom
    }).on("select2:select",async function(e){
        try {
            const indexProducto = listaProductos.findIndex(p => p.idProducto == $(this).val() && p.porMenor === swtichProductoMenor.checked);
            if (indexProducto < 0){
                const response = await gen.funcfetch("administrador/listar/" + $(this).val(), null, "GET");
                if (response.alerta) {
                    return alertify.alert("Alerta", response.alerta);
                }
                if (response.producto && indexProducto < 0) {
                    let precioVe = isNaN(parseFloat(response.producto.precioVenta)) ? 0.00 : parseFloat(response.producto.precioVenta);
                    if (!swtichProductoMenor.checked){
                        precioVe = isNaN(parseFloat(response.producto.precioVentaPorMayor)) ? 0.00 : parseFloat(response.producto.precioVentaPorMayor);
                        if (precioVe == 0){
                            $('#productoBuscar').val("").trigger("change");
                            return alertify.alert("Mensaje", "El producto <strong>" + response.producto.nombreProducto + "</strong> no cuenta con un precio de venta al por mayor o el valor es igual a S/ 0.00");
                        }
                    }
                    if (!listaProductos.length) {
                        tablaDetalleVenta.innerHTML = "";
                    }
                    let detalleTr = agregarDetalleVenta(tablaDetalleVenta.children.length + 1, response.producto.id, response.producto.urlProductos, response.producto.nombreProducto, precioVe,response.perecederos);
                    tablaDetalleVenta.append(detalleTr);
                    listaProductos.push({
                        idProducto: response.producto.id,
                        precio: precioVe,
                        descuento: 0,
                        cantidad: 1,
                        igv: response.producto.igv,
                        subtotal: precioVe,
                        vencimientos: response.perecederos[0].valor,
                        porMenor: swtichProductoMenor.checked
                    });
                    for (const cambio of detalleTr.querySelectorAll(".cambio-detalle")) {
                        cambio.addEventListener("change", modificarCantidad);
                    }
                }
            }else{
                const textMayor = !swtichProductoMenor.checked ? "pormayor" : "pormenor";
                const cantidad = tablaDetalleVenta.querySelector("#detalle-venta-producto-" + $(this).val() + "-" + textMayor);
                listaProductos[indexProducto].cantidad++;
                listaProductos[indexProducto].subtotal = (listaProductos[indexProducto].cantidad * listaProductos[indexProducto].precio) - listaProductos[indexProducto].descuento;
                cantidad.value = isNaN(parseInt(cantidad.value)) ? 1 : parseInt(cantidad.value) + 1;
                tablaDetalleVenta.querySelector("#detalle-venta-subtotal-" + $(this).val() + "-" + textMayor).textContent = gen.resetearMoneda(listaProductos[indexProducto].subtotal);
            }
            sumarTotalDetalle();
            $('#productoBuscar').val("").trigger("change");
        } catch (error) {
            alertify.error("error al obtener el producto");
            console.error(error);
        }
    });

    function agregarDetalleVenta(indice,id,urlImagenProducto,nombreProducto,precio,vencimientos){
        let tr = document.createElement("tr");
        const textMayor = !swtichProductoMenor.checked ? "pormayor" : "pormenor";
        let selectPerecedero = document.createElement("select");
        selectPerecedero.className = "form-control form-control-sm";
        vencimientos.forEach(v => {
            selectPerecedero.append(new Option(v.fecha,v.valor,false,false));
        });
        tr.dataset.producto = id;
        tr.dataset.pormenor = swtichProductoMenor.checked;
        tr.innerHTML = `
        <td>${indice}</td>
        <td><img src="${urlImagenProducto}" class="tdimagen-producto" /></td>
        <td>${nombreProducto}</td>
        <td>${gen.resetearMoneda(precio)}</td>
        <td><input type="number" min="1" data-tipo="cantidad" id="detalle-venta-producto-${id}-${textMayor}" class="form-control form-control-sm cambio-detalle" value="1"/></td>
        <td><input type="number" min="0" data-tipo="descuento" step="0.01" class="form-control form-control-sm cambio-detalle" value="0.00"/></td>
        <td>${selectPerecedero.outerHTML}</td>
        <td><span id="detalle-venta-subtotal-${id}-${textMayor}">${gen.resetearMoneda(precio)}</span></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> <span>Elimar</span></button></td>
        `
        return tr;
    }
    function sumarTotalDetalle(){
        let igv = 0,total = 0,descuento = 0;
        listaProductos.forEach(dv => {
            descuento += dv.descuento;
            total += dv.subtotal;
            igv += !dv.igv ? 0 : (dv.subtotal * 0.18); 
        });
        total = total - descuento;
        if(total < 0){
            return alertify.error("el monto de la venta no debe ser menor a S/ 0.00");
        }
        document.querySelector("#tDetalleSubTotal").textContent = gen.resetearMoneda((total - igv).toFixed(2));
        document.querySelector("#tDetalleIgv").textContent = gen.resetearMoneda(igv.toFixed(2));
        document.querySelector("#tDetalleDescuento").textContent = "- " + gen.resetearMoneda(descuento.toFixed(2));
        document.querySelector("#tDetalleTotal").textContent = gen.resetearMoneda(total.toFixed(2));
    }
    function modificarCantidad(e){
        const tr = e.target.parentElement.parentElement;
        const textMayor = tr.dataset.pormenor == "true" ? "pormenor" : "pormayor";
        const valorPorMenor = tr.dataset.pormenor == "true" ? true : false;
        const indexProducto = listaProductos.findIndex(p => p.idProducto == tr.dataset.producto && p.porMenor === valorPorMenor);
        if(indexProducto < 0){
            alertify.error("producto no encontrado");
        }
        let valor = e.target.step ? parseFloat(e.target.value) : parseInt(e.target.value);
        if(isNaN(valor)){
            valor = 1;
        }
        const txtSubTotal = tr.querySelector("#detalle-venta-subtotal-" + tr.dataset.producto + "-" + textMayor);

        switch (e.target.dataset.tipo) {
            case 'cantidad':
                listaProductos[indexProducto].cantidad = valor;
                listaProductos[indexProducto].subtotal = listaProductos[indexProducto].precio * valor;
            break;
            case 'descuento':
                listaProductos[indexProducto].descuento = valor;
                listaProductos[indexProducto].subtotal = listaProductos[indexProducto].precio * listaProductos[indexProducto].cantidad;
            break;
        }
        if(listaProductos[indexProducto].subtotal < 0){
            listaProductos[indexProducto].cantidad = 1;
            listaProductos[indexProducto].subtotal = listaProductos[indexProducto].precio;
            listaProductos[indexProducto].descuento = 0;
            tr.querySelector(`[data-tipo="cantidad"]`).value = "1";
            tr.querySelector(`[data-tipo="descuento"]`).value = "0.00";
        }
        txtSubTotal.textContent = gen.monedaSoles(listaProductos[indexProducto].subtotal.toFixed(2));
        sumarTotalDetalle();
    }
    // $('#productoBuscar').select2("open");
}
window.addEventListener("DOMContentLoaded",loadPage);