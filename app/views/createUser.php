<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un usuario</title>
</head>
<body>
    
<h2>Crea un usuario</h2>
<form method="POST" action="index.php?controller=users&action=create">

    <input type="text" name="newUsername" placeholder="Nombre de usuario"><br>
    <input type="password" name="newPassword" placeholder="Constraseña"><br>
    <input type="checkbox" name="isAdmin">Administrador<br>
    <button type="submit">Crear</button>

</form>


</body>
</html>