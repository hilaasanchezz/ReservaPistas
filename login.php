<?php 
include('loginSesion2.php');

include('conexion.php');

// 1. Solo actuamos si el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar'])) {
    
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    try {
        // 2. Buscamos al usuario por su email (usando marcadores "?" por seguridad)
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Si el usuario existe, comprobamos la contraseña encriptada
        if ($row && password_verify($contrasena, $row['contraseña'])) {
            
            // Guardamos el email y el nombre en la sesión
            $_SESSION['email'] = $row['email'];
            $_SESSION['nombre'] = $row['nombre'];
            
            // Redirigimos a la página principal (index.php)
            header("Location: index.php");
            exit;
            
        } else {
            // Si no coincide el email o la contraseña
            echo ' 
                <script> 
                    alert("El correo electrónico o la contraseña son incorrectos.");
                    window.location = "login.php";
                </script>
            ';
            exit;
        }

    } catch (PDOException $e) {
        echo "Error en el login: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pistas Jacarilla - Login</title>
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="css/inicioSesion.css">
</head>

<body>

    <header>
        <a href="index.php" class="volverInicio">
            <img src="casa.svg" alt="Inicio">
        </a>
        <div class="logo">
            <img src="logo_sin_fondo.png" alt="Pistas Jacarilla">
        </div>
    </header>

    <div class="inicioSesionEntero">
        <div class="overlay">
            <div class="inicioSesion">
                <h2>Iniciar sesión</h2>
                
                <form method="POST" action="">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <button type="submit" name="entrar">Entrar</button>
                </form>
                
                <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
            </div>
        </div>
    </div>

</body>
</html>