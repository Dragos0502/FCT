<?php

// Definición de variables
$host = "localhost";
$user = "dwes_tarde";
$password = "dwes_2223";
$bbdd = "fct_datos";


//FUNCIONES DE VALIDACIÓN

/**
 * Método que devuelve valor de una clave del REQUEST limpia o cadena vacía si no existe
 * @param {string} - Clave del REQUEST de la que queremos obtener el valor
 * @return {string}
 **/
function obtenerValorCampo(string $campo): string
{
	if (isset($_REQUEST[$campo])) {
		$valor = trim(htmlspecialchars($_REQUEST[$campo], ENT_QUOTES, "UTF-8"));
	} else {
		$valor = "";
	}
	return $valor;
}

/**
 * Método que valida si un texto no está vacío
 * @param {string} - Texto a validar
 * @return {boolean}
 **/
function validar_requerido(string $texto): bool
{
	return !(trim($texto) == "");
}

/**
 * Método que valida si es un número entero 
 * @param {string} - Número a validar
 * @return {bool}
 **/
function validar_entero_limites(string $numero, int $limiteInferior, int $limiteSuperior): bool
{
	return (filter_var($numero, FILTER_VALIDATE_INT,  ["options" => ["min_range" => $limiteInferior, "max_range" => $limiteSuperior]]) === FALSE) ? False : True;
}

/**
 * Método que valida si es un número entero positivo 
 * @param {string} - Número a validar
 * @return {bool}
 **/
function validar_entero_positivo(string $numero): bool
{
	return (filter_var($numero, FILTER_VALIDATE_INT) === FALSE || $numero <= 0) ? False : True;
}

/**
 * FIN FUNCIONES DE VALIDACIÓN
 **/

/**
 * FUNCIONES TRABAJAR CON BBDD
 **/
function conectar_mysqli($host, $user, $password, $dbname)
{

	// Conexión a la base de datos con MySQLi
	try {
		$conexionMySQLi = new mysqli($host, $user, $password, $dbname);
	} catch (mysqli_sql_exception $e) {
		print "<p>Error: No puede conectarse con la base de datos.</p>";
		print "<p>Error: " . $e->getMessage() . "</p>";
		exit();
	}

	return $conexionMySQLi;
}

function conectar_pdo($host, $user, $password, $bbdd)
{

	try {
		$mysql = "mysql:host=$host;dbname=$bbdd;charset=utf8";
		$conexion = new PDO($mysql, $user, $password);
		// set the PDO error mode to exception
		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $exception) {
		exit($exception->getMessage());
	}
	return $conexion;
}

function cerrar_conexion($conexion)
{
	$conexion->close();
}

function resultado_consulta($conexion, $consulta)
{
	$resultado = $conexion->query($consulta);
	return $resultado;
}

function liberar_resultado($resultado)
{
	$resultado->free();
}

function cerrar_consulta($consulta)
{
	$consulta->close();
}



//FUNCIONES CRUD CANDIDATURAS
function createCandidatura($id_alumno, $id_empresa, $aprobado)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "INSERT INTO candidaturas (id_alumno, id_empresa, aprobado) VALUES (?, ?, ?)";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id_alumno, PDO::PARAM_INT);
	$stmt->bindParam(2, $id_empresa, PDO::PARAM_INT);
	$stmt->bindParam(3, $aprobado, PDO::PARAM_STR);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para obtener una candidatura por su ID
function getCandidatura($id_candidatura)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "SELECT * FROM candidaturas WHERE id_candidatura = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id_candidatura, PDO::PARAM_INT);
	$stmt->execute();

	$candidatura = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = null;
	$conexion = null;

	return $candidatura;
}

// Función para actualizar una candidatura
function updateCandidatura($id_candidatura, $aprobado)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "UPDATE candidaturas SET aprobado = ? WHERE id_candidatura = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $aprobado, PDO::PARAM_STR);
	$stmt->bindParam(2, $id_candidatura, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para eliminar una candidatura por su ID
function deleteCandidatura($id_candidatura)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "DELETE FROM candidaturas WHERE id_candidatura = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id_candidatura, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}







//FUNCIONES CRUD EMPRESAS

// Función para crear una nueva empresa
function createEmpresa($nombre, $email, $direccion, $telefono, $id_alumno)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "INSERT INTO empresas (nombre, email, direccion, telefono, id_alumno) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $email, PDO::PARAM_STR);
	$stmt->bindParam(3, $direccion, PDO::PARAM_STR);
	$stmt->bindParam(4, $telefono, PDO::PARAM_STR);
	$stmt->bindParam(5, $id_alumno, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para obtener una empresa por su ID
function getEmpresa($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "SELECT * FROM empresas WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = null;
	$conexion = null;

	return $empresa;
}

// Función para actualizar una empresa
function updateEmpresa($id, $nombre, $email, $direccion, $telefono, $id_alumno)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "UPDATE empresas SET nombre = ?, email = ?, direccion = ?, telefono = ?, id_alumno = ? WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $email, PDO::PARAM_STR);
	$stmt->bindParam(3, $direccion, PDO::PARAM_STR);
	$stmt->bindParam(4, $telefono, PDO::PARAM_STR);
	$stmt->bindParam(5, $id_alumno, PDO::PARAM_INT);
	$stmt->bindParam(6, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para eliminar una empresa por su ID
function deleteEmpresa($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "DELETE FROM empresas WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

//FUNCIONES CRUD ALUMNOS


// Función para crear un nuevo alumno
function createAlumno($nombre, $apellidos, $dni, $direccion, $fecha_nac, $email, $telefono)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "INSERT INTO alumnos (nombre, apellidos, dni, direccion, fecha_nac, email, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $apellidos, PDO::PARAM_STR);
	$stmt->bindParam(3, $dni, PDO::PARAM_STR);
	$stmt->bindParam(4, $direccion, PDO::PARAM_STR);
	$stmt->bindParam(5, $fecha_nac, PDO::PARAM_STR);
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $telefono, PDO::PARAM_STR);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para obtener un alumno por su ID
function getAlumno($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "SELECT * FROM alumnos WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = null;
	$conexion = null;

	return $alumno;
}

// Función para actualizar un alumno
function updateAlumno($id, $nombre, $apellidos, $dni, $direccion, $fecha_nac, $email, $telefono)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "UPDATE alumnos SET nombre = ?, apellidos = ?, dni = ?, direccion = ?, fecha_nac = ?, email = ?, telefono = ? WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $apellidos, PDO::PARAM_STR);
	$stmt->bindParam(3, $dni, PDO::PARAM_STR);
	$stmt->bindParam(4, $direccion, PDO::PARAM_STR);
	$stmt->bindParam(5, $fecha_nac, PDO::PARAM_STR);
	$stmt->bindParam(6, $email, PDO::PARAM_STR);
	$stmt->bindParam(7, $telefono, PDO::PARAM_STR);
	$stmt->bindParam(8, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para eliminar un alumno por su ID
function deleteAlumno($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "DELETE FROM alumnos WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}


//FUNCIONES CRUD PROFESORES


// Función para crear un nuevo profesor
function createProfesor($nombre, $apellidos, $dni, $fecha_nac, $email, $telefono)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "INSERT INTO profesores (nombre, apellidos, dni, fecha_nac, email, telefono) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $apellidos, PDO::PARAM_STR);
	$stmt->bindParam(3, $dni, PDO::PARAM_STR);
	$stmt->bindParam(4, $fecha_nac, PDO::PARAM_STR);
	$stmt->bindParam(5, $email, PDO::PARAM_STR);
	$stmt->bindParam(6, $telefono, PDO::PARAM_STR);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para obtener un profesor por su ID
function getProfesor($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "SELECT * FROM profesores WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$profesor = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = null;
	$conexion = null;

	return $profesor;
}

// Función para actualizar un profesor
function updateProfesor($id, $nombre, $apellidos, $dni, $fecha_nac, $email, $telefono)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "UPDATE profesores SET nombre = ?, apellidos = ?, dni = ?, fecha_nac = ?, email = ?, telefono = ? WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $nombre, PDO::PARAM_STR);
	$stmt->bindParam(2, $apellidos, PDO::PARAM_STR);
	$stmt->bindParam(3, $dni, PDO::PARAM_STR);
	$stmt->bindParam(4, $fecha_nac, PDO::PARAM_STR);
	$stmt->bindParam(5, $email, PDO::PARAM_STR);
	$stmt->bindParam(6, $telefono, PDO::PARAM_STR);
	$stmt->bindParam(7, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}

// Función para eliminar un profesor por su ID
function deleteProfesor($id)
{
	$host = "localhost";
	$user = "dwes_tarde";
	$password = "dwes_2223";
	$bbdd = "fct_datos";
	$conexion = conectar_pdo($host, $user, $password, $bbdd);

	$sql = "DELETE FROM profesores WHERE id = ?";
	$stmt = $conexion->prepare($sql);

	$stmt->bindParam(1, $id, PDO::PARAM_INT);
	$stmt->execute();

	$stmt = null;
	$conexion = null;
}
