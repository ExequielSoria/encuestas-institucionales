<?php

//var_dump($userInfo);

?>

<style> 
.pollsSection {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.marco {
    text-align:center;
    border: 2px solid black;
    padding: 5px 10px 5px 10px;
    width: 30%;
    margin: 10px;
    background-color: #f9f9f9;
    border-radius: 10px;
    }
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas de <?= htmlspecialchars($userInfo["USERNAME"]) ?></title>
</head>
<body>

<a href="?controller=views&action=home">Volver a inicio</a>

<h2>Todas las encuestas creadas por <?= htmlspecialchars($userInfo["USERNAME"]) ?></h2>

<section class="pollsSection">
    <?php foreach ($userPolls as $userPoll): ?>
        <div class="marco">
            <h3><?= htmlspecialchars($userPoll["TITLE"]) ?></h3>
            <?php if (!empty($userPoll["DESCRIPTION"])): ?>
                <p><?= htmlspecialchars($userPoll["DESCRIPTION"]) ?></p>
            <?php endif; ?>

            <?php if( $userPoll["STATUS"] == 3 ) : ?>
                <p> ENCUESTA CERRADA </p>
            <?php endif; ?>

            <?php if( $userPoll["STATUS"] != 3 ) : ?>
                <p> Cierra el <?= date("d/m/y", strtotime($userPoll["END_DATE"])) ?> </p>
            <?php endif; ?>

            <a href="?controller=views&action=votePoll&id=<?= $userPoll["ID_POLL"] ?>">Votar</a>


            <a href="?controller=views&action=viewPoll&id=<?= $userPoll["ID_POLL"] ?>">Ver resultados</a>

            <?php  if( ( in_array( "ALL" , json_decode( $userPoll['CAREERS'], true ) ) || in_array( $_SESSION['career'] , json_decode( $userPoll['CAREERS'], true ) ) ) && ( in_array( "ALL" , json_decode( $userPoll['YEARS'], true ) ) || in_array( $_SESSION['year'] , json_decode( $userPoll['YEARS'], true ) ) ) && $userPoll['STATUS'] != 3): ?>
                <p>PODES VOTAR</p>
            <?php endif;?>

        </div>
        <?php endforeach; ?>
</section>

    
</body>
</html>