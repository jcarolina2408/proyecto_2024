<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$Nombre_completo = $_SESSION["Nombre_completo"];
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
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .is-invalid {
            border-color: red;
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
    <center> <h3>Registrar usuarios</h3></center>

    <form method="post" action="../controlador/controlador_registrou.php" class="row g-3" onsubmit="return validarFormulario();">
        <div class="col-md-4">
            <label for="tipo_documento" class="form-label">Tipo de documento</label>
            <select id="tipo_documento" class="form-select" name="txt1" required>
                <option selected>Seleccione</option>
                <option value="CC">CC</option>
                <option value="TI">TI</option>
                <option value="CE">CE</option>
                <option value="PEP">PEP</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="ID" class="form-label">Número de documento</label>
            <input type="number" class="form-control" id="ID" name="txt2" required>
        </div>

        <div class="col-md-6">
            <label for="Nombre_completo" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="Nombre_completo" name="txt3" required>
        </div>
        <div class="col-md-4">
            <label for="Rh" class="form-label">Tipo de sangre</label>
            <select id="Rh" class="form-select" name="txt4" required>
                <option selected>Seleccione</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="Telefono" class="form-label">Número telefónico</label>
            <input type="number" class="form-control" id="Telefono" name="txt5" required>
        </div>
        <div class="col-md-6">
            <label for="Direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="txt6" required>
        </div>
        <div class="col-md-4">
            <label for="Cargo" class="form-label">Cargo</label>
            <select id="Cargo" class="form-select" name="txt7" required>
                <option selected>Seleccione</option>
                <option value="Administrador">Administrador</option>
                <option value="Coordinador">Coordinador</option>
                <option value="Profesional">Profesional</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="Correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="Correo" name="txt10" required>
        </div>
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
            // Limpiar mensajes de error previos
            var errores = document.querySelectorAll('.error');
            errores.forEach(function(error) {
                error.remove();
            });

            var inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(function(input) {
                input.classList.remove('is-invalid');
            });

            var esValido = true;

            // Obtener valores de los campos
            var id = document.getElementById('ID').value;
            var nombre = document.getElementById('Nombre_completo').value;
            var telefono = document.getElementById('Telefono').value;
            var direccion = document.getElementById('Direccion').value;
            var correo = document.getElementById('Correo').value;
            var tipoDocumento = document.getElementById('tipo_documento').value;
            var rh = document.getElementById('Rh').value;
            var cargo = document.getElementById('Cargo').value;

            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var nombrePattern = /^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]{2,}$/; // Solo letras y espacios (mínimo 2 caracteres)
            var direccionPattern = /^[a-zA-Z0-9ÁÉÍÓÚáéíóúñÑ\s]+$/; // Letras, números y espacios

            // Función auxiliar para agregar mensajes de error
            function mostrarError(campo, mensaje) {
                var elementoError = document.createElement('div');
                elementoError.classList.add('error');
                elementoError.innerText = mensaje;
                campo.classList.add('is-invalid');
                campo.parentNode.appendChild(elementoError);
                esValido = false;
            }

            // Validar selectores
            if (tipoDocumento === 'Seleccione') {
                mostrarError(document.getElementById('tipo_documento'), 'Seleccione un tipo de documento válido.');
            }
            if (rh === 'Seleccione') {
                mostrarError(document.getElementById('Rh'), 'Seleccione un tipo de sangre válido.');
            }
            if (cargo === 'Seleccione') {
                mostrarError(document.getElementById('Cargo'), 'Seleccione un cargo válido.');
            }

            // Validar ID (mínimo 7 dígitos)
            if (id.length < 7) {
                mostrarError(document.getElementById('ID'), 'El ID debe tener al menos 7 dígitos.');
            }

            // Validar nombre (debe contener solo letras y espacios)
            if (!nombrePattern.test(nombre)) {
                mostrarError(document.getElementById('Nombre_completo'), 'El nombre debe contener solo letras y tener sentido.');
            }

            // Validar teléfono (mínimo 10 dígitos)
            if (telefono.length < 10 || isNaN(telefono)) {
                mostrarError(document.getElementById('Telefono'), 'El número de teléfono debe tener al menos 10 dígitos.');
            }

            // Validar dirección (no vacía y con letras/números coherentes)
            if (!direccionPattern.test(direccion)) {
                mostrarError(document.getElementById('Direccion'), 'La dirección debe ser válida y contener letras y/o números.');
            }

            // Validar correo
            if (!emailPattern.test(correo)) {
                mostrarError(document.getElementById('Correo'), 'El correo electrónico no es válido.');
            }

            return esValido; // Retornar true si no hay errores, de lo contrario false
        }

    </script>
</body>

</html>
