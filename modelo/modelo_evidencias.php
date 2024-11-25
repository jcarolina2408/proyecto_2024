<?php
class evidencias
{
    private $nombre_taller;
    private $profesional1;
    private $profesional2;
    private $ficha;
    private $fecha_hora;
    private $enlaceimagen;

    // Método para validar los datos antes de registrar
    public function validarDatos($datos)
    {
        $errores = [];

        // 1. Validar que los profesionales existan en la base de datos
        include "conexion.php"; // Incluir conexión a la base de datos
        $consulta_profesional1 = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE Nombre_completo = ?");
        $consulta_profesional1->bindParam(1, $datos['txt2']);
        $consulta_profesional1->execute();
        if ($consulta_profesional1->fetchColumn() == 0) {
            $errores['profesional1'] = "El profesional 1 no está registrado.";
        }

        $consulta_profesional2 = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE Nombre_completo = ?");
        $consulta_profesional2->bindParam(1, $datos['txt3']);
        $consulta_profesional2->execute();
        if ($consulta_profesional2->fetchColumn() == 0) {
            $errores['profesional2'] = "El profesional 2 no está registrado.";
        }

        // 2. Validar que el nombre del taller sea coherente (solo letras y espacios)
        if (!preg_match("/^[a-zA-Z\s]+$/", $datos['txt1'])) {
            $errores['nombre_taller'] = "El nombre del taller debe contener solo letras y espacios.";
        }

        // 3. Validar que la ficha tenga al menos 7 dígitos
        if (strlen($datos['txt4']) < 7) {
            $errores['ficha'] = "La ficha debe tener al menos 7 dígitos.";
        }

        // 4. Validar que el enlace sea un URL válido
        if (!filter_var($datos['txt6'], FILTER_VALIDATE_URL)) {
            $errores['enlace'] = "El enlace ingresado no es válido.";
        }

        // 5. Validar que la fecha no sea un fin de semana ni futura
        $fecha_timestamp = strtotime($datos['txt5']);
        $dia_semana = date('N', $fecha_timestamp); // 6 = Sábado, 7 = Domingo

        if ($dia_semana >= 6) {
            $errores['fecha'] = "La fecha no puede ser un fin de semana.";
        }

        if ($fecha_timestamp > time()) {
            $errores['fecha'] = "La fecha no puede ser futura.";
        }

        return $errores; // Devolver los errores encontrados
    }

    public function registro($datos)
{
    // Validar los datos
    $errores = $this->validarDatos($datos);

    if (!empty($errores)) {
        return $errores; // Devolver errores si hay
    }

    try {
        // Configura las propiedades
        $this->nombre_taller = $datos['txt1'];
        $this->profesional1 = $datos['txt2'];
        $this->profesional2 = $datos['txt3'];
        $this->ficha = $datos['txt4'];
        $this->fecha_hora = $datos['txt5'];
        $this->enlaceimagen = $datos['txt6'];

        include "conexion.php";
        $consulta = $conexion->prepare("CALL registro_evidencia(?,?,?,?,?,?)");
        $consulta->bindParam(1, $this->nombre_taller);
        $consulta->bindParam(2, $this->profesional1);
        $consulta->bindParam(3, $this->profesional2);
        $consulta->bindParam(4, $this->ficha);
        $consulta->bindParam(5, $this->fecha_hora);
        $consulta->bindParam(6, $this->enlaceimagen);

        $consulta->execute();

        return 1; // Indica éxito
    } catch (Exception $e) {
        return $e->getMessage(); // Devolver solo el mensaje de error
    }
}


    public function consulta_general()
    {
        include "conexion.php";
        $consulta = $conexion->prepare("CALL consultag_evidencia");
        $consulta->execute();
        $tabla = $consulta->fetchALL(PDO::FETCH_ASSOC);
        return $tabla;
    }

    public function Consulta_especifica($dat)
    {
        include "conexion.php";
        $Consulta_especifica = $conexion->prepare("CALL Consultarevidencia(?)");
        $Consulta_especifica->bindParam(1, $dat['txt1']);
        $Consulta_especifica->execute();
        $mani = $Consulta_especifica->fetch();
        return $mani;
    }

    public function buscarPorNombre($nombre_taller)
    {
        $sql = "SELECT * FROM evidencias WHERE Nombre_taller LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $param = "%$nombre_taller%";
        $stmt->bindParam(1, $param);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function actualizar($datos)
    {
        $this->nombre_taller = $datos['txt1'];
        $this->profesional1 = $datos['txt2'];
        $this->profesional2 = $datos['txt3'];
        $this->ficha = $datos['txt4'];
        $this->fecha_hora = $datos['txt5'];
        $this->enlaceimagen = $datos['txt6'];


        

        include "conexion.php";
        $consulta = $conexion->prepare("CALL actualizar_evidencia(?,?,?,?,?,?)");
        $consulta->bindParam(1, $this->nombre_taller);
        $consulta->bindParam(2, $this->profesional1);
        $consulta->bindParam(3, $this->profesional2);
        $consulta->bindParam(4, $this->ficha);
        $consulta->bindParam(5, $this->fecha_hora);
        $consulta->bindParam(6, $this->enlaceimagen);
        $consulta->execute();      
        return 1;
    }

    public function eliminar($datos)
    {
        include "conexion.php";
        $this->nombre_taller = $datos['txt1'];
        $consulta = $conexion->prepare("CALL eliminar_evidencias(?)");
        $consulta->bindParam(1, $this->ID_evidencias);
        $consulta->execute();
        return 1;
    }

}

?>