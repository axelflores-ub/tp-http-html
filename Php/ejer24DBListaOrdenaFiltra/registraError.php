<?php
/* Agrega una línea al errores.log con la fecha y hora del servidor (fopen en modo "a" = adición). */

function registraError($textoError) {
    $puntero = fopen(__DIR__ . "/errores.log", "a");
    fwrite($puntero, date("Y-m-d H:i") . " ");
    fwrite($puntero, $textoError);
    fwrite($puntero, "\n");
    fclose($puntero);
}
