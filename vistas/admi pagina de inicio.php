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
if ($rol !== 'administrador') {
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

    .h2{
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
        /* Contenedor general que agrupa todos los divs */
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
        input{
            margin-bottom: 15px;
        }
        /* Caja grande */
        .big-box {
            width: 95%; /* Tamaño grande */
            height: 180px;
            background-color: #4CAF50; /* Color de fondo */
            border-radius: 20px; /* Bordes redondeados */
            padding: 10px 20px;
            text-align:center;
            align-items: center;
        }

        /* Contenedor de las cajas pequeñas */
        .small-box-container {
            display: flex; /* Alinea las cajas horizontalmente */
            justify-content: center; /* Centra las cajas dentro del contenedor */
            gap: 15px; /* Espacio entre las cajas */
            flex-wrap: wrap; /* Permite que las cajas se ajusten en una nueva línea si el espacio es insuficiente */
            margin-top: 20px; /* Espacio superior opcional */
        }

        /* Cajas pequeñas */
        .small-box {
            flex: 1; /* Las cajas compartirán el espacio disponible */
            max-width: 30%; /* Asegura un tamaño máximo consistente */
            height: 110px; /* Ajusta la altura para acomodar contenido y botón */
            background-color: #e5ebe5; /* Color de fondo */
            border-radius: 20px; /* Bordes redondeados */
            padding: 15px 20px; /* Relleno interno */
            text-align: center; /* Texto centrado */
            display: flex; /* Habilita alineación interna */
            flex-direction: column; /* Alinea los elementos verticalmente */
            justify-content: space-between; /* Empuja el contenido hacia los extremos verticales */
            align-items: center; /* Centra horizontalmente el contenido */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra opcional para mejor visibilidad */
        }

        /* Estilo del formulario */
        form {
            width: 100%; /* Ocupa el ancho de la caja */
            display: flex; /* Habilita la alineación interna */
            flex-direction: column; /* Asegura alineación vertical */
            align-items: center; /* Centra los elementos horizontalmente */
        }

        /* Botón */
        button {
            margin-top: auto; /* Mueve el botón al final del contenedor */
            padding: 10px 15px; /* Ajusta el tamaño del botón */
            border: none; /* Sin bordes */
            border-radius: 10px; /* Bordes redondeados */
            background-color: black; /* Color azul */
            color: white; /* Texto en blanco */
            cursor: pointer; /* Cambia el cursor al pasar por encima */
        }

        button:hover {
         background-color: #c1cec1;
            color: black; }


    </style>
</head>

<body>
    <nav class="navbar">
        
    <ul class="navbar-menu">
            <img src="../vistas/img/nlogo.png" class="logo-oee">
            <li><a href="../vistas/cordi Pagina De Inicio .php">Inicio</a></li>
            <li><a href="../vistas/iniciar_sesion.html">Salir</a></li>
        
    </ul>
        <h2 class="h2">Bienvenido al sistema <?php  echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8');?></h2>
        <div class="navbar-image">
            <img src="img/logo_bienestarAprendiz.png">
        </div>
    </nav>

    <aside class="sidebar">
        <center><h3>Administrador</h3></center>
        <ul class="sidebar-menu">
            <li>
                <a href="#option1" class="sidebar-link">
                    <i class="fas fa-home"></i>Usuarios
                </a>
                <ul class="sub-menu">
                    <li><a href="admi_registrar_usuarios.php">Registrar usuario</a></li>
                    <li><a href="../controlador/controlador_admi_consultar_usuarios.php">Consultar usuario</a></li>
      
                </ul>
            </li>
 

            <li>
                <a href="#option3" class="sidebar-link">
                    <i class="fas fa-cog"></i> Talleres
                </a>
                <ul class="sub-menu">
                    <li><a href="admi_registrar_taller.php">Registrar talleres </a></li>
                    <li><a href="../controlador/admi_consultar_talleres.php">Consultar talleres</a></li>
                </ul>
            </li>
            <li>
                <a href="#option4" class="sidebar-link">
                    <i class="fas fa-envelope"></i> Evidencias
                </a>
                <ul class="sub-menu">
                    <li><a href="admi_cargar_evidencia.php">Cargar evidencia </a></li>
                    <li><a href="../controlador/admi_consultar evidencia.php">Consultar evidencia</a></li>
                </ul>
            </li>
            <li>
                <a href="#option5" class="sidebar-link">
                    <i class="fas fa-info-circle"></i> Horarios 
                </a>
                <ul class="sub-menu">
                    <li><a href="../controlador/admi_consultar_horarios.php">Consultar horarios</a></li>
                    
                </ul>
            </li>
        </ul>
    </aside>
    <div class="content">
        <div class="container">
            <div class="big-box-container">
            <div class="big-box">
                <center><h2>CONSULTAR USUARIO POR NOMBRE</h2></center>
                
                <nav class="search-bar">
                    <form  method="GET" action="../controlador/controlador_admi_consultaeusuario.php">  
                        <input  type="text" name="nombre" placeholder="Digite el nombre del usuario a consultar ">
                        <button type="submit">Buscar</button>
                    </form>
                </nav>
            </div>

                <div class="small-box-container">
                    <div class="small-box">
                        <form method="post" action="../controlador/admi_consultar_talleres.php">
                            <center><h4>CONSULTAR TALLER POR NOMBRE</h4></center>
                            <button type="submit">Consultar</button>
                        </form>
                    </div>
                    <div class="small-box">
                    <center><h4>CONSULTAR HORARIO POR NUMERO DE FICHA</h4></center>
                    <button type="submit">Consultar</button>
                    </div>
                    <form method="post" action="../controlador/admi_consultar evidencia.php">
                        <div class="small-box">
                        <center><h4>CONSULTAR EVIDENCIA POR NOMBRE</h4></center>
                        <button type="submit">Consultar</button>
                        </div>
                    </form>

                    
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
