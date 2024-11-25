<?php
$hashedPassword = '$2y$10$qcJztO90lL4AwzX86UUXuuibDa5wgs2a9InAE3y2ArWBcxnkqiFkW'; // Hash real de tu base de datos
$passwordIngresada = 'fer1234'; // La contraseña que quieres probar

if (password_verify($passwordIngresada, $hashedPassword)) {
    echo "La contraseña es correcta.";
} else {
    echo "La contraseña es incorrecta.";
}
