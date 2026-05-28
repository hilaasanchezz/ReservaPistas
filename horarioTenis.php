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
                
                <div class="contenedor-desplegable">
                    <form id="formCalendario" action="horarioTenis.php" method="POST">
                        <?php// Tiene cargada la fecha actual en el atributo value?>
                        <?php// Y con el onchange, cuando el usuario cambia la fecha, este ejecuta el submit, actuando como un formulario, por lo que recarga la página estableciendo esa nueva fecha como la actual?>
                        <input type="date" id="inputCalendarioHidden" name="fecha_actual" value="<?php echo $fecha_reserva; ?>" onchange="document.getElementById('formCalendario').submit();">
                    </form>
                    <?php// Al hacer 'onclick' (clic en el texto), JavaScript (con el uso de document, que es toda la web) busca en la pantalla el input oculto por su ID ('inputCalendarioHidden') y le ejecuta el '.showPicker()', que obliga al navegador a abrir y desplegar el calendario flotante?>
                    <span class="tituloCentro" onclick="document.getElementById('inputCalendarioHidden').showPicker();">
                        <strong><?php echo $fecha_texto_dinamico; ?> ▾</strong>
                    </span>
                </div>
                
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