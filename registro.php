<?php
// Carga la conexión
include('conexion.php');

// 1. Solo actuamos si el usuario ha pulsado el botón de "Registrarse"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    
    // Recogemos los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // 2. Validación básica: comprobar si las contraseñas coinciden
    if ($contrasena !== $confirmar_contrasena) {
        echo "<script>alert('Las contraseñas no coinciden.');</script>";
    } else {
        try {
            // 3. Sintaxis correcta para INSERT y marcadores (?) por seguridad anti-Hacks
            $sql = 'INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)';

            // Prepara la consulta
            $stmt = $conexion->prepare($sql);

            // Ejecuta la consulta pasando los datos reales
            // (Usamos password_hash para que la contraseña se guarde encriptada y segura)
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);
            $is_insert = $stmt->execute([$nombre, $email, $contrasena_encriptada]);

            if ($is_insert) {
                echo "<script>alert('¡Usuario registrado con éxito!');</script>";
                // Aquí podrías redirigir al login si quisieras: header('Location: inicioSesion.html');
            }

            // Liberar recursos
            $stmt = null;
            $conexion = null;

        } catch(PDOException $e) {
            echo "<script>alert('El correo del usuario ya ha sido utilizado.');</script>";
            $stmt = null;
            $conexion = null;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pistas Jacarilla</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="registro.css">
</head>



<body>

    <header>
        <a href="index.html" class="volverInicio"><img src="casa.svg"></a>

        <div class="logo">
            <img src="logo_sin_fondo.png" alt="Pistas Jacarilla">
        </div>
    </header>


    <div class="registroEntero">
        <div class="overlay">
            <div class="registro">
                <h2>Crear cuenta</h2>
                <form method="POST" action="">
                    <input type="text" name="nombre" placeholder="Nombre de usuario" required>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
                    <button type="submit" name="registrar">Registrarse</button>
                </form>
                <p>¿Ya tienes cuenta? <a href="inicioSesion.html">Inicia sesión</a></p>
            </div>
        </div>
    </div>

</body>
</html>