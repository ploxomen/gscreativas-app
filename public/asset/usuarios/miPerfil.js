function loadPage(){
    let general = new General();
    const imgAvatar = document.querySelector("#file-avatar");
    const $prevAvatar = document.querySelector("#previewAvatar");
    document.querySelector("#btnCargarAvatar").onclick = e => imgAvatar.click();
    imgAvatar.addEventListener("change",function(e){
        const reader = new FileReader();
        reader.onload = function(r){
            $prevAvatar.src = reader.result;
        }
        reader.readAsDataURL(e.target.files[0])
    });
    document.querySelector("#formUpdatePerfil").addEventListener("submit",async function(e){
        e.preventDefault();
        let datos = new FormData(this);
        try {
            const response = await general.funcfetch("miperfil/actualizar",datos);
            if(response.error){
                return alertify.alert("Error",response.error);
            }
            alertify.success(response.success);
        } catch (error) {
            console.error(error);
            alertify.error("error al actualizar el perfil, porfavor intentelo más tarde");
        }
    })
}
window.addEventListener("DOMContentLoaded",loadPage);