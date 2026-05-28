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
                <a href="horarioFut.php"><span class="flecha">‹</span></a>
                <span class="tituloCentro"><strong>TENIS</strong></span>
                <a href="horarioBasket.php"><span class="flecha">›</span></a>
            </div>

            <div class="fechaSelector">
                <form action="horarioTenis.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_anterior->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">‹</button>
                </form>
                
                <span class="tituloCentro"><strong><?php echo $fecha_texto_dinamico; ?></strong></span>
                
                <form action="horarioTenis.php" method="POST">
                    <input type="hidden" name="fecha_actual" value="<?php echo $fecha_siguiente->format('Y-m-d'); ?>">
                    <button type="submit" class="btn-flecha flecha">›</button>
                </form>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 1</h2>
                <?php
                    $id_pista_actual = 4;
                    include ('horas.php');
                ?>     
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 2</h2>
                <?php
                    $id_pista_actual = 5;
                    include ('horas.php');
                ?> 
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 3</h2>
                <?php
                    $id_pista_actual = 6;
                    include ('horas.php');
                ?> 
            </div>
        </div>
    </div>
</main>

</body>
</html>