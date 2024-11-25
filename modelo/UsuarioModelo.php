<?php
require_once "Conexion.php";

class UsuarioModelo {
    private $conn;

    public function __construct() {
        include "conexion.php"; // Archivo con la conexión a la base de datos
        $this->conn = $conexion;
    }

    public function verificarContrasena($username, $oldPassword) {
        $sql = "SELECT Contrasena FROM usuario WHERE ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $username); // Cambiar ':username' a ':id'
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar que el usuario exista
        if (!$resultado) {
            return false; // Usuario no encontrado
        }
    
        // Verificar que la contraseña antigua coincida
        return password_verify($oldPassword, $resultado['Contrasena']);
    }
    
    

    public function actualizarContrasena($username, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET Contrasena = :newPassword WHERE ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':newPassword', $hashedPassword);
        $stmt->bindParam(':id', $username); // Cambiar ':username' a ':id'
        return $stmt->execute();
    }
    
    
}
