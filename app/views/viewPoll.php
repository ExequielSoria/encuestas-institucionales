<?php

//Verifico el total de las encuestas
var_dump ($totalPolls);

$totalPolls = (int)$totalPolls;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    $id = $_POST['idPoll'];
    
    if( $id <= $totalPolls && $id > 0 ){
    echo "<script>window.location.href='?controller=views&action=viewPoll&id=$id';</script>";
    } else {
        echo "<script>alert('ID de encuesta no valido');</script> ";
        echo "<script>window.location.href='?controller=views&action=viewPoll&id=1';</script>";

    }
}


//Validaciones de seguridad


//var_dump($pollData);

//var_dump($creatorData);

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

<a href="?controller=views&action=home">Volver a inicio</a>

<h1> Encuesta numero <? echo $pollData['ID_POLL'];?> </h1>

<form action="?controller=views&action=viewPoll&id=" method="POST">
    <input type="number" name="idPoll" placeholder="ID de la encuesta" value="<?php echo $pollData['ID_POLL']; ?>" required>
    <input type="submit" name="send"value="Buscar encuesta">
</form>

<div class="marco">

    <style> .marco {
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
   
</div>

<h2> Resultados </h2>

<?php foreach ($candidatesData as $candidate): ?>
    
    <div class="marco">
        <h3> <? echo $candidate['NAME_CANDIDATE']; ?> </h3>
        <p> <? echo $candidate['INFO_CANDIDATE']; ?> </p>
        <p> <? echo $candidate['CAREER_CANDIDATE']; ?> </p>

        <h3> Votos: <? echo $candidate['VOTES_CANDIDATE']; ?> </h3> 
    </div>
    <?php endforeach; ?>

<?php foreach ($optionsData as $option): ?>
    
<div class="marco">
    <h3><? echo $option['TITLE_OPTION']; ?> </h3>
    <p> <? echo $option['INFO_OPTION']; ?> </p>
    <h3> Votos: <? echo $option['VOTES_OPTION']; ?> </h3> 
</div>
<?php endforeach; ?>
