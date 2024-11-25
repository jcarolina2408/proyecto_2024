
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../modelo/modelo_talleres.php';
session_start();

if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

$modeloTalleres = new talleres();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sede']) && isset($_POST['jornada'])) {
        $sede = $_POST['sede'];
        $jornada = $_POST['jornada'];

        // Obtener las fichas desde la base de datos
        $fichas = $modeloTalleres->obtenerFichasDesdeDB($sede, $jornada);
        
        // Depuración
        if (empty($fichas)) {
            error_log("No se encontraron fichas para sede: $sede y jornada: $jornada");
        } else {
            error_log("Fichas encontradas: " . print_r($fichas, true));
        }

        // Devolver las fichas en formato JSON
        echo json_encode($fichas);
    } else {
        echo json_encode(['error' => 'Parámetros no válidos']);
    }
    exit;
}?>