<?php
session_start();    

//var_dump($lastestPolls);
//var_dump($_SESSION['career']);

?>
<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>

<?php if($_SESSION['role'] == "ADMIN" ): ?>

    <p>Usuario con ID <?php echo $_SESSION['id']; ?> </p>

<?php endif; ?>

<?php if($_SESSION['role'] == "VOTER" ): ?>

    <p>Estudiante con ID <?php echo $_SESSION['idVoter']; ?> </p>

<?php endif; ?>


<p>Con rol de  <?php echo $_SESSION['role']; ?> </p>

<a href="?controller=users&action=endSession">Cerrar sesión</a>


<!--<p>Para añadir elecciones por id ?controller=polls&action=prepareElections&id=x</p>

<p>Para ver las encuestas por id ?controller=views&action=viewPoll&id=x</p>

-->
<style> 
h2{
    text-align: center;
    margin-top: 20px;
}

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

.panelContainer {
    display: flex;
    justify-content: center;
    width: 100%;
    }
</style>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN"): ?>

    <h2>Panel de Admin</h2>

    <div class="panelContainer">

    <div class="marco">
        
        <h3>Panel de Admin</h3>

        <a href="?controller=views&action=createUser">Crear usuario</a>

        <br>

        <a href="?controller=views&action=viewUser&id=1">Ver usuario</a>

        <br>
        <br>

        <a href="?controller=views&action=createPoll">Crear encuesta</a>

        <br>

        <a href="?controller=views&action=viewPoll&id=1">Ver encuesta</a>

        <br>

        <a href="?controller=views&action=userPolls&id=<?php echo $_SESSION['id']; ?>">Mis encuestas</a>


    </div>

    </div>

<?php endif; ?>



<?php if (isset($_SESSION['role']) && $_SESSION['role'] == "CREATOR"): ?>

    <h2>Panel de Creador</h2>

    <div class="panelContainer">

    <div class="marco">
        
        <h2>Panel de Creador</h2>

        <a href="?controller=views&action=createPoll">Crear encuesta</a>

        <br>

        <a href="?controller=views&action=viewPoll&id=1">Ver encuesta</a>

        <a href="?controller=views&action=userPolls&id=<?php echo $_SESSION['id']; ?>">Mis encuestas</a>


    </div>

    </div>
<?php endif; ?>

<h2>Ultimas encuestas</h2>

<section class="pollsSection">
    <?php foreach ($lastestPolls as $lastestPoll): ?>
        <div class="marco">
            <h3><?= htmlspecialchars($lastestPoll["TITLE"]) ?></h3>

            <p>Creada por <a href="?controller=views&action=userPolls&id=<?= $usersController->getUserInfoById($lastestPoll["ID_USER"])['ID_USER'] ?>"><?= $usersController->getUserInfoById($lastestPoll["ID_USER"])['USERNAME'] ?> </a> </p>

            <?php if (!empty($lastestPoll["DESCRIPTION"])): ?>
                <p><?= htmlspecialchars($lastestPoll["DESCRIPTION"]) ?></p>
            <?php endif; ?>

            <p> Cierra el <?= date("d/m/y", strtotime($lastestPoll["END_DATE"])) ?> </p>

                <?php if ( $_SESSION['role'] == "ADMIN" ) : ?>

                    <p>estado: <?= $lastestPoll["STATUS"] == 1 ? "Activa" : "Inactiva" ?></p>

                <?php endif; ?>

            <a href="?controller=views&action=votePoll&id=<?= $lastestPoll["ID_POLL"] ?>">Votar</a>
            <a href="?controller=views&action=viewPoll&id=<?= $lastestPoll["ID_POLL"] ?>">Ver resultados</a>

            <!-- el peor pedazo de codigo que escribi jamas... a tener en cuenta para mejorarlo-->
            <?php  if( ( in_array( "ALL" , json_decode( $lastestPoll['CAREERS'], true ) ) || in_array( $_SESSION['career'] , json_decode( $lastestPoll['CAREERS'], true ) ) ) && ( in_array( "ALL" , json_decode( $lastestPoll['YEARS'], true ) ) || in_array( $_SESSION['year'] , json_decode( $lastestPoll['YEARS'], true ) ) ) && $lastestPoll['STATUS'] != 2): ?>
                <p>PODES VOTAR</p>
            <?php endif;?>
            
        </div>
        <?php endforeach; ?>
</section>

