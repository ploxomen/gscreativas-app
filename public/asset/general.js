class General{
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    alertaSesion = ["Alerta","La sesión a caducado, favor inicie sesión nuevamente"];
    /*
    if(response.session){
        return alertify.alert([...alertaSesion],() => {window.location.reload()});
    }
    */ 
    requestJson = {
        'X-CSRF-TOKEN': this.token,
        'X-Requested-With': 'XMLHttpRequest'
    }
    claseSpinner = "fas fa-spinner fa-spin";
    funcfetch(url,dato,metodo = "POST"){
        return fetch(url,{
            headers: {
                'X-CSRF-TOKEN' : this.token,
                'X-Requested-With' : 'XMLHttpRequest'
            },
            method: metodo,
            body: dato
        }).then(response => response.json())
    }
    cargandoPeticion($boton,claseIcono,deshabilitar){
        const btn = $boton.querySelector("i");
        btn.disabled = deshabilitar;
        btn.className = claseIcono;
    }
    aumentarDisminuir(e){
        const $numero = document.querySelector(e.target.dataset.number);
        const cantidad = isNaN(parseFloat($numero.step)) ? 1 : parseFloat($numero.step);
        let valor = isNaN(parseFloat($numero.value)) ? 0 : parseFloat($numero.value);
        const fixed = cantidad === 1 ? 0 : cantidad.toString().split(".")[1].length;
        const minimo = isNaN(parseFloat($numero.min)) ? Number.NEGATIVE_INFINITY : parseFloat($numero.min);
        const maximo = isNaN(parseFloat($numero.max)) ? Number.POSITIVE_INFINITY : parseFloat($numero.max);
        if(e.target.dataset.accion == "aumentar" && valor <= maximo){
            $numero.value =  (valor + cantidad).toFixed(fixed);
        }else if(e.target.dataset.accion == "disminuir" && valor > minimo){
            $numero.value =  (valor - cantidad).toFixed(fixed);
        }
    }
    resetearMoneda(numero){
        const newNum = isNaN(parseFloat(numero)) ? 0 : parseFloat(numero);
        return newNum.toLocaleString('es-PE',{
            style: 'currency',
            currency: 'PEN',
        })
    }
    switchs(e){
        const label = e.target.parentElement.querySelector("label");
        label.textContent = e.target.checked ? e.target.dataset.selected : e.target.dataset.noselected;
    }
}