<?php
require_once '../modelo/modelo_talleres.php';
require_once '../modelo/modelo.php';

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
$modeloTalleres = new talleres();
$fichas = $modeloTalleres->obtenerFichas();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum=1.0">
    <title>Bienestar del Aprendiz</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
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
        padding: 10px;
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
        input.is-invalid, select.is-invalid {
            border-color: red;
        }

        input.is-valid, select.is-valid {
            border-color: green;
        }

        .error-message {
            color: red;
            font-size: 0.8em;
        }

        .success-message {
            color: green;
            font-size: 0.8em;
        }

    </style>
</head>


<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
        <img src="img/nlogo.png" class="logo-oee">
            <li><a href="admi pagina de inicio.php"> Inicio</a></li>
            <li><a href="iniciar_sesion.html" >Salir</a></li>
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
    <div class="content">
    <center><h3>Registrar Talleres</h3></center>
    <form method="post" action="../controlador/controlador_registro_taller.php" class="row g-2" onsubmit="return validarFormulario();">
        
        <!-- Nombre Taller -->
        <div class="col-md-12">
            <label for="txt1" class="form-label">Nombre taller</label>
            <input type="text" class="form-control" id="txt1" name="txt1" required>
            <div class="error-message"></div>
        </div>

        <!-- Profesionales -->
        <div class="col-md-6">
            <label for="profesional1" class="form-label">Profesional 1</label>
            <select id="txt2" name="txt2" class="form-select selectpicker" data-live-search="true" required>
                <option selected>Seleccione...</option>
                <?php foreach ($nombresProfesionales as $profesional) {
                    echo '<option value="' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '</option>';
                } ?>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="col-md-6">
            <label for="profesional2" class="form-label">Profesional 2</label>
            <select id="txt3" name="txt3" class="form-select selectpicker" data-live-search="true" required>
                <option selected>Seleccione...</option>
                <?php foreach ($nombresProfesionales as $profesional) {
                    echo '<option value="' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($profesional['Nombre_completo'], ENT_QUOTES, 'UTF-8') . '</option>';
                } ?>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="col-md-4">
            <label for="sede" class="form-label">Sede</label>
            <select id="sede" name="txt4" class="form-select" onchange="cargarJornadas();" required>
                <option selected>Seleccione...</option>
                <option value="calle_52">Calle 52</option>
                <option value="calle_64">Calle 64</option>
                <option value="fontibon">Fontibón</option>
            </select>
            <div class="error-message"></div>
        </div>
        
        <div class="col-md-4">
            <label for="jornada" class="form-label">Jornada</label>
            <select id="jornada" name="txt5" class="form-select" onchange="cargarFichas();" required>
                <option selected>Seleccione...</option>
            </select>
            <div class="error-message"></div>
        </div>
        
        <div class="col-md-4">
            <label for="ficha" class="form-label">Número de Ficha</label>
            <select id="ficha" name="txt6" class="form-select" required>
                <option selected>Seleccione...</option>
                <?php foreach ($fichas as $ficha): ?>
                    <option 
                        value="<?php echo htmlspecialchars($ficha['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-sede="<?php echo htmlspecialchars($ficha['carpeta'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-jornada="<?php echo htmlspecialchars($ficha['subcarpeta'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($ficha['nombre_original'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="error-message"></div>
        </div>

        <!-- Duración, Fecha y Hora, Temática -->
        <div class="col-md-4">
            <label for="txt7" class="form-label">Duración</label>
            <input type="text" class="form-control" id="txt7" name="txt7" required>
            <div class="error-message"></div>
        </div>

        <div class="col-md-4">
            <label for="txt7" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" class="form-control" id="txt8" name="txt8" required>
            <div class="error-message"></div>
        </div>

        <div class="col-md-4">
            <label for="txt9" class="form-label">Temática</label>
            <select id="txt9" name="txt9" class="form-select" required>
                <option selected>Seleccione...</option>
                <option value="Cultural">Cultural</option>
                <option value="Salud">Salud</option>
                <option value="Deporte">Deporte</option>
  
            </select>
            <div class="error-message"></div>
        </div>



        <!-- Botón de enviar -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary btn-custom">Registrar</button>
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
        function validarFormulario() {
        let isValid = true;

        // Validación de nombre del taller
        const nombreTaller = document.getElementById("txt1");
        if (nombreTaller.value.trim() === "" || nombreTaller.value.length < 5) {
            mostrarError(nombreTaller, "Nombre de taller no válido");
            isValid = false;
        } else {
            mostrarExito(nombreTaller);
        }

        // Validación de select (Profesionales, Sede, Jornada, Ficha, Temática)
        const selects = document.querySelectorAll("select");
        selects.forEach(select => {
            if (select.value === "Seleccione...") {
                mostrarError(select, "Este campo es obligatorio");
                isValid = false;
            } else {
                mostrarExito(select);
            }
        });

        // Validación de fecha y hora
        const fechaHora = document.getElementById("txt8");
        const fechaActual = new Date();
        const fechaIngresada = new Date(fechaHora.value);
        if (fechaIngresada <= fechaActual || esFinDeSemana(fechaIngresada)) {
            mostrarError(fechaHora, "La fecha debe ser futura y en día laboral");
            isValid = false;
        } else {
            mostrarExito(fechaHora);
        }

        // Validación de duración
        const duracion = document.getElementById("txt7");
        const duracionRegex = /^(?:\d+\s?hora(?:s)?|\d+\s?minuto(?:s)?)$/;
        if (!duracionRegex.test(duracion.value)) {
            mostrarError(duracion, "Duración debe ser '1 hora', '30 minutos', etc.");
            isValid = false;
        } else {
            mostrarExito(duracion);
        }

        return isValid;
    }

    // Función para mostrar error
    function mostrarError(elemento, mensaje) {
        elemento.classList.add("is-invalid");
        elemento.classList.remove("is-valid");
        let error = elemento.nextElementSibling;
        if (!error || !error.classList.contains("error-message")) {
            error = document.createElement("div");
            error.classList.add("error-message");
            elemento.parentNode.appendChild(error);
        }
        error.innerText = mensaje;
    }

    // Función para mostrar éxito
    function mostrarExito(elemento) {
        elemento.classList.remove("is-invalid");
        elemento.classList.add("is-valid");
        const error = elemento.nextElementSibling;
        if (error && error.classList.contains("error-message")) {
            error.innerText = "";
        }
    }

    // Función para verificar si es fin de semana
    function esFinDeSemana(fecha) {
        const dia = fecha.getDay();
        return dia === 0 || dia === 6;
    }

     // Cargar jornadas al cambiar la sede
     function cargarJornadas() {
        const sede = document.getElementById('sede').value;
        const jornadaSelect = document.getElementById('jornada');

        if (sede !== 'Seleccione...') {
            // Limpiar opciones previas
            jornadaSelect.innerHTML = '<option selected>Seleccione...</option>';

            // Definir jornadas según la sede (si es estático)
            const jornadasPorSede = {
                calle_52: ['Diurna', 'Mixta', 'Nocturna'],
                calle_64: ['Diurna', 'Mixta', 'Nocturna'],
                fontibon: ['Diurna', 'Mixta', 'Nocturna']
            };

            jornadasPorSede[sede].forEach(jornada => {
                const option = document.createElement('option');
                option.value = jornada.toLowerCase(); // Ejemplo: 'diurna'
                option.textContent = jornada;
                jornadaSelect.appendChild(option);
            });
        }
    }

    // Cargar fichas al cambiar la jornada
    function cargarFichas() {
        const sede = document.getElementById('sede').value;
        const jornada = document.getElementById('jornada').value;
        const fichaSelect = document.getElementById('ficha');

        if (sede !== 'Seleccione...' && jornada !== 'Seleccione...') {
            fetch('../controlador/obtener_fichas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ sede, jornada })
            })
            .then(response => response.json())
            .then(data => {
                fichaSelect.innerHTML = '<option selected>Seleccione...</option>';
                data.forEach(ficha => {
                    const option = document.createElement('option');
                    option.value = ficha.id;
                    option.textContent = ficha.nombre_original; // Número de ficha
                    fichaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar las fichas:', error));
        }
    }

    </script>
</body>
</html>
