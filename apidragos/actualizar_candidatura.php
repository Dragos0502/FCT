<?php
// Inclusión de funciones
require_once("funciones.php");
?>
<?php
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="source.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>INICION</title>
    <style>
        body {
            padding-top: 60px;
        }


        .btn-primary {
            background-color: #ffa500;
            border-color: #ffa500;
            color: #fff;
            border-width: 1px;
            border-color: #656172;
            box-shadow: 0px 5px 5px #007bff;
        }

        .card {
            margin-bottom: 20px;
            border-color: #ffa500;
            margin: 10px;
            padding: 25px;
            box-shadow: 0px 5px 5px #007bff;
            color: #656172;
            font-size: large;
        }

        h5 {
            color: black;
            font-weight: bolder;
            font-size: 25px;
            font-family: Arial;

        }
    </style>

</head>

<body>
    <header>
    </header>

    <div class="container">

        <?php
        // Verificar si se han enviado los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos del formulario
            $idCandidatura = $_POST['id_candidatura'];
            $aprobado = $_POST['aprobado'];

            // Realizar la conexión a la base de datos
            $host = "localhost";
            $user = "dwes_tarde";
            $password = "dwes_2223";
            $bbdd = "fct_datos";
            $conexion = conectar_pdo($host, $user, $password, $bbdd);

            // Preparar la consulta SQL para actualizar la candidatura
            $sql = "UPDATE candidaturas SET aprobado = :aprobado WHERE id_candidatura = :idCandidatura";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':aprobado', $aprobado, PDO::PARAM_INT);
            $stmt->bindParam(':idCandidatura', $idCandidatura, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se ha actualizado la candidatura correctamente
            if ($stmt->rowCount() > 0) {
                echo '<div class="alert alert-success">La candidatura se ha actualizado correctamente.</div>';
                echo '<button class="btn btn-primary" onclick="goBack()">Volver a las candidaturas</button>';

                echo '<script>
            function goBack() {
                window.history.go(-2);
            }
        </script>';
            } else {
                echo '<div class="alert alert-danger">No se pudo actualizar la candidatura.</div>';
                echo '<button class="btn btn-primary" onclick="goBack()">Volver a las candidaturas</button>';

                echo '<script>
            function goBack() {
                window.history.go(-2);
            }
        </script>';
            }

            // Cerrar la conexión y liberar recursos
            $stmt = null;
            $conexion = null;

            exit();
        }
        ?>


    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>