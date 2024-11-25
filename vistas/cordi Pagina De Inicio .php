<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el rol del usuario desde la sesión
$rol = $_SESSION["rol"];

// Verificar si el usuario tiene el rol adecuado para esta página
if ($rol !== 'coordinador') {
    header("Location: iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = isset($_SESSION["Nombre_completo"]) ? $_SESSION["Nombre_completo"] : null;

// Verificar si la variable $usuario está definida antes de usarla
if ($Nombre_completo === null) {
    echo "<script>alert('Error: Usuario no definido'); location.href='iniciar_sesion.html';</script>";
    exit();
}


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
            width: 100%;
            height: 11%;
            background-color: #39A900;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .navbar-menu {
            list-style-type: none;
            margin-left: 17%;
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
        .logo-oee {
            position: absolute; /* Esto asegura que puedas posicionarlo dentro del contenedor */
            top: 10px; /* Alinea al top */
            left: 15px; /* Alinea a la izquierda */
            width: 80px; /* Ajusta el tamaño del logo a 100px de ancho */
            height: auto; /* Mantiene la proporción correcta del logo */
        }


        .sidebar {
            position: fixed;
            left: 0;
            top: 12%;
            width: 14%;
            height: 100%;
            background-color: #f6f6f6;
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-menu {
            list-style-type: none;
            margin-top: 20%;
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
        margin-top: 70px;
        margin-left: 18%;
        padding: 15px;
    }

        /* Estilos para el footer */
        footer {
        width: 100%;
        background-color: #ffffff;
        color: rgb(70, 70, 70);
        text-align: center;
        padding: 7px 0;
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
    h2{
        color: #ffffff;
    }
    .search-container {
       width: 60%;
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
            background-color: #4CAF50;
            border-radius: 15px;
            padding: 10px 2px;
            width: 100%;
        }

        .search-bar input[type="text"] {
            border: none;
            padding: 8px;
            border-radius: 10px;
            width: 78%;
        }

        button {
            background-color: black;
            color: white;
            width: 200px;
            height: auto;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c1cec1;
            color: black;
        }
        .container {
            display: flex;
            align-items: flex-start;
            margin: 45px 2px;
            flex-direction: column;
            
        }

        /* Caja grande (a la izquierda) */
        .big-box-container {
            display: flex;
            flex-direction: column; /* Alinea el contenedor grande y las cajas pequeñas debajo verticalmente */
            gap: 20px;
        }

        /* Caja grande */
        .big-box {
            width: 95%; /* Tamaño grande */
            height: 260px;
            background-color: #4CAF50; /* Color de fondo */
            border-radius: 20px; /* Bordes redondeados */
            padding: 10px 20px;
            text-align:center;
            align-items: center;
        }

        /* Contenedor de las dos cajas pequeñas debajo de la caja grande */
        .small-box-container {
            display: flex; /* Alinea las cajas pequeñas horizontalmente */
            gap: 20px; /* Espacio entre las cajas pequeñas */
            justify-content: center;
        }



        /* Cajas pequeñas */
        .small-box {
            width: 45%; /* Tamaño más pequeño */
            height: 25%;
            background-color: #e5ebe5; /* Color de fondo */
            border-radius: 20px; /* Bordes redondeados */
            padding: 15px 20px;
            text-align:center;
            align-items: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
            <img src="img/nlogo.png" class="logo-oee">
            <li><a href="cordi Pagina De Inicio .php">Inicio</a></li>
            <li><a href="iniciar_sesion.html">Salir</a></li>
            <li><a href="../controlador/generar_reporte.php">Generar Reporte</a></li>   
        </ul>
        <h2>Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
        <div class="navbar-image">
            <img src="img/logo_bienestarAprendiz.png">
        </div>
    </nav>

    <aside class="sidebar">
        <center><h3>Coordinador</h3></center>
        <ul class="sidebar-menu">
            <li>
                <a href="#option1" class="sidebar-link">
                    <i class="fas fa-home"></i>Usuarios y talleres
                </a>
                <ul class="sub-menu">
                    <li><a href="../controlador/cordi_consultar_Talleres.php">Consultar talleres</a></li>
                    <li><a href="../controlador/cordi_Consultar_Usuario.php">Consultar usuario</a></li>
                </ul>
            </li>
            <li>
                <a href="#option2" class="sidebar-link">
                    <i class="fas fa-user"></i>Fichas
                </a>
                <ul class="sub-menu">
                    <li><a href="cordi_cargar_ficha.php">Cargar fichas </a></li>
                    <li><a href="../controlador/cordi_consultar_ficha.php">Consultar fichas</a></li>
                </ul>
            </li>

            <li>
                <a href="#option4" class="sidebar-link">
                    <i class="fas fa-envelope"></i> Evidencia
                </a>
                <ul class="sub-menu">
                    <li><a href="../controlador/cordi_consultar_evidencia.php">Consultar evidencia</a></li>
                </ul>
            </li>
            <li>
                <a href="#option5" class="sidebar-link">
                    <i class="fas fa-info-circle"></i> Horarios 
                </a>
                <ul class="sub-menu">
                    <li><a href="cordi_Cargar_Horarios.php">Cargar horarios</a></li>
                    <li><a href="../controlador/cordi_Consultar_Horarios.php">Consultar Horarios</a></li>
                </ul>
            </li>
            <li>

</li>

        </ul>
    </aside>

    <div class="content">
        <div class="container">
            <div class="big-box-container">
                <div class="big-box">
                    <center><h2>CONSULTAR USUARIO POR NOMBRE</h2></center>
                    <p>Esta consulta permite obtener detalles como el ID, correo electrónico, cargo y otros datos relevantes asociados con el nombre proporcionado.Este proceso es útil para acceder rápidamente a la información de un usuario sin necesidad de conocer otros identificadores únicos.</p>
                    <nav class="search-bar">
                        <input  type="text" name="usuario_id" placeholder="Digite el nombre del usuario a consultar ">
                        <button type="submit">Buscar</button>
                    </nav>
                </div>
                <div class="small-box-container">
                    <div class="small-box">
                    <center><h4>CONSULTAR TALLER POR NOMBRE</h4></center>
                    <p>Con este boton podras consultar los talleres por nombres</p>
                    <button type="submit">Consultar</button>
                    </div>
                    <div class="small-box">
                    <center><h4>CONSULTAR HORARIO POR NUMERO DE FICHA</h4></center>
                    <p>Con este boton podras consultar los horarios por numero de ficha</p>
                    <button type="submit">Consultar</button>
                    </div>
                </div>
            </div>
    </div>

    <footer>
        <div class="footer-line"></div>
        <p class="footer-text">Servicio Nacional de Aprendizaje SENA - Centro de Gestión de Mercados, Logística y Tenologías de la Información - Regional Distrito Capital </p>
        <br><p class="footer-text">Dirección: Cl 52 N° 13 65 -Telefono: +(57) 601 594 1301 </p></br>
        
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
