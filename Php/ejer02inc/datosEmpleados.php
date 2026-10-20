<?php
/* Archivo asociado: solo contiene asignaciones de variables.
   index.php lo ubica con include(), y a partir de ese punto estas variables existen allá. */

$aEmpleado1 = ["legajo" => "E-1001", "apellidoNombres" => "Gómez, Lucía",    "codArea" => "CON", "sueldoBasico" => 1250000];
$aEmpleado2 = ["legajo" => "E-1002", "apellidoNombres" => "Pereyra, Martín", "codArea" => "VEN", "sueldoBasico" => 1180000];

/* Este archivo no cierra la etiqueta de PHP a propósito: así no puede escaparse
   ningún espacio o salto de línea al final que termine en la respuesta HTTP. */
