<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'No estás autenticado.']);
    exit();
}

include "../modelo/conexion.php"; // Ajusta la ruta si es necesario

// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comprobar si se ha enviado un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $archivo = $_FILES['archivo'];

        if ($archivo['error'] === UPLOAD_ERR_OK) {
            // Validar solo archivos PDF
            if ($archivo['type'] === 'application/pdf') {
                // Validar el tamaño del archivo
                $maxFileSize = 5 * 1024 * 1024; // 5 MB
                if ($archivo['size'] > $maxFileSize) {
                    $response = ['status' => 'error', 'message' => 'El archivo excede el tamaño máximo permitido de 5 MB.'];
                } else {
                    // Obtener la carpeta y subcarpeta del formulario
                    $carpeta = $_POST['carpeta']; // Asegúrate de enviar esto desde el formulario
                    $subcarpeta = $_POST['subcarpeta']; // Asegúrate de enviar esto desde el formulario

                    // Validar que la carpeta y subcarpeta sean válidas
                    $carpetasValidas = ['calle_52', 'fontibon', 'calle_64'];
                    $subcarpetasValidas = ['jornada_diurna', 'jornada_mixta', 'jornada_nocturna'];

                    if (!in_array($carpeta, $carpetasValidas) || !in_array($subcarpeta, $subcarpetasValidas)) {
                        $response = ['status' => 'error', 'message' => 'Carpeta o subcarpeta no válida.'];
                        echo json_encode($response);
                        exit();
                    }

                    // Definir la ruta completa
                    $directorio = "../fichas/$carpeta/$subcarpeta/";

                    // Crear las carpetas si no existen
                    if (!is_dir($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    $nombreArchivoOriginal = basename($archivo['name']);
                    $nombreArchivoSeguro = uniqid() . '.pdf';
                    $rutaArchivo = $directorio . $nombreArchivoSeguro;

                    if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                        try {
                            $insert = $conexion->prepare("INSERT INTO fichas (nombre_original, nombre_seguro, ruta_archivo, carpeta, subcarpeta, tipo) VALUES (?, ?, ?, ?, ?, 'ficha')");
                            $insert->execute([$nombreArchivoOriginal, $nombreArchivoSeguro, $rutaArchivo, $carpeta, $subcarpeta]);
                            
                            if ($insert->rowCount() > 0) {
                                $response = ['status' => 'success', 'message' => 'Archivo PDF subido y registrado exitosamente.'];
                            } else {
                                $response = ['status' => 'error', 'message' => 'Error al registrar el archivo en la base de datos.'];
                            }
                        } catch (PDOException $e) {
                            $response = ['status' => 'error', 'message' => 'Error de base de datos: ' . $e->getMessage()];
                        }
                    } else {
                        $response = ['status' => 'error', 'message' => 'Error al mover el archivo.'];
                    }
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Tipo de archivo no permitido. Solo se aceptan archivos PDF.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Error en la subida del archivo.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'No se ha enviado ningún archivo.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Método no permitido.'];
}

echo json_encode($response);
?>
