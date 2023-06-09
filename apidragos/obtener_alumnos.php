<?php
// Inclusión de funciones
require_once("funciones.php");
?>
<?php
// Parámetros de conexión a la base de datos (ajusta los valores según tu configuración)
$host = "localhost";
$user = "dwes_tarde";
$password = "dwes_2223";
$bbdd = "fct_datos";

// Establecer la conexión a la base de datos
$conexion = conectar_pdo($host, $user, $password, $bbdd);

// Realizar la consulta para obtener la lista de alumnos
$consulta = "SELECT nombre, apellidos, id FROM alumnos";
$resultado = $conexion->query($consulta);

// Crear un array para almacenar los resultados de la consulta
$alumnos = array();

if ($resultado->rowCount() > 0) {
    // Recorrer los resultados de la consulta y agregarlos al array de alumnos
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $alumnos[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conexion = null;

// Devolver los resultados de la consulta como una respuesta en formato JSON
header("Content-Type: application/json");
echo json_encode($alumnos);
?>
