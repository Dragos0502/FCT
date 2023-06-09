<?php
// Inclusión de funciones
require_once("funciones.php");
?>
 

    <?php
    
    $conexion = conectar_pdo($host, $user, $password, $bbdd);
    $consulta_admins = "SELECT * FROM administradores ";
    $resultado_admins = resultado_consulta($conexion, $consulta_admins);
    $data_admins = array();

    while ($row = $resultado_admins->fetch(PDO::FETCH_ASSOC)) :
        array_push($data_admins, $row);
    endwhile;

    header("Content-Type: application/json");
    echo json_encode($data_admins);
    

    ?>