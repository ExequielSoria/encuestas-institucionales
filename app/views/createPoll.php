<?php
session_start();
//Recupero el formulario almacenado en la sesion
$form_data = $_SESSION['form_data'] ?? [];

//Recupero estas listas del formulario
$careers = $form_data['careers'] ?? [];
$years = $form_data['years'] ?? [];


//var_dump( $form_data );

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea una encuesta</title>
</head>
<body>
    
  
  <form action="?controller=Polls&action=validatePoll" method="POST">
  
    <h2>Crear nueva encuesta</h2>
  
    <button type="submit" name="saveForm">Salvar en cache</button>

    <h3>Informacion principal</h3>

    <label for="title">Título de la encuesta *</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($form_data['title'] ?? '') ?>" required>

    <br>
    
    <label for="description">Descripción de la encuesta</label>
    <input type="text" id="description" name="description" value="<?= htmlspecialchars($form_data['description'] ?? '') ?>" >
    
    <br>

    <h3>Plazos *</h3>

    <label for="startDate">Fecha de inicio</label>
    <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($form_data['startDate'] ?? '') ?>" required></input>

    <label for="endDate">Fecha de cierre</label>
    <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($form_data['endDate'] ?? '') ?>" required></input>

    <br>


    <h3>Apariencia</h3>

    <label for="color">Color de la encuesta</label>
    <select id="color" name="color">
      <option value="1" <?= ($form_data['color'] ?? '') === '1' ? 'selected' : '' ?>>Opción 1</option>
      <option value="2" <?= ($form_data['color'] ?? '') === '2' ? 'selected' : '' ?>>Opción 2</option>
      <option value="3" <?= ($form_data['color'] ?? '') === '3' ? 'selected' : '' ?>>Opción 3</option>
      <option value="4" <?= ($form_data['color'] ?? '') === '4' ? 'selected' : '' ?>>Opción 4</option>
      <option value="5" <?= ($form_data['color'] ?? '') === '5' ? 'selected' : '' ?>>Opción 5</option>
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
      <input type="checkbox" id="multipleChoice" name="multipleChoice" value="1" <?= isset($form_data['multipleChoice']) && $form_data['multipleChoice'] ? 'checked' : '' ?>>

    </label>

    <br>
    <br>

    <label for="visibility">Resultados visibles para</label>
    <select id="visibility" name="visibility" value="<?= htmlspecialchars($form_data['visibility'] ?? '') ?>">
        <option value="public" <?= ($form_data['visibility'] ?? '') === 'public' ? 'selected' : '' ?>>Todos</option>
        <option value="private" <?= ($form_data['visibility'] ?? '') === 'private' ? 'selected' : '' ?>>Solo directivos</option>

    </select>

    <br>
    <br>

    <button type="submit">Crear encuesta</button>
    </form>


</body>
</html>