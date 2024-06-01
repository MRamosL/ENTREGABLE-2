<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 <!-- Modal Agregar    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   --> <title>.:Clientes:.</title>
    <style>
        img {
            width: 16px;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <img src="icons/bootstrap-logo.svg" alt="" width="30" height="24">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                    </li><br>
                    <li class="nav-item">
                        <a class="nav-link" href="Empleados.php">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Areas.php">Áreas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Proyectos.php">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Cliente.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Dueños.php">Dueño</a>
                    </li>
                </ul>
                
            </div>
        </div>
    </nav>

    <h1>Lista Clientes</h1>
    <?php
    // Datos de la conexión
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Empresa";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    ?>

    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#insertarModal">Agregar Clientes</button>
    </div><br>
    <table border="1" style="width: 100%;">
        <tr>
            <td>Id</td>
            <td>Nombre</td>
            <td>Contacto</td>
            <td>Ubicación</td>
            <td colspan="2">Acción</td>
        </tr>
        <?php
        // Consulta SQL para obtener los datos de la tabla Empleados
        $sql = "SELECT id, nombre, contacto, ubicacion FROM Clientes";
        $result = $conn->query($sql);

        // Generar las filas de la tabla en HTML
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['contacto']}</td>
                    <td>{$row['ubicacion']}</td>
                    <td>
                        <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editarRegistroModal'><img src='icons/pencil-solid.svg'></button>
                    </td>
                    <td>
                        <button type='button' class='btn btn-danger'  onclick='openModalProfesor({$row['id']})' data-bs-toggle='modal' data-bs-target='#modalEmpresa'><img src='icons/trash-solid.svg'></button>
                    </td>
                </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='8'>No se encontraron resultados</td></tr>";
        }
        ?>  
    </table>
</body>

<?php
include 'db/db.php'; // Incluye el archivo de conexión a la base de datos

// Define las variables para los mensajes de éxito y error
$insertar_error_message = ""; // Inicializa las variables
$insertar_success_message = "";

// Verifica si el formulario de inserción ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insertar'])) {
    // Obtén los datos del formulario de inserción
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $ubicacion = $_POST['ubicacion'];

    // Inserta en la base de datos
    $sql = "INSERT INTO Clientes (id, nombre, contacto, ubicacion) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssds", $id, $nombre, $contacto, $ubicacion);

    if ($stmt->execute()) {
        // Registro exitoso, asigna mensaje de éxito
        $insertar_success_message = "Datos insertados correctamente";
    } else {
        // Error en el registro, asigna mensaje de error
        $insertar_error_message = "Error al insertar datos: " . $stmt->error;
    }

    // Cierra la conexión
    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!-- Modal de Inserción -->
<div id="insertarModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <hr>
        <h2>Insertar Datos</h2>
        <hr> 
        <form id="insertarForm" action="" method="POST">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" name="id" id="id" class="form-control" placeholder="ID" required>              
            </div><br>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>              
            </div><br>
            <div class="form-group">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" class="form-control" placeholder="contacto" required>              
            </div><br>
            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" placeholder="ubicacion" required>              
            </div><br>
            <?php if (isset($_POST['insertar'])): ?>
                <?php if ($insertar_error_message): ?>
                    <p id="error-message" class="error-message"><?php echo $insertar_error_message; ?></p>
                <?php endif; ?>
                <?php if ($insertar_success_message): ?>
                    <p id="insertar-success-message" class="success-message"><?php echo $insertar_success_message; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <button type="submit" name="insertar" class="btn btn-primary btn-block">Insertar</button>
        </form>
    </div>
</div>





    
  

    <?php
    include 'db/db.php';

    // Verificar si se está enviando una solicitud POST para eliminarx
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id_clientes'])) {
        $id = $_POST['delete_id_clientes'];
        $sql = "DELETE FROM Clientes WHERE id = $id";
        if (mysqli_query($db, $sql)) {
            echo "<script>alert('Cliente eliminado exitosamente.'); window.location.href='';</script>";
        } else {
            $error = mysqli_error($db);
            echo "<script>alert('Error al eliminar el Cliente: $error');</script>";
        }
    }

    // Obtener todos los Empleados
    $sql = "SELECT * FROM Clientes";
    $result = mysqli_query($db, $sql);
?>
<!-- Modal para Eliminar Empleados -->
<div class="modal fade" id="modalEmpresa" tabindex="-1" aria-labelledby="modalEmpresaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProfesorLabel">Estas seguro que deseas eliminar los datos del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="delete_id_profesor" id="delete_id_profesor">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModalProfesor(id) {
        $('#delete_id_profesor').val(id); // Guarda el ID en el formulario de eliminación de profesor
    }
</script>


  <!--Editar-->
  <div class="modal fade" id="editarRegistroModal" tabindex="-1" role="dialog" aria-labelledby="editarDatosModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarDatosModalLabel">Editar registros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <!--<span aria-hidden="true">&times;</span>-->
                    </button>
                </div>
                <form action="index.php?page=insertar" method="POST" name="registroForm" id="registroForm" class="text-left">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" id="id" name="id" class="form-control" aria-describedby="idHelp">
                            <small id="idHelp" class="form-text text-muted">Ingrese el id del cliente.</small>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" aria-describedby="nombreHelp">
                            <small id="nombreHelp" class="form-text text-muted">Ingrese el nombre del cliente.</small>
                        </div>
                        <div class="form-group">
                            <label for="contacto">Contacto</label>
                            <input type="text" id="contacto" name="contacto" class="form-control" aria-describedby="contactoHelp">
                            <small id="contactoHelp" class="form-text text-muted">Ingrese el contacto del cliente.</small>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Edad</label>
                            <input type="text" id="ubicacion" name="ubicacion" class="form-control" aria-describedby="ubicacionHelp">
                            <small id="ubicacionHelp" class="form-text text-muted">Ingrese la ubicación del cliente.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnEditar" name="btnEditar" class="btn btn-primary">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formularioInsertar").addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "insertar.php", true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // Éxito: Mostrar mensaje de éxito
                alert("Cliente insertado exitosamente.");
            } else {
                // Error: Mostrar mensaje de error
                alert("Error al insertar el Cliente.");
            }
        };
        xhr.onerror = function() {
            // Error de conexión
            alert("Error de conexión. Inténtalo de nuevo.");
        };
        xhr.send(formData);
    });
});</script>

</body>
</html>