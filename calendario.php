<?php
    // Captura la fecha por POST si se pulsan las flechas. Si no, cargamos el día de hoy por defecto.
    $fecha_actual_sistema = isset($_POST['fecha_actual']) ? $_POST['fecha_actual'] : date('Y-m-d');
    
    // Guarda en la variable que lee 'horas.php'
    $fecha_reserva = $fecha_actual_sistema;

    // Procesa el formateo de texto amigable en español
    $fecha_objeto = new DateTime($fecha_reserva);
    $fecha_anterior = clone $fecha_objeto;
    $fecha_anterior->modify('-1 day');
    $fecha_siguiente = clone $fecha_objeto;
    $fecha_siguiente->modify('+1 day');

    $meses = [
        'January' => 'enero', 'February' => 'febrero', 'March' => 'marzo', 'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio', 'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre', 'November' => 'noviembre', 'December' => 'diciembre'
    ];
    $nombre_mes_espanol = $meses[$fecha_objeto->format('F')];
    $fecha_texto_dinamico = $fecha_objeto->format('d') . ' ' . $nombre_mes_espanol . ' ' . $fecha_objeto->format('Y');
?>