
<?php
session_start();

if (isset($_FILES['curriculum'])) {
  $file = $_FILES['curriculum'];
  
  // Verificar si no hay errores en la subida del archivo
  if ($file['error'] === UPLOAD_ERR_OK) {
    $tempFilePath = $file['tmp_name'];
    $destinationPath = 'C:/xampp/htdocs/apidragos/cv_alumnos/'; // Reemplaza con la ruta deseada
    $nombre = $_SESSION['nombre']; // Obtener el nombre de la sesión
    $apellidos = $_SESSION['apellidos']; // Obtener los apellidos de la sesión
    $newFileName = $nombre . '_' . $apellidos . '.pdf'; // Nombre personalizado utilizando nombre y apellidos y extensión .pdf


    // Genera la nueva ruta y nombre de archivo
    $uploadedFilePath = $destinationPath . $newFileName;

    // Mueve el archivo temporal a la ubicación deseada con el nuevo nombre
    move_uploaded_file($tempFilePath, $uploadedFilePath);

    // Realiza cualquier otro procesamiento adicional, como guardar el nombre del archivo en la base de datos, etc.
  } else {
    // Hubo un error en la subida del archivo
    echo 'Error al subir el currículum';
  }
}
?>
