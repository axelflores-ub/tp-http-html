/* Tabla auxiliar de géneros: texto JSON (../generos.js) convertido en objeto de JavaScript */
const objGeneros = JSON.parse(textoJSONGeneros);

/* Variable arreglo de objetos: es la fuente de datos de la tabla.
   Arranca vacía. "Cargar datos" la llena a partir del JSON y el formulario le agrega libros nuevos. */
let arregloLibros = [];

/* ---------- Select de géneros ---------- */

/* Puebla el <select> del formulario barriendo el array de géneros con forEach() */
function creaOpcionesGeneros() {
    objGeneros.generos.forEach(function (argValor, argIndice) {
        var objOpcion = document.createElement("option");
        objOpcion.setAttribute("value", argValor.codGenero);
        objOpcion.innerHTML = argValor.descripcionGenero;
        document.getElementById("selectGenero").appendChild(objOpcion);
    });
}

/* Busca en la tabla auxiliar la descripción de un género a partir de su código */
function descripcionDeGenero(argCodGenero) {
    var objEncontrado = objGeneros.generos.find(function (argGenero) {
        return argGenero.codGenero === argCodGenero;
    });
    return objEncontrado ? objEncontrado.descripcionGenero : argCodGenero;
}

/* ---------- Tabla ---------- */

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

/* Crea en memoria la fila <tr> correspondiente a un objeto libro */
function creaFila(argLibro) {
    var objTr = document.createElement("tr");
    objTr.setAttribute("role", "row");

    objTr.appendChild(creaCelda("libros_codLibro", argLibro.codLibro));

    var objTdGenero = creaCelda("libros_codGenero", argLibro.codGenero);
    objTdGenero.setAttribute("title", descripcionDeGenero(argLibro.codGenero));
    objTr.appendChild(objTdGenero);

    objTr.appendChild(creaCelda("libros_titulo", argLibro.titulo));
    objTr.appendChild(creaCelda("libros_fechaAlta", fechaLegible(argLibro.fechaAlta)));
    objTr.appendChild(creaCelda("libros_ejemplares", argLibro.ejemplares));

    return objTr;
}

/* Recalcula la fila de totales recorriendo el arreglo de objetos */
function actualizaTotales() {
    var totalEjemplares = 0;
    arregloLibros.forEach(function (argLibro, argIndice) {
        totalEjemplares += argLibro.ejemplares;
    });
    $("#sumCantidad").text("Libros: " + arregloLibros.length);
    $("#sumEjemplares").text("Total: " + totalEjemplares.toLocaleString("es-AR"));
}

/* Botón "Cargar datos": el arreglo se llena desde el JSON y se dibuja la tabla */
function cargaDatos() {
    arregloLibros = JSON.parse(textoJSONLibros).libros;

    $("#tbDatos").empty();
    var objTbDatos = document.getElementById("tbDatos");
    arregloLibros.forEach(function (argValor, argIndice) {
        objTbDatos.appendChild(creaFila(argValor));
    });

    actualizaTotales();
}

/* Botón "Vaciar datos": se vacía el arreglo y la tabla */
function vaciaDatos() {
    arregloLibros = [];
    $("#tbDatos").empty();
    actualizaTotales();
}

/* ---------- Ventana modal ---------- */

/* El contenedor principal se desactiva (transparente y sin eventos) y se prende el modal.
   Además se lo marca "inert" para que tampoco se pueda llegar a sus botones con el teclado. */
function abreModal() {
    $("#contenedor").attr("class", "contenedorPasivo").prop("inert", true);
    $("#ventanaModal").attr("class", "ventanaModalPrendido");
    $("#codLibro").focus();
}

function cierraModal() {
    $("#ventanaModal").attr("class", "ventanaModalApagado");
    $("#contenedor").attr("class", "contenedorActivo").prop("inert", false);
    $("#btAgregar").focus();
}

/* ---------- Alta desde el formulario ---------- */

function altaLibro() {
    const objLibro = {
        codLibro: $("#codLibro").val().trim(),
        codGenero: $("#selectGenero").val(),
        titulo: $("#titulo").val().trim(),
        fechaAlta: $("#fechaAlta").val(),
        ejemplares: parseInt($("#ejemplares").val())
    };

    /* El código es la clave del maestro: no puede repetirse */
    var yaExiste = arregloLibros.some(function (argLibro) {
        return argLibro.codLibro.toUpperCase() === objLibro.codLibro.toUpperCase();
    });
    if (yaExiste) {
        alert("Ya existe un libro con el código " + objLibro.codLibro + ". Ingresá otro código.");
        $("#codLibro").focus();
        return;
    }

    /* Se agrega el objeto al arreglo y, en paralelo, se crea su fila en la tabla */
    arregloLibros.push(objLibro);

    var objTr = creaFila(objLibro);
    objTr.setAttribute("class", "filaNueva");       /* resalta la fila agregada por un instante */
    var objTbDatos = document.getElementById("tbDatos");
    objTbDatos.appendChild(objTr);
    objTbDatos.scrollTop = objTbDatos.scrollHeight;   /* baja hasta la fila nueva */

    actualizaTotales();
    $("#formLibro")[0].reset();
    cierraModal();
}

/* ---------- Código a ejecutar cuando termina de cargar el documento ---------- */
$(document).ready(function () {
    $("#contenedor").attr("class", "contenedorActivo");
    $("#ventanaModal").attr("class", "ventanaModalApagado");

    creaOpcionesGeneros();
    actualizaTotales();

    $("#btCargar").click(cargaDatos);
    $("#btVaciar").click(vaciaDatos);
    $("#btAgregar").click(abreModal);
    $("#btCierraModal").click(cierraModal);

    /* Con los atributos "required" el navegador solo dispara submit si todo está completo */
    $("#formLibro").submit(function (evento) {
        evento.preventDefault();
        altaLibro();
    });
});
