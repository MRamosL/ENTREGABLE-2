<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.: Formulario :.</title>
    <link rel="stylesheet" href="css/estilos.css">
    <?php include 'bootstrap.php'; ?>
    <style>
        img {
            width: 16px;
            height: auto;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a class="nav-link active" aria-current="page" href="index.php">Profesores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="alumno.php">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="curso.php">Cursos</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>
    <h1>Listado de Alumnos</h1>
    <a href="views/registroalumno.php" class="btn btn-primary">Agregar Nuevo</a>
    <?php
        include 'db/db.php';

        // Verificar si se está enviando una solicitud POST para eliminar
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            $id = $_POST['delete_id'];
            $sql = "DELETE FROM Alumno WHERE id = $id";
            if (mysqli_query($db, $sql)) {
                echo "<script>alert('Alumno eliminado exitosamente.'); window.location.href='';</script>";
            } else {
                $error = mysqli_error($db);
                echo "<script>alert('Error al eliminar el Alumno: $error');</script>";
            }
        }

        // Obtener todos los profesores
        $sql = "SELECT * FROM Alumno";
        $result = mysqli_query($db, $sql);
    ?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Last Name</td>
            <td>Career</td>
            <td>Enable</td>
            <td colspan="2">Acción</td>
        </tr>
        <?php
            while($row = mysqli_fetch_assoc($result)){
                echo "
                <tr>
                    <td>{$row['Id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['lastname']}</td>
                    <td>{$row['career']}</td>
                    <td>{$row['enable']}</td>
                    <td>
                        <a href='views/editaralumno.php?id={$row['Id']}' class='btn btn-warning' onclick='openEditar({$row['Id']})'>
                            <img src='icons/pencil-solid.svg'>
                        </a>
                    </td>
                <td>
                    <button type='button' class='btn btn-danger' onclick='openModal({$row['Id']})' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                        <img src='icons/trash-solid.svg'>
                    </button>
                </td>
                
                ";
            }
        ?>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Estas seguro que deseas Eliminar los datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal">
                    <!-- Los detalles del profesor se cargarán aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            $.ajax({
                url: '', // La URL es la misma página
                type: 'GET',
                data: { fetch_id: id },
                success: function(response) {
                    $('.modal-body').html(response);
                    $('#delete_id').val(id); // Guarda el ID en el formulario de eliminación
                }
            });
        }
    </script>

    <?php
        // Manejar la solicitud de obtener detalles del alumno
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_id'])) {
            $id = $_GET['fetch_id'];
            $sql = "SELECT * FROM Alumno WHERE id = $id";
            $result = mysqli_query($db, $sql);

            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "
                    <div>
                        <p>ID: {$row['id']}</p>
                        <p>Nombre: {$row['name']}</p>
                        <p>Apellido: {$row['lastname']}</p>
                        <p>Carrera: {$row['career']}</p>
                        <p>Habilitado: {$row['enable']}</p>
                    </div>
                ";
            } else {
                echo "No se encontraron detalles para este profesor.";
            }
            exit;
        }
    ?>
    
</body>
</html>
