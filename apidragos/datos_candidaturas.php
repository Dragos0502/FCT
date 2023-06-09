<?php
    // Inclusión de funciones
    require_once("funciones.php");
?>


    <?php
        $conexion = conectar_pdo($host, $user, $password, $bbdd);
        $consulta_candidaturas = "SELECT * FROM candidaturas";
        $resultado_candidaturas = resultado_consulta($conexion, $consulta_candidaturas);
        $data_candidaturas = array();

        while ($row = $resultado_candidaturas->fetch(PDO::FETCH_ASSOC)):
            array_push($data_candidaturas,$row);
        endwhile;
        header("Content-Type: application/json");
        echo json_encode($data_candidaturas);



    ?>