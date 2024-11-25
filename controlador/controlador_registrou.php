<?php
include "../modelo/modelo.php"; // Incluir el modelo de usuario

$instancia = new usuario(); // Crear una instancia de la clase usuario
$r = $instancia->registro($_POST); // Registrar al usuario y obtener el resultado

if ($r === 1) {
    // Aquí invocamos la función del modelo para enviar el correo de confirmación
    $correoUsuario = $_POST['txt10']; // Obtener el correo del usuario registrado
    $nombreUsuario = $_POST['txt3']; // Obtener el nombre del usuario

    // Obtener la contraseña generada
    $contrasena = $instancia->obtenerContrasena(); // Llamar al método para obtener la contraseña generada

    // Enviar el correo directamente sin condicionales
    $instancia->enviarCorreo($correoUsuario, $nombreUsuario, $contrasena);

    // Redirigir a la página de consulta después de registrar y enviar el correo
    echo "<script>location.href='controlador_admi_consultar_usuarios.php';</script>";
} else {
    // Manejo de otros errores que podrían haber ocurrido durante el registro
    if (str_contains($r, '1045')) {
        echo "Se desconectó el servidor, comuníquese con el administrador.";
    } else if (str_contains($r, '1062')) {
        echo "El nombre del producto ya existe, modifíquelo.";
    } else if (str_contains($r, '2002')) {
        echo "La conexión cayó.";
    } else {
        echo $r; // Si es un error general
    }
}
?>
