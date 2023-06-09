<?php
    // Inclusión de funciones
    require_once("funciones.php");
?>

<?php
    $idAlumno = $_GET['id_alumno'];

    // Construir la consulta SQL con el filtro por ID de alumno
    $consulta_candidaturas = "SELECT * FROM candidaturas WHERE id_alumno = $idAlumno";

    $conexion = conectar_pdo($host, $user, $password, $bbdd);
    $resultado_candidaturas = resultado_consulta($conexion, $consulta_candidaturas);
    $data_candidaturas = array();

    while ($row = $resultado_candidaturas->fetch(PDO::FETCH_ASSOC)):
        array_push($data_candidaturas,$row);
    endwhile;
    
    header("Content-Type: application/json");
    echo json_encode($data_candidaturas);
?>