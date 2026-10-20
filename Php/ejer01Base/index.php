<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>PHP base 01</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>PHP base 01</h1>
    <p>Variables, tipos de datos, arreglos y alcance · ejemplos del Maestro de empleados</p>
</header>

<main>

<!-- ================= 1. TEXTO FUERA DE LAS MARCAS ================= -->
<section class="tarjeta">
    <h2>1. Texto fuera de las marcas de PHP</h2>
    <p>Este texto está escrito fuera de las marcas <code>&lt;?php ... ?&gt;</code>. Se entrega en la respuesta HTTP tal cual, sin pasar por el procesador de PHP.</p>
    <?php
    /* Estas son marcas de comentario de varias líneas dentro del código PHP. */
    // Esta es otra marca, para comentarios al final de una línea.
    # Esta es otra forma más de comentar dentro de PHP.
    ?>
    <p>Los tres tipos de comentario (<code>/* */</code>, <code>//</code> y <code>#</code>) están en el código de este archivo, pero no se ven acá porque PHP los descarta.</p>
</section>

<!-- ================= 2. SALIDA CON ECHO ================= -->
<section class="tarjeta">
    <h2>2. Salida con <code>echo</code></h2>
    <?php
    echo "<p>Este texto y este HTML los entrega el procesador PHP usando la sentencia <strong>echo</strong>.</p>";
    echo "<p style='color:#00695c'>Los atributos HTML dentro de un echo se escriben con comillas simples, para no cortar la cadena.</p>";
    echo "<hr />";   /* toda sentencia en PHP termina con punto y coma */
    ?>
</section>

<!-- ================= 3. VARIABLES Y TIPOS ================= -->
<section class="tarjeta">
    <h2>3. Variables y tipos de datos</h2>
    <?php
    /* Toda variable empieza con $ y no hace falta declararla antes de usarla: se declara al asignarle un valor.
       Para mostrar el nombre sin evaluarlo se escapa el signo de pesos: \$apellidoNombres */
    $apellidoNombres = "Gómez, Lucía";
    echo "<p>El valor de <span class='var'>\$apellidoNombres</span> es: " . $apellidoNombres . "</p>";
    echo "<p>El tipo de <span class='var'>\$apellidoNombres</span> es: " . gettype($apellidoNombres) . "</p>";

    $horasNormales = 160;
    $horasExtra = 12;
    echo "<p>El valor de <span class='var'>\$horasNormales</span> es: " . $horasNormales . "</p>";
    echo "<p>El tipo de <span class='var'>\$horasNormales</span> es: " . gettype($horasNormales) . "</p>";
    echo "<p>El valor de <span class='var'>\$horasExtra</span> es: " . $horasExtra . "</p>";
    echo "<p>El tipo de <span class='var'>\$horasExtra</span> es: " . gettype($horasExtra) . "</p>";
    ?>

    <p class="nota">horasTotales es la suma de horasNormales y horasExtra</p>
    <p class="nota">Si uno de los operandos fuera un texto no numérico, PHP 8 devolvería un error (TypeError).</p>

    <?php
    $horasTotales = $horasNormales + $horasExtra;
    echo "<p>El valor de <span class='var'>\$horasTotales</span> es: " . $horasTotales . "</p>";
    echo "<p>El tipo de <span class='var'>\$horasTotales</span> es: " . gettype($horasTotales) . "</p>";
    ?>
</section>

<!-- ================= 4. BOOLEANAS ================= -->
<section class="tarjeta">
    <h2>4. Variables booleanas (lógicas)</h2>
    <?php
    $estaActivo = true;
    $enLicencia = false;
    echo "<p>Variable booleana (verdadero) <span class='var'>\$estaActivo</span>: " . $estaActivo . "</p>";
    echo "<p>El tipo de <span class='var'>\$estaActivo</span> es: " . gettype($estaActivo) . "</p>";
    echo "<p>Variable booleana (falso) <span class='var'>\$enLicencia</span>: " . $enLicencia . "</p>";
    echo "<p>El tipo de <span class='var'>\$enLicencia</span> es: " . gettype($enLicencia) . "</p>";
    ?>
    <p class="nota">Con echo, PHP muestra true como 1 y false como texto vacío.</p>
</section>

<!-- ================= 5. CONSTANTES ================= -->
<section class="tarjeta">
    <h2>5. Constantes</h2>
    <?php
    define("NOMBRE_EMPRESA", "Distribuidora Norte S.A.");
    define("JORNADA_HORAS", 8);

    /* Las constantes no llevan $ y no se pueden reasignar.
       Como no se interpolan dentro de las comillas, se concatenan con el punto. */
    echo "<p><span class='var'>NOMBRE_EMPRESA</span> : " . NOMBRE_EMPRESA . "</p>";
    echo "<p>Tipo de <span class='var'>NOMBRE_EMPRESA</span>: " . gettype(NOMBRE_EMPRESA) . "</p>";
    echo "<p><span class='var'>JORNADA_HORAS</span> : " . JORNADA_HORAS . "</p>";
    echo "<p>Tipo de <span class='var'>JORNADA_HORAS</span>: " . gettype(JORNADA_HORAS) . "</p>";
    ?>
</section>

<!-- ================= 6. ARREGLOS DE ÍNDICE NUMÉRICO ================= -->
<section class="tarjeta">
    <h2>6. Arreglos de índice numérico</h2>
    <p class="nota">Un arreglo de índice numérico es un vector con elementos del mismo tipo. Acá, las áreas de desempeño de la empresa.</p>
    <?php
    $aAreas = [];                                  /* arreglo vacío */
    $aAreas = ["Contable", "Ventas"];              /* asignación de un arreglo con 2 elementos */
    echo "<p><span class='var'>\$aAreas[0]</span> : " . $aAreas[0] . "</p>";
    echo "<p><span class='var'>\$aAreas[1]</span> : " . $aAreas[1] . "</p>";
    echo "<p>Tipo de <span class='var'>\$aAreas</span> : " . gettype($aAreas) . "</p>";

    echo "<p><strong>Se agregan por programa dos elementos nuevos</strong></p>";
    $aAreas[] = "Compras";                         /* agrega al final con corchetes vacíos */
    array_push($aAreas, "Depósito");               /* agrega al final: los argumentos son el arreglo y el valor */

    echo "<h3>Todos los elementos originales y agregados:</h3>";
    echo "<ul>";
    foreach ($aAreas as $area) {
        echo "<li>" . $area . "</li>";
    }
    echo "</ul>";
    echo "<p>Cantidad de elementos de <span class='var'>\$aAreas</span>: " . count($aAreas) . "</p>";
    ?>
</section>

<!-- ================= 7. ARREGLO DE DOS DIMENSIONES ================= -->
<section class="tarjeta">
    <h2>7. Arreglo de dos dimensiones (nómina)</h2>
    <p class="nota">Un arreglo de arreglos: cada elemento de la nómina es, a su vez, un arreglo con los datos de un empleado.</p>
    <?php
    $aEncabezados = ["Legajo", "Apellido y nombres", "Área", "Sueldo básico"];
    $aNomina = [
        [1001, "Gómez, Lucía",    "Contable", 1250000],
        [1002, "Pereyra, Martín", "Ventas",   1180000],
        [1003, "Suárez, Camila",  "Depósito", 1100000]
    ];

    echo "<p>La variable <span class='var'>\$aNomina</span> tiene el siguiente tipo: " . gettype($aNomina) . "</p>";

    echo "<table class='catalogo'>";
    echo "<tr>";
    foreach ($aEncabezados as $encabezado) {
        echo "<th>" . $encabezado . "</th>";
    }
    echo "</tr>";
    foreach ($aNomina as $fila) {            /* un foreach para las filas... */
        echo "<tr>";
        foreach ($fila as $celda) {          /* ...y otro anidado para las columnas */
            echo "<td>" . $celda . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

    echo "<p>También así se puede expresar el valor de <span class='var'>\$aNomina[1][1]</span> : " . $aNomina[1][1] . "</p>";
    echo "<p>Cantidad de empleados en la nómina: " . count($aNomina) . "</p>";
    echo "<p>Cantidad de columnas de cada fila: " . count($aNomina[0]) . "</p>";
    ?>
</section>

<!-- ================= 8. ARREGLO ASOCIATIVO ================= -->
<section class="tarjeta">
    <h2>8. Variables tipo arreglo asociativo</h2>

    <p class="nota">Cargar por programa un arreglo asociativo con un empleado y mostrar sus atributos, la cantidad de elementos y el tipo de cada uno de ellos</p>

    <?php
    /* En un arreglo asociativo el índice es una cadena (la clave) en lugar de un número natural.
       Sus elementos suelen ser de distinto tipo. */
    $aEmpleado = [
        "legajo"          => "E-1001",
        "apellidoNombres" => "Gómez, Lucía",
        "dni"             => 31245678,
        "fechaIngreso"    => "2019-04-02",
        "codArea"         => "CON",
        "sueldoBasico"    => 1250000.5
    ];

    /* foreach con clave => valor: recorre el arreglo mostrando cada atributo y su tipo */
    echo "<p class='salida'>";
    foreach ($aEmpleado as $clave => $valor) {
        echo $clave . ": " . $valor . "<br>";
        echo "tipo del elemento: " . gettype($valor) . "<br>";
    }
    echo "<br>Cantidad de elementos del arreglo: " . count($aEmpleado) . "<br>";
    echo "Tipo de dato del arreglo: " . gettype($aEmpleado);
    echo "</p>";

    echo "<p>Así se muestra un solo elemento: <span class='var'>\$aEmpleado['apellidoNombres']</span> : " . $aEmpleado['apellidoNombres'] . "</p>";
    ?>
    <p class="nota">Un número con decimales es de tipo double (así llama PHP a los float). La fecha de ingreso es un texto (string).</p>
</section>

<!-- ================= 9. EXPRESIONES ARITMÉTICAS ================= -->
<section class="tarjeta">
    <h2>9. Expresiones aritméticas</h2>
    <?php
    $sueldoBasico = 1250000;
    $adicional = 125000;
    $descuentos = 212500;
    $valorHora = 7800;
    $diasHabiles = 22;

    echo "<p>La variable <span class='var'>\$sueldoBasico</span> tiene el siguiente valor: " . $sueldoBasico . " y es de tipo " . gettype($sueldoBasico) . "</p>";
    echo "<p>La variable <span class='var'>\$adicional</span> tiene el siguiente valor: " . $adicional . " y es de tipo " . gettype($adicional) . "</p>";

    /* Los paréntesis permiten resolver la operación antes de concatenar el resultado */
    $sueldoBruto = ($sueldoBasico + $adicional);
    echo "<p>Suma: <span class='var'>\$sueldoBasico + \$adicional</span> = " . $sueldoBruto . "</p>";

    $sueldoNeto = ($sueldoBruto - $descuentos);
    echo "<p>Resta: <span class='var'>\$sueldoBruto - \$descuentos</span> = " . $sueldoNeto . "</p>";

    $importeHorasExtra = $valorHora * $horasExtra;
    echo "<p>Multiplicación: <span class='var'>\$valorHora * \$horasExtra</span> = " . $importeHorasExtra . "</p>";

    $valorDia = $sueldoBasico / $diasHabiles;
    echo "<p>División: <span class='var'>\$sueldoBasico / \$diasHabiles</span> = " . $valorDia . " (tipo " . gettype($valorDia) . ")</p>";

    $horasSueltas = $horasTotales % JORNADA_HORAS;
    echo "<p>Resto: <span class='var'>\$horasTotales % JORNADA_HORAS</span> = " . $horasSueltas . " (horas que no completan una jornada)</p>";
    ?>
    <p class="nota">Si la división no es exacta, el resultado pasa a ser double; si es exacta (por ejemplo 900000 / 30), PHP devuelve un integer.</p>
</section>

<!-- ================= 10. ALCANCE DE LAS VARIABLES ================= -->
<section class="tarjeta">
    <h2>10. Alcance de las variables</h2>

    <p><strong>Variables globales:</strong> las variables definidas fuera de toda función tienen alcance global y se encuentran referenciadas en el arreglo asociativo global <code>$GLOBALS[]</code>, donde el índice se corresponde con el nombre de la variable (sin el signo $).</p>

    <?php
    $empleadosContable = 8;
    $empleadosVentas = 12;
    echo "<p>El valor de <span class='var'>\$empleadosContable</span> es: " . $empleadosContable . "</p>";
    echo "<p>El valor de <span class='var'>\$empleadosVentas</span> es: " . $empleadosVentas . "</p>";
    echo "<p>Suma de variables en el ámbito global: <code>\$GLOBALS['empleadosContable'] + \$GLOBALS['empleadosVentas']</code> : " . ($GLOBALS['empleadosContable'] + $GLOBALS['empleadosVentas']) . "</p>";
    ?>

    <p><strong>Las declaraciones de variables dentro de una función solo tienen alcance dentro de la misma.</strong></p>

    <?php
    /* Una variable global NO es visible dentro de una función, salvo que se la pida */
    function sinAccesoALaGlobal() {
        return isset($empleadosContable) ? "visible" : "NO visible";
    }

    /* 1) Con la palabra clave global */
    function totalConGlobal() {
        global $empleadosContable, $empleadosVentas;
        return $empleadosContable + $empleadosVentas;
    }

    /* 2) Con el arreglo $GLOBALS */
    function totalConGlobals() {
        return $GLOBALS['empleadosContable'] + $GLOBALS['empleadosVentas'];
    }

    /* Variable local: nace y muere dentro de la función */
    function calculaBonificacion() {
        $bonificacion = 50000;
        return $bonificacion;
    }

    /* Variable estática: conserva su valor entre llamadas a la función */
    function cuentaLiquidaciones() {
        static $liquidaciones = 0;
        $liquidaciones++;
        return $liquidaciones;
    }

    echo "<p>Dentro de una función, <span class='var'>\$empleadosContable</span> es: " . sinAccesoALaGlobal() . "</p>";
    echo "<p>Con la palabra clave <code>global</code> la función puede sumar las áreas: " . totalConGlobal() . "</p>";
    echo "<p>Con <code>\$GLOBALS</code> la función también puede sumarlas: " . totalConGlobals() . "</p>";

    echo "<p>La función calculaBonificacion() devuelve: " . calculaBonificacion() . "</p>";
    echo "<p>Pero fuera de la función, <span class='var'>\$bonificacion</span> " . (isset($bonificacion) ? "existe" : "NO existe") . ".</p>";

    echo "<p>Variable estática: " . cuentaLiquidaciones() . ", " . cuentaLiquidaciones() . ", " . cuentaLiquidaciones() . " (conserva el valor entre llamadas)</p>";
    ?>
</section>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
