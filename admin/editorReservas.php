<?php
include '../conexion.php'; 

$mensaje_exito = null;
$mensaje_error = null;

// ELIMINACIÓN DE RESERVAS
if (isset($_GET['action']) && $_GET['action'] === 'cancelar' && isset($_GET['id'])) {
    $id_reserva = intval($_GET['id']);
    
    try {
        // Detecta la columna ID por seguridad
        $q_cols = $conexion->query("SHOW COLUMNS FROM reservas");
        $columnas = $q_cols->fetchAll(PDO::FETCH_ASSOC);
        $columna_id = 'id';
        
        foreach ($columnas as $col) {
            if ($col['Key'] == 'PRI' || strpos($col['Field'], 'id') !== false) {
                $columna_id = $col['Field'];
                break;
            }
        }
        
        $sql_delete = "DELETE FROM reservas WHERE $columna_id = :id";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->bindParam(':id', $id_reserva, PDO::PARAM_INT);
        
        if ($stmt_delete->execute()) {
            $mensaje_exito = "Reserva #" . $id_reserva . " eliminada correctamente.";
        } else {
            $mensaje_error = "No se pudo eliminar la reserva.";
        }
    } catch (PDOException $e) {
        $mensaje_error = "Error al eliminar: " . $e->getMessage();
    }
}

// CONSULTA PARA TRAER LAS RESERVAS
try {
    $sql_select = "SELECT * FROM reservas";
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->execute();
    $reservas = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
    
    $col_id = 'id';
    $col_fecha = 'fecha';
    $col_hora = 'hora';
    
    if (!empty($reservas)) {
        $primer_registro = $reservas[0];
        foreach (array_keys($primer_registro) as $key) {
            $key_lower = strtolower($key);
            if (strpos($key_lower, 'id') !== false) $col_id = $key;
            if (strpos($key_lower, 'fech') !== false) $col_fecha = $key;
            if (strpos($key_lower, 'hor') !== false) $col_hora = $key;
        }
    }
} catch (PDOException $e) {
    $mensaje_error = "Error al cargar las reservas: " . $e->getMessage();
    $reservas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección de Reservas - Pistas Jacarilla</title>
    <link rel="stylesheet" href="panelAdmin.css">
    <link rel="stylesheet" href="editorReservas.css">
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
                <a href="editorReservas.php" class="active">📅 Reservas Activas</a>
                <a href="editorUsuarios.php">👥 Usuarios</a>
                <a href="../index.php" class="btn-volver">Visitar la Web</a>
            </nav>
        </aside>

        <main class="contenido-principal">
            
            <header class="header-top">
                <h2>Sección de Reservas</h2>
                <div class="usuario-info">
                    <span>Bienvenido, <strong>admin</strong></span>
                    <a href="panelAdmin.php?action=logout" class="btn-cerrar">Cerrar Sesión</a>
                </div>
            </header>

            <section class="gestion-seccion">
                
                <div class="header-seccion">
                    <h3>Listado de Reservas Activas</h3>
                </div>

                <?php if ($mensaje_exito) { ?>
                    <p class="alerta-exito"><?php echo $mensaje_exito; ?></p>
                <?php } ?>
                
                <?php if ($mensaje_error) { ?>
                    <p class="alerta-error"><?php echo $mensaje_error; ?></p>
                <?php } ?>

                <div class="tabla-contenedor">
                    <table class="tabla-admin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FECHA</th>
                                <th>HORA</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (!empty($reservas)) { 
                                foreach ($reservas as $row) { 
                                    $id_actual = $row[$col_id];
                                    $fecha_cruda = isset($row[$col_fecha]) ? $row[$col_fecha] : '';
                                    $hora_cruda = isset($row[$col_hora]) ? $row[$col_hora] : '';

                                    $timestamp = strtotime($fecha_cruda);
                                    if ($timestamp && false !== $timestamp) {
                                        $fecha_formateada = date("d/m/Y", $timestamp);
                                    } else {
                                        $fecha_formateada = $fecha_cruda;
                                    }

                                    $timestamp_hora = strtotime($hora_cruda);
                                    $hora_formateada = ($timestamp_hora) ? date("H:i", $timestamp_hora) : $hora_cruda;
                            ?>
                                <tr>
                                    <td><?php echo $id_actual; ?></td>
                                    <td><?php echo $fecha_formateada; ?></td>
                                    <td><?php echo $hora_formateada; ?></td>
                                    <td>
                                        <a href="editorReservas.php?action=cancelar&id=<?php echo $id_actual; ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Seguro que quieres eliminar esta reserva?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php 
                                } 
                            } else { 
                            ?>
                                <tr>
                                    <td colspan="4" class="tabla-vacia">
                                        No hay ninguna reserva registrada en este momento.
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>

</body>
</html>