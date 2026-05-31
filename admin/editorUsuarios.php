<?php
session_start();

// Si no ha iniciado sesión, o si ha iniciado sesión pero no es admin (es 0), lo echamos al login
if (!isset($_SESSION['id']) || $_SESSION['admin'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Variables para control de errores y edición
$error = ""; // Guarda el mensaje de fallo si algo sale mal (ej: email repetido)
$usuarioEditar = null; // Almacena los datos del usuario si están siendo editados, o null si es uno nuevo

try {
    include('../conexion.php');

    // EDICIÓN DE UN USUARIO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'editar') { // Comprueba si el usuario ha enviado el formulario (POST) para guardar los cambios de la edición (action=editar)
        $idEditar = $_GET['id']; // Recoge el ID del usuario directamente desde la URL para saber que usuario está siendo editado
        $nombreMod = trim($_POST['nombre']); // Recoge el nombre enviado por el formulario y borra los espacios en blanco al principio y al final
        $emailMod = trim($_POST['email']);
        $rolMod = $_POST['admin']; // Recoge el rol seleccionado en el formulario

        // Comprueba si el email modificado ya lo tiene otro usuario
        $sqlCheckEmail = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id != :id";
        $stmtCheckEmail = $conexion->prepare($sqlCheckEmail);
        $stmtCheckEmail->execute([':email' => $emailMod, ':id' => $idEditar]);

        if ($stmtCheckEmail->fetchColumn() > 0) {
            $error = "El correo electrónico ya está registrado por otro usuario.";
            // Vuelve a cargar los datos del usuario para que no se vacíe el formulario
            $sqlUser = "SELECT id, nombre, email, admin FROM usuarios WHERE id = :id";
            $stmtUser = $conexion->prepare($sqlUser);
            $stmtUser->execute([':id' => $idEditar]);
            $usuarioEditar = $stmtUser->fetch(PDO::FETCH_ASSOC);
        } else {
            // Si la contraseña cambia, se encripta. Si no, se mantiene la vieja.
            if (!empty($_POST['password'])) {
                $passMod = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $sqlUpdate = "UPDATE usuarios SET nombre = :nombre, email = :email, contraseña = :pass, admin = :admin WHERE id = :id";
                $params = [':nombre' => $nombreMod, ':email' => $emailMod, ':pass' => $passMod, ':admin' => $rolMod, ':id' => $idEditar];
            } else {
                $sqlUpdate = "UPDATE usuarios SET nombre = :nombre, email = :email, admin = :admin WHERE id = :id";
                $params = [':nombre' => $nombreMod, ':email' => $emailMod, ':admin' => $rolMod, ':id' => $idEditar];
            }

            $stmtUpdate = $conexion->prepare($sqlUpdate);
            $stmtUpdate->execute($params);

            // Si el admin se editó a sí mismo, se actualiza su sesión al momento
            if ($idEditar == $_SESSION['id']) {
                $_SESSION['nombre'] = $nombreMod;
            }

            header("Location: editorUsuarios.php");
            exit;
        }
    }

    // LECTURA DE DATOS DEL USUARIO
    if (isset($_GET['action']) && $_GET['action'] === 'editar' && isset($_GET['id']) && empty($error)) {
        $idEditar = $_GET['id'];
        $sqlUser = "SELECT id, nombre, email, admin FROM usuarios WHERE id = :id";
        $stmtUser = $conexion->prepare($sqlUser);
        $stmtUser->execute([':id' => $idEditar]);
        $usuarioEditar = $stmtUser->fetch(PDO::FETCH_ASSOC);
    }

    // INSERCIÓN DE UN USUARIO NUEVO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'nuevo') {
        $nombreNuevo = trim($_POST['nombre']);
        $emailNuevo = trim($_POST['email']);
        $passNueva = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $rolNuevo = $_POST['admin'];

        $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->execute([':email' => $emailNuevo]);
        
        if ($stmtCheck->fetchColumn() > 0) {
            $error = "El correo electrónico ya está registrado por otro usuario.";
        } else {
            $sqlInsert = "INSERT INTO usuarios (nombre, email, contraseña, admin) VALUES (:nombre, :email, :pass, :admin)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->execute([
                ':nombre' => $nombreNuevo,
                ':email' => $emailNuevo,
                ':pass' => $passNueva,
                ':admin' => $rolNuevo
            ]);

            header("Location: editorUsuarios.php");
            exit;
        }
    }

    // ELIMINACIÓN DE UN USUARIO
    if (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['id'])) {
        $idEliminar = $_GET['id'];
        
        if ($idEliminar != $_SESSION['id']) {
            $sqlDelete = "DELETE FROM usuarios WHERE id = :id";
            $stmtDelete = $conexion->prepare($sqlDelete);
            $stmtDelete->execute([':id' => $idEliminar]);
        }
        
        header("Location: editorUsuarios.php");
        exit;
    }

    // Trae todos los usuarios a la tabla
    $sqlListar = "SELECT id, nombre, email, admin FROM usuarios";
    $stmtListar = $conexion->query($sqlListar);
    $usuarios = $stmtListar->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("<h3>🚨 Error detectado en la Base de Datos:</h3>" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Pistas Jacarilla</title>
    <link rel="stylesheet" href="panelAdmin.css">
    <link rel="stylesheet" href="editorUsuarios.css">
    <link rel="icon" type="image/png" href="../logo.png">
</head>
<body>

    <div class="contenedor-panel">
        
        <aside class="barra-lateral">
            <div class="logo-admin">
                <img src="../fotos/logo_sin_fondo.png" alt="Logo">
            </div>
            <nav class="menu-admin">
                <a href="panelAdmin.php">📊 Panel Principal</a>
                <a href="editorReservas.php">📅 Reservas Activas</a>
                <a href="editorUsuarios.php" class="active">👥 Usuarios</a>
                <a href="#">🎾 Gestionar Pistas (PRÓXIMAMENTE)</a>
                <a href="../index.php" class="btn-volver">Visitar la Web</a>
            </nav>
        </aside>

        <main class="contenido-principal">
            <header class="header-top">
                <h2>Sección de Usuarios</h2>
                <div class="usuario-info">
                    <span>Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong></span>
                    <a href="panelAdmin.php?action=logout" class="btn-cerrar">Cerrar Sesión</a>
                </div>
            </header>

            <?php if (isset($_GET['action']) && $_GET['action'] === 'editar' && $usuarioEditar): ?> // Comprueba si se va a editar un usuario y, además, confirma que los datos del usuario existan antes de cargar el formulario
                
                <section class="gestion-seccion">
                    <div class="header-seccion">
                        <h3>Editar Usuario (ID: <?php echo $usuarioEditar['id']; ?>)</h3>
                        <a href="editorUsuarios.php" class="btn-editar btn-volver-listado">Volver al Listado</a>
                    </div>

                    <?php if (!empty($error)): ?> // Si la variable error no está vacía, muestra lo siguiente
                        <p class="alerta-error"><?php echo $error; ?></p> // Mensaje de error
                    <?php endif; ?>

                    <form action="editorUsuarios.php?action=editar&id=<?php echo $usuarioEditar['id']; ?>" method="POST" class="formulario-admin">
                        <div class="grupo-formulario">
                            <label>Nombre Completo</label>
                            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuarioEditar['nombre']); ?>" required>
                        </div>

                        <div class="grupo-formulario">
                            <label>Correo Electrónico</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($usuarioEditar['email']); ?>" required>
                        </div>

                        <div class="grupo-formulario">
                            <label>Contraseña <span class="nota-opcional">(Dejar en blanco para no cambiarla)</span></label>
                            <input type="password" name="password" placeholder="Opcional">
                        </div>

                        <div class="grupo-formulario">
                            <label>Rol del Sistema</label>
                            <select name="admin">
                                <option value="0" <?php echo $usuarioEditar['admin'] == 0 ? 'selected' : ''; ?>>👤 Usuario Normal</option>
                                <option value="1" <?php echo $usuarioEditar['admin'] == 1 ? 'selected' : ''; ?>>👑 Administrador</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-crear btn-actualizar-azul">
                            Actualizar Datos del Usuario
                        </button>
                    </form>
                </section>

            <?php elseif (isset($_GET['action']) && $_GET['action'] === 'nuevo'): ?> // Comprueba si la URL indica que se va acrear un nuevo usuario
                
                <section class="gestion-seccion">
                    <div class="header-seccion">
                        <h3>Crear Nuevo Usuario</h3>
                        <a href="editorUsuarios.php" class="btn-editar btn-volver-listado">Volver al Listado</a>
                    </div>

                    <?php if (!empty($error)): ?> // Si la variable error no está vacía, muestra lo siguiente
                        <p class="alerta-error"><?php echo $error; ?></p> // Mensaje de error
                    <?php endif; ?>

                    <form action="editorUsuarios.php?action=nuevo" method="POST" class="formulario-admin">
                        <div class="grupo-formulario">
                            <label>Nombre Completo</label>
                            <input type="text" name="nombre" required>
                        </div>

                        <div class="grupo-formulario">
                            <label>Correo Electrónico</label>
                            <input type="email" name="email" required>
                        </div>

                        <div class="grupo-formulario">
                            <label>Contraseña</label>
                            <input type="password" name="password" required>
                        </div>

                        <div class="grupo-formulario">
                            <label>Rol del Sistema</label>
                            <select name="admin">
                                <option value="0">👤 Usuario Normal</option>
                                <option value="1">👑 Administrador</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-crear">
                            Guardar Usuario en la Base de Datos
                        </button>
                    </form>
                </section>

            <?php else: ?>

                <section class="gestion-seccion">
                    <div class="header-seccion">
                        <h3>Listado de Usuarios Registrados</h3>
                        <a href="editorUsuarios.php?action=nuevo" class="btn-crear">Añadir Nuevo Usuario</a>
                    </div>

                    <div class="tabla-contenedor">
                        <table class="tabla-admin">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['nombre']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td>
                                        <span class="rol <?php echo $user['admin'] == 1 ? 'rol-admin' : 'rol-user'; ?>">
                                            <?php echo $user['admin'] == 1 ? '👑 Admin' : '👤 Usuario'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="editorUsuarios.php?action=editar&id=<?php echo $user['id']; ?>" class="btn-accion btn-editar">Editar</a>
                                        <a href="editorUsuarios.php?action=eliminar&id=<?php echo $user['id']; ?>" 
                                           class="btn-accion btn-eliminar"
                                           onclick="return confirm('¿Seguro que quieres eliminar a este usuario?');">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            <?php endif; ?>
        </main>

    </div>

</body>
</html>