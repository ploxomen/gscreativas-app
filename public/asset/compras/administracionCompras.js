function loadPage() {
    let general = new General();
    const tablaCompras = document.querySelector("#tablaCompras");
    const tablaComprasDataTable = $(tablaCompras).DataTable({
        ajax: {
            url: 'listar/mostrar',
            method: 'POST',
            headers: general.requestJson,
            data: function (d) {
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
                data: 'nroComprobante'
            },
            {
                data: 'proveedor.nombre_proveedor'
            },
            {
                data: 'importe',
                render: function (dato) {
                    return !dato ? 'Sin subtotal' : general.monedaSoles(dato);
                }
            },
            {
                data: 'igv',
                render: function (dato) {
                    return !dato ? 'Sin I.G.V' : general.monedaSoles(dato);
                }
            },
            {
                data: 'total',
                render: function (dato) {
                    return !dato ? 'Sin total' : general.monedaSoles(dato);
                }
                
            },
            {
                data: 'id',
                render: function (data) {
                    return `<div class="d-flex justify-content-center" style="gap:5px;"><button class="btn btn-sm btn-outline-info p-1" type="button" data-compra="${data}">
                    <small>
                    <i class="fas fa-pencil-alt"></i>
                    Editar
                    </small>
                </button>
                <button class="btn btn-sm btn-outline-danger p-1" data-compra="${data}">
                    <small>    
                    <i class="fas fa-trash-alt"></i>
                        Eliminar
                    </small>
                </button></div>`
                }
            }
        ]
    });
    let listaCompras = [];
    let idCompra = null;
    const tablaCompra = document.querySelector("#tablaDetalleVenta tbody");
    tablaCompra.addEventListener("click", async function (e) {
        if (e.target.classList.contains("btn-outline-danger")) {
            if (e.target.parentElement.parentElement.dataset.tipo == "actualizar"){
                alertify.confirm("Mensaje","¿Deseas eliminar este producto de la compra?",async ()=>{
                    let datos = new FormData();
                    datos.append("compra",idCompra);
                    datos.append("producto", e.target.parentElement.parentElement.dataset.producto);
                    const response = await general.funcfetch("listar/eliminar",datos,"POST");
                    if (response.session) {
                        return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
                    }
                    if(response.alerta){
                        return alertify.alert("Alerta",response.alerta);
                    }
                    listaCompras = listaCompras.filter(c => c.id != e.target.parentElement.parentElement.dataset.producto);
                    calculoTotal();
                    e.target.parentElement.parentElement.remove();
                    if (!listaCompras.length) {
                        tablaCompra.innerHTML = `
                        <tr>
                            <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                        </tr>
                    `
                    }
                    alertify.success(response.success);
                    tablaComprasDataTable.draw();
                },()=>{})
            }else{
                listaCompras = listaCompras.filter(c => c.id != e.target.parentElement.parentElement.dataset.producto);
                calculoTotal();
                e.target.parentElement.parentElement.remove();
                if (!listaCompras.length) {
                    tablaCompra.innerHTML = `
                        <tr>
                            <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                        </tr>
                    `
                }
            }
        }
    })
    tablaCompras.onclick = async function(e){
        if (e.target.classList.contains("btn-outline-info")){
            try{
                const response = await general.funcfetch("listar/mostrar/" + e.target.dataset.compra,null,"GET");
                if (response.session) {
                    return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
                }
                listaCompras = [];
                idCompra = e.target.dataset.compra;
                for (const key in response.compra) {
                    if (Object.hasOwnProperty.call(response.compra, key)) {
                        const valor = response.compra[key];
                        const $dom = document.querySelector("#idModal"+key);
                        if(!$dom){
                            continue;
                        }
                        if(key == "importe" || key == "igv" || key == "total"){
                            $dom.textContent = general.monedaSoles(valor);
                            continue;
                        }
                        $dom.value = valor;
                    }
                }
                tablaCompra.innerHTML = "";
                $("#editarCompra .select2-simple").trigger("change");
                response.detalleCompra.forEach(cd => {
                    const precioProd = isNaN(parseFloat(cd.pivot.precio)) ? 0 : parseFloat(cd.pivot.precio);
                    listaCompras.push({
                        id: cd.pivot.productoFk,
                        cantidad: cd.pivot.cantidad,
                        precio: precioProd
                    });
                    renderProducto(cd.pivot.productoFk, cd.pivot.cantidad, cd.nombreProducto, precioProd, general.urlProductos + cd.urlImagen,"actualizar");
                });
                $("#editarCompra").modal("show");
            }catch(error){
                console.error(error);
            }
        }
        if (e.target.classList.contains("btn-outline-danger")){
            alertify.confirm("Alerta","¿Deseas eliminar esta compra?",async ()=>{
                const response = await general.funcfetch("listar/eliminar/compra/" + e.target.dataset.compra, null, "GET");
                if (response.session) {
                    return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
                }
                tablaComprasDataTable.draw();
                return alertify.success(response.success);
            },()=>{})
        }
    }
    $("#editarCompra").on("hidden.bs.modal",function (e) {  
        idCompra = null;
        listaCompras = null;
    })
    $("#productoBuscar").on("select2:select",async function(e){
        const indexListaCompra = listaCompras.findIndex(p => p.id == $(this).val());
        if (indexListaCompra >= 0) {
            const trProducto = tablaCompra.querySelector(`[data-producto="${$(this).val()}"]`);
            listaCompras[indexListaCompra].cantidad++;
            trProducto.querySelector(".change-cantidad").value = listaCompras[indexListaCompra].cantidad;
            trProducto.querySelector(".importe").textContent = (listaCompras[indexListaCompra].cantidad * listaCompras[indexListaCompra].precio).toFixed(2);
            calculoTotal();
            return
        }
        try {
            const response = await general.funcfetch("registrar/consultar/" + $(this).val(), null, "GET");
            if (response.session) {
                return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
            }
            if (response.producto) {
                const precioProducto = isNaN(parseFloat(response.producto.precioCompra)) ? 0.00 : parseFloat(response.producto.precioCompra).toFixed(2);
                if (!listaCompras.length) {
                    tablaCompra.innerHTML = "";
                }
                listaCompras.push({
                    id: response.producto.id,
                    cantidad: 1,
                    precio: precioProducto
                });
                renderProducto(response.producto.id, 1, response.producto.nombreProducto, precioProducto, general.urlProductos + response.producto.urlImagen);
                calculoTotal();
            }
        } catch (error) {
            console.error(error);
            return alertify.alert("Error", "Ocurrió un error al obterner el producto, por favor intentelo más tarde");
        }
        $(this).val("").trigger("change");
    });
    function renderProducto(id, cantidad, producto, precio, url,tipo) {
        const tr = document.createElement("tr");
        tr.dataset.producto = id;
        tr.dataset.tipo = tipo;
        tr.innerHTML = `
            <td><input type="hidden" name="producto[]" value="${id}">${listaCompras.length}</td>
            <td><img class="tdimagen-producto" src="${url}"></td>
            <td>${producto}</td>
            <td><input class="form-control change-precio form-control-sm" name="precio[]" step="0.01" min="0.01" value="${precio}"></td>
            <td><input name="cantidad[]" class="form-control change-cantidad form-control-sm" min="1" value="${cantidad}"></td>
            <td class="importe">${(precio * cantidad).toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button></td>
            `
        tablaCompra.append(tr);
        for (const cambio of tr.querySelectorAll("input")) {
            cambio.addEventListener("change", calcularImporte);
        }
    }
    document.querySelector("#btnGuardarFrm").onclick = e => document.querySelector("#btnFrmEnviar").click();
    document.querySelector("#formCompra").addEventListener("submit",async function(e){
        e.preventDefault();
        let datos = new FormData(this);
        datos.append("compra",idCompra);
        try {
            const response = await general.funcfetch("listar/agregar",datos,"POST");
            if (response.session) {
                return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
            }
            $("#editarCompra").modal("hide");
            tablaComprasDataTable.draw();
            return alertify.success(response.success);
        } catch (error) {
            console.error(error);
            alertify.error("error al actualizar la compra");
        }
    });
    function calculoTotal() {
        let total = 0;
        listaCompras.forEach(c => {
            total += c.cantidad * c.precio;
        });
        document.querySelector("#idModalimporte").textContent = general.monedaSoles(total - (total * 0.18));
        document.querySelector("#idModaligv").textContent = general.monedaSoles(total * 0.18);
        document.querySelector("#idModaltotal").textContent = general.monedaSoles(total);
    }
    function calcularImporte() {
        const indexListaCompra = listaCompras.findIndex(p => p.id == this.parentElement.parentElement.dataset.producto);
        if (indexListaCompra >= 0) {
            const trProducto = this.parentElement.parentElement;
            let importe = 0;
            if (this.classList.contains("change-precio")) {
                const precio = isNaN(parseFloat(this.value)) || this.value == "" || this.value < 0 ? 0.00 : parseFloat(this.value);
                listaCompras[indexListaCompra].precio = precio;
                importe = precio * listaCompras[indexListaCompra].cantidad;
                this.value = parseFloat(this.value).toFixed(2);
            } else {
                const cantidad = isNaN(parseInt(this.value)) || this.value == "" || this.value < 0 ? 0 : parseInt(this.value);
                listaCompras[indexListaCompra].cantidad = cantidad;
                importe = cantidad * listaCompras[indexListaCompra].precio;
                this.value = parseInt(this.value);
            }
            if (isNaN(this.value) || this.value == "" || this.value < 0) {
                this.value = this.classList.contains("change-precio") ? 0.00 : 0;
            }
            trProducto.querySelector(".importe").textContent = importe.toFixed(2);
            calculoTotal()
        }
    }
}
window.addEventListener("DOMContentLoaded", loadPage);