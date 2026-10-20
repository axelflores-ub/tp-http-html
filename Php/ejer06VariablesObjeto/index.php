<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Variables tipo objeto en PHP</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="portada">
    <h1>Variables tipo objeto en PHP</h1>
    <p>Objeto empleado del Maestro de empleados, arreglo de objetos y respuesta en JSON</p>
</header>

<main>

<!-- ================= 1. TABLA AUXILIAR: ÁREAS ================= -->
<section class="tarjeta">
    <h2>1. Tabla auxiliar parametrizable: áreas de desempeño</h2>
    <p class="nota">El área de desempeño es un dato parametrizable: se guarda el código y la descripción se busca en esta tabla (cod_Area – Descripción). Es un arreglo asociativo: la clave es el código.</p>
    <?php
    $aAreas = [
        "CON" => "Contable",
        "VEN" => "Ventas",
        "COM" => "Compras",
        "DEP" => "Depósito",
        "CCO" => "Cuentas corrientes"
    ];

    echo "<table class='nomina'>";
    echo "<tr><th>cod_Area</th><th>Descripción</th></tr>";
    foreach ($aAreas as $codArea => $descripcionArea) {
        echo "<tr><td>" . $codArea . "</td><td>" . $descripcionArea . "</td></tr>";
    }
    echo "</table>";
    ?>
</section>

<!-- ================= 2. UN OBJETO ================= -->
<section class="tarjeta">
    <h2>2. Objeto empleado: <span class="var">$objEmpleado</span></h2>
    <p>Las variables de tipo objeto son muy parecidas a los arreglos de índice asociativo: sus elementos, en este caso <strong>atributos</strong>, suelen ser de tipos diferentes. Se crean con la clase estándar <code>stdClass</code>, y las propiedades se asignan con el separador <code>-&gt;</code>.</p>
    <?php
    $objEmpleado = new stdClass;
    $objEmpleado->legajo = "E-1001";
    $objEmpleado->apellidoNombres = "Gómez, Lucía";
    $objEmpleado->dni = 31245678;
    $objEmpleado->fechaIngreso = "2019-04-02";
    $objEmpleado->codArea = "CON";
    $objEmpleado->sueldoBasico = 1250000;
    $objEmpleado->fotoEmpleado = "fotos/E-1001.jpg";

    echo "<p class='salida'>";
    echo "Legajo: " . $objEmpleado->legajo . "<br>";
    echo "Apellido y nombres: " . $objEmpleado->apellidoNombres . "<br>";
    echo "DNI: " . $objEmpleado->dni . "<br>";
    echo "Fecha de ingreso: " . $objEmpleado->fechaIngreso . "<br>";
    echo "Área de desempeño: " . $objEmpleado->codArea . " – " . $aAreas[$objEmpleado->codArea] . "<br>";
    echo "Sueldo básico: " . $objEmpleado->sueldoBasico . "<br>";
    echo "Foto del empleado: " . $objEmpleado->fotoEmpleado;
    echo "</p>";

    echo "<p>Tipo de <span class='var'>\$objEmpleado</span>: " . gettype($objEmpleado) . "</p>";
    ?>

    <h3>El mismo objeto recorrido con foreach (clave =&gt; valor)</h3>
    <?php
    echo "<table class='nomina'>";
    echo "<tr><th>Atributo</th><th>Valor</th><th>Tipo</th></tr>";
    foreach ($objEmpleado as $atributo => $valor) {
        echo "<tr><td>" . $atributo . "</td><td>" . $valor . "</td><td>" . gettype($valor) . "</td></tr>";
    }
    echo "</table>";
    ?>
</section>

<!-- ================= 3. ARREGLO DE OBJETOS ================= -->
<section class="tarjeta">
    <h2>3. Arreglo de empleados: <span class="var">$aEmpleados</span></h2>
    <p>Esta variable de tipo array contiene como elementos los objetos empleado definidos en el paso anterior. Cada nuevo objeto se suma al arreglo con <code>array_push()</code>.</p>
    <?php
    $aEmpleados = [];
    array_push($aEmpleados, $objEmpleado);

    $objEmpleado = new stdClass;     /* se instancia otro objeto: ya no es el que se guardó antes */
    $objEmpleado->legajo = "E-1002";
    $objEmpleado->apellidoNombres = "Pereyra, Martín";
    $objEmpleado->dni = 33890412;
    $objEmpleado->fechaIngreso = "2021-08-17";
    $objEmpleado->codArea = "VEN";
    $objEmpleado->sueldoBasico = 1180000;
    $objEmpleado->fotoEmpleado = "fotos/E-1002.jpg";
    array_push($aEmpleados, $objEmpleado);

    $objEmpleado = new stdClass;
    $objEmpleado->legajo = "E-1003";
    $objEmpleado->apellidoNombres = "Suárez, Camila";
    $objEmpleado->dni = 36574109;
    $objEmpleado->fechaIngreso = "2023-02-06";
    $objEmpleado->codArea = "DEP";
    $objEmpleado->sueldoBasico = 1100000;
    $objEmpleado->fotoEmpleado = "fotos/E-1003.jpg";
    array_push($aEmpleados, $objEmpleado);

    echo "<p>Tipo de <span class='var'>\$aEmpleados</span>: " . gettype($aEmpleados) . "</p>";
    ?>

    <h3>Tabulá <span class="var">$aEmpleados</span>: recorrer el arreglo de empleados y armar las filas con HTML</h3>
    <?php
    echo "<table class='nomina'>";
    echo "<tr><th>Legajo</th><th>Apellido y nombres</th><th>DNI</th><th>Ingreso</th><th>Área</th><th>Sueldo básico</th></tr>";

    foreach ($aEmpleados as $objEmp) {
        $fechaLegible = implode("/", array_reverse(explode("-", $objEmp->fechaIngreso)));
        echo "<tr>";
        echo "<td>" . $objEmp->legajo . "</td>";
        echo "<td>" . $objEmp->apellidoNombres . "</td>";
        echo "<td>" . $objEmp->dni . "</td>";
        echo "<td>" . $fechaLegible . "</td>";
        echo "<td>" . $aAreas[$objEmp->codArea] . "</td>";
        echo "<td>" . $objEmp->sueldoBasico . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<p><strong>Cantidad de empleados: " . count($aEmpleados) . "</strong></p>";
    ?>
</section>

<!-- ================= 4. OBJETO CONTENEDOR ================= -->
<section class="tarjeta">
    <h2>4. Producción de un objeto contenedor: <span class="var">$objEmpleados</span></h2>
    <p>Si quisiéramos un objeto <em>empleados</em> en lugar de un simple arreglo, ese objeto podría contener no solo el arreglo sino otros atributos adicionales. Cada elemento del objeto es un atributo que se debe asignar. Acá se declaran dos: el arreglo completo de empleados y la cantidad de empleados.</p>
    <?php
    $objEmpleados = new stdClass();
    $objEmpleados->empleados = $aEmpleados;
    $objEmpleados->cantidadDeEmpleados = count($aEmpleados);

    echo "<p>Tipo de <span class='var'>\$objEmpleados</span>: " . gettype($objEmpleados) . "</p>";
    echo "<p>Tipo de <span class='var'>\$objEmpleados-&gt;empleados</span>: " . gettype($objEmpleados->empleados) . "</p>";
    echo "<p>Tipo de <span class='var'>\$objEmpleados-&gt;cantidadDeEmpleados</span>: " . gettype($objEmpleados->cantidadDeEmpleados) . "</p>";
    echo "<p>Cantidad de empleados: " . $objEmpleados->cantidadDeEmpleados . "</p>";
    ?>
</section>

<!-- ================= 5. JSON ================= -->
<section class="tarjeta">
    <h2>5. Producción de un JSON: <span class="var">$jsonEmpleados</span></h2>
    <p>El objeto obtenido en el paso anterior se codifica como texto JSON con <code>json_encode()</code>, para ser enviado al navegador remoto. Ese texto reemplaza al archivo <code>.js</code> con el JSON escrito a mano de los ejercicios del lado del cliente: el navegador lo convierte en un objeto de JavaScript y lo barre para presentarlo.</p>
    <?php
    $jsonEmpleados = json_encode($objEmpleados, JSON_UNESCAPED_UNICODE);

    echo "<p>Tipo de <span class='var'>\$jsonEmpleados</span>: " . gettype($jsonEmpleados) . " (es solo texto)</p>";
    echo "<pre class='json'>" . htmlspecialchars($jsonEmpleados) . "</pre>";
    ?>
    <p class="nota">Se usa <code>JSON_UNESCAPED_UNICODE</code> para que los acentos se lean tal cual; sin esa opción <code>json_encode()</code> los escribiría como <code>ó</code>.</p>
</section>

<p class="volver"><a href="../index.html">Volver al índice de Php</a></p>

</main>

</body>
</html>
