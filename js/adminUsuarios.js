let elemento;
let modalRes;
let modalMen;


$(document).ready(function () {
    console.log('jquery.OK');
});

//Funcionalidad boton eliminar
$(document).on('click', '.boton_eliminar', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent()
    let dni = elemento.find('div.dniCliente').text();
    eliminarUsuario(dni);
    console.log(dni);

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

$(document).on('click', '.boton_editar', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    let dni = elemento.find('div.dniCliente').text();
    $(".usuarios_modal_dni").prop('readonly', true);
    $(".usuarios_modal_dni").val(elemento.find("div.dniCliente").text());
    $(".usuarios_modal_nombre").val(elemento.find("div.nombre").text());
    $(".usuarios_modal_direccion").val(elemento.find("div.direccion").text());
    $(".usuarios_modal_email").val(elemento.find("div.email").text());
    $(".modal_titulo").text("Editar usuario");
    // cargarUsuarioModal(dni);
    $("#modalAccion").show();
    console.log(dni);

});

$(document).on('click', '.boton_crear', function (event) {
    event.preventDefault();
    elemento = $(".cuerpo_tabla_usuarios");
    $(".modal_titulo").text("Nuevo usuario");
    $(".usuarios_modal_dni").prop('readonly', false);
    $(".modal_cuerpo :input").val('');
    $("#modalAccion").show();

});

$(document).on('click', '.boton_modal_cancelar', function (event) {
    event.preventDefault();
    $(".modal").hide();
});

$(document).on('click', '.boton_modal_aceptar', function (event) {
    event.preventDefault();
    let funcion = $(".modal_titulo").text();
    if (funcion == "Editar usuario") {
        modificarUsuario();
    } else if (funcion == "Nuevo usuario") {
        insertarUsuario();
    }

});


// Pido  todos los usuarios
function pedirUsuarios() {
    console.log("Entro a pedir usuarios");
    modalRes = $("#modalResultado");
    modalMen = $(".modal_mensaje");


    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/pedirUsuarios.php",
        dataType: "json",
        success: function (response) {
            imprimirTabla(response);
        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log(jqXHR);
            console.log(textStatus + " ---- ");
            console.log(thrownError + " ---- ");
            console.error("Error al pedir usuarios");
            console.log("error");
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al pedir usuarios");

        }
    });

}

// Imprimo la tabla
function imprimirTabla(response) {
    //primero borro la tabla pra poder actualizar datos
    $(".cuerpo_tabla").empty();
    //array para no usar algunas columnas como "pwd"
    const arrayOcultar = ["pwd"];
    let appendString = "";
    let cabecera = "<div class='cabecera_tabla cabecera_tabla_usuarios'>";
    let paso = 0;
    response["usuarios"].forEach(element => {
        appendString += "<div class='linea_tabla usuarios_linea_tabla'>"
        $.each(element, function (indexInArray, valueOfElement) {
            if (!arrayOcultar.includes(indexInArray)) {
                if (paso == 0) {
                    cabecera += "<div class='" + indexInArray + "'>" + indexInArray + "</div>";
                }
                appendString += "<div class='" + indexInArray + "'>" + valueOfElement + "</div>"
            }

        });
        paso++;
        appendString += "<div class='acciones'><span class='boton_editar' title='Editar'></span><span class='boton_eliminar' title='Eliminar'></span></div></div>"



    });
    cabecera += "<div class='acciones'>Acciones</div>";
    $(".cuerpo_tabla").append(cabecera);
    console.log(appendString);

    $(".cuerpo_tabla").append(appendString);

}

//insertar usuario
function insertarUsuario() {
    console.log("Entro a insertar usuarios");
    const dni = $(".usuarios_modal_dni").val();
    const nombre = $(".usuarios_modal_nombre").val()
    const direccion = $(".usuarios_modal_direccion").val();
    const email = $(".usuarios_modal_email").val();
    let peticion = {
        "dni": dni,
        "nombre": nombre,
        "direccion": direccion,
        "email": email
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/insertarUsuario.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            $(".modal").hide();
            if (response['Insertado']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);

                elemento.append("<div class='linea_tabla usuarios_linea_tabla'><div class='dniCliente'>" + dni + "</div><div class='nombre'>" + nombre + "</div><div class='direccion'>" + direccion + "</div><div class='email'>" + email + "</div><div class='administrador'>0</div><div class='acciones'><span class='boton_editar'></span><span class='boton_eliminar'></span></div></div>");
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['mensaje']);
            }

        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log(jqXHR);
            console.log(textStatus + " ---- ");
            console.log(thrownError + " ---- ");
            console.error("Error al insertar usuario");
            console.log("error");
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error de ajax al insertar");
        }
    });

}


// function cargarUsuarioModal(dni) {
//     console.log("Entro a cargarUsuario");
//     let peticion = {
//         "accion": "loadUser",
//         "dni": dni
//     };


//     $.ajax({
//         type: "POST",
//         url: "/Proyecto-DAW/php/adminUsuarios.php",
//         data: peticion,
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//             $(".usuarios_modal_dni").prop('readonly', true);
//             $(".usuarios_modal_dni").val(response['usuario']['dniCliente']);
//             $(".usuarios_modal_nombre").val(response['usuario']['nombre']);
//             $(".usuarios_modal_direccion").val(response['usuario']['direccion']);
//             $(".usuarios_modal_email").val(response['usuario']['email']);
//         },
//         error: function () {
//             console.log("error");
//         }
//     });
// }


function modificarUsuario() {
    console.log("Entro a modificar usuarios");
    const dni = $(".usuarios_modal_dni").val();
    const nombre = $(".usuarios_modal_nombre").val()
    const direccion = $(".usuarios_modal_direccion").val();
    const email = $(".usuarios_modal_email").val();
    let peticion = {
        "dni": dni,
        "nombre": nombre,
        "direccion": direccion,
        "email": email
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/modUsuario.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['modificado']) {
                elemento.find("div.nombre").text(nombre);
                elemento.find("div.direccion").text(direccion);
                elemento.find("div.email").text(email);
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
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
            modalMen.text("Error Ajax al intentar modificar usuario.");
        }
    });

}

function eliminarUsuario(dni) {
    console.log("Entro a eliminar");
    let peticion = {
        "dni": dni
    };


    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/eliminarUsuario.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['eliminado']) {
                elemento.remove();
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['mensaje']);
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
            modalMen.text("Error Ajax al eliminar usuario");
        }
    });
}