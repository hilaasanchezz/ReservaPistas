<?php
include('loginSesion.php');

include('conexion.php');

$email_sesion = $_SESSION['email'];

try {
    // Buscamos los datos actualizados del usuario en la base de datos
    $sql = "SELECT nombre, email FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$email_sesion]);
    $usuario_datos = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al cargar el perfil: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pistas Jacarilla - Mi Perfil</title>
    <link rel="stylesheet" href="perfil.css">
</head>
<body>

    <?php
    include('navegador.php');
    ?>

    <div class="perfilEntero">
        <div class="overlay">
            <div class="perfilContenedor">
                <h2>Mi Perfil</h2>
                <p class="subtitulo">Aquí tienes tus datos de usuario registrados</p>
                
                <form>
                    <div class="grupo-input">
                        <label>Nombre de usuario</label>
                        <input type="text" value="<?php echo htmlspecialchars($usuario_datos['nombre']); ?>" readonly>
                    </div>

                    <div class="grupo-input">
                        <label>Correo electrónico</label>
                        <input type="email" value="<?php echo htmlspecialchars($usuario_datos['email']); ?>" readonly>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>