<?php
session_start();    

?>

<h1>Este es el home</h1>

<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>
<p>Usuario N° <?php echo $_SESSION['id']; ?> </p>
<p>Identificado como <?php echo $_SESSION['role']; ?> </p>

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
    <?php foreach ($homePolls as $homePoll): ?>
        <div class="marco">
            <h3><?= htmlspecialchars($homePoll["TITLE"]) ?></h3>

            <p>Creada por <a href="?controller=views&action=userPolls&id=<?= $usersController->getUserInfoById($homePoll["ID_USER"])['ID_USER'] ?>"><?= $usersController->getUserInfoById($homePoll["ID_USER"])['USERNAME'] ?> </a> </p>

            <?php if (!empty($homePoll["DESCRIPTION"])): ?>
                <p><?= htmlspecialchars($homePoll["DESCRIPTION"]) ?></p>
            <?php endif; ?>

            <p> Cierra el <?= date("d/m/y", strtotime($homePoll["END_DATE"])) ?> </p>

            <a href="?controller=views&action=viewPoll&id=<?= $homePoll["ID_POLL"] ?>">Ver encuesta</a>
        </div>
        <?php endforeach; ?>
</section>

