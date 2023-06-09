<?php
// Inclusión de funciones
require_once("funciones.php");
?>


    <?php
    $conexion = conectar_pdo($host, $user, $password, $bbdd);
    $consulta_profesores = "SELECT * FROM profesores ";
    $resultado_profesores = resultado_consulta($conexion, $consulta_profesores);
    $data_profesores = array();

    while ($row = $resultado_profesores->fetch(PDO::FETCH_ASSOC)) :
        array_push($data_profesores, $row);
    endwhile;

    header("Content-Type: application/json");
    echo json_encode($data_profesores);


    ?>