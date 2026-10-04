/* Los textos JSON vienen de ../libros.js y ../generos.js; acá los convierto en objetos de JavaScript */
const objLibros = JSON.parse(textoJSONLibros);
const objGeneros = JSON.parse(textoJSONGeneros);

/* Busca en la tabla auxiliar la descripción de un género a partir de su código */
function descripcionDeGenero(argCodGenero) {
    var objEncontrado = objGeneros.generos.find(function (argGenero) {
        return argGenero.codGenero === argCodGenero;
    });
    return objEncontrado ? objEncontrado.descripcionGenero : argCodGenero;
}

/* Crea en memoria una celda <td> con su atributo campo-dato y su contenido */
function creaCelda(argCampo, argContenido) {
    var objTd = document.createElement("td");
    objTd.setAttribute("role", "cell");
    objTd.setAttribute("campo-dato", argCampo);
    objTd.textContent = argContenido;
    return objTd;
}

/* "2020-06-15" -> "15/06/2020" */
function fechaLegible(argFechaIso) {
    return argFechaIso.split("-").reverse().join("/");
}

function actualizaTotales(argCantidadLibros, argTotalEjemplares) {
    $("#sumCantidad").text("Libros: " + argCantidadLibros);
    $("#sumEjemplares").text("Total: " + argTotalEjemplares.toLocaleString("es-AR"));
}

/* Barre el array de libros y crea una fila por cada objeto */
function cargaDatos() {
    $("#tbDatos").empty();                       /* así, apretar dos veces el botón no duplica filas */

    var objTbDatos = document.getElementById("tbDatos");
    var totalEjemplares = 0;

    objLibros.libros.forEach(function (argValor, argIndice) {
        var objTr = document.createElement("tr");
        objTr.setAttribute("role", "row");

        objTr.appendChild(creaCelda("libros_codLibro", argValor.codLibro));

        var objTdGenero = creaCelda("libros_codGenero", argValor.codGenero);
        objTdGenero.setAttribute("title", descripcionDeGenero(argValor.codGenero));
        objTr.appendChild(objTdGenero);

        objTr.appendChild(creaCelda("libros_titulo", argValor.titulo));
        objTr.appendChild(creaCelda("libros_fechaAlta", fechaLegible(argValor.fechaAlta)));
        objTr.appendChild(creaCelda("libros_ejemplares", argValor.ejemplares));

        objTbDatos.appendChild(objTr);
        totalEjemplares += argValor.ejemplares;
    });

    actualizaTotales(objLibros.libros.length, totalEjemplares);
}

function vaciaDatos() {
    $("#tbDatos").empty();
    actualizaTotales(0, 0);
}

$(document).ready(function () {
    actualizaTotales(0, 0);
    $("#btCargar").click(cargaDatos);
    $("#btVaciar").click(vaciaDatos);
});
