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
    funcfetch(url,dato){
        return fetch(url,{
            headers: {
                'X-CSRF-TOKEN' : this.token,
                'X-Requested-With' : 'XMLHttpRequest'
            },
            method: 'POST',
            body: dato
        }).then(response => response.json())
    }
    cargandoPeticion($boton,claseIcono,deshabilitar){
        const btn = $boton.querySelector("i");
        btn.disabled = deshabilitar;
        btn.className = claseIcono;
    }
}