<?php
// Obtén los datos del formulario
$tipo_documento = $_POST['txt1'] ?? '';  // Asegúrate de que este campo esté presente en tu formulario
$ID = $_POST['txt2'] ?? '';
$Nombre_completo = $_POST['txt3'] ?? '';
$Rh = $_POST['txt4'] ?? '';
$Telefono = $_POST['txt5'] ?? '';
$Direccion = $_POST['txt6'] ?? '';
$Cargo = $_POST['txt7'] ?? '';
$Correo = $_POST['txt10'] ?? '';

// Verifica si todos los campos requeridos están presentes
if (empty($tipo_documento) || empty($ID) || empty($Nombre_completo) || empty($Rh) || empty($Telefono)|| empty($Direccion)|| empty($Cargo)||  empty($Correo)) {
    die("Error: Todos los campos son obligatorios.");
}

// Conéctate a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'proyecto_2024');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Prepara la consulta SQL para actualizar los datos en la tabla 'evidencias'
$sql = "UPDATE usuario SET tipo_documento = ?, Nombre_completo = ?, Rh = ?, Telefono = ?, Direccion = ?, Cargo = ?, Correo = ? WHERE ID = ?";
$stmt = $conexion->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Asigna los parámetros y ejecuta la consulta
$stmt->bind_param("sssssssi", $tipo_documento, $Nombre_completo, $Rh, $Telefono, $Direccion, $Cargo,$Correo,$ID);

// Ejecuta la consulta
if ($stmt->execute()) {
    // Redirige a una página de éxito si la actualización fue exitosa
    header("Location: controlador_admi_consultar_usuarios.php");
    exit();
} else {
    // Muestra un mensaje de error si la ejecución falla
    die("Error al actualizar los datos: " . $stmt->error);
}

// Cierra la consulta y la conexión
$stmt->close();
$conexion->close();
?>

