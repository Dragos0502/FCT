<?php
// Inclusión de funciones
require_once("funciones.php");
?>


<?php
session_start();

// Establecer la conexión a la base de datos (utilizando la función conectar_pdo)
$host = "localhost";
$user = "dwes_tarde";
$password = "dwes_2223";
$bbdd = "fct_datos";
$conexion = conectar_pdo($host, $user, $password, $bbdd);

// Obtener los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consultar la base de datos para verificar los datos del usuario como alumno
$sql = "SELECT * FROM alumnos WHERE email = :email";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$alumno = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultar la base de datos para verificar los datos del usuario como profesor
$sql = "SELECT * FROM profesores WHERE email = :email";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$profesor = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultar la base de datos para verificar los datos del usuario como administrador
$sql = "SELECT * FROM administradores WHERE email = :email";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró un alumno con el correo electrónico proporcionado
if ($alumno) {
    // Verificar la contraseña del alumno
    if ($password == $alumno['password']) {
        // Las credenciales son correctas para un alumno, iniciar sesión como alumno
        $_SESSION['user_id'] = $alumno['id'];
        $_SESSION['user_email'] = $alumno['email'];
        $_SESSION['user_rol'] = $alumno['rol'];
        $_SESSION['nombre'] = $alumno['nombre'];
        $_SESSION['apellidos'] = $alumno['apellidos'];
        $_SESSION['loggedin'] = true;

        // Redireccionar a la página de inicio o panel de control del alumno
        header('Location: inicio.php');
        exit;
    } else {
        // Contraseña incorrecta para el alumno
        echo "Contraseña incorrecta.";
    }
} elseif ($profesor) {
    // Verificar la contraseña del profesor
    if ($password == $profesor['password']) {
        // Las credenciales son correctas para un profesor, iniciar sesión como profesor
        $_SESSION['user_id'] = $profesor['id'];
        $_SESSION['user_email'] = $profesor['email'];
        $_SESSION['user_rol'] = $profesor['rol'];
        $_SESSION['loggedin'] = true;

        // Redireccionar a la página de inicio o panel de control del profesor
        header('Location: inicio.php');
        exit;
    } else {
        // Contraseña incorrecta para el profesor
        echo "Contraseña incorrecta.";
    }
} elseif ($admin) {
    // Verificar la contraseña del administrador
    if ($password == $admin['password']) {
        // Las credenciales son correctas para un administrador, iniciar sesión como administrador
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['user_email'] = $admin['email'];
        $_SESSION['user_rol'] = $admin['rol'];

        $_SESSION['loggedin'] = true;

        // Redireccionar a la página de inicio o panel de control del administrador
        header('Location: inicio.php');
        exit;
    } else {
        // Contraseña incorrecta para el administrador
        echo "Contraseña incorrecta.";
    }
} else {
    // No se encontró un usuario con el correo electrónico proporcionado
    echo "Usuario no encontrado.";
}
?>
