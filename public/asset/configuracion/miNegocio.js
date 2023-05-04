function loadPage(){
    const general = new General();
    const frmMiNegocio = document.querySelector("#configuracionMiNegocio");
    const btnSubmitFrmNegocio = document.querySelector("#btnSubmitNegocio");
    frmMiNegocio.addEventListener("submit",async function (e) {
        e.preventDefault();
        general.cargandoPeticion(btnSubmitFrmNegocio, general.claseSpinner, true);
        const datos = new FormData(this);
        try {
            const response = await general.funcfetch("negocio/actualizar", datos, "POST");
            if (response.session) {
                return alertify.alert([...general.alertaSesion], () => { window.location.reload() });
            }
            if (response.success) {
                alertify.success(response.success);
            }
        } catch (error) {
            console.error(error);
            alertify.error("error al actualizar los datos de configuracion");
        }finally{
            general.cargandoPeticion(btnSubmitFrmNegocio, 'fas fa-pencil-alt', false);
        }
    })
}
window.addEventListener("DOMContentLoaded",loadPage);