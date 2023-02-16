window.onload = loadPage;
function loadPage(){
    let gen = new General();
    let cbArea = document.getElementById('areas'),
        cbRol = document.getElementById('roles');
    $(cbArea).on('select2:select',async function(e){
        try {
            cbRol.disabled = true;
            let data = new FormData();
            data.append('id_area',cbArea.value);
            let result = await gen.funcfetch('get-area',data);
            if(!result.error){
                let template = '<option></option>';
                console.log(result.success);
                result.success.forEach(e => {
                    template += `<option value='${e.id}'>${e.rol}</option>`;
                });
                cbRol.innerHTML = template;
                $('#role').select2('destroy');
                $('#roles').select2({theme: 'bootstrap',placeholder: 'Seleccione una opción',width: '100%'});
                cbRol.disabled = false;
            }
        } catch (error) {
            console.error(error);
        }
    })
    $('#roles, #areas').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: 'Seleccione una opción'
    })
}
