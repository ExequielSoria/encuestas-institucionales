<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Encuesta</title>
</head>
<body>
    <a href="?controller=views&action=home">Volver a inicio</a>
    <h1>Seguro que desea eliminar la encuesta?</h1>
    <form action="?controller=polls&action=deletePoll" method="POST">
        <input type="hidden" name="idPoll" value="<?php echo $pollId; ?>">
        
        <h2><?php echo $pollData['TITLE']; ?></h2>
        <p><?php echo $pollData['DESCRIPTION']; ?></p>
        <p> Creada por <?php echo $creatorData['USERNAME']; ?> </p>


        <button type="submit">Eliminar</button>
    </form>


</body>
</html>