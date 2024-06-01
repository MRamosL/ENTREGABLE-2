<?php
session_start();

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tienes una contraseña
$dbname = "Empresa";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables para mensajes de error
$login_error_message = "";
$register_error_message = "";
$register_success_message = "";

// Verificar si el formulario de inicio de sesión ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Obtener los datos del formulario de inicio de sesión
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Consultar la base de datos
    $sql = "SELECT * FROM InicioSesion WHERE correo = ? AND clave = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si las credenciales son correctas
    if ($result->num_rows > 0) {
        // Credenciales correctas, redirigir a otro.html
        header("Location: Empleados.php");
        exit();
    } else {
        // Credenciales incorrectas, asignar mensaje de error
        $login_error_message = "Correo o contraseña incorrectos";
    }

    // Cerrar la conexión
    $stmt->close();
}

// Verificar si el formulario de registro ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Obtener los datos del formulario de registro
    $new_correo = $_POST['new_correo'];
    $new_clave = $_POST['new_clave'];

    // Insertar en la base de datos
    $sql = "INSERT INTO InicioSesion (correo, clave) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_correo, $new_clave);

    if ($stmt->execute()) {
        // Registro exitoso, asignar mensaje de éxito
        $register_success_message = "Registro exitoso, por favor inicia sesión.";
    } else {
        // Error en el registro, asignar mensaje de error
        $register_error_message = "Error al registrar el usuario";
    }

    // Cerrar la conexión
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Inicio</title>
    <style>
        #error-message {
            display: none;
            color: red;
            font-size: 12px;
            margin-left: 10px;
        }

       /* Estilos del modal */
       .modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.10); /* Más transparente */
}

.modal-content {
    background-image: url('https://img.freepik.com/vector-gratis/diseno-fondo-abstracto-blanco_23-2148825582.jpg?t=st=1717125901~exp=1717129501~hmac=2e6d29d5da9c60018047c3b8d9a68fea201e46b87567632d44657c2fa28d19ac&w=740');

    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    border: none; /* Eliminar el borde */
    border-radius: 10px; /* Añadir un poco de suavidad */
    width: 80%;
    max-width: 500px; /* Ajusta el tamaño del modal */
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 255, 0.5), 0 0 10px rgba(0, 0, 255, 0.4), 0 0 10px rgba(0, 0, 255, 0.3); /* Añadir resplandor azul */
}


.form-group small {
    display: block;
    margin-bottom: 5px; /* Separación del input */
    text-align: left; /* Alineación a la izquierda */
    color: #00468b; /* Color de texto azul oscuro */
}


.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.30); /* Más transparente */
}

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }

        
    </style>
    <script>
        // Función para habilitar/deshabilitar el botón de enviar y mostrar mensaje de error
        function toggleSubmitButton() {
            const checkBox = document.getElementById('user-check');
            const submitButton = document.querySelector('.login__button');
            const errorMessage = document.getElementById('error-message');
            if (checkBox.checked) {
                submitButton.disabled = false;
                errorMessage.style.display = 'none';
            } else {
                submitButton.disabled = true;
                errorMessage.style.display = 'inline';
            }
        }

        // Función para abrir el modal
        function openModal() {
            document.getElementById('registerModal').style.display = 'block';
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('registerModal').style.display = 'none';
        }

        // Función para ocultar el mensaje de éxito después de un intervalo de tiempo
        function hideMessage(elementId) {
            var message = document.getElementById(elementId);
            if (message) {
                setTimeout(function() {
                    message.style.display = 'none';
                }, 3000); // 3 segundos
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            toggleSubmitButton(); // Inicialmente deshabilitar el botón
            document.getElementById('user-check').addEventListener('change', toggleSubmitButton);

            // Ocultar el mensaje de error después de 7 segundos
            hideMessage('login-error-message');
            hideMessage('register-success-message');
        });
    </script>
</head>
<body>
    <div class="login">
        <img src="assets/img/inicio.jpg" alt="image" class="login__bg">
        <form action="" method="POST" class="login__form">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" name="correo" placeholder="Usuario" required class="login__input">
                    <i class="ri-mail-fill"></i>
                </div>
                <div class="login__box">
                    <input type="password" name="clave" placeholder="Contraseña" required class="login__input">
                    <i class="ri-lock-2-fill"></i>
                </div>
            </div>
            <?php if ($login_error_message): ?>
                <p id="login-error-message" class="error-message"><?php echo $login_error_message; ?></p>
            <?php endif; ?>
            <div class="login__check">
                <div class="login__check-box">
                    <input type="checkbox" class="login__check-input" id="user-check">
                    <label for="user-check" class="login__check-label">Terminos</label>
                    <span id="error-message">Debes aceptar el acuerdo</span>
                </div>
                <a href="#" class="login__forgot"></a>
            </div>
            <button type="submit" name="login" class="login__button" disabled>Iniciar</button>
            <div class="login__register">
                ¿No tienes una cuenta? <a href="javascript:void(0)" onclick="openModal()">Regístrate</a>
            </div>
        </form>
    </div>

<!-- Modal de Registro -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <hr>
        <h2>Crear cuenta</h2>
        <hr> 
        <form id="registerForm" action="" method="POST">
            <div class="form-group">
                <small id="apellidoHelp" class="form-text text-muted">Ingrese el correo Empresarial.</small>
                <input type="email" name="new_correo" class="form-control" placeholder="Correo" required>              
            </div><br>
            <div class="form-group">
                <small id="apellidoHelp" class="form-text text-muted">Cree una contraseña.</small>
                <input type="password" name="new_clave" class="form-control" placeholder="Contraseña" required>
            </div><br>
            <hr>
            <?php if (isset($_POST['register'])): ?>
                <?php if ($register_error_message): ?>
                    <p id="error-message" class="error-message"><?php echo $register_error_message; ?></p>
                <?php endif; ?>
                <?php if ($register_success_message): ?>
                    <p id="register-success-message" class="success-message"><?php echo $register_success_message; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <button type="submit" name="register" class="btn btn-primary btn-block" onclick="showMessage()">Registrar</button>
        </form>
    </div>
</div>


    <script>
        // Ocultar el mensaje de éxito después de 3 segundos si está presente en el modal
        hideMessage('register-success-message');


        <script>
    function openModal() {
        var modal = document.getElementById('registerModal');
        modal.style.display = 'block'; // Muestra el modal
    }
    
</script>
</body>
</html>
