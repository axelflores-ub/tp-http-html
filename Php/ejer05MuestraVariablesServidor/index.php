<?php
/* $_SERVER es un arreglo asociativo global: el índice es una cadena que describe el dato.
   Se muestran las variables agrupadas como enseña el apunte (servidor, cliente y requerimiento)
   y, al final, todo el arreglo barrido con foreach($_SERVER as $clave => $valor). */

/* Grupos de variables (los mismos tres grupos del apunte) */
$aGrupos = [
    "Variables de servidor" => [
        "detalle" => "Tienen que ver con parámetros del servidor.",
        "claves"  => ["SERVER_ADDR", "SERVER_PORT", "SERVER_NAME", "HTTP_HOST", "DOCUMENT_ROOT"]
    ],
    "Variables de cliente" => [
        "detalle" => "Tienen que ver con parámetros del navegador remoto.",
        "claves"  => ["REMOTE_ADDR", "REMOTE_PORT"]
    ],
    "Variables de requerimiento" => [
        "detalle" => "Tienen que ver con parámetros del requerimiento HTTP.",
        "claves"  => ["SCRIPT_NAME", "SERVER_PROTOCOL", "REQUEST_METHOD", "REQUEST_URI", "QUERY_STRING"]
    ]
];

/* Algunos valores del requerimiento los controla quien navega (User-Agent, Referer, la URL...).
   Por eso todo valor se escapa con htmlspecialchars() antes de enviarlo al navegador.
   Además, no se muestran claves que suelen guardar datos privados (cookies, credenciales, tokens). */
function esClaveReservada($clave) {
    return preg_match('/COOKIE|AUTH|PASS|SECRET|TOKEN|KEY/i', $clave) === 1;
}

function textoDelValor($valor) {
    if (is_array($valor)) {
        $valor = implode(", ", $valor);
    }
    /* En el hosting las rutas incluyen el usuario de la cuenta (if0_12345678): se lo enmascara para no publicarlo */
    $valor = preg_replace('/if0_[0-9]+/', 'if0_********', (string) $valor);
    return htmlspecialchars($valor);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Variables de servidor</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>Variables globales de servidor</h1>
    <p>El arreglo asociativo <strong>$_SERVER</strong> recorrido con <strong>foreach</strong> (clave =&gt; valor)</p>
</header>

<main>

<?php
/* Un foreach exterior recorre los grupos; uno interior recorre las variables de cada grupo como clave => valor */
foreach ($aGrupos as $tituloGrupo => $aGrupo) {

    /* Del arreglo global $_SERVER se arma el subconjunto de claves de este grupo */
    $aSeleccion = [];
    foreach ($aGrupo["claves"] as $claveBuscada) {
        $aSeleccion[$claveBuscada] = $_SERVER[$claveBuscada] ?? "(no disponible)";
    }

    echo "<section class='tarjeta'>";
    echo "<h2>" . $tituloGrupo . "</h2>";
    echo "<p class='detalle'>" . $aGrupo["detalle"] . "</p>";
    echo "<div class='contenedorTabla'><table class='variables'>";

    foreach ($aSeleccion as $clave => $valor) {
        $texto = textoDelValor($valor);
        $claseCelda = ($texto === "") ? " class='vacio'" : "";
        if ($texto === "") {
            $texto = "(vacío)";
        }
        echo "<tr><th>" . $clave . "</th><td" . $claseCelda . ">" . $texto . "</td></tr>";
    }

    echo "</table></div>";
    echo "</section>";
}
?>

<!-- ============ PARÁMETROS GET ============ -->
<section class="tarjeta">
    <h2>Parámetros recibidos por GET</h2>
    <p class="detalle">Lo que viaja en la URL después del signo <code>?</code> queda en <code>$_GET</code> (y también en <code>QUERY_STRING</code>, arriba).</p>
    <p>Probalo: <a class="ejemplo" href="?legajo=E-1001&amp;apellido=G%C3%B3mez&amp;area=CON">agregar ?legajo=E-1001&amp;apellido=Gómez&amp;area=CON</a></p>

    <?php
    if (count($_GET) === 0) {
        echo "<p class='nota'>Esta página se pidió sin parámetros, por eso <code>\$_GET</code> está vacío.</p>";
    } else {
        echo "<div class='contenedorTabla'><table class='variables'>";
        foreach ($_GET as $clave => $valor) {
            echo "<tr><th>\$_GET['" . htmlspecialchars((string) $clave) . "']</th><td>" . textoDelValor($valor) . "</td></tr>";
        }
        echo "</table></div>";
    }
    ?>
</section>

<!-- ============ TODAS ============ -->
<section class="tarjeta">
    <h2>TODAS</h2>
    <p class="detalle">Barrido completo del arreglo con <code>foreach($_SERVER as $clave => $valor)</code>.
        Hay <strong><?php echo count($_SERVER); ?></strong> variables.</p>

    <div class="listado">
    <?php
    foreach ($_SERVER as $clave => $valor) {
        if (esClaveReservada($clave)) {
            echo "<div><span class='clave'>" . htmlspecialchars($clave) . "</span>=<span class='oculto'>(oculto por seguridad)</span></div>";
        } else {
            echo "<div><span class='clave'>" . htmlspecialchars($clave) . "</span>=" . textoDelValor($valor) . "</div>";
        }
    }
    ?>
    </div>
    <p class="nota">Las claves que suelen contener datos privados (cookies, credenciales o tokens) se ocultan, para no publicarlas en un servidor real.</p>
</section>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
