<?php

var_dump ($_SESSION['pollData']);

$pollData = $_SESSION['pollData'] ?? [];

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir participantes</title>
</head>
<body>
    
<h2>Se añadiran selecciones a la siguiente encuesta:</h2>

<div>

    <h3><?= htmlspecialchars($pollData['TITLE'] ?? 'Encuesta sin título') ?></h3>
    <p><?= htmlspecialchars($pollData['DESCRIPTION'] ?? 'Sin descripción') ?></p>
    <p>Fecha de inicio: <?= htmlspecialchars($pollData['START_DATE'] ?? 'No definida') ?></p>
    <p>Fecha de cierre: <?= htmlspecialchars($pollData['END_DATE'] ?? 'No definida') ?></p>
    <p>Color: <?= htmlspecialchars($pollData['COLOUR'] ?? 'No definido') ?></p>
    <p>Tipo de encuesta: <?= htmlspecialchars($pollData['VISIBILITY'] ?? 'No definido') ?></p>
    <p>Permitir múltiples selecciones: <?= htmlspecialchars($pollData['MULTIPLE_CHOICE'] ?? 'No definido') ?></p>



</div>



</body>
</html>