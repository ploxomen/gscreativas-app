function loadPage() {
    let general = new General();
    const btnAbrirCaja = document.querySelector("#btnAbrirCaja");
    btnAbrirCaja.addEventListener("click",function(e){
        general.funcfetch("abrir",null,"POST");
    });
}
window.addEventListener("DOMContentLoaded",loadPage);