<h1>Este es el home</h1>

<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>
<p>Usuario N° <?php echo $_SESSION['id']; ?> </p>
<p>Identificado como <?php echo $_SESSION['role']; ?> </p>


<a href="?controller=views&action=createPoll">Crear una encuesta</a>


<br>
<br>

<a href="?controller=users&action=endSession">Cerrar sesión</a>

<p>Para añadir elecciones por id ?controller=polls&action=prepareElections&id=x</p>

<p>Para ver las encuestas por id ?controller=views&action=viewPoll&id=x</p>


<h2>Encuestas</h2>
