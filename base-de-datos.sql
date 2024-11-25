CREATE DATABASE proyecto_2024;
USE proyecto_2024;

/* Creación de tablas */

CREATE TABLE usuario (
    tipo_documento ENUM('cc','ti','ce','pep') NOT NULL,
    ID INT UNSIGNED PRIMARY KEY,
    Nombre_completo VARCHAR(60) NOT NULL,
    Rh ENUM('A+','A-','O+','O-','AB+','AB-') NOT NULL,
    Telefono INT UNSIGNED NOT NULL,
    Direccion VARCHAR(60) NOT NULL,
    Cargo ENUM('administrador','coordinador','profesional') NOT NULL,
    Contrasena VARCHAR(255),
    Correo VARCHAR(250) NOT NULL,
    estado ENUM('Activo','No activo') DEFAULT 'Activo'
);



CREATE TABLE archivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_original VARCHAR(255) NOT NULL,
    nombre_seguro VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    fecha_subida DATETIME NOT NULL,
    carpeta VARCHAR(255) NOT NULL,
    subcarpeta VARCHAR(255) NOT NULL
);
CREATE TABLE fichas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_original VARCHAR(255) NOT NULL,
    nombre_seguro VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    fecha_subida DATETIME NOT NULL,
    carpeta VARCHAR(255) NOT NULL,
    subcarpeta VARCHAR(255) NOT NULL
);



CREATE TABLE evidencias (
    nombre_taller varchar(100) PRIMARY KEY,
	profesional1 varchar(60) not null,
    profesional2 varchar(60) not null,
    ficha int unsigned not null,
    fecha_hora datetime not null,
    enlaceimagen varchar(250) not null,
    estado ENUM('Activo','No activo') DEFAULT 'Activo'
);



CREATE TABLE talleres (
    Nombre_taller VARCHAR(100) PRIMARY KEY,
    profesional1 varchar(60) not null,
    profesional2 varchar(60) not null,
    sede enum('calle 52','calle 64','fontibon'),
    jornada enum('diurna','nocturna','mixta'),
	numeroficha int unsigned not null,
    duracion varchar (30) not null,
    fecha_hora datetime not null,
    tematica ENUM ('cultural','salud','deportes') NOT NULL,
    estado ENUM('Activo','No activo') DEFAULT 'Activo'
);


/* Registro de usuarios de prueba */
INSERT INTO usuario ( tipo_documento, ID, Nombre_completo, Rh, Telefono, Direccion, Cargo, Contrasena, Correo)
VALUES ("cc",424324, "judy calderon","o+", 3005558234, "av 233 n 43",  "administrador",  '106', "judy@soy.sena.edu.co");
INSERT INTO usuario ( tipo_documento, ID, Nombre_completo, Rh, Telefono, Direccion, Cargo,  Contrasena, Correo)
VALUES ("cc",1000464672, "Alison Melo","A-", 353453, "cll n 20 # 12",  "coordinador", '2610', "valeria@soy.sena.edu.co");


/* Consulta */
SELECT * FROM usuario;
SELECT ID, contrasena FROM usuario WHERE estado = 'Activo';

-- Actualizar contraseñas manuales encriptándolas con bcrypt
UPDATE usuario
SET contrasena = bcrypt(contrasena)
WHERE contrasena NOT LIKE '%$%';  -- Este filtro selecciona solo las contraseñas en texto plano (sin encriptar)


/* Creación de procedimientos para la tabla usuario */


DELIMITER //

CREATE PROCEDURE validacion(
    IN p_usuario INT UNSIGNED,
    IN p_contrasena varchar(255)
)
BEGIN
    SELECT * FROM usuario
    WHERE ID = p_usuario
    
    AND estado = 'Activo';
END //

DELIMITER ;




CREATE PROCEDURE registro_usuario(
     IN td VARCHAR(250),
     IN id INT UNSIGNED,
     IN nom VARCHAR(60),
     IN rh VARCHAR(4),
     IN tel INT UNSIGNED,
     IN dir VARCHAR(60),
     IN car VARCHAR(250),
     IN cont VARCHAR(255),
     IN corr VARCHAR(250)
)

    INSERT INTO usuario (tipo_documento, ID, Nombre_completo, Rh, Telefono, Direccion, Cargo, Contrasena, Correo)
    VALUES (td, id, nom, rh, tel, dir, car,cont, corr);



/* Procedimiento para consultar usuarios */
CREATE PROCEDURE consultag_usuario_con_paginacion(IN lim INT, IN off INT)

    SELECT * FROM usuario LIMIT lim OFFSET off;


  create procedure  ConsultarUsuario
 (
    in i INT UNSIGNED
 )
 select tipo_documento, ID, Nombre_completo, Rh, Telefono, Direccion, Cargo, Correo from usuario where ID=i;
 

CREATE PROCEDURE actualizar_usuario(
	IN td VARCHAR(250),
     IN id INT UNSIGNED,
     IN nom VARCHAR(60),
     IN rh VARCHAR(4),
     IN tel INT UNSIGNED,
     IN dir VARCHAR(60),
     IN car VARCHAR(250),
     IN corr VARCHAR(250)
)
update usuario set tipo_documento = td, Nombre_completo = nom, Rh = rh, Telefono = tel, Direccion = dir, Cargo = car, Correo = corr where ID= id;

Create procedure eliminar_usuario(
in id INT UNSIGNED 
) update usuario set estado="No activo" where ID=id;


CREATE PROCEDURE buscar_usuario_por_nombre(IN nombre_usuario VARCHAR(60))

    SELECT * 
    FROM usuario 
    WHERE Nombre_completo = nombre_usuario;

DELIMITER //

CREATE PROCEDURE consultar_profesionales()
BEGIN
    SELECT ID, Nombre_completo
    FROM usuario
    WHERE Cargo = 'profesional'
    AND estado = 'Activo';
END //

DELIMITER ;

select * from fichas;



/*Procedimientos tabla evidencias*/

CREATE PROCEDURE registro_evidencia(
	 IN ntaller varchar(100),
     IN p1 VARCHAR(60),
     IN p2 VARCHAR(60),
     IN f INT UNSIGNED,
     IN fh VARCHAR(100),
     IN ei VARCHAR(250)

)

    INSERT INTO evidencias (nombre_taller,profesional1, profesional2, ficha,fecha_hora, enlaceimagen)
    VALUES (ntaller,p1, p2, f,fh, ei);



/* Procedimiento para consultar usuarios */
CREATE PROCEDURE consultag_evidencia()
    SELECT * FROM evidencias WHERE estado = 'Activo';


  create procedure  Consultarevidencia
 (
    in ntaller VARCHAR(100)
 )
 select nombre_taller, profesional1, profesional2, ficha,fecha_hora, enlaceimagen from evidencias where nombre_taller=ntaller;
 
 
CREATE PROCEDURE actualizar_evidencia(
	 IN ntaller VARCHAR(100),
     IN p1 VARCHAR(60),
     IN p2 VARCHAR(60),
     IN f INT UNSIGNED,
     IN fh VARCHAR(100),
     IN ei VARCHAR(250)
)
update evidencias set nombre_taller=ntaller, profesional1 = p1, profesional2 = p2, ficha = f, fecha_hora=fh, enlaceimagen = ei where nombre_taller= ntaller;

Create procedure eliminar_evidencia(
in ntaller VARCHAR(100) 
) update evidencias set estado="No activo" where nombre_taller=ntaller;

 drop procedure actualizar_talleres ;

/*Procedimientos tabla talleres*/
CREATE PROCEDURE registro_talleres(
	 IN ntaller VARCHAR(100),
     IN p1 VARCHAR(60),
     IN p2 VARCHAR (60),
     IN s VARCHAR(20),
     IN j VARCHAR(20),
     IN f INT UNSIGNED,
     IN du VARCHAR(30),
     IN fh VARCHAR(50),
     IN tem VARCHAR(50)

)

    INSERT INTO talleres (Nombre_taller,profesional1,profesional2, sede, jornada, numeroficha,  duracion, fecha_hora, tematica)
    VALUES (ntaller,p1,p2,s,j,f,du,fh,tem);
    
    CREATE PROCEDURE consultag_talleres()
    SELECT * FROM talleres WHERE estado = 'Activo';


CREATE PROCEDURE Consultartaller(
    IN ntaller varchar(100)
)
SELECT Nombre_taller, profesional1, profesional2, numeroficha, sede, duracion, fecha_hora, tematica
FROM talleres
WHERE Nombre_taller = ntaller;


 
CREATE PROCEDURE actualizar_talleres(
	 IN ntaller varchar(100),
     IN p1 VARCHAR(60),
     IN p2 VARCHAR(60),
     IN f INT UNSIGNED,
     IN sd VARCHAR(100),
     IN dr VARCHAR(30),
     IN fh VARCHAR(250),
     IN tm VARCHAR(50)
)
update talleres set Nombre_taller=ntaller, profesional1 = p1, profesional2 = p2, numeroficha = f, sede = sd, duracion = dr, fecha_hora = fh, tematica = tm where Nombre_taller= ntaller;

Create procedure eliminar_talleres(
 IN ntaller varchar(100)
) update talleres set estado="Inactivo" where Nombre_taller=ntaller;


CREATE PROCEDURE buscarPorNombre(IN Nombretaller VARCHAR(60))

    SELECT * 
    FROM talleres 
    WHERE Nombre_taller = Nombretaller;







