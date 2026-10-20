<?php
/* Recibe por POST el orden y los filtros, consulta la tabla empleados con una sentencia preparada
   y devuelve el resultado en JSON. */

include("./datosConexionBase.php");
include("./registraError.php");

header("Content-Type: application/json; charset=utf-8");

/* 1) Recepción de variables del requerimiento */
function leePost($nombre) {
    return isset($_POST[$nombre]) && is_string($_POST[$nombre]) ? trim($_POST[$nombre]) : "";
}

$orden = leePost("orden");
$f_empleados_legajo = leePost("f_empleados_legajo");
$f_empleados_apellidoNombres = leePost("f_empleados_apellidoNombres");
$f_empleados_dni = leePost("f_empleados_dni");
$f_empleados_codArea = leePost("f_empleados_codArea");
$f_empleados_fechaIngreso = leePost("f_empleados_fechaIngreso");

/* El orden se concatena al SQL (no se puede vincular con bindParam), así que solo se aceptan
   nombres de columna conocidos. Cualquier otro valor vuelve al orden por legajo. */
$columnasValidas = ["legajo", "apellidoNombres", "dni", "codArea", "sueldoBasico", "fechaIngreso"];
if (!in_array($orden, $columnasValidas, true)) {
    $orden = "legajo";
}

$empleados = [];
$respuesta_estado = "";

try {
    /* 2) Apertura de conexión con el motor */
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $respuesta_estado = "conexion exitosa";

    /* 3) Consulta SQL con filtros (LIKE) y orden */
    $sql = "select * from empleados where ";
    $sql = $sql . "legajo LIKE CONCAT('%',:legajo,'%') and ";
    $sql = $sql . "apellidoNombres LIKE CONCAT('%',:apellidoNombres,'%') and ";
    $sql = $sql . "dni LIKE CONCAT('%',:dni,'%') and ";
    $sql = $sql . "codArea LIKE CONCAT('%',:codArea,'%') and ";
    $sql = $sql . "fechaIngreso LIKE CONCAT('%',:fechaIngreso,'%')";
    $sql = $sql . " ORDER BY $orden";

    /* 4) Preparación, vinculación y ejecución */
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':legajo', $f_empleados_legajo);
    $stmt->bindParam(':apellidoNombres', $f_empleados_apellidoNombres);
    $stmt->bindParam(':dni', $f_empleados_dni);
    $stmt->bindParam(':codArea', $f_empleados_codArea);
    $stmt->bindParam(':fechaIngreso', $f_empleados_fechaIngreso);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    /* 5) Construcción de la respuesta: un objeto por fila */
    while ($fila = $stmt->fetch()) {
        $objEmpleado = new stdClass();
        $objEmpleado->legajo = $fila['legajo'];
        $objEmpleado->apellidoNombres = $fila['apellidoNombres'];
        $objEmpleado->dni = $fila['dni'];
        $objEmpleado->codArea = $fila['codArea'];
        $objEmpleado->sueldoBasico = (float) $fila['sueldoBasico'];
        $objEmpleado->fechaIngreso = $fila['fechaIngreso'];
        /* La foto (longblob) no viaja en el listado: solo se avisa si el empleado la tiene */
        $objEmpleado->tieneFoto = $fila['fotoEmpleado'] !== null;
        array_push($empleados, $objEmpleado);
    }
    $dbh = null;
} catch (PDOException $e) {
    $respuesta_estado = "Error en el acceso a la base de datos";
    registraError("salidaJsonEmpleadosConPrepare.php: " . $e->getMessage());
}

/* 6) Objeto que representa al arreglo completo, convertido en texto JSON */
$objEmpleados = new stdClass();
$objEmpleados->empleados = $empleados;
$objEmpleados->cuenta = count($empleados);
$objEmpleados->estado = $respuesta_estado;

/* 7) Envío de la respuesta al cliente remoto */
echo json_encode($objEmpleados, JSON_UNESCAPED_UNICODE);
