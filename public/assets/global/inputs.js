$(function() {

    const inputCustom = $(".input-custom input");
    inputCustom.focus(function(evento) {
        const seleccionado = $(evento.target).parent().parent();
        seleccionado.toggleClass("focus");
    });
    inputCustom.blur(function(evento) {
        const seleccionado = $(evento.target).parent().parent();
        seleccionado.toggleClass("focus");
    });

});