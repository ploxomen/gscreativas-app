class General{
    token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
}