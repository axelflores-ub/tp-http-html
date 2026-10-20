<?php
/* require() trae la tabla auxiliar de áreas. Si el archivo no existiera, la ejecución terminaría con un error fatal. */
require("./areas.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Formulario de alta de empleado</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>Alta de empleado</h1>
    <p>Formulario del Maestro de empleados enviado con el método <strong>POST</strong></p>
</header>

<main>

<section class="tarjeta">
    <h2>Ingrese la información</h2>
    <p class="nota">Al apretar el botón, el navegador envía los datos en el cuerpo del requerimiento HTTP (método POST) a <code>respuesta.php</code>. Por eso la URL de la respuesta va a quedar limpia, sin parámetros. En PHP cada dato se lee de <code>$_POST</code>, usando como índice el atributo <code>name</code> de cada campo.</p>

    <form class="alta" action="respuesta.php" method="post">

        <div class="campo">
            <label for="legajo">Legajo:</label>
            <input type="text" id="legajo" name="legajo" maxlength="12" placeholder="Ej: E-1004" required>
        </div>

        <div class="campo">
            <label for="apellidoNombres">Apellido y nombres:</label>
            <input type="text" id="apellidoNombres" name="apellidoNombres" maxlength="80" placeholder="Ej: Romero, Julián" required>
        </div>

        <div class="campo">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" inputmode="numeric" pattern="[0-9]{7,8}" maxlength="8" placeholder="Solo números" required>
        </div>

        <div class="campo">
            <label for="fechaIngreso">Fecha de ingreso:</label>
            <input type="date" id="fechaIngreso" name="fechaIngreso" required>
        </div>

        <div class="campo">
            <label for="codArea">Área de desempeño:</label>
            <select id="codArea" name="codArea" required>
                <option value="">Elegí un área</option>
                <?php
                /* Las opciones se crean desde PHP barriendo la tabla auxiliar: código => descripción */
                foreach ($aAreas as $codArea => $descripcionArea) {
                    echo "<option value='" . $codArea . "'>" . $codArea . " – " . $descripcionArea . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="campo">
            <label for="sueldoBasico">Sueldo básico:</label>
            <input type="number" id="sueldoBasico" name="sueldoBasico" min="0" step="0.01" placeholder="Ej: 1250000" required>
        </div>

        <div class="campo ancho">
            <button class="boton" type="submit">Ingrese la información</button>
        </div>

    </form>
</section>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
