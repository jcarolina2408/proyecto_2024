<?php
$sede = $_GET['sede'] ?? '';
$jornadas = [];

// Ruta base de las fichas
$rutaBase = "../fichas/$sede";

if ($sede && is_dir($rutaBase)) {
    $jornadas = array_filter(scandir($rutaBase), function ($carpeta) use ($rutaBase) {
        return $carpeta !== '.' && $carpeta !== '..' && is_dir("$rutaBase/$carpeta");
    });
}

header('Content-Type: application/json');
echo json_encode(array_values($jornadas)); // Devuelve solo las jornadas (subcarpetas)
