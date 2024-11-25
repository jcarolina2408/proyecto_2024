<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Verificar si la variable de usuario está en la sesión
if (isset($_SESSION["Nombre_completo"])) {
    $Nombre_completo = $_SESSION["Nombre_completo"];
} else {
    $Nombre_completo = 'Usuario no definido'; // O manejar el caso de manera adecuada
}

include "../modelo/conexion.php";

// Obtener la lista de archivos desde la base de datos
$consulta = $conexion->prepare("SELECT * FROM archivos");
$consulta->execute();
$archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Bienestar del aprendiz</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }   

        /* Estilo general para el navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 20%;
            width: 80%;
            height: 12%;
            background-color: #39A900;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .navbar-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        .navbar-menu li {
            margin: 0;
        }

        .navbar-menu a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .navbar-image img {
            height: 75px;
            width: auto;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 17%;
            height: 100%;
            background-color: #f6f6f6;
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-menu {
            list-style-type: none;
            margin-top: 25%;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-link {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
            padding: 10px;
            border-bottom: 1px solid #333;
        }

        .sidebar-link i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sub-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: none;
            padding-left: 20px;
        }

        .sub-menu li {
            margin-bottom: 5px;
        }

        .sub-menu a {
            text-decoration: none;
            color: #666;
        }

        .sub-menu.active {
            display: block;
        }

        .content {
        flex: 1;
        margin-top: 65px;
        margin-left: 20%;
        padding: 20px;
    }

        /* Estilos para el footer */
        footer {
        width: 100%;
        background-color: #ffffff;
        color: rgb(70, 70, 70);
        text-align: center;
        padding: 10px 0;
        position: relative;
        left: 0;
        bottom: 0;
        height: 10%;
    }

    .footer-line {
        border-top: 1px solid #666;
        margin-bottom: 10px;
    }

    .footer-text {
        margin: 0;
        font-size: 14px;
    }

    .logo-oee {
        height: 10%;
            position: fixed;
            bottom: 0;
            left: 15px;
    }
    h2{
        color: #ffffff;
    }
    .search-container {
       width: 80%;
       margin: 20px auto;
       text-align: center;
        }

        /* Estilo para centrar la imagen */
        .search-container img {
            width: 125px; /* Ajusta el tamaño según sea necesario */
            
        }

        .search-container h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #d8d8d7;
            border-radius: 15px;
            padding: 10px 20px;
            width: 100%;
        }

        .search-bar input[type="number"] {
            border: none;
            padding: 8px;
            border-radius: 10px;
            width: 85%;
        }

        .search-bar button {
            background-color: white;
            color: #39A900;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #2e7b00;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
            <li><a href="../vistas/prof pagina de inicio.php">Inicio</a></li>
            <li><a href="../vistas/iniciar_sesion.html">Salir</a></li>
        </ul>
        <h2>Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
        <div class="navbar-image">
            <img src="../vistas/img/logo_bienestarAprendiz.png">
        </div>
    </nav>

    <aside class="sidebar">
        <center><h3>Profesional</h3></center>
        <ul class="sidebar-menu">
            <li>
                <a href="#option1" class="sidebar-link">
                    <i class="fas fa-home"></i>Evidencias
                </a>
                <ul class="sub-menu">
                    <li><a href="prof_subir_evidencias.php">Registrar evidencia</a></li>
                    <li><a href="prof_consultar_evidencias.php">Consultar evidencia</a></li>
                </ul>
            </li>
          
        </ul>
    </aside>
    <div class="content">
 
    </div>


    <footer>
        <div class="footer-line"></div>
        <p class="footer-text">© 2024 SENA</p>
        <img src="../vistas/img/logo_oe.png" class="logo-oee">
    </footer>

    <!-- JavaScript para manejar la expansión de subopciones -->
    <script>
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', (event) => {
                const subMenu = link.nextElementSibling;
                if (subMenu) {
                    subMenu.classList.toggle('active');
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
