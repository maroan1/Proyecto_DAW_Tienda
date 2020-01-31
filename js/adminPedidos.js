let elemento;
let modalRes;
let modalMen;

$(document).ready(function () {
    console.log('jquery.OK');
});

$(document).on('click', '.boton_menu', function (event) {
    event.preventDefault();
    console.log("boton menu");
    $(this).toggleClass("active");
    menu = $(".menu");
    if (menu.is(':visible')) {
        menu.hide();
        $(".principal").css("padding-left", "0px")
    } else {
        menu.show();
        $(".principal").css("padding-left", "200px")
    }
});

//Funcionalidad boton eliminar
$(document).on('click', '.boton_eliminar', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent()
    let id = elemento.find('div.idPedido').text();
    console.log(id);

    eliminarPedido(id);

});

$(document).on('click', '.boton_eliminar_lineas', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    let id = elemento.find('div.idPedido').text();
    let nl = elemento.find('div.nlinea').text();
    console.log(id + " ---- " + nl);

    eliminarLinea(id, nl);

});

$(document).on('click', '.boton_mostrarLineas', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    let next = elemento.next('div');


    if (next.hasClass('lineaspedidos_tabla')) {
        if (next.is(':visible')) {
            next.hide();
        } else {
            next.show();
        }
    } else {
        let id = elemento.find('div.idPedido').text();
        console.log(id);
        pedirLineasPedido(id);
    }

});
//TODO: Formatear fechas

$(document).on('click', '.boton_editar', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    let id = elemento.find('div.idPedido').text();
    let fecha = elemento.find('div.fecha').text();
    let dniCliente = elemento.find('div.dniCliente').text();
    console.log(id);

    $(".modal_titulo").text("Editar pedido");
    // cargarPedidoModal(id);
    $(".pedidos_modal_id").val(id);
    $(".pedidos_modal_fecha").val(fecha);
    // $(".pedidos_modal_dni option[value=" + response['pedido']['dniCliente'] + "]").attr('selected', 'selected');
    $(".pedidos_modal_dni").val(dniCliente);
    $("#modal_editar").show();

});

$(document).on('click', '.boton_editar_lineas', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    let id = elemento.find('div.idPedido').text();
    let nlinea = elemento.find('div.nlinea').text();
    let idProducto = elemento.find('div.idProducto').text();
    let cantidad = elemento.find('div.cantidad').text();
    console.log(id + " - " + nlinea + " - " + " - " + idProducto + " - " + cantidad);

    $(".modal_titulo").text("Editar linea");
    $(".pedidos_modal_idPedido").val(id);
    $(".pedidos_modal_nlinea").val(nlinea);
    $(".pedidos_modal_productos").val(idProducto);
    $(".pedidos_modal_cantidad").val(cantidad);

    $("#modal_linea").show();
    // console.log(id);

});

$(document).on('click', '.boton_crear', function (event) {
    event.preventDefault();
    $(".modal_titulo").text("Nuevo pedido");
    $(".pedidos_modal_id").prop('readonly', false);
    $(".modal_cuerpo :input").val('');
    $("#modal_editar").first().show();
    elemento = $(".cuerpo_tabla_pedidos");
    // console.log(id);

});

$(document).on('click', '.boton_crear_lineas', function (event) {
    event.preventDefault();
    $(".modal_titulo").text("Nueva linea");
    $(".modal_cuerpo :input").val('');
    elemento = $(this).parent();
    const idPedido = elemento.prev('div').find('div.idPedido').text();
    $(".pedidos_modal_idPedido").val(idPedido);
    $("#modal_linea").show();
    // console.log(id);

});

$(document).on('click', '.boton_modal_cancelar', function (event) {
    event.preventDefault();
    $(".modal").hide();
    // console.log(id);

});

$(document).on('click', '.boton_modal_cancelar_lineas', function (event) {
    event.preventDefault();
    $("#modal_linea").hide();
    // console.log(id);

});

$(document).on('click', '.boton_modal_aceptar', function (event) {
    event.preventDefault();
    console.log("acepto");

    let funcion = $(".modal_titulo").first().text();
    console.log(funcion);

    if (funcion == "Editar pedido") {
        modificarPedido();
    } else if (funcion == "Nuevo pedido") {
        insertarPedido();
    }
    // else if (funcion == "Nueva linea") {
    //     console.log("entro a nueva linea");

    //     insertarLinea();
    // }
    // console.log(id);

});

$(document).on('click', '.boton_modal_aceptar_lineas', function (event) {
    event.preventDefault();
    console.log('Aceptar lineas');

    let funcion = $(".modal_titulo").first().text();
    if (funcion == "Nueva linea") {
        console.log("entro a nueva linea");

        insertarLinea();
    } else if (funcion == "Editar linea") {
        modificarLinea();
    }

});

function cargar() {
    pedirPedidos();
    modalRes = $("#modalResultado");
    modalMen = $(".modal_mensaje");

    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/cargarSelectspedidos.php",
        dataType: "json",
        success: function (response) {
            console.log(response);
            cargarSelects(response);
        },
        error: function () {
            console.error("Error al pedir pedidos");
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al cargar selects");

        }
    });
}


// Pido  todos los pedidos
function pedirPedidos() {
    console.log("Entro a pedir pedidos");


    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/pedirPedidos.php",
        dataType: "json",
        success: function (response) {
            console.log(response);

            imprimirTabla(response);
        },
        error: function () {
            console.error("Error al pedir pedidos");
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al insertar producto");

        }
    });

}

function pedirLineasPedido(id) {
    console.log("Entro a cargar lineas pedido con id: " + id);
    const peticion = {
        "id": id
    }

    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/pedirLineas.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);

            imprimirLineas(response);
        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log("error");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(thrownError);
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al pedir LineasPedido");
        }
    });

}

function cargarSelects(response) {
    let idsString = "";
    let productosString = "";
    response["dnis"].forEach(element => {
        idsString += "<option value='" + element + "'>" + element + "</option>"
    });

    $(".pedidos_modal_dni").append(idsString);

    response["productos"].forEach(element => {
        productosString += "<option value='" + element['idProducto'] + "'>ID:" + element['idProducto'] + " --> " + element['nombre'] + "</option>"
    });

    $(".pedidos_modal_productos").append(productosString);

}

// Imprimo la tabla
function imprimirTabla(response) {
    //primero borro la tabla pra poder actualizar datos
    $(".cuerpo_tabla").empty();
    //array para no usar algunas columnas como "pwd"
    const arrayOcultar = ["pwd"];
    let appendString = "";
    let cabecera = "<div class='cabecera_tabla cabecera_tabla_pedidos'>";
    let paso = 0;
    response["pedidos"].forEach(element => {
        appendString += "<div class='linea_tabla pedidos_linea_tabla'>";
        $.each(element, function (indexInArray, valueOfElement) {
            if (!arrayOcultar.includes(indexInArray)) {
                if (paso == 0) {
                    cabecera += "<div class='" + indexInArray + "'>" + indexInArray + "</div>";
                }
                appendString += "<div class='" + indexInArray + "'>" + valueOfElement + "</div>";
            }

        });
        paso++;
        appendString += "<div class='acciones'><span class='boton_mostrarLineas' title='Mostrar líneas'></span><span class='boton_editar' title='Editar'></span><span class='boton_eliminar' title='Eliminar'></span></div></div>"



    });
    cabecera += "<div class='acciones'>Acciones</div>"
    $(".cuerpo_tabla").append(cabecera);
    // response["dnis"].forEach(element => {
    //     idsString += "<option value='" + element + "'>" + element + "</option>"
    // });

    console.log(appendString);

    $(".cuerpo_tabla").append(appendString);
    // $(".pedidos_modal_dni").append(idsString);

}


function imprimirLineas(response) {
    //primero borro la tabla pra poder actualizar datos
    //array para no usar algunas columnas como "pwd"
    const arrayOcultar = ["pwd"];
    let appendString = "";
    let cabecera = "<div class='lineaspedidos_tabla'><span class='boton_crear_lineas'></span>";
    // let idsString = "";
    let paso = 0;
    if (response["lineas"] !== undefined) {
        cabecera += "<div class='cabecera_tabla cabecera_tabla_pedidos cabecera_tabla_pedidos_lineas'>";
        response["lineas"].forEach(element => {
            appendString += "<div class='linea_tabla pedidos_linea_tabla pedidos_linea_tabla_lineas'>";
            $.each(element, function (indexInArray, valueOfElement) {
                if (!arrayOcultar.includes(indexInArray)) {
                    if (paso == 0) {
                        cabecera += "<div class='" + indexInArray + "'>" + indexInArray + "</div>";
                    }
                    appendString += "<div class='" + indexInArray + "'>" + valueOfElement + "</div>";
                }

            });
            paso++;
            appendString += "<div class='acciones'><span class='boton_editar_lineas'>  </span><span class='boton_eliminar_lineas'>  </span></div></div>";



        });
        cabecera += "<div class='acciones'>Acciones</div></div>"
    }


    appendString += "</div>";
    cabecera += appendString;

    console.log(cabecera);

    elemento.after(cabecera);


}

//insertar pedido
function insertarPedido() {
    console.log("Entro a insertar pedidos");
    const dni = $(".pedidos_modal_dni").val();
    const fecha = $(".pedidos_modal_fecha").val()
    let peticion = {
        "dni": dni,
        "fecha": fecha
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/insertarPedido.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            $(".modal").hide();
            if (response['funciona']) {
                elemento.append("<div class='linea_tabla pedidos_linea_tabla'><div class='idPedido'>" + response['id'] + "</div><div class='fecha'>" + fecha + "</div><div class='dirEntrega'></div><div class='nTarjeta'></div><div class='fechaCaducidad'></div><div class='matriculaRepartidor'></div><div class='dniCliente'>" + dni + "</div><div class='acciones'><span class='boton_mostrarLineas'>  </span><span class='boton_editar'>  </span><span class='boton_eliminar'>  </span></div></div>");
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
            } else {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }
        },
        error: function (jqXHR, textStatus, thrownError) {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al insertar pedido");
            console.log("error");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(thrownError);
        }
    });

}

function insertarLinea() {
    console.log("Entro a insertar linea");
    const id = $(".pedidos_modal_idPedido").val();
    const idProducto = $(".pedidos_modal_productos").val();
    const cantidad = $(".pedidos_modal_productos").val();
    let peticion = {
        "id": id,
        "cantidad": cantidad,
        "idProducto": idProducto
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/insertarLinea.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            $(".modal").hide();
            if (response['funciona']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
                if (response['nlinea'] == "1") {
                    elemento.append("<div class='cabecera_tabla'><div class='idPedido'>idPedido</div><div class='nlinea'>nlinea</div><div class='idProducto'>idProducto</div><div class='cantidad'>cantidad</div><div class='acciones'>Acciones</div></div>");
                }
                console.log("escribo linea ");

                elemento.append("<div class='linea_tabla pedidos_linea_tabla pedidos_linea_tabla_lineas'><div class='idPedido'>" + id + "</div><div class='nlinea' > " + response["nlinea"] + "</div><div class='idProducto'>" + idProducto + "</div><div class='cantidad'>" + cantidad + "</div><div class='acciones'><span class='boton_editar_lineas'>  </span><span class='boton_eliminar_lineas'>  </span></div></div>");
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }
        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log("error");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(thrownError);
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al insertar linea");
        }
    });

}


function modificarPedido() {
    console.log("Entro a modificar pedidos");
    const dni = $(".pedidos_modal_dni").val();
    const fecha = $(".pedidos_modal_fecha").val()
    const id = $(".pedidos_modal_id").val()
    let peticion = {
        "id": id,
        "dni": dni,
        "fecha": fecha
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/modificarPedido.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['funciona']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
                elemento.find('div.dniCliente').text(dni);
                elemento.find('div.fecha').text(fecha);
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }


        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log("error cargar pedido");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(thrownError);
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al modificar pedido");
        }
    });

}

function modificarLinea() {
    console.log("Entro a modificar pedidos");
    const id = $(".pedidos_modal_idPedido").val();
    const idProducto = $(".pedidos_modal_productos").val();
    const cantidad = $(".pedidos_modal_cantidad").val();
    const nlinea = $(".pedidos_modal_nlinea").val();
    let peticion = {
        "id": id,
        "idProducto": idProducto,
        "cantidad": cantidad,
        "nlinea": nlinea
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/modificarLinea.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['funciona']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
                elemento.find('div.idProducto').text(idProducto);
                elemento.find('div.cantidad').text(cantidad);
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }
        },
        error: function () {
            console.log("error");
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al modificar linea");
        }
    });

}

function eliminarPedido(id) {
    console.log("Entro a eliminar");
    let peticion = {
        "id": id
    };
    console.log(peticion);

    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/eliminarPedido.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log("Response eliminarPedido");
            console.log(response);


            if (response['funciona']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
                elemento.remove();
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }
        },
        error: function (jqXHR, textStatus, thrownError) {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al eliminar pedido");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(thrownError);
        }
    });

}

function eliminarLinea(id, nlinea) {
    console.log("Entro a eliminar");
    let peticion = {
        "id": id,
        "nlinea": nlinea
    };


    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/eliminarLinea.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['funciona']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
                elemento.remove();
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }
        },
        error: function () {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al eliminar linea");
        }
    });
}