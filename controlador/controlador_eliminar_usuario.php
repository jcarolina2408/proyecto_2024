<?php
// Conexión y lógica para eliminar el usuario
$id = $_GET['txt2'];

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'proyecto_2024');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Preparar y ejecutar la consulta para eliminar el usuario
$sql = "DELETE FROM usuario WHERE ID=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conexion->close();

// Redirige a la lista de usuarios

header("Location: controlador_admi_consultar_usuarios.php");
exit();
?>
