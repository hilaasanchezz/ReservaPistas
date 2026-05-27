<?php
// 1. Validamos que el usuario tiene la sesión iniciada con tu guardián
include('loginSesion.php'); 

// 2. Conectamos a la base de datos
include('conexion.php');    

// 3. Comprueba que haya datos enviados por post (a través del botón)
if ($_POST) {
    
    // Si el ID no está en la sesión, se detiene el proceso
    if (!isset($_SESSION['id'])) {
        echo "<script>
                alert('Error: No se ha detectado el ID de tu usuario. Por favor, cierra sesión y vuelve a entrar.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }

    // Recuperamos el ID del usuario logueado que acabamos de añadir en el login
    $id_usuario = $_SESSION['id']; 
    
    // Recogemos los datos ocultos que viajan desde el formulario de horas.php
    $id_pista = $_POST['id_pista'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    
    // Juntamos la fecha y la hora en una sola variable para cumplir con el formato DATETIME (YYYY-MM-DD HH:MM:SS)
    $fecha_hora_inicio = $fecha . ' ' . $hora;
    
    // Definimos los valores por defecto para los ENUM de tu tabla
    $estado = 'Confirmada';
    $metodo_pago = 'Tarjeta'; 

    try {
        // 4. Preparamos la consulta SQL utilizando marcadores para evitar Inyección SQL
        $sql = "INSERT INTO reservas (id_usuario, id_pista, fecha_hora_inicio, estado, metodo_pago) 
                VALUES (:id_usuario, :id_pista, :fecha_hora_inicio, :estado, :metodo_pago)";
        
        $stmt = $conexion->prepare($sql);
        
        // Vinculamos los parámetros a las variables reales
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_pista', $id_pista, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora_inicio', $fecha_hora_inicio);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        
        // 5. Ejecutamos la inserción
        if ($stmt->execute()) {
            // Si funciona, alerta visual de éxito y redirección al perfil para que vea su reserva
            echo "<script>
                    alert('¡Reserva realizada con éxito!');
                    window.location.href = 'perfil.php';
                  </script>";
            exit;
        } else {
            echo "Hubo un error al procesar la reserva.";
        }
        
    } catch (PDOException $e) {
        // Si salta una restricción (como que la pista ya esté reservada a esa hora), se captura aquí
        echo "Error al guardar la reserva: " . $e->getMessage();
    }

} else {
    // Si alguien intenta entrar a reservas.php escribiendo la URL a mano en el navegador, lo mandamos a tenis
    header('Location: horarioTenis.php');
    exit();
}
?>