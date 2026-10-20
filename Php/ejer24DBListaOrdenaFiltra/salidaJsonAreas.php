<?php
/* Devuelve en JSON la tabla auxiliar de áreas, para poblar el select del filtro. */

include("./datosConexionBase.php");
include("./registraError.php");

header("Content-Type: application/json; charset=utf-8");

$areas = [];
$respuesta_estado = "";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $dbh = new PDO($dsn, $user, $password); /* Database Handler */
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select * from areas order by descripcionArea";
    $stmt = $dbh->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    while ($fila = $stmt->fetch()) {
        $objArea = new stdClass();
        $objArea->codArea = $fila['codArea'];
        $objArea->descripcionArea = $fila['descripcionArea'];
        array_push($areas, $objArea);
    }
    $dbh = null;
} catch (PDOException $e) {
    $respuesta_estado = "Error al leer las áreas";
    registraError("salidaJsonAreas.php: " . $e->getMessage());
}

$objAreas = new stdClass();
$objAreas->areas = $areas;
if ($respuesta_estado != "") {
    $objAreas->error = $respuesta_estado;
}

echo json_encode($objAreas, JSON_UNESCAPED_UNICODE);
