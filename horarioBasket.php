<?php
    include('loginSesion.php');

    include('conexion.php');

    include('calendario.php');
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
                <a href="horarioTenis.php"><span class="flecha">‹</span></a>
                <span class="tituloCentro"><strong>BALONCESTO</strong></span>
                <a href="horarioFut.php"><span class="flecha">›</span></a>
            </div>

            <div class="fechaSelector">
                <form action="horarioBasket.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_anterior->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">‹</button>
                </form>
                
                <div class="contenedor-desplegable">
                    <form id="formCalendario" action="horarioBasket.php" method="POST">
                        <input type="date" id="inputCalendarioHidden" name="fecha_actual" value="<?php echo $fecha_reserva; ?>" onchange="document.getElementById('formCalendario').submit();">
                    </form>
                    <span class="tituloCentro" onclick="document.getElementById('inputCalendarioHidden').showPicker();">
                        <strong><?php echo $fecha_texto_dinamico; ?> ▾</strong>
                    </span>
                </div>
                
                <form action="horarioBasket.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_siguiente->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">›</button>
                </form>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Cancha 1</h2>
                <?php
                    $id_pista_actual = 7;
                    include ('horas.php');
                ?>   
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Cancha 2</h2>
                <?php
                    $id_pista_actual = 8;
                    include ('horas.php');
                ?> 
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Cancha cubierta</h2>
                <?php
                    $id_pista_actual = 9;
                    include ('horas.php');
                ?> 
            </div>
        </div>
    </div>
</main>

</body>
</html>