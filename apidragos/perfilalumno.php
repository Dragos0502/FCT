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
    // Obtener el valor del ID de usuario desde PHP y asignarlo a una variable JS
    let userId = <?php echo $_SESSION['user_id']; ?>;
    let rolUsuario = '<?php echo $_SESSION['user_rol']; ?>';
    // Llamar a la función mostrarDatosAlumno con el ID de usuario
    if (rolUsuario === "1") {
      window.addEventListener("load", function(event) {

        mostrarDatosAlumno(userId);
        mostrarCandidaturasAlumno(userId);

      });
    }

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

    document.addEventListener('DOMContentLoaded', () => {
      const uploadForm = document.getElementById('uploadForm');

      uploadForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada

        const fileInput = document.getElementById('curriculumFile');
        const file = fileInput.files[0]; // Obtiene el archivo seleccionado

        const formData = new FormData(); // Crea un objeto FormData
        formData.append('curriculum', file); // Agrega el archivo al objeto FormData

        try {
          const response = await fetch('http://apidragos.com/subir_cv.php', {
            method: 'POST',
            body: formData
          });

          if (response.ok) {
            // El archivo se subió correctamente
            console.log('Currículum subido exitosamente');
            alert('Currículum subido exitosamente');
          } else {
            // Hubo un error al subir el archivo
            console.error('Error al subir el currículum');
            alert('Error al subir el currículum');
          }
        } catch (error) {
          console.error('Error al enviar la solicitud:', error);
          alert('Error al enviar la solicitud:', error);
        }
      });
    });
  </script>
</head>


<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
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
                <a class="nav-link" href="buscador_alumno.php" id="buscadorNavItem">Buscador</a>
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




  <div id="datosAlumno"></div>

  <div id="candidaturasAlumno"></div>

  <div id="subirCv">
    <form id="uploadForm" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="curriculumFile" class="form-label">Seleccionar Currículum</label>
        <input class="form-control w-50"  type="file" name="curriculum" id="curriculumFile" required>
      </div>
      <button class="btn btn-primary" type="submit" onclick="">Subir Currículum</button>
    </form>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>