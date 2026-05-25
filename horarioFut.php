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
                <a href="horarioBasket.php"><span class="flecha">‹</span></a>
                <span class="tituloCentro"><strong>FÚTBOL</strong></span>
                <a href="horarioTenis.php"><span class="flecha">›</span></a>
            </div>

            <div class="fechaSelector">
                <span class="flecha">‹</span>
                <span class="tituloCentro"><strong>01 enero 2026</strong></span>
                <span class="flecha">›</span>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Campo</h2>
                <div class="horarios">
                    <button>08:00 / 10:00</button>
                    <button>10:15 / 10:45</button>
                    <button>11:00 / 13:00</button>
                    <button>16:00 / 18:00</button>
                    <button>18:15 / 18:45</button>
                    <button>19:00 / 21:00</button>
                </div>    
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Campo infantil</h2>
                    <div class="horarios">
                    <button>08:00 / 10:00</button>
                    <button>10:15 / 10:45</button>
                    <button>11:00 / 13:00</button>
                    <button>16:00 / 18:00</button>
                    <button>18:15 / 18:45</button>
                    <button>19:00 / 21:00</button>
                </div>
            </div>

            <div class="bloque">
                <h2 class="tituloPista">Fútbol sala</h2>
                    <div class="horarios">
                    <button>08:00 / 9:15</button>
                    <button>9:45 / 11:00</button>
                    <button>11:30 / 12:45</button>
                    <button>16:15 / 17:30</button>
                    <button>18:00 / 19:15</button>
                    <button>19:45 / 21:00</button>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>