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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
    margin-top: 70px; /* Ajusta según el tamaño del navbar */
    margin-left: 18%;
    padding: 15px;
    background-color: #f6f6f6; /* Fondo claro para resaltar el contenido */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
    overflow-y: auto; /* Permitir desplazamiento vertical */
    max-height: calc(100vh - 70px - 50px); /* Resta la altura del navbar y footer */
}

        /* Estilos para el footer */
footer {
    width: 84%;
    background-color: #ffffff;
    color: rgb(70, 70, 70);
    text-align: center;
    padding: 7px 0;
    position: relative; /* Cambiado a relative */
    bottom: 0;
    left: 16%;
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
    h3 {
            background-color: #f6f6f6;
            color: #000000;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 30px;
            margin-top:4%;
        }

        .btn-custom {
            background-color: #39A900;
            border-color: #39A900;
            color: white;
        }

        .btn-custom:hover {
            background-color: #2d8d00;
            border-color: #2d8d00;
        }
#mensaje {
            display: none;
        }
        #mensaje {
            display: none;
            margin-top: 20px;
        }
        
        .folders {
    display: flex;
    flex-wrap: wrap; /* Permite que las carpetas se ajusten en varias filas si es necesario */
    gap: 20px; /* Espacio entre las carpetas */
}

.folder {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px; /* Espacio entre carpetas */
}
 /* Las carpetas se apilan verticalmente */


.subfolder {
    display: flex;
    align-items: center; /* Alinea verticalmente el contenido */
    gap: 10px; /* Espacio entre la etiqueta y el formulario */
    margin-bottom: 10px; /* Espacio entre subcarpetas */
}

.folder-button {
    cursor: pointer;
    width: 50px; /* Ajusta el tamaño según necesites */
    height: auto;
}
.subfolder-content {
    display: none; /* Oculta el contenido por defecto */
}

.toggle:checked + .subfolder-content {
    display: block; /* Muestra el contenido cuando la caja está marcada */
}


    </style>
</head>

<body>
    <nav class="navbar">
        
        <ul class="navbar-menu">
            <img src="img/nlogo.png" class="logo-oee">
            <li><a href="cordi Pagina De Inicio .php">Inicio</a></li>
            <li><a href="iniciar_sesion.html">Salir</a></li>
            <li><a href="../controlador/generar_reporte.php">Generar Reporte</a></li> 
        </ul>
        <h2>Bienvenido al sistema <?php echo htmlspecialchars($Nombre_completo, ENT_QUOTES, 'UTF-8'); ?></h2>
        <div class="navbar-image">
            <img src="img/logo_bienestarAprendiz.png">
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
    <center><h3>Cargar fichas</h3></center>
    <div class="folders" style="display: flex; flex-wrap: wrap;">

        <!-- Carpeta Calle 52 -->
        <div class="folder" style="margin-right: 20px;">
            <h4>Calle 52</h4>
            <label for="toggleCalle52" class="folder-label">
                <img src="img/carpeta.png" alt="Subir Archivo" class="folder-button">
            </label>
            <input type="checkbox" id="toggleCalle52" class="toggle" />
            <div class="subfolder-content">
                <div class="subfolder">
                    <h5>Jornada Diurna</h5>
                    <form id="formCargaCalle52Diurna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_52">
                        <input type="hidden" name="subcarpeta" value="jornada_diurna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Mixta</h5>
                    <form id="formCargaCalle52Mixta" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_52">
                        <input type="hidden" name="subcarpeta" value="jornada_mixta">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Nocturna</h5>
                    <form id="formCargaCalle52Nocturna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_52">
                        <input type="hidden" name="subcarpeta" value="jornada_nocturna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Carpeta Fontibón -->
        <div class="folder" style="margin-right: 20px;">
            <h4>Fontibón</h4>
            <label for="toggleFontibon" class="folder-label">
                <img src="img/carpeta.png" alt="Subir Archivo" class="folder-button">
            </label>
            <input type="checkbox" id="toggleFontibon" class="toggle" />
            <div class="subfolder-content">
                <div class="subfolder">
                    <h5>Jornada Diurna</h5>
                    <form id="formCargaFontibonDiurna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="fontibon">
                        <input type="hidden" name="subcarpeta" value="jornada_diurna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Mixta</h5>
                    <form id="formCargaFontibonMixta" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="fontibon">
                        <input type="hidden" name="subcarpeta" value="jornada_mixta">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Nocturna</h5>
                    <form id="formCargaFontibonNocturna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="fontibon">
                        <input type="hidden" name="subcarpeta" value="jornada_nocturna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Carpeta Calle 64 -->
        <div class="folder">
            <h4>Calle 64</h4>
            <label for="toggleCalle64" class="folder-label">
                <img src="img/carpeta.png" alt="Subir Archivo" class="folder-button">
            </label>
            <input type="checkbox" id="toggleCalle64" class="toggle" />
            <div class="subfolder-content">
                <div class="subfolder">
                    <h5>Jornada Diurna</h5>
                    <form id="formCargaCalle64Diurna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_64">
                        <input type="hidden" name="subcarpeta" value="jornada_diurna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Mixta</h5>
                    <form id="formCargaCalle64Mixta" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_64">
                        <input type="hidden" name="subcarpeta" value="jornada_mixta">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
                <div class="subfolder">
                    <h5>Jornada Nocturna</h5>
                    <form id="formCargaCalle64Nocturna" action="procesar_carga.php" class="upload-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="carpeta" value="calle_64">
                        <input type="hidden" name="subcarpeta" value="jornada_nocturna">
                        <input class="form-control" type="file" name="archivo" required>
                        <button type="submit" class="btn btn-primary btn-custom">Subir</button>
                        <div class="mensaje" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

    <footer>
    <div class="footer-line"></div>
        <p class="footer-text">Servicio Nacional de Aprendizaje SENA - Centro de Gestión de Mercados, Logística y Tenologías de la Información - Regional Distrito Capital </p>
        <br><p class="footer-text">Dirección: Cl 52 N° 13 65 -Telefono: +(57) 601 594 1301 </p></br>
        
    </footer>

    <script>
    document.querySelectorAll('.upload-form').forEach(form => {
        form.onsubmit = function(event) {
            event.preventDefault(); // Evita la recarga de página

            const formData = new FormData(this);
            fetch('../controlador/procesar_carga.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = this.querySelector('.mensaje');
                mensajeDiv.className = 'alert ' + (data.status === 'success' ? 'alert-success' : 'alert-danger');
                mensajeDiv.textContent = data.message;
                mensajeDiv.style.display = 'block';

                // Limpiar el input de archivo para permitir nuevas selecciones
                this.reset(); // Resetea el formulario
            })
            .catch(error => {
                console.error('Error:', error);
                const mensajeDiv = this.querySelector('.mensaje');
                mensajeDiv.className = 'alert alert-danger';
                mensajeDiv.textContent = 'Hubo un error en la carga del archivo.';
                mensajeDiv.style.display = 'block';
            });
        };
    });
</script>

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
