<div class="horarios">
    
    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="08:00:00">
        <button type="submit">08:00 / 10:00</button>
    </form>

    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="10:15:00">
        <button type="submit">10:15 / 10:45</button>
    </form>

    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="11:00:00">
        <button type="submit">11:00 / 13:00</button>
    </form>

    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="16:00:00">
        <button type="submit">16:00 / 18:00</button>
    </form>

    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="18:15:00">
        <button type="submit">18:15 / 18:45</button>
    </form>

    <form action="reservas.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
        <input type="hidden" name="hora" value="19:00:00">
        <button type="submit">19:00 / 21:00</button>
    </form>

</div>