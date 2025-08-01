<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver usuario</title>

<a href="?controller=views&action=home">Volver a inicio</a>

<h1>Mostrando usuario <?php echo $idToSearch; ?> de <?php echo $usersCount; ?></h1>

<form action="?controller=views&action=viewUser&id=" method="POST">
    <input type="number" name="idUser" placeholder="ID del usuario" value="<?php echo $idToSearch; ?>" required>
    <input type="submit" name="send"value="Buscar usuario">
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

<h3>Nombre de usuario:</h3>

<p><?php echo $userData['USERNAME']; ?></p>


<h3>Rol del usuario</h3>

<p><?php echo $userData['ROLE']; ?></p>

<h3>Estado del usuario</h3>
<p><?php if ( $userData['STATUS'] == "1"){ echo "Activo"; } else { echo "Inactivo"; } ?></p>

<a href="?controller=views&action=editUser&id=<?php echo $idToSearch; ?>">Editar usuario</a>

</div>