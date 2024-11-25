<?php
include "../modelo/modelo.php";

// Crear una instancia de la clase de validación
$instancia = new validacion();

// Llamar al método Acceso con los datos del formulario
$dat = $instancia->Acceso($_POST);

if (empty($dat)) {
    // Mostrar mensaje de error y redirigir si la contraseña es incorrecta o el usuario no se encuentra
    echo "<script> alert('Error al iniciar sesión. Contraseña incorrecta o usuario no encontrado.'); location.href='../vistas/iniciar_sesion.html'; </script>";
} else {
    // Iniciar sesión y almacenar datos en la sesión
    session_start();
    $_SESSION["SesionIn"] = true;
    $_SESSION["rol"] = $dat["Cargo"];
    $_SESSION["usuario"] = $dat["ID"];
    // Almacenar el nombre completo del usuario en la sesión
    $_SESSION["Nombre_completo"] = $dat["Nombre_completo"];
    // Almacenar la contraseña generada para futuros usos si es necesario
    $_SESSION["contrasena"] = $dat["Contrasena"]; 

    // Redirigir según el rol del usuario
    switch ($_SESSION["rol"]) {
        case 'administrador':
            header("Location: ../vistas/admi pagina de inicio.php");
            break;
        case 'coordinador':
            header("Location: ../vistas/cordi Pagina De Inicio .php");
            break;
        case 'profesional':
            header("Location: ../vistas/prof pagina de inicio.php");
            break;
        default:
            // Si el rol no es reconocido, redirigir al inicio de sesión
            echo "<script> alert('Rol de usuario desconocido'); location.href='../vistas/iniciar_sesion.html'; </script>";
            break;
    }
}

?>
