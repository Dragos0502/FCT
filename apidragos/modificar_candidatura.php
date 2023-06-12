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

// Obtener el ID de la candidatura a modificar
$idCandidatura = $_GET['id_candidatura'];

// Consultar la base de datos para obtener el estado actual de la candidatura
$host = "localhost";
$user = "dwes_tarde";
$password = "dwes_2223";
$bbdd = "fct_datos";

$conexion = conectar_pdo($host, $user, $password, $bbdd);

$sql = "SELECT aprobado FROM candidaturas WHERE id_candidatura = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$idCandidatura]);

// Obtener el estado actual de la candidatura
$estadoActual = $stmt->fetchColumn();

if ($estadoActual == "1") {
    $estadoActual = "aprobado";
}
if ($estadoActual == "0") {
    $estadoActual = "denegado";
}

// Verificar si se obtuvo el estado actual correctamente
if ($estadoActual === false) {
    // Manejar el error de obtener el estado actual de la candidatura
    die("Error al obtener el estado actual de la candidatura.");
}

// Cerrar la conexión a la base de datos
$conexion = null;

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

.form-group {
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


    <body>
    <div class="container">
       
        <form action="actualizar_candidatura.php" method="POST" class="form">
            <input type="hidden" name="id_candidatura" value="<?php echo $_GET['id_candidatura']; ?>">
            <div class="mb-3"><h3>Estado actual de candidatura: <?php echo $estadoActual; ?></h3></div>
            <div class="mb-3 form-group">
                <label for="aprobado" class="form-label"><h5>Modificar Estado:</h5></label>
                <div class="col-md-4">
                    <select name="aprobado" id="aprobado" class="form-select form-control">
                        <option value="1">Aprobado</option>
                        <option value="0">Denegado</option>
                    </select>
                </div>
            </div>
            <br><br>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {

            // Mostrar mensaje de éxito
            echo '<script>alert("Estado de candidatura actualizado con éxito.");</script>';
        }
        ?>
    </div>
</body>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>