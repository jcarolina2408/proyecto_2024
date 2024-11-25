<?php

class talleres
{
    private $Nombre_taller;
    private $profesional1;
    private $profesional2;
    private $sede;
    private $jornada;
    private $numeroficha;
    private $duracion;
    private $fecha_hora;
    private $tematica;
    private $conn; // Define la propiedad $conn

    public function __construct()
    {
        // Incluye la conexión a la base de datos en el constructor
        include "conexion.php";
        $this->conn = $conexion; // Asigna la conexión a la propiedad $conn
    }

    public function registro($datos)
    {
        try {
            $this->Nombre_taller = $datos['txt1'];
            $this->profesional1 = $datos['txt2'];
            $this->profesional2 = $datos['txt3'];
            $this->sede = $datos['txt4'];
            $this->jornada = $datos['txt5'];
            $this->numeroficha = $datos['txt6'];
            $this->duracion = $datos['txt7'];
            $this->fecha_hora = $datos['txt8'];
            $this->tematica = $datos['txt9'];

            $consulta = $this->conn->prepare("CALL registro_talleres(?,?,?,?,?,?,?,?,?)");
            $consulta->bindParam(1, $this->Nombre_taller);
            $consulta->bindParam(2, $this->profesional1);
            $consulta->bindParam(3, $this->profesional2);
            $consulta->bindParam(4, $this->sede);
            $consulta->bindParam(5, $this->jornada);
            $consulta->bindParam(6, $this->numeroficha);
            $consulta->bindParam(7, $this->duracion);
            $consulta->bindParam(8, $this->fecha_hora);
            $consulta->bindParam(9, $this->tematica);
            $consulta->execute();

            return 1;
        } catch (Exception $a) {
            return $a;
        }
    }

    public function consulta_general()
    {
        $consulta = $this->conn->prepare("CALL consultag_talleres");
        $consulta->execute();
        $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $tabla;
    }

    public function Consulta_especifica($dat)
    {
        $Consulta_especifica = $this->conn->prepare("CALL Consultartaller(?)");
        $Consulta_especifica->bindParam(1, $dat['txt1']);
        $Consulta_especifica->execute();
        $mani = $Consulta_especifica->fetch();
        return $mani;
    }

    public function actualizar($datos)
    {
        $this->Nombre_taller = $datos['txt1'];
        $this->profesional1 = $datos['txt2'];
        $this->profesional2 = $datos['txt3'];
        $this->numeroficha = $datos['txt4'];
        $this->sede = $datos['txt5'];
        $this->duracion = $datos['txt6'];
        $this->fecha_hora = $datos['txt7'];
        $this->tematica = $datos['txt8'];

        $consulta = $this->conn->prepare("CALL actualizar_talleres(?,?,?,?,?,?,?,?,?)");
        $consulta->bindParam(1, $this->Nombre_taller);
        $consulta->bindParam(2, $this->profesional1);
        $consulta->bindParam(3, $this->profesional2);
        $consulta->bindParam(4, $this->numeroficha);
        $consulta->bindParam(5, $this->sede);
        $consulta->bindParam(6, $this->duracion);
        $consulta->bindParam(7, $this->fecha_hora);
        $consulta->bindParam(8, $this->tematica);
        $consulta->execute();
        return 1;
    }

    public function eliminar($datos)
    {
        $this->Nombre_taller = $datos['txt1'];
        $consulta = $this->conn->prepare("CALL eliminar_talleres(?)");
        $consulta->bindParam(1, $this->Nombre_taller);
        $consulta->execute();
        return 1;
    }

    public function buscarPorNombre($Nombre_taller)
    {
        $sql = "SELECT * FROM talleres WHERE Nombre_taller LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $param = "%$Nombre_taller%";
        $stmt->bindParam(1, $param);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function obtenerFichas() {
        $sql = "SELECT id, nombre_original, carpeta, subcarpeta FROM fichas";
        $consulta = $this->conn->prepare($sql); // Usa $this->conn para la conexión
        $consulta->execute();
    
        $fichas = [];
        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $fichas[] = $row;
        }
    
        return $fichas;
    }
    


}
