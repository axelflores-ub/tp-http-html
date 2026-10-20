<?php
/* Tabla auxiliar parametrizable (cod_Area – Descripción) del Maestro de empleados.
   Se la trae con require() tanto desde el formulario como desde la respuesta, así queda definida una sola vez.
   Como no se cierra la etiqueta de PHP, no puede escaparse ningún espacio al final hacia la respuesta HTTP. */

$aAreas = [
    "CON" => "Contable",
    "VEN" => "Ventas",
    "COM" => "Compras",
    "DEP" => "Depósito",
    "CCO" => "Cuentas corrientes"
];
