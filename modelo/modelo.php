<?php

require_once __DIR__ . '/../vendor/autoload.php';

    

class validacion
{
    private $usuario_id;
    private $contrasena;

    public function Acceso($datos)
    {
        $this->usuario_id = $datos["txt1"];
        $this->contrasena = $datos["txt2"];
        include "conexion.php"; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

        $consulta = $conexion->prepare("CALL validacion(?, ?)");
        $consulta->bindParam(1, $this->usuario_id);
        $consulta->bindParam(2, $this->contrasena);
        $consulta->execute();
        $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($tabla) == 1) {
            // Verificar la contraseña usando password_verify()
            $usuario = $tabla[0]; // Obtener el primer (y único) resultado
            if (password_verify($this->contrasena, $usuario['Contrasena'])) {
                return $usuario; // Devolver los datos del usuario si la contraseña es correcta
            } else {
                return null; // Si la contraseña no coincide
            }
        } else {
            return null; // No se encontró el usuario
        }
    }
}



class usuario
{
    private $tipo_documento;
    private $ID;
    private $Nombre_completo;
    private $Rh;
    private $Telefono;
    private $Direccion;
    private $Cargo;
    public $contrasena;
    private $Correo;
    private $conn;

    public function __construct() {
        include "conexion.php"; // Archivo con la conexión a la base de datos
        $this->conn = $conexion;
    }
    private function generarContrasena($longitud = 8) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        $contrasena = '';
        $max = strlen($caracteres) - 1;
    
        for ($i = 0; $i < $longitud; $i++) {
            $contrasena .= $caracteres[random_int(0, $max)];
        }
    
        return $contrasena;
    }
    
    // Método para obtener la contraseña generada
    public function obtenerContrasena() {
        return $this->contrasena;
    }

    // Método para registrar un usuario
    public function registro($datos) {
        try {
            $this->tipo_documento = $datos['txt1'];
            $this->ID = $datos['txt2'];
            $this->Nombre_completo = $datos['txt3'];
            $this->Rh = $datos['txt4'];
            $this->Telefono = $datos['txt5'];
            $this->Direccion = $datos['txt6'];
            $this->Cargo = $datos['txt7'];
            $this->Correo = $datos['txt10'];

            // Generar una contraseña aleatoria
            $this->contrasena = $this->generarContrasena();

            // Encriptar la contraseña para almacenarla
            $contrasenaEncriptada = password_hash($this->contrasena, PASSWORD_DEFAULT);

            // Ejecutar el procedimiento almacenado
            $consulta = $this->conn->prepare("CALL registro_usuario(?,?,?,?,?,?,?,?,?)");
            $consulta->bindParam(1, $this->tipo_documento);
            $consulta->bindParam(2, $this->ID);
            $consulta->bindParam(3, $this->Nombre_completo);
            $consulta->bindParam(4, $this->Rh);
            $consulta->bindParam(5, $this->Telefono);
            $consulta->bindParam(6, $this->Direccion);
            $consulta->bindParam(7, $this->Cargo);
            $consulta->bindParam(8, $contrasenaEncriptada); // Guardar la contraseña encriptada
            $consulta->bindParam(9, $this->Correo);
            $consulta->execute();

            // Enviar correo al usuario con su contraseña generada
            $this->enviarCorreo($this->Correo, $this->Nombre_completo, $this->contrasena);

            return 1; // Éxito
        } catch (Exception $e) {
            return $e->getMessage(); // Retorna el error en caso de fallo
        }
    }

    public function enviarCorreo($correoUsuario, $nombreUsuario, $contrasena) {
        // Configuración de SwiftMailer para Gmail
        $transporte = (new Swift_SmtpTransport('smtp.gmail.com', 587)) // Servidor SMTP de Gmail
            ->setUsername('j.carolina2408@gmail.com')                  // Tu correo de Gmail
            ->setPassword('uloz gduv ypxd bngd')               // Contraseña de aplicación de Gmail
            ->setEncryption('tls');                                    // Protocolo de seguridad TLS
    
        $mailer = new Swift_Mailer($transporte);
    
        // Crear el mensaje
        $mensaje = (new Swift_Message('Bienvenido al Sistema'))
            ->setFrom(['j.carolina2408@gmail.com' => 'Bienestar Del Aprendiz']) // Cambia "Nombre de tu Empresa" si lo deseas
            ->setTo([$correoUsuario => $nombreUsuario])
            ->setBody(
                "Hola $nombreUsuario,\n\n".
                "Tu registro fue exitoso. Estas son tus credenciales:\n\n".
                "Usuario: $correoUsuario\n".
                "Contraseña: $contrasena\n\n".
                "Por favor, cámbiala en tu primer inicio de sesión.\n\n".
                "Saludos,\nEl Equipo de Bienestar del aprendiz.",
                'text/plain'
            );
    
        // Enviar correo
        try {
            $mailer->send($mensaje);
            echo "Correo enviado exitosamente a $correoUsuario";
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
        }
    }
    


    // Método para obtener los nombres de los profesionales desde la base de datos
    public function obtenerNombresProfesionales() {
        try {
            // Preparar la consulta para obtener los nombres de los profesionales
            $consulta = $this->conn->prepare("SELECT Nombre_completo FROM usuario WHERE Cargo = 'profesional'");
            $consulta->execute();
            
            // Obtener los resultados
            $nombresProfesionales = $consulta->fetchAll(PDO::FETCH_ASSOC);
            
            return $nombresProfesionales;
        } catch (PDOException $e) {
            // Manejar el error en caso de que la consulta falle
            return "Error al obtener los nombres de los profesionales: " . $e->getMessage();
        }
    }



    
    
    public function consulta_general($pagina, $limite)
    {
        include "conexion.php";
        $consulta = $conexion->prepare("CALL consultag_usuario_con_paginacion(?, ?)");
        $consulta->bindParam(1, $pagina, PDO::PARAM_INT);
        $consulta->bindParam(2, $limite, PDO::PARAM_INT);
        $consulta->execute();
        $tabla = $consulta->fetchALL(PDO::FETCH_ASSOC);
        return $tabla;
    }
    

    public function Consulta_especifica($dat)
    {
        include "conexion.php";
        $Consulta_especifica = $conexion->prepare("CALL ConsultarUsuario(?)");
        $Consulta_especifica->bindParam(1, $dat['txt2']);
        $Consulta_especifica->execute();
        $mani = $Consulta_especifica->fetch();
        return $mani;
    }
    
    public function actualizar($datos)
    {
        $this->tipo_documento = $datos['txt1'];
        $this->ID = $datos['txt2'];
        $this->Nombre_completo = $datos['txt3'];
        $this->Rh = $datos['txt4'];
        $this->Telefono = $datos['txt5'];
        $this->Direccion = $datos['txt6'];
        $this->Cargo = $datos['txt7'];
        $this->Correo = $datos['txt10'];

        

        include "conexion.php";
        $consulta = $conexion->prepare("CALL actualizar_usuario(?,?,?,?,?,?,?,?)");
        $consulta->bindParam(1, $this->tipo_documento);
        $consulta->bindParam(2, $this->ID);
        $consulta->bindParam(3, $this->Nombre_completo);
        $consulta->bindParam(4, $this->Rh);
        $consulta->bindParam(5, $this->Telefono);
        $consulta->bindParam(6, $this->Direccion);
        $consulta->bindParam(7, $this->Cargo);
        $consulta->bindParam(8, $this->Correo);
        $consulta->execute();      
        return 1;
    }

    public function eliminar($datos)
    {
        include "conexion.php";
        $this->ID = $datos['txt2'];
        $consulta = $conexion->prepare("CALL eliminar_usuario(?)");
        $consulta->bindParam(1, $this->ID);
        $consulta->execute();
        return 1;
    }


    public function buscarPorNombre($nombre) {
        // Asegúrate de usar la misma conexión
        $sql = "SELECT * FROM usuario WHERE Nombre_completo LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $param = "%$nombre%";
        $stmt->bindParam(1, $param);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function contar_usuarios() {
        $sql = "SELECT COUNT(*) as total FROM usuario"; // Asegúrate de usar el nombre correcto de tu tabla
        $resultado = $this->conn->query($sql); // Usa $this->conn
        
        if ($resultado) {
            $fila = $resultado->fetch(PDO::FETCH_ASSOC); // Cambiado a fetch para PDO
            return $fila['total'];
        } else {
            return 0; // Devuelve 0 si no hay resultados
        }
    }
}


    
    



?>