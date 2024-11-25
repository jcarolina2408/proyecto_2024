<?php
// Obtén los datos del formulario
$Nombre_taller = $_POST['txt1'];  // Asegúrate de que este campo esté presente en tu formulario
$profesional1 = $_POST['txt2'];
$profesional2 = $_POST['txt3'];
$numeroficha = $_POST['txt4'];
$sede = $_POST['txt5'];
$duracion = $_POST['txt6'];
$fecha_hora = $_POST['txt7'];
$tematica = $_POST['txt8'];


// Verifica si todos los campos requeridos están presentes
if (empty($Nombre_taller) || empty($profesional1) || empty($profesional2) || empty($numeroficha) || empty($sede ) || empty($duracion) || empty($fecha_hora) || empty($tematica)  ) {
    die("Error: Todos los campos son obligatorios.");
}

// Conéctate a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'proyecto_2024');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Prepara la consulta SQL para actualizar los datos en la tabla 'evidencias'
$sql = "UPDATE talleres SET profesional1 = ?, profesional2 = ?, numeroficha = ?, sede = ?, duracion = ?, fecha_hora = ?, tematica = ? WHERE Nombre_taller = ?";
$stmt = $conexion->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Asigna los parámetros y ejecuta la consulta
$stmt->bind_param("sssssssi", $profesional1, $profesional2, $numeroficha, $sede, $duracion, $fecha_hora, $tematica, $Nombre_taller);

// Ejecuta la consulta
if ($stmt->execute()) {
    // Redirige a una página de éxito si la actualización fue exitosa
    header("Location: admi_consultar_talleres.php");
    exit();
} else {
    // Muestra un mensaje de error si la ejecución falla
    die("Error al actualizar los datos: " . $stmt->error);
}

// Cierra la consulta y la conexión
$stmt->close();
$conexion->close();
?>
