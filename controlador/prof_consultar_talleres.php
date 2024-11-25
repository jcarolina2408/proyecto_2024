<?php
include "../modelo/modelo_talleres.php"; 
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = $_SESSION["Nombre_completo"];
$instancia = new talleres();
$r = $instancia->consulta_general();
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

        h2 {
            color: #ffffff;
        }

        h1 {
            background-color: #f6f6f6;
            color: #000000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 30px;
            margin-top: 20px;
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
    <div class="search-container">
            <form method="post" action="prof_consultae_talleres.php">
                <!-- Imagen centrada -->
                 <div class="divimg">
                    <img src="../vistas/img/meraki.png" alt="Logo">
                </div>
                <div class="divtext">
                   <h3>¿Desea buscar algún taller en específico?</h3>
                </div>
                <nav class="search-bar">
                    <input  type="text" name="nombre_taller" placeholder="Digite el nombre del taller que desea consultar">
                    <button type="submit">Buscar</button>
                </nav>
            </form>
        </div>
    <section>
        <center> <h1>Consultar talleres</h1></center>
        
        <table class="table table-sm ">
                <thead>
                    <tr>
                        <th>NOMBRE TALLER</th>
                        <th>PROFESIONAL 1</th>
                        <th>PROFESIONAL 2</th>
                        <th>FICHA</th>
                        <th>SEDE</th>
                        <th>DURACION</th>
                        <th>FECHA Y HORA</th>
                        <th>TEMATICA</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($r as $valor) {
                        echo "<tr>
                                <td>$valor[Nombre_taller]</td>
                                <td>$valor[profesional1]</td>
                                <td>$valor[profesional2]</td>
                                <td>$valor[numeroficha]</td>
                                <td>$valor[sede]</td>
                                <td>$valor[duracion]</td>
                                <td>$valor[fecha_hora]</td>
                                <td>$valor[tematica]</td>

                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
    
    

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