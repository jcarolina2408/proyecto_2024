<?php
include "../modelo/modelo.php"; 
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = $_SESSION["Nombre_completo"];
$instancia = new usuario();

// Configuración de paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 5; // Número de registros por página
$offset = ($pagina_actual - 1) * $limite;

// Obtener el total de registros
$total_registros = $instancia->contar_usuarios(); // Método que debes implementar para contar los usuarios
$total_paginas = ceil($total_registros / $limite);

// Obtener los usuarios con límite y offset
$r = $instancia->consulta_general($limite, $offset); // Modifica tu método para aceptar límites y offsets
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
            margin-top: 90px;
            margin-left: 18%;
            padding: 15px;
        }

            /* Estilos para el footer */
            footer {
            width: 84%;
            background-color: #ffffff;
            color: rgb(70, 70, 70);
            text-align: center;
            padding: 7px 0;
            position: relative;
            left: 16%;
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
                <?php
                foreach ($r as $valor) {
                    echo "<tr>
                            <td>{$valor['tipo_documento']}</td>
                            <td>{$valor['ID']}</td>
                            <td>{$valor['Nombre_completo']}</td>
                            <td>{$valor['Cargo']}</td>
                            <td>{$valor['Correo']}</td>
                            <td>
                                <a href='controlador_act1.php?txt2={$valor['ID']}'>
                                    <button type='button' class='btn btn-outline-success  w-75'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pen' viewBox='0 0 16 16'>
                                                <path d='m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z'></path>
                                            </svg>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href='controlador_eliminar_usuario.php?txt2={$valor['ID']}'>
                                    <button type='button' class='btn btn-outline-danger  w-75'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                                                <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'></path>
                                            </svg>
                                    </button>
                                </a>
                            </td>
                          </tr>";
                }
                ?>
            </table>
            <nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($pagina_actual > 1): ?>
            <li class="page-item">
                <a class="page-link text-success" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="page-item <?php echo $i === $pagina_actual ? 'active' : ''; ?>">
                <a class="page-link <?php echo $i === $pagina_actual ? 'bg-success text-white' : 'text-success'; ?>" href="?pagina=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($pagina_actual < $total_paginas): ?>
            <li class="page-item">
                <a class="page-link text-success" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
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
