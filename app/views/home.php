<h1>Este es el home</h1>

<h3>Bienvenido <?php echo $_SESSION['username']; ?> </h3>
<p>Usuario N° <?php echo $_SESSION['id']; ?> </p>
<p>Identificado como <?php echo $_SESSION['role']; ?> </p>

<a href="?controller=users&action=endSession">Cerrar sesión</a>

<p>?controller=polls&action=prepareElections&id=8</p>

<h2>Encuestas</h2>
