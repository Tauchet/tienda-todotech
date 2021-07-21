function comprarProductos() {

    const formulario = $('<form>', {
        method: 'POST'
    });

    formulario.appendTo(document.body).submit();

}