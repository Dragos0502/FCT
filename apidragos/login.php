<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="source.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>INICIO</title>

    <style>
        
        body {
            
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
        }
    
        .form-container {
            zoom: 1.5;
          max-width: 400px;
          margin: auto;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
          background-color: #f9f9f9;
          
        }
    
        .form-container h2 {
          text-align: center;
          margin-bottom: 20px;
        }

        .btn-primary{
            margin-top: 10px;

        }
      </style>
</head>

<body>
    <header>


    </header>
    

    <div class="container">
        <div class="form-container">
          <h2>Iniciar sesión FCT</h2>
          
          <form action="procesar_login.php" method="post">
            <div class="form-group">
              <label for="email">Correo electrónico:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
    
            <div class="form-group">
              <label for="password">Contraseña:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
    
            <div  class="form-group text-center">
              <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            </div>
          </form>
        </div>
      </div>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>