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
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; /* Tipo de letra */
        }

        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; /* Tipo de letra */
        }   

        /* Estilo general para el navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 20%;
            width: 80%;
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
            height: 70px; /* Tamaño del logo ajustado */
            width: auto;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 20%;
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
            margin-top: 60px;
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
            height: 50px; /* Tamaño del logo ajustado */
            position: fixed;
            bottom: 0;
            left: 15px;
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


    </style>
</head>

<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
            <li><a href="../vistas/cordi Pagina De Inicio .php">Inicio</a></li>
            <li><a href="../vistas/iniciar_sesion.html">Salir</a></li>
            <li><a href="../controlador/generar_reporte.php">Generar Reporte</a></li> 
        </ul>
        <h2>Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
        <div class="navbar-image">
            <img src="../vistas/img/logo_bienestarAprendiz.png">
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


        </ul>
    </aside>

    <div class="content">
    <section>
        <center> <h1>Consultar talleres</h1></center>
        <div class="table-responsive">
        <table class="table table-hover table-sm tabla-reducida">
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
                        <th>NOMBRE INSTRUCTOR</th>
                        <th>CORREO INSTRUCTOR</th>
                    
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
                                <td>$valor[nombre_instructor]</td>
                                <td>$valor[correo_instructor]</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>

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