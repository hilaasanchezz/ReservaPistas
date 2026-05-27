<?php
    include('loginSesion.php');

    include('conexion.php');
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
                <span class="flecha">‹</span>
                <span class="tituloCentro"><strong>01 enero 2026</strong></span>
                <span class="flecha">›</span>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 1</h2>
                <?php
                    include ('horas.php');
                ?>     
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 2</h2>
                <?php
                    include ('horas.php');
                ?> 
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Pista 3</h2>
                <?php
                    include ('horas.php');
                ?> 
            </div>
        </div>
    </div>
</main>

</body>
</html>