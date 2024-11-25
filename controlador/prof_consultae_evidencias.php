<?php
session_start();

// Depuración: Imprimir el contenido de $_SESSION["usuario"]
echo '<pre>';
var_dump($_SESSION["nombre_taller"]);
echo '</pre>';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el rol del usuario desde la sesión
$rol = $_SESSION["rol"];

// Verificar si el usuario tiene el rol adecuado para esta página
if ($rol !== 'profesional') {
    header("Location: iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = isset($_SESSION["Nombre_completo"]) ? $_SESSION["Nombre_completo"] : null;

// Verificar si la variable $usuario está definida antes de usarla
if ($Nombre_completo === null) {
    echo "<script>alert('Error: Usuario no definido'); location.href='../vistas/iniciar_sesion.html';</script>";
    exit();
}

// Incluir el archivo del modelo que contiene la lógica para obtener los datos
include "../modelo/modelo_evidencias.php";

$evidencias = new evidencias();

// Verificar si se ha enviado el formulario de búsqueda
if (isset($_POST['nombre_taller']) && !empty($_POST['nombre_taller'])) {
    // Obtener el nombre del taller desde el formulario
    $nombreTaller = $_POST['nombre_taller'];

    // Llamar al método de búsqueda
    $resultados = $evidencias->buscarPorNombre($nombreTaller);
} else {
    // Si no se busca nada, mostrar todos los talleres
    $resultados = $evidencias->consulta_general();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum=1.0">
    <title>Bienestar del Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            height: 14%;
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
            width: 16%;
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
        margin-top: none;
        margin-left: 16%;
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

        h2 {
            color: #ffffff;
        }

        h1 {
            background-color: #f6f6f6;
            color: #000000;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            margin-top: 30px;
        }
        .search-container {
            display: flex; /* Usa flexbox para alinear horizontalmente */
            align-items: center; /* Alinea verticalmente en el centro */
            width: 100%;
            margin: 20px auto;
        }

        .search-container img {
            width: 70px; /* Ajusta el tamaño de la imagen según sea necesario */
            height: auto;
            margin-right: 10px; /* Espacio entre la imagen y el texto */
        }

        .search-content {
            display: flex;
            flex-direction: column; /* Para que el texto esté en columna */
            flex: 1;
        }

        .search-content h3 {
            text-align: center;
            margin: 0; /* Quita el margen para alinear el texto con la imagen */
            color: #333;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: #4CAF50;
            border-radius: 15px;
            padding: 5px;
            margin-top:15px;
            width: 150%; /* Ajusta el tamaño del contenedor de búsqueda */
        }

        .search-bar input[type="text"] {
            border: none;
            padding: 8px;
            border-radius: 10px;
            width: 90%; /* Ajusta el tamaño del campo de texto */
            box-sizing: border-box; /* Asegura que el padding no afecte el tamaño del campo */
        }

        button {
            margin-left:2%;
            background-color: white;
            color: black;
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #39A900;
            color: white;
        }
        .divtext{
            margin-top:6%;
            width: 100%;
            margin-left:25%;
            display: flex;
        }
        .divimg{
            position: absolute;
            
            width:39%;
            display: flex;
            
        }

    </style>
</head>

<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
            <img src="../vistas/img/nlogo.png" class="logo-oee">
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
  
       <section class="sec2">
       <center> <h1>Consultar evidencias</h1></center>
       <table class="table table-hover ">
            <thead>
                <tr>
                <th>NOMBRE TALLER</th>
                    <th>PROFESIONAL 1</th>
                    <th>PROFESIONAL 2</th>
                    <th>FICHA</th>
                    <th>FECHA</th>
                    <th>ENLACE DE EVIDENCIA</th>
                    <th>Actualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si se encontraron resultados
                if (isset($resultados) && !empty($resultados)) {
                    foreach ($resultados as $valor) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($valor['nombre_taller'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['profesional1'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['profesional2'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['ficha'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['fecha_hora'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['enlaceimagen'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                    <a href='controlador_taller_act1.php?txt1=$valor[Nombre_taller]'>
                                        <button type='button' class='btn btn-outline-success'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'></path>
                                            </svg>
                                            Actualizar
                                        </button>
                                    </a>
                                </td>

                            </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="10">No se encontraron resultados.</td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
        </section>


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
