<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    
<h2>Iniciar Sesión</h2>
<form method="POST" action="?controller=users&action=login">
    <input type="text" name="username" placeholder="Usuario o Legajo"><br>
    <input type="password" name="password" placeholder="Contraseña"><br>
    Creador/Administrador<input type="checkbox" name="isCreator"><br>
    <button type="submit">Ingresar</button>
</form>

</body>
</html>

<?php
