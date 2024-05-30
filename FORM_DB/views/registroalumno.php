<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.: Registro :.</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../funciones.js"></script>
</head>
<body>
<a href="../alumno.php" class = "regresar"><img class = "volver" src="../icons/flecha-hacia-atras.png" ></a>
<form action="" method="post">
    <h1>Agregar Nuevo</h1>
    <fieldset class="marco">
        <label for="id">ID</label>
        <input type="text" name="id" id="id" class="form-control" required>

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>

        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" class="form-control" required>

        <label for="career">Career</label>
        <input type="text" name="career" id="career" class="form-control" required>

        <div class="row">
            <div class="col">
                <label for="enable">¿Está habilitado?</label>
                <input type="checkbox" name="enable" id="enable">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="../alumno.php" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </fieldset>
</form>

    <?php
if(isset($_POST["id"]) && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["career"])) {    
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $career = $_POST["career"];
    $enable = true;

    include '../db/db.php';

    $sql = "INSERT INTO Alumno(id, name, lastname, career, enable) VALUES ($id, '$nombre', '$apellido', '$career', $enable)";

    $execute = mysqli_query($db, $sql);
    if($execute){
        echo "<script>show('New record created successfully', 'success')</script>";
        echo "
            <script>
                setTimeout(() =>{
                        redirectToPage();
                }, '3500');
                </script>
                ";
    } else {
        $error = mysqli_error($db);
        echo "<script>show('Error: $error', 'error')</script>";
    }

    $db->close();
}
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');




h1{
    font-family: 'Poppins', sans-serif; 
}
img {
    width: 50px;
    height: auto;
}

img.volver {
    position: absolute;
    top: 10px; /* Distancia desde la parte superior */
    left: 10px; /* Distancia desde la izquierda */
}

 body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Altura del viewport */
    margin: 0;
    background-image: url('../icons/fondo.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
    
}

.marco {
    border: 2px solid black; /* Borde del marco */
    padding: 20px;
    box-sizing: border-box;
    max-width: 1000px; /* Ancho máximo del marco */
    margin: auto; /* Centra horizontalmente */
}

fieldset {
    border: 1px solid black; /* Borde del fieldset */
    padding: 15px;
    box-sizing: border-box;
    width: 700px; /* Ancho del fieldset */
    max-width: 600px; /* Ancho máximo del fieldset */
    margin: 0 auto; /* Centra horizontalmente */
    border-radius: 10px; /* Radio de borde */
    background-color: #f0f0f0; /* Color de fondo para mejor visualización */
    
}

.form-control {
    width: calc(100% - 30px); /* Ajusta el ancho de los inputs al 100% del fieldset */
    margin-bottom: 20px; /* Espacio entre inputs */
}

.btn-container {
    text-align: center;
    margin-top: 20px; /* Espacio superior para los botones */
}

</style>
</body>
</html>