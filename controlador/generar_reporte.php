<?php
require_once('../tcpdf/tcpdf.php');
include "../modelo/conexion.php";

// Crear nuevo objeto TCPDF
$pdf = new TCPDF();

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Reporte de Talleres');
$pdf->SetHeaderData('', 0, 'Reporte de Talleres', 'Generado el: ' . date('Y-m-d H:i:s'));

// Agregar una página
$pdf->AddPage();

// Configurar la fuente
$pdf->SetFont('helvetica', '', 12);

// Obtener los talleres desde la base de datos
try {
    // Asegúrate de que la consulta incluya la columna "tematica" si la necesitas
    $consulta = $conexion->prepare("SELECT nombre_taller, profesional1, profesional2, numeroficha, sede, duracion, fecha_hora, tematica FROM talleres");
    $consulta->execute();
    $talleres = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla HTML
    $html = '<h1 style="text-align: center;">Lista de Talleres</h1>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th>Nombre Taller</th>
                        <th>Profesional 1</th>
                        <th>Profesional 2</th>
                        <th>Número de Ficha</th>
                        <th>Sede</th>
                        <th>Duración</th>
                        <th>Fecha y Hora</th>
                        <th>Temática</th>
                    </tr>
                </thead>
                <tbody>';

    // Llenar la tabla con los datos
    foreach ($talleres as $taller) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($taller['nombre_taller']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['profesional1']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['profesional2']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['numeroficha']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['sede']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['duracion']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['fecha_hora']) . '</td>';
        $html .= '<td>' . htmlspecialchars($taller['tematica']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
} catch (Exception $e) {
    $html = '<h2>Error al obtener datos: ' . htmlspecialchars($e->getMessage()) . '</h2>';
}

// Verificar si hay salida previa (por ejemplo, errores o advertencias)
// Asegúrate de no tener espacios en blanco o salida previa antes de esta línea
ob_clean(); // Limpiar cualquier salida previa

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y generar el PDF
$pdf->Output('reporte_talleres.pdf', 'D');
?>
