<?php
// Conexión y lógica para eliminar el usuario
$Nombre_taller = $_GET['txt1'];

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'proyecto_2024');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Preparar y ejecutar la consulta para eliminar el usuario
$sql = "DELETE FROM talleres WHERE Nombre_taller=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ntaller", $Nombre_taller);
$stmt->execute();
$stmt->close();
$conexion->close();

// Redirige a la lista de usuarios

header("Location: admi_consultar_talleres.php");
exit();
?>