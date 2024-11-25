<?php
require_once "../modelo/UsuarioModelo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['txt1']; // Nombre de usuario (ID o nombre)
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    $modelo = new UsuarioModelo();

    // Verificar la contraseña antigua
    if ($modelo->verificarContrasena($username, $oldPassword)) {
        // Actualizar la contraseña
        if ($modelo->actualizarContrasena($username, $newPassword)) {
            echo "<script> alert('Se actualizo la contraseña correctamente'); location.href='../vistas/iniciar_sesion.html'; </script>";
        } else {
             echo "<script> alert('Error al actualizar contraseña'); location.href='../vistas/iniciar_sesion.html'; </script>";
        }
    } else {
        echo "<script> alert('la contraseña antigua es incorrecta'); location.href='../vistas/iniciar_sesion.html'; </script>";
    }
}

?>