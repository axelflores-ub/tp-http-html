<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Empleados</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
    :root {
        --acento: #00695c;
        --acento-claro: #d6f0ea;
        --cabecera: #fff6e0;
        --fila-par: #ffffff;
        --fila-impar: #f1f8f6;
        --borde: #b9ddd4;
        /* Las filas de thead, tbody y tfoot comparten estas columnas, así quedan alineadas */
        --columnas: 1fr 2.2fr 1fr 1.6fr 1.2fr 1.2fr;
    }

    * { box-sizing: border-box; }

    html, body { height: 100%; }

    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #f4faf8;
        color: #1f2d2a;
        display: flex;
        flex-direction: column;
    }

    /* ---------- Encabezado ---------- */
    header {
        background-color: var(--cabecera);
        padding: 14px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        border-bottom: 1px solid #f0e2bb;
    }

    header h1 { margin: 0; flex: 1; font-size: 1.8rem; color: var(--acento); }

    .orden { display: flex; flex-direction: column; font-size: 0.85rem; }
    .orden input {
        width: 150px;
        padding: 4px 6px;
        border: 1px solid var(--borde);
        border-radius: 6px;
        background-color: #ffffff;
        font-weight: bold;
        color: var(--acento);
    }

    header button {
        padding: 12px 22px;
        border: none;
        border-radius: 8px;
        background-color: var(--acento-claro);
        color: var(--acento);
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
    }
    header button:hover { background-color: var(--acento); color: #ffffff; }

    /* ---------- Tabla ---------- */
    main { flex: 1; min-height: 0; padding: 14px 24px; display: flex; }

    table {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-collapse: collapse;
        background-color: #ffffff;
        border: 1px solid var(--borde);
        border-radius: 10px;
        overflow: hidden;
    }

    thead, tfoot { display: block; scrollbar-gutter: stable; overflow: hidden; }
    tbody { display: block; flex: 1; overflow-y: auto; scrollbar-gutter: stable; }

    tr { display: grid; grid-template-columns: var(--columnas); }

    th, td { padding: 8px 10px; text-align: left; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    thead tr.titulos { background-color: var(--acento-claro); }
    thead th { color: var(--acento); cursor: pointer; user-select: none; }
    thead th:hover { text-decoration: underline; }
    thead th.ordenActivo::after { content: " ▲"; font-size: 0.8em; }

    thead tr.filtros { background-color: var(--acento-claro); border-bottom: 2px solid var(--borde); }
    thead tr.filtros th { cursor: default; padding-top: 0; }
    thead tr.filtros input, thead tr.filtros select {
        width: 100%;
        padding: 6px;
        border: 1px solid var(--borde);
        border-radius: 6px;
        font: inherit;
        font-weight: normal;
    }

    tbody tr:nth-child(odd) { background-color: var(--fila-impar); }
    tbody tr:nth-child(even) { background-color: var(--fila-par); }
    tbody tr:hover { background-color: #fff6e0; }
    tbody td.mensaje { grid-column: 1 / -1; color: #5f7a74; font-style: italic; }
    .numero { text-align: right; }

    tfoot tr { background-color: var(--cabecera); border-top: 2px solid var(--borde); font-weight: bold; }

    /* ---------- Pie ---------- */
    footer {
        background-color: var(--cabecera);
        border-top: 1px solid #f0e2bb;
        padding: 10px 24px;
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }
    footer a { color: var(--acento); }

    /* En pantallas angostas la tabla se desplaza en horizontal en vez de aplastarse */
    @media (max-width: 800px) {
        main { overflow-x: auto; padding: 10px; }
        table { min-width: 760px; }
        header h1 { flex-basis: 100%; }
    }
</style>
</head>
<body>

<header>
    <h1>Empleados</h1>
    <div class="orden">
        <label for="orden">Orden:</label>
        <input type="text" id="orden" value="legajo" readonly>
    </div>
    <button type="button" id="btCargar">Cargar datos</button>
    <button type="button" id="btVaciar">Vaciar datos</button>
</header>

<main>
    <table>
        <thead>
            <tr class="titulos">
                <th id="th_empleados_legajo" data-campo="legajo">Legajo</th>
                <th id="th_empleados_apellidoNombres" data-campo="apellidoNombres">Apellido y nombres</th>
                <th id="th_empleados_dni" data-campo="dni">DNI</th>
                <th id="th_empleados_codArea" data-campo="codArea">Área</th>
                <th id="th_empleados_fechaIngreso" data-campo="fechaIngreso">Fecha ingreso</th>
                <th id="th_empleados_sueldoBasico" data-campo="sueldoBasico" class="numero">Sueldo básico</th>
            </tr>
            <tr class="filtros">
                <th><input type="text" id="f_empleados_legajo" placeholder="Filtrar"></th>
                <th><input type="text" id="f_empleados_apellidoNombres" placeholder="Filtrar"></th>
                <th><input type="text" id="f_empleados_dni" placeholder="Filtrar"></th>
                <th><select id="f_empleados_codArea"><option value=""></option></select></th>
                <th><input type="text" id="f_empleados_fechaIngreso" placeholder="aaaa-mm-dd"></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbDatos"></tbody>
        <tfoot>
            <tr>
                <td id="totalRegistros">Registros: 0</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total sueldos</td>
                <td id="totalSueldos" class="numero">$ 0,00</td>
            </tr>
        </tfoot>
    </table>
</main>

<footer>
    <span>Maestro de empleados · Axel Flores</span>
    <a href="../index.html">Volver a Php</a>
</footer>

<script>
// Descripción de cada área, para mostrarla en la tabla en lugar del código
const descripcionesAreas = {};

const formatoPesos = new Intl.NumberFormat('es-AR', { style: 'currency', currency: 'ARS' });

// Al entrar: se pide la tabla auxiliar de áreas para poblar el select del filtro
function cargaAreas() {
    fetch('./salidaJsonAreas.php')
    .then(respuesta => respuesta.text())
    .then(textoJSON => {
        alert(textoJSON);
        const objAreas = JSON.parse(textoJSON);
        objAreas.areas.forEach(area => {
            descripcionesAreas[area.codArea] = area.descripcionArea;
            const opcion = document.createElement('option');
            opcion.value = area.codArea;
            opcion.textContent = area.descripcionArea;
            document.getElementById('f_empleados_codArea').appendChild(opcion);
        });
        if (objAreas.error) {
            alert('Error del servidor: ' + objAreas.error);
        }
    })
    .catch(error => alert('Error producido: ' + error));
}

function muestraMensaje(texto) {
    $("#tbDatos").empty();
    const fila = document.createElement('tr');
    const celda = document.createElement('td');
    celda.className = 'mensaje';
    celda.textContent = texto;
    fila.appendChild(celda);
    document.getElementById('tbDatos').appendChild(fila);
}

function actualizaTotales(cuenta, totalSueldos) {
    $("#totalRegistros").text('Registros: ' + cuenta);
    $("#totalSueldos").text(formatoPesos.format(totalSueldos));
}

function marcaColumnaOrden() {
    $("thead tr.titulos th").removeClass('ordenActivo');
    $('thead tr.titulos th[data-campo="' + $("#orden").val() + '"]').addClass('ordenActivo');
}

function creaCelda(texto, clase) {
    const celda = document.createElement('td');
    celda.textContent = texto;
    if (clase) {
        celda.className = clase;
    }
    return celda;
}

function cargaTabla() {
    // 1) y 2) Se vacía el tbody y se avisa que se espera la respuesta
    muestraMensaje('Esperando respuesta del servidor...');
    marcaColumnaOrden();

    // 3) Objeto con el orden y los filtros que viajan en el body del requerimiento
    const objDatosOrdenFiltros = new URLSearchParams();
    objDatosOrdenFiltros.append('orden', $("#orden").val());
    objDatosOrdenFiltros.append('f_empleados_legajo', $("#f_empleados_legajo").val());
    objDatosOrdenFiltros.append('f_empleados_apellidoNombres', $("#f_empleados_apellidoNombres").val());
    objDatosOrdenFiltros.append('f_empleados_dni', $("#f_empleados_dni").val());
    objDatosOrdenFiltros.append('f_empleados_codArea', $("#f_empleados_codArea").val());
    objDatosOrdenFiltros.append('f_empleados_fechaIngreso', $("#f_empleados_fechaIngreso").val());

    alert('Lo que sale del navegador en el body:\n' + objDatosOrdenFiltros.toString());

    // 4) Disparo del AJAX y cadena de promesas
    fetch('./salidaJsonEmpleadosConPrepare.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: objDatosOrdenFiltros
    })
    .then(respuesta => respuesta.text())
    .then(textoJSON => {
        alert('Respuesta del servidor:\n' + textoJSON);
        const objEmpleados = JSON.parse(textoJSON);

        $("#tbDatos").empty();
        let totalSueldos = 0;

        objEmpleados.empleados.forEach(empleado => {
            const fila = document.createElement('tr');
            fila.appendChild(creaCelda(empleado.legajo));
            fila.appendChild(creaCelda(empleado.apellidoNombres));
            fila.appendChild(creaCelda(empleado.dni));
            fila.appendChild(creaCelda(descripcionesAreas[empleado.codArea] || empleado.codArea));
            fila.appendChild(creaCelda(empleado.fechaIngreso));
            fila.appendChild(creaCelda(formatoPesos.format(empleado.sueldoBasico), 'numero'));
            document.getElementById('tbDatos').appendChild(fila);
            totalSueldos += empleado.sueldoBasico;
        });

        if (objEmpleados.cuenta === 0) {
            muestraMensaje(objEmpleados.estado === 'conexion exitosa'
                ? 'No hay empleados que coincidan con los filtros.'
                : 'Error: ' + objEmpleados.estado);
        }
        actualizaTotales(objEmpleados.cuenta, totalSueldos);
    })
    .catch(error => {
        muestraMensaje('No se pudo obtener la respuesta.');
        alert('Error producido: ' + error);
    });
}

$(document).ready(function() {
    cargaAreas();
    marcaColumnaOrden();

    $("#btCargar").click(function() {
        cargaTabla();
    });

    // Vaciar solo limpia la vista: los datos siguen en la base y se pueden volver a cargar
    $("#btVaciar").click(function() {
        $("#tbDatos").empty();
        actualizaTotales(0, 0);
    });

    // Click en un título: se carga el input "orden" con esa columna y se vuelve a pedir la tabla
    $("thead tr.titulos th").click(function() {
        $("#orden").val($(this).attr('data-campo'));
        cargaTabla();
    });

    // Enter dentro de un filtro equivale a "Cargar datos"
    $("thead tr.filtros input").keyup(function(evento) {
        if (evento.key === 'Enter') {
            cargaTabla();
        }
    });
});
</script>

</body>
</html>
