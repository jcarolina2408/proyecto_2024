<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["SesionIn"]) || $_SESSION["SesionIn"] !== true) {
    header("Location: ../vistas/iniciar_sesion.html");
    exit();
}

// Verificar si la variable de usuario está en la sesión
if (isset($_SESSION["Nombre_completo"])) {
    $Nombre_completo = $_SESSION["Nombre_completo"];
} else {
    $Nombre_completo = 'Usuario no definido'; // O manejar el caso de manera adecuada
}

include "../modelo/conexion.php";

// Obtener la lista de archivos desde la base de datos
$consulta = $conexion->prepare("SELECT * FROM fichas");
$consulta->execute();
$archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);
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
        h3 {
            background-color: #f6f6f6;
            color: #000000;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 30px;
            margin-top:4%;
        }
        .fileBox {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 150px;
            text-align: center;
            margin-bottom: 15px;
        }
        .fileBox iframe {
            width: 100%;
            height: 100px; /* Altura ajustable para la vista previa */
            border: none;
            display: none; /* Ocultar por defecto */
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
    margin-bottom: 20px; /* Espacio entre subcarpetas */
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
            <img src="../vistas/img/nlogo.png" class="logo-oee">
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
                    <li><a href="cordi_consultar_Talleres.php">Consultar talleres</a></li>
                    <li><a href="cordi_Consultar_Usuario.php">Consultar usuario</a></li>
                </ul>
            </li>
            <li>
                <a href="#option2" class="sidebar-link">
                    <i class="fas fa-user"></i>Fichas
                </a>
                <ul class="sub-menu">
                    <li><a href="../vistas/cordi_cargar_ficha.php">Cargar fichas </a></li>
                    <li><a href="cordi_consultar_ficha.php">Consultar fichas</a></li>
                </ul>
            </li>

            <li>
                <a href="#option4" class="sidebar-link">
                    <i class="fas fa-envelope"></i> Evidencia
                </a>
                <ul class="sub-menu">
                    <li><a href="cordi_consultar_evidencia.php">Consultar evidencia</a></li>
                </ul>
            </li>
            <li>
                <a href="#option5" class="sidebar-link">
                    <i class="fas fa-info-circle"></i> Horarios 
                </a>
                <ul class="sub-menu">
                    <li><a href="../vistas/cordi_Cargar_Horarios.php">Cargar horarios</a></li>
                    <li><a href="cordi_Consultar_Horarios.php">Consultar Horarios</a></li>
                </ul>
            </li>


        </ul>
    </aside>
    <div class="content">
    <center><h3>Consulta de fichas</h3></center>
    <div class="folders" style="display: flex; flex-wrap: wrap;">

        <?php
        // Definimos las carpetas y jornadas
        $carpetas = ['calle_52', 'fontibon', 'calle_64'];
        $jornadas = ['jornada_diurna', 'jornada_mixta', 'jornada_nocturna'];

        // Iteramos sobre cada carpeta
        foreach ($carpetas as $carpeta) {
            echo "<div class='folder'>";
            echo "<h4>" . ucfirst(str_replace('_', ' ', $carpeta)) . "</h4>";
            echo "<label for='toggle$carpeta' class='folder-label'>";
            echo "<img src='../vistas/img/carpeta.png' alt='Horarios' class='folder-button'>";
            echo "</label>";
            echo "<input type='checkbox' id='toggle$carpeta' class='toggle' />";
            echo "<div class='subfolder-content'>";

            // Filtrar archivos de la carpeta actual
            $archivosCarpeta = array_filter($archivos, function($archivo) use ($carpeta) {
                return strpos($archivo['carpeta'], $carpeta) !== false;
            });

            // Iteramos sobre cada jornada
            foreach ($jornadas as $jornada) {
                echo "<div class='subfolder'><h5>Jornada " . ucfirst(str_replace('_', ' ', $jornada)) . "</h5>";
                echo "<div class='fileContainer'>";

                // Filtrar archivos por jornada
                $archivosJornada = array_filter($archivosCarpeta, function($archivo) use ($jornada) {
                    return strpos($archivo['subcarpeta'], strtolower($jornada)) !== false;
                });

                if (empty($archivosJornada)) {
                    echo "<p>No hay archivos para esta jornada.</p>";
                } else {
                    foreach ($archivosJornada as $archivo) {
                        $nombreArchivo = htmlspecialchars($archivo['nombre_original']);
                        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

                        // Construir la ruta del archivo
                        $subcarpetaBase = strtolower($jornada); // 'diurna', 'mixta', 'nocturna'
                        $rutaArchivo = "../fichas/$carpeta/$subcarpetaBase/" . urlencode($archivo['nombre_seguro']);

                        echo "<div class='fileBox'>";
                        echo "<p>$nombreArchivo</p>";

                        // Enlace para descargar el archivo
                        echo "<a href='descarga.php?file=" . urlencode("$carpeta/$subcarpetaBase/" . $archivo['nombre_seguro']) . "' target='_blank'>Descargar</a>";

                        // Enlace para vista previa del archivo que carga en el iframe
                        if ($extension === 'pdf') {
                            echo "<a href='#' onclick='cargarPDF(\"$rutaArchivo\")'>Vista previa</a>";
                        }

                        echo "</div>";
                    }
                }
                echo "</div></div>"; // Cierra subfolder
            }
            echo "</div></div>"; // Cierra subfolder-content y folder
        }
        ?>

    </div>

    <iframe id="pdfViewer" style="width: 100%; height: 600px; border: none;"></iframe>
    <button id="closeButton" style="display: none;" onclick="cerrarPDF()">Cerrar PDF</button>
</div>

<footer>
    <div class="footer-line"></div>
    <p class="footer-text">Servicio Nacional de Aprendizaje SENA - Centro de Gestión de Mercados, Logística y Tenologías de la Información - Regional Distrito Capital </p>
    <br><p class="footer-text">Dirección: Cl 52 N° 13 65 -Telefono: +(57) 601 594 1301 </p></br>
</footer>

<script>
document.querySelectorAll('.toggle').forEach(toggle => {
    toggle.addEventListener('change', () => {
        const subfolderContent = toggle.nextElementSibling;
        if (subfolderContent) {
            subfolderContent.style.display = toggle.checked ? 'block' : 'none';
        }
    });
});

function cargarPDF(ruta) {
    document.getElementById('pdfViewer').src = ruta;
    document.getElementById('closeButton').style.display = 'block'; // Mostrar el botón de cerrar
}

function cerrarPDF() {
    document.getElementById('pdfViewer').src = ''; // Limpiar el iframe
    document.getElementById('closeButton').style.display = 'none'; // Ocultar el botón de cerrar
}
</script>

    <!-- JavaScript para manejar la expansión de subopciones -->
    <script>

function togglePreview(fileName) {
    const previewDiv = document.getElementById(`preview-${fileName}`);
    if (previewDiv) {
        previewDiv.style.display = previewDiv.style.display === 'none' || !previewDiv.style.display ? 'block' : 'none';
    }
}



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
