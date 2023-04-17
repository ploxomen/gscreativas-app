function loadPage() {
    let gen = new General();
    let listaCompras = [];
    const formatoListaProductos = function (producto) {
        if (!producto.id) {
            return producto.text;
        }
        let urlProducto = gen.urlProductos  + producto.element.dataset.url;
        let $producto = $(
            `<div class="d-flex" style="gap:5px;">
                <div>
                    <img src="${urlProducto}" width="60px" height="60px" class="select2-img">
                </div>
                <div>
                    <p class="mb-0" style="font-size: 0.8rem;">
                        <span>${producto.text}</span><br>
                    </p>
                </div>
                
            </div>`
        );
        return $producto;
    }
    const tablaCompra = document.querySelector("#tablaDetalleVenta tbody");
    tablaCompra.addEventListener("click",function(e){
        if (e.target.classList.contains("btn-outline-danger")){
            listaCompras = listaCompras.filter(c => c.id != e.target.parentElement.parentElement.dataset.producto)
            calculoTotal();
            e.target.parentElement.parentElement.remove();
            if (!listaCompras.length){
                tablaCompra.innerHTML = `
                <tr>
                    <td colspan="100%" class="text-center">No se seleccionó ningún producto</td>
                </tr>
                `
            }
        }
    })
    $('#productoBuscar').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: "Busque y seleccione un producto",
        templateResult: formatoListaProductos,
    }).on("select2:select",async function(e){
        const indexListaCompra = listaCompras.findIndex( p => p.id == $(this).val());
        if(indexListaCompra >= 0){
            const trProducto = tablaCompra.querySelector(`[data-producto="${$(this).val()}"]`);
            listaCompras[indexListaCompra].cantidad++;
            trProducto.querySelector(".change-cantidad").value = listaCompras[indexListaCompra].cantidad;
            trProducto.querySelector(".importe").textContent = (listaCompras[indexListaCompra].cantidad * listaCompras[indexListaCompra].precio).toFixed(2);
            calculoTotal();
            return
        }
        try {
            const response = await gen.funcfetch("registrar/consultar/" + $(this).val(), null, "GET");
            if (response.session) {
                return alertify.alert([...gen.alertaSesion], () => { window.location.reload() });
            }
            if(response.producto){
                const precioProducto = isNaN(parseFloat(response.producto.precioCompra)) ? 0.00 : parseFloat(response.producto.precioCompra).toFixed(2);
                if (!listaCompras.length){
                    tablaCompra.innerHTML = "";
                }
                listaCompras.push({
                    id: response.producto.id,
                    cantidad : 1,
                    precio: precioProducto
                });
                renderProducto(response.producto.id, 1, response.producto.nombreProducto, precioProducto, gen.urlProductos + response.producto.urlImagen);
                calculoTotal();
            }
        } catch (error) {
            console.error(error);
            return alertify.alert("Error","Ocurrió un error al obterner el producto, por favor intentelo más tarde");
        }
        $(this).val("").trigger("change");
    });
    function calculoTotal(){
        let total = 0;
        listaCompras.forEach(c => {
            total += c.cantidad * c.precio;
        });
        document.querySelector("#tDetalleSubTotal").textContent = gen.monedaSoles(total - (total * 0.18));
        document.querySelector("#tDetalleIgv").textContent = gen.monedaSoles(total * 0.18);
        document.querySelector("#tDetalleTotal").textContent = gen.monedaSoles(total);
    }
    function renderProducto(id, cantidad, producto, precio, url) {
        const tr = document.createElement("tr");
        tr.dataset.producto = id;
        tr.innerHTML = `
            <td>${listaCompras.length}</td>
            <td><img class="tdimagen-producto" src="${url}"></td>
            <td>${producto}</td>
            <td><input class="form-control change-precio form-control-sm" step="0.01" min="0.01" value="${precio}"></td>
            <td><input class="form-control change-cantidad form-control-sm" min="1" value="${cantidad}"></td>
            <td class="importe">${(precio * cantidad).toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> <span>Elimar</span></button></td>
            `
        tablaCompra.append(tr);
        for (const cambio of tr.querySelectorAll("input")) {
            cambio.addEventListener("change", calcularImporte);
        }
    }
    function calcularImporte(){
        const indexListaCompra = listaCompras.findIndex(p => p.id == this.parentElement.parentElement.dataset.producto);
        if (indexListaCompra >= 0) {
            const trProducto = this.parentElement.parentElement;
            let importe = 0;
            if (this.classList.contains("change-precio")){
                const precio = isNaN(parseFloat(this.value)) || this.value == "" || this.value < 0 ? 0.00 : parseFloat(this.value);
                listaCompras[indexListaCompra].precio = precio; 
                importe = precio * listaCompras[indexListaCompra].cantidad;
                this.value = parseFloat(this.value).toFixed(2);
            }else{
                const cantidad = isNaN(parseInt(this.value)) || this.value == "" || this.value < 0 ? 0 : parseInt(this.value);
                listaCompras[indexListaCompra].cantidad = cantidad;
                importe = cantidad * listaCompras[indexListaCompra].precio;
                this.value = parseInt(this.value);
            }
            if(isNaN(this.value) || this.value == "" || this.value < 0){
                this.value = this.classList.contains("change-precio") ? 0.00 : 0;
            }
            trProducto.querySelector(".importe").textContent = importe.toFixed(2);
            calculoTotal()
        }
    }
    
    document.querySelector("#generarCompra").addEventListener("submit",function(e){
        e.preventDefault();
        if(!listaCompras.length){
            return alertify.error("para agregar una comprar debe haber mínimo un producto");
        }
        alertify.confirm("Mensaje", "¿Deseas agregar una nueva compra?", async ()=>{
            let datos = new FormData(this);
            listaCompras.forEach(c => {
                datos.append("productos[]",c.id);
                datos.append("cantidad[]", c.cantidad);
                datos.append("precio[]", c.precio);
            });
            try {
                const response = await gen.funcfetch("registrar/crear",datos,"POST");
                if(response.session){
                    return alertify.alert([...gen.alertaSesion], () => { window.location.reload() });
                }
                alertify.alert("Mensaje",response.success,()=>{window.location.reload()});
            } catch (error) {
                console.error(error);
                return alertify.alert("Error","Ocurrió un error al registrar una compra, por favor intentelo más tarde");
            }
        },()=>{})
    });
}
window.addEventListener("DOMContentLoaded",loadPage);