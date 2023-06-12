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
  </script>

  <style>
    body {
      padding-top: 100px;
      
    }

    .container {

      display: flex;
      justify-content: center;
      align-items: center;

    }

    .welcome-message {
      text-align: center;
      max-width: 600px;
      margin-bottom: 20px;
      border-color: #ffa500;
      margin: 10px;
      padding: 25px;
      box-shadow: 0px 3px 3px 3px #007bff;
      font-size:x-large;
      color: #ffa500;
      text-shadow: 1px 1px 2px #ffa500;
    }

    .welcome-message h1 {
   
      margin-bottom: 20px;
    }

    .welcome-message p {
      
      margin-bottom: 10px;
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

  <div class="container">
    <div class="welcome-message">
      <h1>Bienvenido a la plataforma de gestión de alumnos</h1>
      <p>Esta plataforma está diseñada para gestionar los datos de los alumnos y las candidaturas a empresas.</p>
      <p>Permite llevar un seguimiento de los alumnos, su información personal, currículums, candidaturas y más.</p>
      <p>Además, facilita el proceso de búsqueda y selección de candidatos por parte de las empresas.</p>
      <p>¡Explora las diferentes funcionalidades y disfruta de una gestión eficiente y organizada!</p>
    </div>
  </div>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>