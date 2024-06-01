<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 <!-- Modal Agregar    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   --> <title>.:Empleados:.</title>
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

    <h1>Lista Empleados</h1>
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
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#insertarModal">Agregar Empleado</button>
    </div><br>
    <table border="1" style="width: 100%;">
        <tr>
            <td>Id</td>
            <td>Nombre</td>
            <td>Apellido</td>
            <td>Edad</td>
            <td>Salario (Soles)</td>
            <td>Área</td>
            <td colspan="2">Acción</td>
        </tr>
        <?php
        // Consulta SQL para obtener los datos de la tabla Empleados
        $sql = "SELECT id, nombre, apellido, edad, salario_soles, area FROM Empleados";
        $result = $conn->query($sql);

        // Generar las filas de la tabla en HTML
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$row['edad']}</td>
                    <td>{$row['salario_soles']}</td>
                    <td>{$row['area']}</td>
                    <td>
                        <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editarRegistroModal'><img src='icons/pencil-solid.svg'></button>
                    </td>
                    <td>
                    <button type='button' class='btn btn-info' onclick='openModalProfesor({$row['id']})' data-bs-toggle='modal' data-bs-target='#modalProfesor'>
                    <img src='icons/trash-solid.svg'>
                </button>
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
  <!-- Insertar datos -->
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
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $salario = $_POST['salario']; // Mantén el nombre del campo consistente
    $area = $_POST['area'];

    // Inserta en la base de datos
    $sql = "INSERT INTO Empleados (id, nombre, apellido, edad, salario_soles, area) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("issids", $id, $nombre, $apellido, $edad, $salario, $area);

        if ($stmt->execute()) {
            // Registro exitoso, asigna mensaje de éxito
            $insertar_success_message = "Datos insertados correctamente";
        } else {
            // Error en el registro, asigna mensaje de error
            $insertar_error_message = "Error al insertar datos: " . $stmt->error;
        }

        // Cierra la conexión
        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        $insertar_error_message = "Error al preparar la consulta: " . $conn->error;
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>

   <!-- Modal de Inserción -->
   <div class="modal fade" id="insertarModal" tabindex="-1" aria-labelledby="insertarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertarModalLabel">Insertar nuevos registros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="insertarForm" action="" method="POST">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" name="id" id="id" class="form-control" placeholder="ID" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control" placeholder="Edad" required>
                        </div>
                        <div class="mb-3">
                            <label for="salario" class="form-label">Salario</label>
                            <input type="number" step="0.01" name="salario" id="salario" class="form-control" placeholder="Salario" required>
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">Área</label>
                            <input type="text" name="area" id="area" class="form-control" placeholder="Área" required>
                        </div>
                        
                        <button type="submit" name="insertar" class="btn btn-primary w-100">Insertar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <!-- Insertar datos fin  -->


    
  <?php
    include 'db/db.php';

    // Verificar si se está enviando una solicitud POST para eliminar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id_profesor'])) {
        $id = $_POST['delete_id_profesor'];
        $sql = "DELETE FROM Empleados WHERE id = $id";
        if (mysqli_query($db, $sql)) {
            echo "<script>alert('Profesor eliminado exitosamente.'); window.location.href='';</script>";
        } else {
            $error = mysqli_error($db);
            echo "<script>alert('Error al eliminar el profesor: $error');</script>";
        }
    }

    // Obtener todos los profesores
    $sql = "SELECT * FROM Empleados";
    $result = mysqli_query($db, $sql);
?> 

<!-- Modal para Profesores -->
<div class="modal fade" id="modalProfesor" tabindex="-1" aria-labelledby="modalProfesorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProfesorLabel">Estas seguro que deseas eliminar los datos del profesor</h5>
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


<!-- Botón de Edición -->


<!-- Modal de Edición -->
<div class="modal fade" id="editarRegistroModal" tabindex="-1" role="dialog" aria-labelledby="editarDatosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarDatosModalLabel">Editar datos del empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" name="editarEmpleadoForm" id="editarEmpleadoForm" class="text-left">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre</label>
                        <input type="text" id="edit_nombre" name="edit_nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_apellido">Apellido</label>
                        <input type="text" id="edit_apellido" name="edit_apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_edad">Edad</label>
                        <input type="number" id="edit_edad" name="edit_edad" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_salario">Salario</label>
                        <input type="number" step="0.01" id="edit_salario" name="edit_salario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_area">Área</label>
                        <input type="text" id="edit_area" name="edit_area" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btnEditar" name="btnEditar" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para Abrir el Modal y Establecer el ID -->
<script>
    function openEditarModal(id, nombre, apellido, edad, salario, area) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_apellido').value = apellido;
        document.getElementById('edit_edad').value = edad;
        document.getElementById('edit_salario').value = salario;
        document.getElementById('edit_area').value = area;
        var myModal = new bootstrap.Modal(document.getElementById('editarRegistroModal'));
        myModal.show();
    }
</script>
<?php
include 'db/db.php'; // Incluye el archivo de conexión a la base de datos

// Verifica si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnEditar'])) {
    // Obtiene los datos del formulario
    $id = $_POST['edit_id'];
    $nombre = $_POST['edit_nombre'];
    $apellido = $_POST['edit_apellido'];
    $edad = $_POST['edit_edad'];
    $salario = $_POST['edit_salario'];
    $area = $_POST['edit_area'];

    // Verifica si la conexión está establecida
    if ($conn) {
        // Prepara la consulta de actualización
        $sql = "UPDATE Empleados SET nombre=?, apellido=?, edad=?, salario_soles=?, area=? WHERE id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincula los parámetros y ejecuta la consulta
            $stmt->bind_param("ssidsi", $nombre, $apellido, $edad, $salario, $area, $id);

            if ($stmt->execute()) {
                echo "<script>alert('Datos actualizados correctamente');</script>";
            } else {
                echo "<script>alert('Error al actualizar datos: " . $stmt->error . "');</script>";
            }

            $stmt->close(); // Cierra la consulta preparada
        } else {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error: No se pudo conectar a la base de datos.');</script>";
    }
}
?>






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
                alert("Empleado insertado exitosamente.");
            } else {
                // Error: Mostrar mensaje de error
                alert("Error al insertar el Empleado.");
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
