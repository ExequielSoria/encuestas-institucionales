<h1>Este es el home</h1>

<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>
<p>Usuario N° <?php echo $_SESSION['id']; ?> </p>
<p>Identificado como <?php echo $_SESSION['role']; ?> </p>

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

<div class="marco">
    
    <h3>Panel de Admin</h3>

    <a href="?controller=views&action=createUser">Crear usuario</a>

    <br>

    <a href="?controller=views&action=viewUser&id=1">Ver usuario</a>

    <br>
    <br>

    <a href="?controller=views&action=createPoll">Crear encuesta</a>

    <br>

    <a href="?controller=views&action=createPoll">Ver encuesta</a>

</div>

<div class="marco">
    
    <h3>Panel de Creador</h3>

    <a href="?controller=views&action=createPoll">Crear encuesta</a>

    <br>

    <a href="?controller=views&action=createPoll">Ver encuesta</a>

</div>


<br>
<br>

<a href="?controller=users&action=endSession">Cerrar sesión</a>

<p>Para añadir elecciones por id ?controller=polls&action=prepareElections&id=x</p>

<p>Para ver las encuestas por id ?controller=views&action=viewPoll&id=x</p>


<h2>Encuestas</h2>
