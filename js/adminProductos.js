let nombre_foto;
let id_producto;
let elemento;
let modalRes;
let modalMen;

$(document).ready(function () {
    console.log('jquery.OK');
    console.log("valor:" + $(".productos_modal_foto").val() + ":");

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
    elemento = $(this).parent().parent();
    let id = elemento.find('div.idProducto').text();
    eliminarProducto(id);
    console.log(id);

});

$(document).on('click', '.boton_editar', function (event) {
    event.preventDefault();
    elemento = $(this).parent().parent();
    id_producto = elemento.find('div.idProducto').text();
    $(".modal_titulo").text("Editar producto");
    $(".productos_modal_autor").val(elemento.find('div.autor').text());
    $(".productos_modal_nombre").val(elemento.find('div.nombre').text());
    $(".productos_modal_precio").val(elemento.find('div.precio').text());
    $(".productos_modal_foto").val('');
    nombre_foto = elemento.find('div.foto>img').attr('src').substring(18);
    // cargarProductoModal(id);
    $("#modal_crear").show();

});

$(document).on('click', '.boton_crear', function (event) {
    event.preventDefault();
    elemento = $(".cuerpo_tabla_productos");
    $(".modal_titulo").text("Nuevo producto");
    // $(".productos_modal_id").prop('readonly', false);
    $(".modal_cuerpo :input").val('');
    $("#modal_crear").show();

});

$(document).on('click', '.boton_modal_cancelar', function (event) {
    event.preventDefault();
    $(".modal").hide();

});

$(document).on('click', '.boton_modal_aceptar', function (event) {
    event.preventDefault();
    let funcion = $(".modal_titulo").text();
    if (funcion == "Editar producto") {
        if ($(".productos_modal_foto").val() == '') {
            // console.log("no cargo foto");
            modificarProducto();

        } else {
            console.log('cargo foto');
            subirImagen()
        }

    } else if (funcion == "Nuevo producto") {
        subirImagen()

    }

});

$(document).on('click', '.foto>img', function () {
    console.log("clickFoto");
    let src = $(this).attr('src');
    console.log(src);

    let imagen = "<img class='modal_imagen_foto' src='" + src + "' width='500' height='500'><span class='modal_imagen_cerrar'></span>";
    console.log(imagen);

    const modal = $("#modal_imagen>.modal_cuerpo");
    modal.html(imagen);
    $("#modal_imagen").show();
});

$(document).click(function (e) {
    if ($(e.target).is("#modal_imagen") ||
        $(e.target).is("img.modal_imagen_foto") ||
        $(e.target).is("div.modal_cuerpo")) {
        $("#modal_imagen").fadeOut(500);
    }
});


// Pido  todos los productos
function pedirProductos() {
    console.log("Entro a pedir productos");
    modalRes = $("#modalResultado");
    modalMen = $(".modal_mensaje");



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/pedirProductos.php",
        dataType: "json",
        success: function (response) {
            imprimirTabla(response);
        },
        error: function () {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al pedir productos");
            console.error("Error al pedir productos");
            console.log("error");

        }
    });

}

// Imprimo la tabla
function imprimirTabla(response) {
    //primero borro la tabla pra poder actualizar datos
    $(".cuerpo_tabla").empty();
    //array para no usar algunas columnas como "pwd"
    const arrayOcultar = [];
    let appendString = "";
    let cabecera = "<div class='cabecera_tabla cabecera_tabla_productos'>";
    let paso = 0;
    response["productos"].forEach(element => {
        appendString += "<div class='linea_tabla productos_linea_tabla'>"
        $.each(element, function (indexInArray, valueOfElement) {
            if (!arrayOcultar.includes(indexInArray)) {
                if (paso == 0) {
                    cabecera += "<div class='" + indexInArray + "'>" + indexInArray + "</div>";
                }
                if (indexInArray != "foto") {
                    appendString += "<div class='" + indexInArray + "'>" + valueOfElement + "</div>";
                } else {
                    appendString += "<div class='" + indexInArray + "'><img src='/Proyecto-DAW/img/" + valueOfElement + "'></div>";
                }

            }

        });
        paso++;
        appendString += "<div class='acciones'><span class='boton_editar' title='Editar'></span><span class='boton_eliminar' title='Eliminar'></span></span></div></div>";



    });
    cabecera += "<div class='acciones'>Acciones</div>"
    $(".cuerpo_tabla").append(cabecera);
    console.log(appendString);

    $(".cuerpo_tabla").append(appendString);

}

//insertar producto
function insertarProducto() {
    console.log("Entro a insertar productos");
    const nombre = $(".productos_modal_nombre").val()
    const autor = $(".productos_modal_autor").val();
    const precio = $(".productos_modal_precio").val();
    let peticion = {
        "nombre": nombre,
        "autor": autor,
        "precio": precio,
        "foto": nombre_foto
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/insertarProducto.php",
        data: peticion,
        dataType: "json",
        dataType: "json",
        success: function (response) {
            console.log(response);
            $(".modal").hide();
            if (response["Insertado"]) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response['Mensaje']);
                elemento.append("<div class='linea_tabla productos_linea_tabla'><div class='idProducto'>" + response['id'] + "</div><div class='nombre'>" + nombre + "</div><div class='idioma'></div><div class='foto'><img src='/Proyecto-DAW/img/" + nombre_foto + "'></div><div class='autor'>" + autor + "</div><div class='categoria'></div><div class='anyo'></div><div class='unidades'>100</div><div class='precio'>" + precio + "</div><div class='acciones'><span class='boton_editar'></span><span class='boton_eliminar'></span></div></div>");
            } else {
                modalRes.removeClass('success');
                modalRes.addClass('error');
                modalRes.show();
                modalMen.text(response['Mensaje']);
            }
        },
        error: function (jqXHR, textStatus, thrownError) {
            console.log("error1");
            console.log(jqXHR);
            console.log(textStatus + " ---- ");
            console.log(thrownError + " ---- ");
            $(".modal").hide();
            pedirProductos();
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al insertar producto");

            //TODO: mostrar modal error
        }
    });

}


// function cargarProductoModal(id) {
//     console.log("Entro a cargarProducto");
//     let peticion = {
//         "accion": "loadProduct",
//         "id": id
//     };


//     $.ajax({
//         type: "POST",
//         url: "/Proyecto-DAW/php/adminProductos.php",
//         data: peticion,
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//             // $(".productos_modal_id").prop('readonly', true);
//             $(".productos_modal_autor").val(response['producto']['autor']);
//             $(".productos_modal_nombre").val(response['producto']['nombre']);
//             nombre_foto = response['producto']['foto'];
//             $(".productos_modal_precio").val(response['producto']['precio']);
//             id_producto = id;
//         },
//         error: function () {
//             console.log("error");

//         }
//     });
// }


function modificarProducto() {
    console.log("Entro a modificar productos id:" + id_producto);
    // const id = id_producto;
    const nombre = $(".productos_modal_nombre").val()
    const autor = $(".productos_modal_autor").val();
    const precio = $(".productos_modal_precio").val();

    let peticion = {
        "id": id_producto,
        "nombre": nombre,
        "autor": autor,
        "precio": precio,
        "foto": nombre_foto
    };
    console.log(peticion);



    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/modificarProducto.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['modificado']) {
                modalRes.removeClass('error');
                modalRes.addClass('success');
                modalRes.show();
                modalMen.text(response["mensaje"]);
                elemento.find("div.nombre").text(nombre);
                elemento.find("div.autor").text(autor);
                elemento.find("div.precio").text(precio);
                elemento.find("div.foto").html("<img src='/Proyecto-DAW/img/" + nombre_foto + "'>");
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
            modalMen.text("Error Ajax al modificar producto");
        }
    });

}

function eliminarProducto(id) {
    console.log("Entro a eliminar");
    let peticion = {
        "id": id
    };


    $.ajax({
        type: "POST",
        url: "/Proyecto-DAW/php/eliminarProducto.php",
        data: peticion,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['eliminado']) {
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
            id_producto = '';
        },
        error: function () {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al eliminar producto");
        }
    });
}

function subirImagen() {
    // let foto = $('.productos_modal_foto').file[0];
    // console.log(foto);

    let formData = new FormData();
    const inputFile = document.querySelector(".productos_modal_foto");
    var primer_fichero = inputFile.files[0];
    console.log(primer_fichero);

    formData.append("fichero", primer_fichero); // En la posición 0; es decir, el primer elemento
    // let peticion = {
    //     "accion": "loadImage",
    //     "fichero": foto
    // };
    console.log(formData);


    $.ajax({
        url: '/Proyecto-DAW/php/subirImagen.php',
        type: 'POST',
        // data: peticion,
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //una vez finalizado correctamente
        success: function (response) {
            // alert("El archivo se subió correctamente");
            response = JSON.parse(response);
            console.log(response);
            nombre_foto = response['foto'];
            console.log(" . " + response['foto'] + " . " + response['subida']);
            let funcion = $(".modal_titulo").text();
            if (funcion == "Editar producto") {
                modificarProducto();
            } else if (funcion == "Nuevo producto") {
                if ($(".productos_modal_foto").val() == '') {
                    alert("Introduce una foto");
                }
                insertarProducto();

            }



        },
        //si ha ocurrido un error
        error: function () {
            modalRes.removeClass('success');
            modalRes.addClass('error');
            modalRes.show();
            modalMen.text("Error Ajax al subir imagen");
            alert("Ha ocurrido un error");
            return false;
        }

    });
}