<?php
// Obtén los datos del formulario
$nombre_taller = $_POST['txt1'] ?? '';  // Asegúrate de que este campo esté presente en tu formulario
$profesional1 = $_POST['txt2'] ?? '';
$profesional2 = $_POST['txt3'] ?? '';
$ficha = $_POST['txt4'] ?? '';
$fecha_hora = $_POST['txt5'] ?? '';
$enlaceimagen = $_POST['txt6'] ?? '';

// Verifica si todos los campos requeridos están presentes
if (empty($nombre_taller) || empty($profesional1) || empty($profesional2) || empty($ficha)||empty($fecha_hora) || empty($enlaceimagen)) {
    die("Error: Todos los campos son obligatorios.");
}

// Conéctate a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'proyecto_2024');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Prepara la consulta SQL para actualizar los datos en la tabla 'evidencias'
$sql = "UPDATE evidencias SET profesional1 = ?, profesional2 = ?, ficha = ?,fecha_hora = ?, enlaceimagen = ? WHERE nombre_taller = ?";
$stmt = $conexion->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Asigna los parámetros y ejecuta la consulta
$stmt->bind_param("sssssi", $profesional1, $profesional2, $ficha, $fecha_hora, $enlaceimagen, $nombre_taller);

// Ejecuta la consulta
if ($stmt->execute()) {
    // Redirige a una página de éxito si la actualización fue exitosa
    header("Location: admi_consultar evidencia.php");
    exit();
} else {
    // Muestra un mensaje de error si la ejecución falla
    die("Error al actualizar los datos: " . $stmt->error);
}

// Cierra la consulta y la conexión
$stmt->close();
$conexion->close();
?>
