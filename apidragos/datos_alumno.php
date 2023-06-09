<?php
// Inclusión de funciones
require_once("funciones.php");
?>
 
<?php
$conexion = conectar_pdo($host, $user, $password, $bbdd);
$consulta_alumnos = "SELECT * FROM alumnos ";
$resultado_alumnos = resultado_consulta($conexion, $consulta_alumnos);
$data_alumnos = array();

while ($row = $resultado_alumnos->fetch(PDO::FETCH_ASSOC)) :
    array_push($data_alumnos, $row);
endwhile;

header("Content-Type: application/json");
echo json_encode($data_alumnos);
?>