/* Arreglo de objetos de dato: cada libro dado de alta desde el modal se guarda acá */
const arregloLibros = [];

/* Texto JSON de géneros (../generos.js) convertido en objeto de JavaScript */
const objGeneros = JSON.parse(textoJSONGeneros);

/* Puebla el <select> de géneros barriendo el array del objeto con forEach() */
function creaOpcionesGeneros() {
    objGeneros.generos.forEach(function (argValor, argIndice) {
        var objOpcion = document.createElement("option");
        objOpcion.setAttribute("value", argValor.codGenero);
        objOpcion.innerHTML = argValor.descripcionGenero;
        document.getElementById("selectGenero").appendChild(objOpcion);
    });
}

/* Abre el modal: el contenedor principal se desactiva (transparente y sin eventos)
   y el botón que abre el modal queda inactivo. */
function abreModal() {
    $("#contenedor").attr("class", "contenedorPasivo");
    $("#ventanaModal").attr("class", "ventanaModalPrendido");
    $("#btAbreModal").prop("disabled", true);
    $("#codLibro").focus();
}

/* Cierra el modal: se reactiva el contenedor principal y el botón */
function cierraModal() {
    $("#ventanaModal").attr("class", "ventanaModalApagado");
    $("#contenedor").attr("class", "contenedorActivo");
    $("#btAbreModal").prop("disabled", false).focus();
}

/* Arma un objeto con los datos del formulario y lo agrega al arreglo de libros */
function altaLibro() {
    const objLibro = {
        codLibro: $("#codLibro").val(),
        codGenero: $("#selectGenero").val(),
        descripcionGenero: $("#selectGenero option:selected").text(),
        titulo: $("#titulo").val(),
        fechaAlta: $("#fechaAlta").val(),
        ejemplares: parseInt($("#ejemplares").val())
    };

    arregloLibros.push(objLibro);
    console.log(arregloLibros);
    $("#cantLibros").text(arregloLibros.length);

    alert(
        "Libro dado de alta (" + arregloLibros.length + " en el arreglo)\n\n" +
        "Código: " + objLibro.codLibro + "\n" +
        "Título: " + objLibro.titulo + "\n" +
        "Género: " + objLibro.codGenero + " - " + objLibro.descripcionGenero + "\n" +
        "Fecha de alta: " + objLibro.fechaAlta + "\n" +
        "Ejemplares: " + objLibro.ejemplares
    );

    $("#formLibro")[0].reset();
}

/* Código a ejecutar cuando termina de cargar el documento */
$(document).ready(function () {
    $("#contenedor").attr("class", "contenedorActivo");
    $("#ventanaModal").attr("class", "ventanaModalApagado");

    creaOpcionesGeneros();

    $("#btAbreModal").click(abreModal);
    $("#btCierraModal").click(cierraModal);

    /* Con los atributos "required" el navegador solo dispara submit si todo está completo */
    $("#formLibro").submit(function (evento) {
        evento.preventDefault();
        altaLibro();
    });
});
