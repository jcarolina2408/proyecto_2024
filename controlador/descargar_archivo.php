<?php
// Obtener el nombre del archivo de la URL
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Sanitizar el nombre del archivo
$file = filter_var($file, FILTER_SANITIZE_STRING);

// Definir la ruta base de los archivos
$baseDir = '../archivos_subidos/';

// Construir la ruta completa del archivo
$filepath = $baseDir . $file;

// Depuración: imprimir la ruta del archivo
error_log('Ruta del archivo: ' . $filepath);

// Verificar si el archivo existe y si es un PDF
if (file_exists($filepath) && strtolower(pathinfo($filepath, PATHINFO_EXTENSION)) === 'pdf') {
    // Establecer los encabezados para la descarga del PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($filepath));

    // Leer el archivo y enviar su contenido
    readfile($filepath);
    exit();
} else {
    http_response_code(404);
    echo 'El archivo solicitado no se encuentra o no es un PDF.';
}
?>
