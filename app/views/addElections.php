<?php
$pollData = $_SESSION['pollData'] ?? [];

$pollMultipleChoice = "No definido";

if ( $pollData['MULTIPLE_CHOICE'] == "1" ){

    $pollMultipleChoice = "Se permiten múltiples elecciones";

} else if ( $pollData['MULTIPLE_CHOICE'] == "0" ){

    $pollMultipleChoice = "No se permiten múltiples elecciones";
}

$pollVisibility = "No definido";

if ( $pollData['VISIBILITY'] == "public" ){

    $pollVisibility = "Resultados visibles para todos";

} else if ( $pollData['VISIBILITY'] == "private" ){

    $pollVisibility = "Resultados visibles para directivos";
}

//var_dump($pollData);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir elecciones</title>
</head>
<body>
    
<a href="?controller=views&action=home">Volver a inicio</a>

<div>
    <h1><?= htmlspecialchars($pollData['TITLE'] ?? 'Encuesta sin título') ?></h1>
    <p><?= htmlspecialchars($pollData['DESCRIPTION'] ?? 'Sin descripción') ?></p>
    <p><?= htmlspecialchars($pollVisibility) ?></p>
    <p><?= htmlspecialchars($pollMultipleChoice) ?></p>

</div>


<h2>Añadir candidato</h2>

<form action="?controller=Polls&action=validateCandidate" method="post">

    <label for="candidateName">Nombre del candidato</label>
    <input type="text" name="candidateName" required>

    <br>

    <label for="candidateInfo">Informacion del candidato</label>
    <input type="text" name="candidateInfo" required>

    <br>

    <label for="candidateAge">Edad del candidato</label>
    <input type="text" name="candidateAge">

    <br>

    <label for="candidateCareer">Carrera del candidato</label>
    <input type="text" name="candidateCareer">

    <br>

    <label for="candidatePhoto">Foto del candidato</label>
    <input type="file" name="candidatePhoto">
    
    <br>
    <br>

    <button type="submit" name="sendCandidate" >Añadir candidato</button>

</form>

<h2>Añadir opcion</h2>

<form action="?controller=Polls&action=validateOption" method="post">

    <label for="optionTitle">Titulo de la opcion</label>
    <input type="text" name="optionTitle" required>

    <br>

    <label for="optionInfo">Informacion de la opcion</label>
    <input type="text" name="optionInfo" required>

    <br>

    <label for="optionPhoto">Foto de la opcion</label>
    <input type="file" name="optionPhoto">
    
    <br>
    <br>

    <button type="submit" name="sendOption" >Añadir opcion</button>

</form>

<br>

<a href="?controller=views&action=viewPoll&id=<?php echo $pollData['ID_POLL'];?> ">Ver encuesta</a>


</body>
</html>