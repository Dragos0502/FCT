<?php
require_once("funciones.php");
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    // Redireccionar al formulario de inicio de sesión si no ha iniciado sesión
    header('Location: login.php');
    exit;
}

// Procesar el cierre de sesión si se envió el formulario
if (isset($_POST['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_destroy();

    // Redireccionar al formulario de inicio de sesión
    header('Location: login.php');
    exit;
}


// Verificar si se ha enviado el ID de la candidatura a borrar
if (isset($_GET['id_candidatura'])) {
    $idCandidatura = $_GET['id_candidatura'];
    
    // Realizar la conexión a la base de datos
    $host = "localhost";
    $user = "dwes_tarde";
    $password = "dwes_2223";
    $bbdd = "fct_datos";
    $conexion = conectar_pdo($host, $user, $password, $bbdd);
    
    // Preparar la consulta SQL para borrar la candidatura
    $sql = "DELETE FROM candidaturas WHERE id_candidatura = :idCandidatura";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idCandidatura', $idCandidatura, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Verificar si se ha eliminado la candidatura correctamente
    if ($stmt->rowCount() > 0) {
        // Generar la respuesta en formato JSON
        $response = array(
            'success' => true,
            'message' => 'Candidatura borrada exitosamente.'
        );
    } else {
        // Generar la respuesta en formato JSON
        $response = array(
            'success' => false,
            'message' => 'No se pudo borrar la candidatura.'
        );
    }
    
    // Enviar la respuesta JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($response);
    
    // Cerrar la conexión y liberar recursos
    $stmt = null;
    $conexion = null;
}
?>


