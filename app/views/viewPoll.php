<?php

//var_dump($candidatesData);

//require_once __DIR__ . '/../models/PollsModels.php';

//Validaciones de seguridad


//var_dump($pollData);

//var_dump($creatorData);

//Preparo la fecha
$closeDate = $pollData['END_DATE'];

//Convierto a timestamp
$timestamp_close = strtotime($closeDate);

$pollData['START_DATE'] = date("d/m/Y", strtotime( $pollData['START_DATE'] ));
$pollData['END_DATE'] = date("d/m/Y", strtotime( $pollData['END_DATE'] ));



//Opcion multiple
if ($pollData['MULTIPLE_CHOICE'] == 1) {
    $pollData['MULTIPLE_CHOICE'] = "Opcion multiple";
} else {
    $pollData['MULTIPLE_CHOICE'] = "Una sola eleccion";
}

//Preparo los datos que vienen como string
$pollData['YEARS'] = json_decode($pollData['YEARS']);
$pollData['CAREERS'] = json_decode($pollData['CAREERS']);


//Verifico si dice todas
if ( in_array('ALL', $pollData['YEARS']) ){
    $pollData['YEARS'] = "Todos los años";
} else {
    $pollData['YEARS'] = implode(", ", $pollData['YEARS']);
}

//Verifico si dice todas
if ( in_array('ALL', $pollData['CAREERS']) ){
    $pollData['CAREERS'] = "Todas las carreras";
} else {
    $pollData['CAREERS'] = implode(", ", $pollData['CAREERS']);
}

//var_dump($optionsData);

?>

<!-- Lo paso al HTML con JavaScript -->
<script>
    const closeDateJS = <?= $timestamp_close * 1000 ?>; // JS usa milisegundos
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver encuesta</title>
    

<a href="?controller=views&action=home">Volver a inicio</a>

<h1> Encuesta numero <? echo $pollData['ID_POLL'];?> </h1>

<form action="?controller=views&action=viewPoll&id=" method="POST">
    <input type="number" name="idPoll" placeholder="ID de la encuesta" value="<?php echo $pollData['ID_POLL']; ?>" required>
    <input type="submit" name="send"value="Buscar encuesta">
</form>


<div class="time">
    <h3> Cierra en</h3>
    <h3 id="countdown"></h3>
</div>

<div class="marco">

    <style>
    
    #countdown{
        margin-left:10px;
    }

    .time{
        display:flex;
    }

    .marco {
        text-align: left;
        width:40%;
        border: 2px solid black;
        padding: 5px 10px 5px 10px;
        margin: 10px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }  </style>

    <h2> <? echo $pollData['TITLE'];?> </h2>

    <h3> Creada por <? echo $creatorData['USERNAME'];?> </h3>

    <p> <? echo $pollData['DESCRIPTION'];?> </p>

    <h3> Inicia el <? echo $pollData['START_DATE'];?> </h3>

    <h3> Termina el  <? echo $pollData['END_DATE'];?> </h3>

    <!-- <h3> Apariencia <? echo $pollData['COLOUR'];?> </h3> -->

    <h3> Carreras que votan <br> <? echo $pollData['CAREERS'];?> </h3>
    
    <h3> Años que votan <br> <? echo $pollData['YEARS'];?> </h3>

    <h3><? echo $pollData['MULTIPLE_CHOICE'];?> </h3>

    <?php if ($_SESSION['role'] == "ADMIN" || $creatorData['ID_USER'] == $_SESSION['id']): ?>
    <a href="?controller=Views&action=editPoll&id=<? echo $pollData['ID_POLL']; ?>">Editar encuesta</a>
    <br>
    <a href="?controller=Views&action=deletePoll&id=<? echo $pollData['ID_POLL']; ?>">Borrar encuesta</a>
    <?php endif; ?>
    

</div>

<h2> Resultados </h2>

<?php foreach ($candidatesData as $candidate): ?>
    
    <div class="marco">
        <h3> <? echo $candidate['NAME_CANDIDATE']; ?> </h3>
        <p> <? echo $candidate['INFO_CANDIDATE']; ?> </p>
        <p> <? echo $candidate['CAREER_CANDIDATE']; ?> </p>

        <h3>Votos: <?= $pollModel->votesCountCandidate($candidate['ID_CANDIDATE']) ?></h3>
        <h3>Votantes publicos</h3>
        <p><? echo implode(' , ', $pollModel->publicVotesCandidate($candidate['ID_CANDIDATE']) )  ;?></p>

    </div>
    <?php endforeach; ?>

<?php foreach ($optionsData as $option): ?>
    
<div class="marco">
    <h3><? echo $option['TITLE_OPTION']; ?> </h3>
    <p> <? echo $option['INFO_OPTION']; ?> </p>
        <h3>Votantes publicos</h3>
        <p><? echo implode(' , ', $pollModel->publicVotesOption($option['ID_OPTION']) )  ;?></p>

</div>
<?php endforeach; ?>

<!--  -->
<script>

    //Guardo el div "countdown"
    const countdownEl = document.getElementById("countdown");

    function refreshCountdown() {
        const ahora = new Date().getTime();
        const diferencia = closeDateJS - ahora;

        //Si llega a cero cambia el estado
        if (diferencia <= 0) {
            countdownEl.innerHTML = "Encuesta Cerrada";
            clearInterval(timer);
            return;
        }

        const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
        const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

        countdownEl.innerHTML = `${dias}d ${horas}h ${minutos}m ${segundos}s`;
    }

    refreshCountdown(); // Mostrar al instante
    const timer = setInterval(refreshCountdown, 1000);
</script>