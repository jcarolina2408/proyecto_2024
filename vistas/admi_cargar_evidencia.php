<?php
require_once '../modelo/modelo.php';
require_once '../modelo/modelo_evidencias.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = $_SESSION["Nombre_completo"];
$modelUsuario = new usuario();
$nombresProfesionales = $modelUsuario->obtenerNombresProfesionales();

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
    .grupo-formulario {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
        }
        input[type="text"], select {
            width: 100%; /* Ajusta el ancho al contenedor padre */
            padding: 8px; /* Espaciado interno para consistencia */
            font-size: 16px; /* Tamaño de fuente uniforme */
            border: 1px solid #ccc; /* Borde uniforme */
            border-radius: 4px; /* Bordes redondeados */
            box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
        }


        button {
            grid-column: span 2;
            padding: 10px;
            background-color: #39A900;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 20%;
            justify-self: center; /* Centra horizontalmente el botón */
            
            
        }
        h1 {
            background-color: #f6f6f6;
            color: #000000;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .error {
            color: red;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>
<nav class="navbar">
        <ul class="navbar-menu">
            <img src="img/nlogo.png" class="logo-oee">
            <li><a href="admi pagina de inicio.php"> Inicio</a></li>
            <li><a href="iniciar_sesion.html">Salir</a></li>
        </ul>
        <h2 class="h2">Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
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
                <a href="#option2" class="sidebar-link">
                    <i class="fas fa-user"></i>Fichas
                </a>
                <ul class="sub-menu">
                    <li><a href="../controlador/admi_consultar_ficha.php">Consultar fichas</a></li>
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
    <main class="content">
        <center><h1>Cargar Evidencias</h1></center>
        <form method="post" action="../controlador/controlador_registro_evidencias.php" onsubmit="return validarFormulario();">
            <div class="grupo-formulario">
                <label for="nombretaller">Nombre taller</label>
                <input type="text" id="nombre_taller" name="txt1" required>
                <div id="error_nombre_taller" class="error"></div> <!-- Contenedor para el error -->
            </div>

            <div class="grupo-formulario">
            <label for="profesional1" >Profesional 1</label>
            <select id="txt2" name="txt2" data-live-search="true" required>
                <option selected>Seleccione...</option>
                <?php foreach ($nombresProfesionales as $profesional) {
                    echo '<option value="' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '</option>';
                } ?>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="grupo-formulario">
            <label for="profesional2" >Profesional 2</label>
            <select id="txt3" name="txt3" data-live-search="true" required>
                <option selected>Seleccione...</option>
                <?php foreach ($nombresProfesionales as $profesional) {
                    echo '<option value="' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '</option>';
                } ?>
            </select>
            <div class="error-message"></div>
        </div>
            <div class="grupo-formulario">
                <label for="ficha">Ficha</label>
                <input type="number" id="ficha" name="txt4" required>
                <div id="error_ficha" class="error"></div> <!-- Contenedor para el error -->
            </div>
            <div class="grupo-formulario">
                <label for="fecha_hora">Fecha que se realizó el taller</label>
                <input type="datetime-local" id="fecha_hora" name="txt5" required>
                <div id="error_fecha_hora" class="error"></div> <!-- Contenedor para el error -->
            </div>
            <div class="grupo-formulario">
                <label for="enlaceTaller">Agregar enlace de taller</label>
                <input type="text" id="enlaceTaller" name="txt6" required>
                <div id="error_enlaceTaller" class="error"></div> <!-- Contenedor para el error -->
            </div>
            <button type="submit">SUBIR</button>
        </form>
    </main>
    <footer>
        <div class="footer-line"></div>
        <p class="footer-text">Servicio Nacional de Aprendizaje SENA - Centro de Gestión de Mercados, Logística y Tenologías de la Información - Regional Distrito Capital </p>
        <br><p class="footer-text">Dirección: Cl 52 N° 13 65 -Telefono: +(57) 601 594 1301 </p></br>
        
    </footer>


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

        function validarFormulario() {
            // Limpiar mensajes de error previos
            var errores = document.querySelectorAll('.error');
            errores.forEach(function(error) {
                error.innerText = ''; // Limpiar el mensaje de error
            });

            var esValido = true;

            // Obtener valores de los campos
            var nombreTaller = document.getElementById('nombre_taller').value;
            var ficha = document.getElementById('ficha').value;
            var fechaHora = new Date(document.getElementById('fecha_hora').value);
            var enlaceTaller = document.getElementById('enlaceTaller').value;

            var nombrePattern = /^[a-zA-ZÁÉÍÓÚáéíóúñÑ0-9\s]+$/; // Solo letras, números y espacios
            var enlacePattern = /^(https?:\/\/[^\s]+)/; // Validar enlace

            // Validar nombre del taller (debe ser coherente)
            if (!nombrePattern.test(nombreTaller) || nombreTaller.length < 3) {
                mostrarError('nombre_taller', 'El nombre del taller debe ser coherente y tener al menos 3 caracteres.');
                esValido = false;
            }

            // Validar ficha (mínimo 7 caracteres)
            if (ficha.length < 7) {
                mostrarError('ficha', 'La ficha debe tener al menos 7 caracteres.');
                esValido = false;
            }

            // Validar fecha y hora
            var dia = fechaHora.getDay();
            var hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            // Comprobar si es fin de semana
            if (dia === 0 || dia === 6) {
                mostrarError('fecha_hora', 'La fecha no puede ser un fin de semana.');
                esValido = false;
            }

            // Comprobar si la fecha es futura
            if (fechaHora > hoy) {
                mostrarError('fecha_hora', 'La fecha y hora no pueden ser en el futuro.');
                esValido = false;
            }

            // Validar enlace
            if (!enlacePattern.test(enlaceTaller)) {
                mostrarError('enlaceTaller', 'El enlace del taller debe ser un enlace válido.');
                esValido = false;
            }

            return esValido; // Retornar true si no hay errores, de lo contrario false
        }

        function mostrarError(campo, mensaje) {
            var elementoError = document.getElementById('error_' + campo);
            elementoError.innerText = mensaje; // Muestra el mensaje de error
        }
    </script>
</body>

</html>
