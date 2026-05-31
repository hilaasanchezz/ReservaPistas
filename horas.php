<div class="horarios">
    <?php 
    // Array con todos los tramos horarios disponibles
    $intervalos = [
        ["bd" => "08:00:00", "texto" => "08:00 / 10:00"],
        ["bd" => "10:15:00", "texto" => "10:15 / 10:45"],
        ["bd" => "11:00:00", "texto" => "11:00 / 13:00"],
        ["bd" => "16:00:00", "texto" => "16:00 / 18:00"],
        ["bd" => "18:15:00", "texto" => "18:15 / 18:45"],
        ["bd" => "19:00:00", "texto" => "19:00 / 21:00"]
    ];

    // El bucle 'for' recorre los 6 intervalos de uno en uno
    for ($i = 0; $i < count($intervalos); $i++) {
        
        // Extrae la hora para la Base de Datos y el texto para el botón
        $hora_bd = $intervalos[$i]["bd"];
        $hora_texto = $intervalos[$i]["texto"];

        // Junta el día y la hora en una sola cadena para tu campo 'fecha_hora_inicio'
        $fecha_hora_combinada = $fecha_reserva . " " . $hora_bd;

        // CONSULTA EN SINTAXIS PDO: Prepara la consulta de forma segura con marcadores (:pista, :fecha_hora)
        $sql = "SELECT id_reserva FROM reservas WHERE id_pista = :pista AND fecha_hora_inicio = :fecha_hora";
        
        $stmt = $conexion->prepare($sql); // Prepara la consulta de forma segura contra inyecciones
        
        // Ejecuta la consulta pasando las variables reales a los marcadores
        $stmt->execute([
            ':pista' => $id_pista_actual,
            ':fecha_hora' => $fecha_hora_combinada
        ]);

        // En PDO, cuenta las filas usando rowCount()
        if ($stmt->rowCount() > 0) {
            $esta_ocupada = true;
        } else {
            $esta_ocupada = false;
        }

        // CONTROL VISUAL: Si está ocupada, pinta el botón bloqueado
        if ($esta_ocupada == true) { ?>
            <button type="button" class="hora-ocupada" disabled><?php echo $hora_texto; ?> - Ocupado</button>
        <?php } 
        
        // Si está libre, pinta el formulario dinámico habitual
        else { ?>
            <form action="metodoPago.php" method="POST" style="display:inline;">
                <input type="hidden" name="id_pista" value="<?php echo $id_pista_actual; ?>">
                <input type="hidden" name="fecha" value="<?php echo $fecha_reserva; ?>">
                <input type="hidden" name="hora" value="<?php echo $hora_bd; ?>">
                <button type="submit"><?php echo $hora_texto; ?></button>
            </form>
        <?php } 
    } 
    ?>
</div>