<?php
session_start();

// Depuración: Imprimir el contenido de $_SESSION["usuario"]
echo '<pre>';
var_dump($_SESSION["usuario"]);
echo '</pre>';

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
    echo "<script>alert('Error: Usuario no definido'); location.href='../vistas/iniciar_sesion.html';</script>";
    exit();
}

// Incluir el archivo del modelo que contiene la lógica para obtener los datos
include "../modelo/modelo.php";

// Crear una instancia de la clase usuario
$usuarioModel = new usuario();

// Obtener el nombre de usuario a buscar desde la solicitud
$nombreBuscado = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Llamar al método que consulta los datos filtrados y asignar el resultado a $r
$r = $usuarioModel->buscarPorNombre($nombreBuscado);


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
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 30px;
                
            }
            .form{
                width: 110%;
            }


        </style>
    </head>

    <body>
        <nav class="navbar">
            
            <ul class="navbar-menu">
                <img src="../vistas/img/nlogo.png" class="logo-oee">
                <li><a href="../vistas/admi pagina de inicio.php">Inicio</a></li>
                <li><a href="../vistas/iniciar_sesion.html">Salir</a></li>
            </ul>
            <h2>Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
            <div class="navbar-image">
                <img src="../vistas/img/logo_bienestarAprendiz.png">
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
                        <li><a href="../vistas/admi_registrar_usuarios.php">Registrar usuario</a></li>
                        <li><a href="controlador_admi_consultar_usuarios.php">Consultar usuario</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#option2" class="sidebar-link">
                        <i class="fas fa-user"></i>Fichas
                    </a>
                    <ul class="sub-menu">
                        
                        <li><a href="admi_consultar_ficha.html">Consultar fichas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#option3" class="sidebar-link">
                        <i class="fas fa-cog"></i> Talleres
                    </a>
                    <ul class="sub-menu">
                        <li><a href="../vistas/admi_registrar_taller.php">Registrar talleres </a></li>
                        <li><a href="admi_consultar_talleres.php">Consultar talleres</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#option4" class="sidebar-link">
                        <i class="fas fa-envelope"></i> Evidencias
                    </a>
                    <ul class="sub-menu">
                        <li><a href="../vistas/admi_cargar_evidencia.php">Cargar evidencia </a></li>
                        <li><a href="admi_consultar evidencia.php">Consultar evidencia</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#option5" class="sidebar-link">
                        <i class="fas fa-info-circle"></i> Horarios 
                    </a>
                    <ul class="sub-menu">
                        <li><a href="admi_consultar_horarios.html">Consultar horarios</a></li>
                        
                    </ul>
                </li>
            </ul>
        </aside>

        <div class="content">
        <section class="sec2">
                <center><h1>Consultar usuarios</h1></center>
                <table class="table table-hover">
                <tr>
                    <th>TIPO DOCUMENTO</th>
                    <th>NUMERO DOCUMENTO</th>
                    <th>NOMBRE</th>
                    <th>CARGO</th>
                    <th>CORREO</th>
                    <th>MODIFICAR</th>
                    <th>INACTIVAR</th>
                </tr>

              <!-- Verificar si $r tiene datos -->
                <?php if (isset($r) && is_array($r) && !empty($r)): ?>
                    <?php foreach ($r as $valor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($valor['tipo_documento']); ?></td>
                            <td><?php echo htmlspecialchars($valor['ID']); ?></td>
                            <td><?php echo htmlspecialchars($valor['Nombre_completo']); ?></td>
                            <td><?php echo htmlspecialchars($valor['Cargo']); ?></td>
                            <td><?php echo htmlspecialchars($valor['Correo']); ?></td>
                            <td>
                                <a href='controlador_act1.php?txt2=<?php echo $valor['ID']; ?>'>
                                    <button type='button' class='btn btn-outline-success'>Actualizar</button>
                                </a>
                            </td>
                            <td>
                                <a href='controlador_eliminar_usuario.php?txt2=<?php echo $valor['ID']; ?>'>
                                    <button type='button' class='btn btn-outline-success'>Inactivar</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" style="text-align:center;">No se encontraron resultados para el usuario especificado.</td>
                    </tr>
                <?php endif; ?>
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