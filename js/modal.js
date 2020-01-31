$(document).ready(function () {

    console.log('jquery OK');
    $("#cerrarModal").click(function () {
        $("#modalLogin").hide();
    });



});


function showModal(id) {
    $(id).show();
}

function hideModal(id) {
    $(id).hide();
}