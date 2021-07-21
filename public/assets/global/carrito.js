function modificarCarrito(productoId, cantidad, stock, general = false) {

    const request = {producto: productoId, cantidad: cantidad, stock: stock};

    $.post(window.base_url + "/carrito-cantidad", request).done(function (data) {
         var carrito = $("*[producto-id='" + productoId + "']");

         console.log(data);

         // Actualizar notificación
        carrito.find(".carrito-notificacion").text("¡Se ha actualizado el carrito!");
        if (carrito.find("input").length > 0) {
            carrito.find("input").val(data.cantidad);
        } else {
            carrito.find(".carrito-cantidad").html(data.cantidad);
        }

        if (general) {
            window.location.reload();
        }

    });

}