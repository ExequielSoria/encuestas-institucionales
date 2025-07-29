<?php
session_start();    

?>

<h1>Este es el home</h1>

<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>
<p>Usuario N° <?php echo $_SESSION['id']; ?> </p>
<p>Identificado como <?php echo $_SESSION['role']; ?> </p>

<a href="?controller=users&action=endSession">Cerrar sesión</a>


<style> .marco {
    text-align:center;
    border: 2px solid black;
    padding: 5px 10px 5px 10px;
    width: 30%;
    margin: 10px;
    background-color: #f9f9f9;
    border-radius: 10px;
    }
</style>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN"): ?>

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

        <a href="?controller=views&action=createPoll">Mis encuestas</a>


    </div>
<?php endif; ?>



<?php if (isset($_SESSION['role']) && $_SESSION['role'] == "CREATOR"): ?>
    <div class="marco">
        
        <h3>Panel de Creador</h3>

        <a href="?controller=views&action=createPoll">Crear encuesta</a>

        <br>

        <a href="?controller=views&action=createPoll">Ver encuesta</a>

        <br>

        <a href="?controller=views&action=createPoll">Mis encuestas</a>

    </div>
<?php endif; ?>

<br>
<br>

<p>Para añadir elecciones por id ?controller=polls&action=prepareElections&id=x</p>

<p>Para ver las encuestas por id ?controller=views&action=viewPoll&id=x</p>


<h2>Encuestas</h2>

<div class="marco">

    <h3>Boca el mas grande</h3>
    <p>Creada por Exequiel Soria</p>
    <p>¿Boca sera el equipo mas grande del mundo? jaja</p>
    <p> Cierra el 28/09/25 </p>

    <a href="?controller=views&action=viewPoll&id=1">Ver encuesta</a>

</div>
