<?php

include '../modelo/modelo_talleres.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = $_SESSION["Nombre_completo"];
$instancia = new talleres();
$r=$instancia->Consulta_especifica($_GET);

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

            .h2 {
                color: white;
            }

            h3 {
                background-color: #f6f6f6;
                color: #000000;
                padding: 12px;
                border-radius: 5px;
                margin-bottom: 30px;
                margin-top: 22px;
            }
        .btn-custom {
            background-color: #39A900;
            border-color: #39A900;
            color: white;
            
        }

        .btn-custom:hover {
            background-color: #2d8d00;
            border-color: #2d8d00;
            justify-self: center;
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
        <h2 class="h2">Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
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
                    <li><a href="admi_registrar_usuarios.php">Registrar usuario</a></li>
                    <li><a href="../controlador/controlador_admi_consultar_usuarios.php">Consultar usuario</a></li>
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
                    <li><a href="admi_registrar_taller.php">Registrar talleres </a></li>
                    <li><a href="admi_consultar_talleres.php">Consultar talleres</a></li>
                </ul>
            </li>
            <li>
                <a href="#option4" class="sidebar-link">
                    <i class="fas fa-envelope"></i> Evidencias
                </a>
                <ul class="sub-menu">
                    <li><a href="admi_cargar_evidencia.php">Cargar evidencia </a></li>
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
        <center><h3>Actualizar Talleres</h3></center>
        <form method="post" action="controlador_taller_act2.php" class="row g-3">

          <div class="col-md-6">
                <label for="txt1" class="form-label">Nombre taller</label>
                <input type="text" class="form-control" id="txt1" name="txt1" required  value='<?php echo $r["Nombre_taller"]; ?>' >
            </div>   
            
            <div class="col-md-6">
                <label for="txt2" class="form-label">Profesional 1</label>
                <input type="text" class="form-control" id="txt2" name="txt2" required value="<?php echo $r["profesional1"]; ?>">
            </div>
            <div class="col-md-6">
                <label for="txt3" class="form-label">Profesional 2</label>
                <input type="text" class="form-control" id="txt3" name="txt3" required value="<?php echo $r["profesional2"]; ?>">
            </div>
            <div class="col-md-2">
                <label for="txt4" class="form-label">Número de ficha</label>
                <input type="number" class="form-control" id="txt4" name="txt4" required value="<?php echo $r["numeroficha"]; ?>">
            </div>
            <div class="col-md-4">
                <label for="txt5" class="form-label">Sede</label>
                <select id="txt5" class="form-select" name="txt5" required>
                    <option value="<?php echo $r["sede"]; ?>"><?php echo $r["sede"]; ?></option>
                    <option>Calle 52</option>
                    <option>Calle 64</option>
                    <option>Fontibón</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="txt6" class="form-label">Duración</label>
                <input type="text" class="form-control" id="txt6" name="txt6" required value="<?php echo $r["duracion"]; ?>">
            </div>
            <div class="col-md-6">
                <label for="txt7" class="form-label">Fecha y hora</label>
                <input type="datetime-local" class="form-control" id="txt7" name="txt7" required value="<?php echo $r["fecha_hora"]; ?>">
            </div>
            <div class="col-md-4">
                <label for="txt8" class="form-label">Temática</label>
                <select id="txt8" class="form-select" name="txt8" required>
                    <option value="<?php echo $r["tematica"]; ?>"><?php echo $r["tematica"]; ?></option>
                    <option>Cultural</option>
                    <option>Salud</option>
                    <option>Deportes</option>
                </select>
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-custom">Actualizar</button>
            </div>
        </form>
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
