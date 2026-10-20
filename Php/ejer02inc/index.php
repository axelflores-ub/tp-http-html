<?php
/* Para que este ejercicio se vea igual en cualquier servidor, se fuerza que PHP informe
   todas las advertencias y se las muestra con un manejador propio (sin rutas del servidor). */
error_reporting(E_ALL);

set_error_handler(function (int $nivel, string $mensaje, string $archivo, int $linea) {
    $mensaje = preg_replace('/\s*\(include_path=[^)]*\)/', '', $mensaje);   /* oculta la ruta de include_path */
    echo "<div class='advertencia'><strong>Warning:</strong> " . htmlspecialchars($mensaje)
       . " <span class='linea'>(línea " . $linea . ")</span></div>";
    return true;
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>PHP include</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>La función include()</h1>
    <p>Ubica y ejecuta código PHP definido en otro archivo: <strong>datosEmpleados.php</strong></p>
</header>

<main>

<section class="tarjeta">
    <h2>Cómo leer este ejercicio</h2>
    <p>En este ejemplo se utiliza la función <code>include()</code>, que ubica código PHP definido en otro archivo (<code>datosEmpleados.php</code>). Ese archivo solo asigna dos arreglos asociativos con datos del Maestro de empleados: <span class="var">$aEmpleado1</span> y <span class="var">$aEmpleado2</span>.</p>
    <p class="nota">Probalo de las dos maneras: primero renombrá <strong>datosEmpleados.php</strong> y recargá la página, y después devolvele su nombre. Visualizá la diferencia.</p>
    <p>Las advertencias amarillas son mensajes reales de PHP, capturados con <code>set_error_handler()</code>.</p>
</section>

<!-- ============ PASO 1: ANTES DEL INCLUDE ============ -->
<section class="tarjeta">
    <h2><span class="paso">1</span> Antes del include</h2>
    <p>Antes de insertar el <code>include</code>, las variables declaradas en el otro archivo <strong>no existen</strong>. Pero, a pesar de ello, el ciclo de ejecución continúa hasta el final.</p>
    <p><strong>Las variables son:</strong></p>

    <?php
    echo "<div class='intento'>Intento leer <code>\$aEmpleado1['legajo']</code></div>";
    $lectura = $aEmpleado1['legajo'];
    echo "<div class='intento'>Intento leer <code>\$aEmpleado1['apellidoNombres']</code></div>";
    $lectura = $aEmpleado1['apellidoNombres'];
    echo "<div class='intento'>Intento leer <code>\$aEmpleado1['sueldoBasico']</code></div>";
    $lectura = $aEmpleado1['sueldoBasico'];

    echo "<div class='intento'>Intento leer <code>\$aEmpleado2['legajo']</code></div>";
    $lectura = $aEmpleado2['legajo'];
    echo "<div class='intento'>Intento leer <code>\$aEmpleado2['apellidoNombres']</code></div>";
    $lectura = $aEmpleado2['apellidoNombres'];
    echo "<div class='intento'>Intento leer <code>\$aEmpleado2['sueldoBasico']</code></div>";
    $lectura = $aEmpleado2['sueldoBasico'];
    ?>
</section>

<!-- ============ PASO 2: INCLUDE DE UN ARCHIVO QUE NO EXISTE ============ -->
<section class="tarjeta">
    <h2><span class="paso">2</span> include de un archivo que no existe</h2>
    <p>Cuando se usa <code>include</code> y el archivo asociado no existe, se visualiza un warning y el script sigue ejecutándose hasta el final.</p>

    <?php
    echo "<div class='intento'>Ejecuto <code>include 'archivoInexistente.php';</code></div>";
    $resultadoFaltante = include 'archivoInexistente.php';

    echo "<p class='exito'>El script siguió ejecutándose. include devolvió: <code>" . var_export($resultadoFaltante, true) . "</code></p>";
    ?>
</section>

<!-- ============ PASO 3: INCLUDE DEL ARCHIVO REAL ============ -->
<section class="tarjeta">
    <h2><span class="paso">3</span> include del archivo asociado</h2>
    <p>En este punto se ejecuta la función <code>include()</code> con el archivo real. Su código se ejecuta como si estuviera escrito acá mismo, por eso las variables pasan a existir en este script.</p>

    <?php
    echo "<div class='intento'>Ejecuto <code>include 'datosEmpleados.php';</code></div>";
    $resultadoReal = include 'datosEmpleados.php';

    if ($resultadoReal === false) {
        echo "<p class='nota'>No se encontró <strong>datosEmpleados.php</strong>: las variables siguen sin existir.</p>";
    } else {
        echo "<p class='exito'>include devolvió: <code>" . var_export($resultadoReal, true) . "</code> (el archivo se ejecutó bien)</p>";

        echo "<p><strong>Las 2 variables de tipo arreglo asociativo del archivo asociado son:</strong></p>";
        echo "<table class='empleados'>";
        echo "<tr><th>Variable</th><th>Legajo</th><th>Apellido y nombres</th><th>Área</th><th>Sueldo básico</th></tr>";
        echo "<tr><td>\$aEmpleado1</td><td>" . $aEmpleado1['legajo'] . "</td><td>" . $aEmpleado1['apellidoNombres'] . "</td><td>" . $aEmpleado1['codArea'] . "</td><td>" . $aEmpleado1['sueldoBasico'] . "</td></tr>";
        echo "<tr><td>\$aEmpleado2</td><td>" . $aEmpleado2['legajo'] . "</td><td>" . $aEmpleado2['apellidoNombres'] . "</td><td>" . $aEmpleado2['codArea'] . "</td><td>" . $aEmpleado2['sueldoBasico'] . "</td></tr>";
        echo "</table>";

        echo "<p>La longitud de <span class='var'>\$aEmpleado1</span> es: " . count($aEmpleado1) . "</p>";
        echo "<p>La longitud de <span class='var'>\$aEmpleado2</span> es: " . count($aEmpleado2) . "</p>";
    }
    ?>
</section>

<!-- ============ RESUMEN ============ -->
<section class="tarjeta">
    <h2>Resumen: las cuatro variantes</h2>
    <table class="comparativa">
        <tr><th>Sentencia</th><th>Si el archivo no existe</th><th>Si ya fue incluido antes</th></tr>
        <tr><td><code>include</code></td><td>Warning y el script continúa</td><td>Lo vuelve a ejecutar</td></tr>
        <tr><td><code>require</code></td><td>Error fatal y el script se detiene</td><td>Lo vuelve a ejecutar</td></tr>
        <tr><td><code>include_once</code></td><td>Warning y el script continúa</td><td>No lo repite</td></tr>
        <tr><td><code>require_once</code></td><td>Error fatal y el script se detiene</td><td>No lo repite</td></tr>
    </table>
</section>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
