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
$idAlumno =  $_GET['id_alumno'];
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

        .container {

            display: flex;
            justify-content: center;
            align-items: center;

        }

        .form-group{
            margin-top: 10px;
        }
        .form {
            margin-top: 15%;
            border-width: 1px;
            border-color: #ffa500;
            box-shadow: 0px 3px 3px 3px #007bff;
            max-width: 1000px;
            width: 100%;
            padding: 30px;
            background-color: #f8f9fa;

        }

        .form-control {
            border-width: 1px;
            border-color: #ffa500;
            box-shadow: 0px 5px 5px #007bff;
        }


        .btn {
            font-size: large;
        }

        .btn-primary {
            margin-top: 15px;
            background-color: #ffa500;
            border-color: #ffa500;
            color: #fff;
            border-width: 1px;
            border-color: #656172;
            box-shadow: 0px 5px 5px #007bff;


        }
    </style>

</head>

<body>
    <header>
   
    </header>

    <div class="container ">
        <!-- Formulario para crear una nueva candidatura -->
        <form action="nueva_candidatura.php" method="POST" class="form">
            <input type="hidden" name="id_alumno" value="<?php echo $idAlumno; ?>">
            <div class="form-group">
                <label for="id_empresa" class="form-label">
                    <h3>Empresa:</h3>
                </label>
                <select name="id_empresa" id="id_empresa" class="form-control" required>
                    <?php
                    // Realizar la conexión a la base de datos
                    $host = "localhost";
                    $user = "dwes_tarde";
                    $password = "dwes_2223";
                    $bbdd = "fct_datos";
                    $conexion = conectar_pdo($host, $user, $password, $bbdd);

                    // Obtener las empresas desde la base de datos
                    $query = "SELECT id, nombre FROM empresas";
                    $stmt = $conexion->prepare($query);
                    $stmt->execute();
                    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Generar la lista de opciones con ID de empresa y nombre de empresa
                    foreach ($empresas as $empresa) {
                        $idEmpresa = $empresa['id'];
                        $nombreEmpresa = $empresa['nombre'];
                        echo "<option value=\"$idEmpresa\">$nombreEmpresa</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="aprobado" class="form-label">
                    <h3>Estado:</h3>
                </label>
                <select name="aprobado" id="aprobado" class="form-control" required>
                    <option value="1">Aprobado</option>
                    <option value="0">Denegado (valor por defecto)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Crear Candidatura</button>

        </form>

    </div>

    <?php
    // Verificar si se han enviado los datos del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $idAlumno = intval($_POST['id_alumno']);
        $idEmpresa = intval($_POST['id_empresa']);
        $aprobado = intval($_POST['aprobado']);
        if ($idEmpresa != 1) {
            $idEmpresa = $idEmpresa - 1;
        }
    
        // Realizar la conexión a la base de datos
        $host = "localhost";
        $user = "dwes_tarde";
        $password = "dwes_2223";
        $bbdd = "fct_datos";
        $conexion = conectar_pdo($host, $user, $password, $bbdd);
        try {
            // Verificar si ya existe una candidatura para la misma empresa y alumno
            $query = "SELECT COUNT(*) FROM candidaturas WHERE id_alumno = :idAlumno AND id_empresa = :idEmpresa";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':idAlumno', $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
            $stmt->execute();
            $numCandidaturas = $stmt->fetchColumn();
    
            if ($numCandidaturas > 0) {
                // Ya existe una candidatura para la misma empresa
                 echo '<script>alert("Ya existe una candidatura para la misma empresa.");</script>';
            } else {
                // No existe una candidatura para la misma empresa, proceder a crearla
    
                // Preparar la consulta SQL para insertar la nueva candidatura
                $query = "INSERT INTO candidaturas (id_alumno, id_empresa, aprobado) VALUES (:idAlumno, :idEmpresa, :aprobado)";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idAlumno', $idAlumno, PDO::PARAM_INT);
                $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
                $stmt->bindParam(':aprobado', $aprobado, PDO::PARAM_INT);
    
                // Ejecutar la consulta
                $stmt->execute();
    
                // Verificar si la candidatura se creó correctamente
                if ($stmt->rowCount() > 0) {
                    echo "La candidatura se ha creado exitosamente.";
                } else {
                    echo "No se pudo crear la candidatura.";
                }
            }
        } catch (PDOException $e) {
            echo "Error al crear la candidatura: " . $e->getMessage();
        }
    
        // Cerrar la conexión y liberar recursos
        $stmt = null;
        $conexion = null;
    
        header("Location:perfil_alumno_profesor.php?id=". $idAlumno);
        exit();
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>