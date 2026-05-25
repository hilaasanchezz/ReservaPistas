<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pistas Jacarilla</title>
        <link rel="stylesheet" href="inicio.css">
    </head>
    <body>

        <header>
            <div class="menu">☰</div>

            <div class="logo">
                <img src="logo_sin_fondo.png" alt="Logo">
            </div>

            <div class="contenedor-usuario">
                
                    <span class="usuario">👤</span>
                    <div class="menu-desplegable">
                        <p class="bienvenida">Hola, <?php echo htmlspecialchars($usuario_datos['nombre']); ?></p>
                        <a href="perfil.php">⚙️ Mi Perfil</a>
                        <a href="cerrarSesion.php" class="logout">❌ Cerrar sesión</a>
                    </div>
                
            </div>
        </header>

    </body>
</html>