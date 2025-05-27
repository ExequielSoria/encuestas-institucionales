<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea una encuesta</title>
</head>
<body>
    
    <h1>Crea una nueva encuesta</h1>
    <form action="?controller=Polls&action=CreatePollCandidate" method="POST">

        <label for="title">Nombre del candidato</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Descripción:</label>
        <textarea id="description" name="description"></textarea>
        
        <label for="options">Opciones (una por línea):</label>
        <textarea id="options" name="options" required></textarea>
        
        <button type="submit">Crear Encuesta</button>
    </form>

</body>
</html>