<?php
    include('loginSesion.php');

    include('conexion.php');

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

<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar horario</title>
    <link rel="stylesheet" href="css/horario.css">
</head>



<body>
    <?php
        include ('navegador.php');
    ?>



<main>
    <div class="overlay">

        

        <div class="cajaHorarios">

            <div class="deporteSelector">
                <a href="horarioBasket.php"><span class="flecha">‹</span></a>
                <span class="tituloCentro"><strong>FÚTBOL</strong></span>
                <a href="horarioTenis.php"><span class="flecha">›</span></a>
            </div>

            <div class="fechaSelector">
                <form action="horarioFut.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_anterior->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">‹</button>
                </form>
                
                <span class="tituloCentro"><strong><?php echo $fecha_texto_dinamico; ?></strong></span>
                
                <form action="horarioFut.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_siguiente->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">›</button>
                </form>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Campo</h2>
                <?php
                    $id_pista_actual = 1;
                    include ('horas.php');
                ?>  
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Campo infantil</h2>
                <?php
                    $id_pista_actual = 2;
                    include ('horas.php');
                ?> 
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Fútbol sala</h2>
                <?php
                    $id_pista_actual = 3;
                    include ('horas.php');
                ?> 
            </div>
        </div>
    </div>
</main>

</body>
</html>