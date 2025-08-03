<?php

//var_dump( $pollData );

//Recupero estas listas del formulario
$careers = $pollData['CAREERS'] ?? [];
$careers = json_decode($careers, true);

//var_dump($careers);

$years = $pollData['YEARS'] ?? [];
$years = json_decode($years, true);

//Sanitizo las fechas
$pollData['START_DATE'] = date("Y-m-d", strtotime($pollData['START_DATE'])) ?? '';
$pollData['END_DATE'] = date("Y-m-d", strtotime($pollData['END_DATE'])) ?? '';




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar encuesta</title>
</head>
<body>
   
<a href="?controller=views&action=home">Volver a inicio</a>  

  <form action="?controller=Polls&action=editPoll&id=<?= $pollId ?>" method="POST">

    <h2>Editar encuesta</h2>

    <h3>Informacion principal</h3>

    <input type="hidden" name="idPoll" value="<?= htmlspecialchars($pollData['ID_POLL'] ?? '') ?>">

    <label for="title">Título de la encuesta *</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($pollData['TITLE'] ?? '') ?>" required>

    <br>
    
    <label for="description">Descripción de la encuesta</label>
    
    <br>
    <textarea id="description" name="description" rows="4" cols="50"><?= htmlspecialchars($pollData['DESCRIPTION'] ?? '') ?></textarea>

    <h3>Plazos *</h3>

    <label for="startDate">Fecha de inicio</label>
    <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($pollData['START_DATE'] ?? '') ?>" required></input>

    <label for="endDate">Fecha de cierre</label>
    <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($pollData['END_DATE'] ?? '') ?>" required></input>

    <br>


    <h3>Apariencia</h3>

    <label for="colour">Color de la encuesta</label>
    <select id="colour" name="colour">
      <option value="1" <?= ($pollData['COLOUR'] ?? '') === '1' ? 'selected' : '' ?>>Opción 1</option>
      <option value="2" <?= ($pollData['COLOUR'] ?? '') === '2' ? 'selected' : '' ?>>Opción 2</option>
      <option value="3" <?= ($pollData['COLOUR'] ?? '') === '3' ? 'selected' : '' ?>>Opción 3</option>
      <option value="4" <?= ($pollData['COLOUR'] ?? '') === '4' ? 'selected' : '' ?>>Opción 4</option>
      <option value="5" <?= ($pollData['COLOUR'] ?? '') === '5' ? 'selected' : '' ?>>Opción 5</option>
    </select>




    <h3>¿Quienes votan?</h3>

    <h4>Carreras</h4>

    <label> <input type="checkbox" name="careers[]" value="sistemas" <?= in_array('sistemas', $careers) ? 'checked' : '' ?>> Sistemas </label>

    <label> <input type="checkbox" name="careers[]" value="laboratorio" <?= in_array('laboratorio', $careers) ? 'checked' : '' ?>> Laboratorio </label>


    <label>
        <input type="checkbox" name="careers[]" value="clinico" <?= in_array('clinico', $careers) ? 'checked' : '' ?>> Analisis Clinicos
    </label>
    

    <label>
        <input type="checkbox" name="careers[]" value="contabilidad" <?= in_array('contabilidad', $careers) ? 'checked' : '' ?>> Contabilidad
    </label>

    <label>
        <input type="checkbox" name="careers[]" value="ambiental" <?= in_array('ambiental', $careers) ? 'checked' : '' ?>> Ambiental
    </label>

    <label>
        <input type="checkbox" name="careers[]" value="ALL" <?= in_array('ALL', $careers) ? 'checked' : '' ?>> Todas
    </label>

    
    <h4>Años</h4>


    <label>
        <input type="checkbox" name="years[]" value="1" <?= in_array('1', $years) ? 'checked' : '' ?>> 1° Año
    </label>


    <label>
        <input type="checkbox" name="years[]" value="2" <?= in_array('2', $years) ? 'checked' : '' ?>> 2° Año
    </label>


    <label>
        <input type="checkbox" name="years[]" value="3" <?= in_array('3', $years) ? 'checked' : '' ?>> 3° Año
    </label>

    <label>
        <input type="checkbox" name="years[]" value="ALL" <?= in_array('ALL', $years) ? 'checked' : '' ?>> Todos
    </label>

    <h3>Votaciones</h3>

    <label for="multipleChoice">

      Permitir múltiples opciones
      <input type="checkbox" id="multipleChoice" name="multipleChoice" value="1" <?= isset($pollData['MULTIPLE_CHOICE']) && $pollData['MULTIPLE_CHOICE'] ? 'checked' : '' ?>>

    </label>

    <br>
    <br>

    <label for="visibility">Resultados visibles para</label>
    <select id="visibility" name="visibility" value="<?= htmlspecialchars($pollData['VISIBILITY'] ?? '') ?>">
        <option value="public" <?= ($pollData['VISIBILITY'] ?? '') === 'public' ? 'selected' : '' ?>>Todos</option>
        <option value="private" <?= ($pollData['VISIBILITY'] ?? '') === 'private' ? 'selected' : '' ?>>Solo directivos</option>

    </select>

    <br>
    <br>

    <button type="submit" name="sendForm" >Guardar cambios</button>
    </form>



</body>
</html>