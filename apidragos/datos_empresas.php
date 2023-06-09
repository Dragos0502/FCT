<?php
    // Inclusión de funciones
    require_once("funciones.php");
?>


    <?php
        $conexion = conectar_pdo($host, $user, $password, $bbdd);
        $consulta_empresas = "SELECT * FROM empresas ";
        $resultado_empresas = resultado_consulta($conexion, $consulta_empresas);
        $data_empresas = array();
        while ($row = $resultado_empresas->fetch(PDO::FETCH_ASSOC)):
            array_push($data_empresas,$row);
        endwhile;

        header("Content-Type: application/json");
        echo json_encode($data_empresas);
      
    ?>