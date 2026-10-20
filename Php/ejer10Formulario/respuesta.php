<?php
require("./areas.php");

/* Todo dato que viene del formulario lo controla quien navega: se escapa antes de mostrarlo. */
function esc($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

$metodo = $_SERVER['REQUEST_METHOD'];
$aCampos = ["legajo", "apellidoNombres", "dni", "fechaIngreso", "codArea", "sueldoBasico"];
$aEtiquetas = [
    "legajo"          => "Legajo",
    "apellidoNombres" => "Apellido y nombres",
    "dni"             => "DNI",
    "fechaIngreso"    => "Fecha de ingreso",
    "codArea"         => "Área de desempeño",
    "sueldoBasico"    => "Sueldo básico"
];

$aDatos = [];
$aErrores = [];

if ($metodo === "POST") {

    /* Se leen los datos recibidos en $_POST. Si alguien manda un arreglo en lugar de un texto
       (por ejemplo legajo[]=x), se lo trata como vacío en vez de dejar que trim() falle. */
    foreach ($aCampos as $campo) {
        $valor = $_POST[$campo] ?? "";
        $aDatos[$campo] = is_string($valor) ? trim($valor) : "";
    }

    /* Validación en el servidor: los controles del navegador se pueden saltear. */
    if (!preg_match('/^[A-Za-z0-9-]{1,12}$/', $aDatos["legajo"])) {
        $aErrores[] = "El legajo es obligatorio y admite letras, números y guiones (hasta 12 caracteres).";
    }
    if ($aDatos["apellidoNombres"] === "" || strlen($aDatos["apellidoNombres"]) > 80) {
        $aErrores[] = "Apellido y nombres es obligatorio (hasta 80 caracteres).";
    }
    if (!preg_match('/^[0-9]{7,8}$/', $aDatos["dni"])) {
        $aErrores[] = "El DNI debe tener 7 u 8 dígitos.";
    }

    $fecha = DateTime::createFromFormat("Y-m-d", $aDatos["fechaIngreso"]);
    $infoFecha = DateTime::getLastErrors();
    $fechaValida = ($fecha !== false) && ($infoFecha === false || ($infoFecha["warning_count"] === 0 && $infoFecha["error_count"] === 0));
    if (!$fechaValida) {
        $aErrores[] = "La fecha de ingreso no es una fecha válida.";
    } elseif ($fecha > new DateTime("today")) {
        $aErrores[] = "La fecha de ingreso no puede ser posterior a hoy.";
    }

    if (!array_key_exists($aDatos["codArea"], $aAreas)) {
        $aErrores[] = "El área de desempeño no figura en la tabla de áreas.";
    }
    if (!is_numeric($aDatos["sueldoBasico"]) || (float) $aDatos["sueldoBasico"] < 0) {
        $aErrores[] = "El sueldo básico debe ser un número mayor o igual a cero.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Respuesta al formulario</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>Respuesta al formulario</h1>
    <p>Lo que PHP recibió en <strong>$_POST</strong></p>
</header>

<main>

<?php if ($metodo !== "POST") { ?>

<section class="tarjeta">
    <h2>No se recibieron datos</h2>
    <p>Esta página se pidió con el método <strong><?php echo esc($metodo); ?></strong>, y para leer datos en <code>$_POST</code> hace falta que el formulario los envíe con el método POST.</p>
    <p><a class="boton" href="index.php">Ir al formulario</a></p>
</section>

<?php } else { ?>

<section class="tarjeta">
    <h2>Valores pasados:</h2>

    <?php
    if (count($aErrores) > 0) {
        echo "<div class='errores'><strong>No se pudo dar de alta al empleado:</strong><ul>";
        foreach ($aErrores as $error) {
            echo "<li>" . esc($error) . "</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<p class='exito'>Los datos recibidos son válidos.</p>";
    }

    /* Lectura directa por el atributo name del campo, como en el apunte */
    echo "<p>Legajo = " . esc($aDatos["legajo"]) . "<br>";
    echo "Apellido y nombres = " . esc($aDatos["apellidoNombres"]) . "</p>";
    ?>

    <h3>Todos los datos, recorridos con foreach (clave =&gt; valor)</h3>
    <table class="recibido">
        <tr><th>$_POST['campo']</th><th>Dato</th><th>Valor recibido</th></tr>
        <?php
        foreach ($aDatos as $clave => $valor) {
            $mostrado = esc($valor);
            if ($clave === "codArea" && array_key_exists($valor, $aAreas)) {
                $mostrado = esc($valor . " – " . $aAreas[$valor]);
            } elseif ($clave === "fechaIngreso" && $valor !== "") {
                $mostrado = esc(implode("/", array_reverse(explode("-", $valor))));
            }
            echo "<tr><th>" . esc($clave) . "</th><td>" . esc($aEtiquetas[$clave]) . "</td><td>" . $mostrado . "</td></tr>";
        }
        ?>
    </table>
</section>

<section class="tarjeta">
    <h2>Cómo llegaron los datos</h2>
    <p>Método del requerimiento (<code>$_SERVER['REQUEST_METHOD']</code>): <strong><?php echo esc($metodo); ?></strong></p>
    <p>Parámetros en la URL (<code>$_GET</code>): <strong><?php echo count($_GET); ?></strong>. Con POST los datos no viajan en la URL: por eso la barra de direcciones muestra solo <code>respuesta.php</code>.</p>
    <p><a class="boton" href="index.php">Volver</a></p>
</section>

<?php } ?>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
