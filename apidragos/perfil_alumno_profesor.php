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
// Obtener el ID del alumno desde el parámetro "id" en la URL
$idAlumno = $_GET['id'];

// Parámetros de conexión a la base de datos (ajusta los valores según tu configuración)
$host = "localhost";
$user = "dwes_tarde";
$password = "dwes_2223";
$bbdd = "fct_datos";

// Establecer la conexión a la base de datos
$conexion = conectar_pdo($host, $user, $password, $bbdd);

// Realizar la consulta para obtener los datos del alumno
$consulta = "SELECT * FROM alumnos WHERE id = $idAlumno";
$resultado = $conexion->query($consulta);
$alumno = $resultado->fetch(PDO::FETCH_ASSOC);

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
    <script>
        let rolUsuario = '<?php echo $_SESSION['user_rol']; ?>';

        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento del enlace "Mi perfil" por su ID
            let perfilNavItem = document.getElementById('perfilNavItem');

            // Ocultar el enlace si el rol del usuario es "profesor"
            if (rolUsuario === '2') {
                perfilNavItem.style.display = 'none';
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento del enlace "Mi perfil" por su ID
            let perfilNavItem = document.getElementById('buscadorNavItem');

            // Ocultar el enlace si el rol del usuario es "profesor"
            if (rolUsuario === '1') {
                perfilNavItem.style.display = 'none';
            }
        });
        let urlParams = new URLSearchParams(window.location.search);
        let alumnoId = urlParams.get('id');

        let idAlumno = parseInt(alumnoId);
        mostrarCandidaturas(idAlumno);
        mostrarDatosAlumno(alumnoId);
    </script>

    <style>
        body {
            padding-top: 60px;
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

        .btn {
            font-size: large;
        }

        .btn-primary {
            background-color: #ffa500;
            border-color: #ffa500;
            color: #fff;
            border-width: 1px;
            border-color: #656172;
            box-shadow: 0px 5px 5px #007bff;


        }

        .btn-danger {
            border-width: 1px;
            border-color: #656172;
            box-shadow: 0px 5px 5px #007bff;
        }
        

        #btn_candi {
            text-align: center;
            position: absolute;
            right: 0;
            margin-top: 5%;
            margin-bottom: 20%;
            margin-left: 10%;
            margin-right: 10%;
            width: 30%;
            background-color: #ffa500;
            border-color: #ffa500;
            color: #fff;
            border-width: 1px;
            border-color: #656172;
            box-shadow: 0px 5px 5px #007bff;


        }

        #enlaceDescarga {
            text-align: center;
            position: absolute;
            right: 0;
            margin-top: 20%;
            margin-bottom: 30%;
            margin-left: 10%;
            margin-right: 10%;
            width: 30%;
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

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">FCT Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="inicio.php">Principal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="listado_alumnos.php" id="buscadorNavItem">Buscador</a>
                            </li>
                            <li class="nav-item" id="perfilNavItem">
                                <a class="nav-link" href="perfilalumno.php">Mi perfil</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ml-auto">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>


    <div class="container">
        <div class="card" id="card-principal">
            <div class="card-body">
                <h5 class="card-title">Información personal del alumno</h5>
                <a class="btn btn-primary" id="btn_candi" href="nueva_candidatura.php?id_alumno=<?php echo $idAlumno; ?>">Crear Nueva Candidatura</a>
                <?php
                // Construir la ruta del currículum
                $rutaCurriculum = "cv_alumnos/" . $alumno['nombre'] . "_" . $alumno['apellidos'] . ".pdf";

                // Verificar si el archivo del currículum existe en la ruta
if (file_exists($rutaCurriculum)) {
    // Mostrar el enlace de descarga solo si el archivo existe
    echo '<div >';
    echo '<a  id="enlaceDescarga" href="' . $rutaCurriculum . '" download class="btn btn-primary">Descargar currículum</a>';
    echo '</div>';
} else {
    // Mostrar un mensaje de aviso si el archivo no existe
    echo '<div id="enlaceDescarga">';
    echo 'Este alumno no tiene ningún currículum disponible.';
    echo '</div>';
}


                ?>

                <div id="datosAlumno"></div>
            </div>
        </div>

        <div class="card" id="card-principal">
            <div class="card-body">
                <h5 class="card-title">Candidaturas</h5>
                <div id="candidaturasAlumno" class="row row-cols-2"></div>
            </div>
        </div>










        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>