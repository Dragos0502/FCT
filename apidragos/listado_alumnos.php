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

    // Llamar a la función para mostrar la lista de alumnos al cargar la página
    window.onload = mostrarAlumnos();

    // JavaScript
  </script>

  <style>
    body {

      background-color: #f8f9fa;
      padding-top: 60px;
    }

      h1{
        text-shadow: 1px 1px grey;
        font-size: 50px;
      }
    .row {
      margin: auto;
      margin-top: 8%;
      padding: auto;

    }
    .btn{
            font-size: large;
        }

    .dropdown-menu-width {
      width: 100%;
      text-align: center;
    }

    .dropdown-btn-width {
      width: 100%;
    }

    .btn-orange {
      background-color: #ffa500;
      border-color: #ffa500;
      color: #fff;
    }

    #buscadorAlumnos{
      border-width:1px;
      border-color: #ffa500;
      box-shadow: 0px 5px 5px #007bff;
    }

    #dropdownMenuButton{
      border-width:1px;
      border-color:  #656172;
      box-shadow: 0px 5px 5px #007bff;

    }
  </style>
</head>

<body>
  <header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">FCT</a>
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

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center mb-4">Buscador Alumno</h1>
        <div class="d-flex align-items-center mb-4">
          <input type="text" id="buscadorAlumnos" class="form-control" placeholder="Buscar por nombre o apellido">
         
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center mb-4">Lista de Alumnos</h1>
        <div class="dropdown">
          <button class="btn btn-orange dropdown-toggle dropdown-btn-width " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Mostra alumnos
          </button>
          <ul class="dropdown-menu dropdown-menu-width" aria-labelledby="dropdownMenuButton" id="dropdownMenu">
            <!-- La lista de alumnos se generará aquí -->
          </ul>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>