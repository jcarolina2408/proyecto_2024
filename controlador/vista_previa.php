<?php
// Asegurarse de que se ha recibido un archivo a previsualizar
if (!isset($_GET['file'])) {
    echo "No se especificó ningún archivo.";
    exit();
}

$nombre_archivo = urldecode($_GET['file']);

// Dividir el nombre del archivo en partes
$partes = explode('/', $nombre_archivo);

// Verificar que se recibieron las partes necesarias
if (count($partes) < 3) { // Debe incluir carpeta, subcarpeta y nombre del archivo
    echo "Ruta del archivo no válida.";
    exit();
}

// Asumimos que la estructura es: carpeta/subcarpeta/nombre_archivo
$carpetaBase = $partes[0]; // Calle 52, Fontibón o Calle 64
$subcarpeta = $partes[1];   // Jornada (diurna, mixta, nocturna)
$nombreArchivo = basename($partes[2]); // Solo el nombre del archivo

// Construir la ruta completa
$ruta_archivo = "../archivos_subidos/$carpetaBase/$subcarpeta/$nombreArchivo";

// Verificar si el archivo existe
if (!file_exists($ruta_archivo)) {
    echo "El archivo no existe en la ruta especificada.";
    exit();
}

// Obtener la extensión del archivo
$extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

// Mostrar el iframe para vista previa
if ($extension === 'pdf') {
    echo '<h3>Vista previa del archivo: ' . htmlspecialchars($nombreArchivo) . '</h3>';
    echo '<iframe src="' . htmlspecialchars($ruta_archivo) . '" width="100%" height="600px" style="border: none;"></iframe>';
    echo '<br>';
    echo '<a href="ruta_de_tu_script_de_descarga.php?file=' . urlencode($nombre_archivo) . '" class="btn btn-primary">Descargar PDF</a>';
} else {
    echo "Vista previa no disponible para este tipo de archivo.";
}

// Enlace para volver a la lista de archivos
echo '<br><a href="ruta_a_tu_pagina_principal.php" class="btn btn-secondary">Volver a la lista de archivos</a>';
?>
