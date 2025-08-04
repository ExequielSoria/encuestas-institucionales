<?php

//var_dump($userData);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
</head>
<body>

<a href="?controller=Views&action=home">Volver al inicio</a>

<h2>Editar usuario</h2>

<form action="?controller=Users&action=validateUserEdit" method="POST">

    <input type="hidden" name="idToEdit" value="<?php echo $userData['ID_USER']; ?>">

    <label for="editedUsername">Nombre de usuario:</label>

    <input type="text" name="editedUsername" value="<?php echo $userData['USERNAME']; ?>" required>
    
    <br>

    <label>Usuario activado

        <input type="checkbox" name="editedState" value="1" <?php echo ($userData['STATUS'] == '1') ? 'checked' : ''; ?>>

    </label>

    <br>
    <label>ADMINISTRADOR

    <input type="checkbox" name="editedRole" value="ADMIN" <?php echo ($userData['ROLE'] == 'ADMIN') ? 'checked' : ''; ?>>

    </label>

    <br>
    <input type="submit" value="Guardar cambios">
</form>

<h2>Actualizar contraseña</h2>

<form action="?controller=Users&action=validatePasswordUpdate" method="post">
    <input type="hidden" name="id" value="<?php echo $userData['ID_USER']; ?>">
    <label for="newPassword">Nueva contraseña:</label>
    <input type="password" name="newPassword" required>
    <br>
    <label for="confirmPassword">Confirmar contraseña:</label>
    <input type="password" name="confirmPassword" required>
    <br>
    <input type="submit" name="updatePassword" value="Actualizar contraseña">


</form>

</body>
</html>