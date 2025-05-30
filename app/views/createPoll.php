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
    
    <h1>Crea una nueva encuesta</h1>


    <form action="?controller=Polls&action=validatePoll" method="POST">

        <button type="submit" name="saveForm">Salvar formulario</button>

        <h3>Datos principales</h3>

        <label for="title">Título de la encuesta</label>
        <br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($form_data['title'] ?? '') ?>" notrequired>

        <br>
        
        <label for="description">Descripción</label>
        <br>
        <input type="text" id="description" name="description" value="<?= htmlspecialchars($form_data['description'] ?? '') ?>" >
        
        <br>
        <br>

        <h3>Plazos</h3>


        <label for="startDate">Fecha de inicio</label>
        <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($form_data['startDate'] ?? '') ?>" notrequired></input>

        <label for="endDate">Fecha de cierre</label>
        <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($form_data['endDate'] ?? '') ?>" notrequired></input>

        <br>
        <br>

        <h3>Privacidad</h3>


        <label for="visibility">Visibilidad de los resultados</label>
        <select id="visibility" name="visibility" value="<?= htmlspecialchars($form_data['visibility'] ?? '') ?>" notrequired>
            <option value="public" <?= ($form_data['visibility'] ?? '') === 'public' ? 'selected' : '' ?>>Pública</option>
            <option value="private" <?= ($form_data['visibility'] ?? '') === 'private' ? 'selected' : '' ?>>Privada</option>

        </select>
        <br>


        <h3>Carreras que pueden votar</h3>


        <label>
            <input type="checkbox" name="careers[]" value="sistemas" <?= in_array('sistemas', $careers) ? 'checked' : '' ?>> Sistemas
        </label>


        <label>
            <input type="checkbox" name="careers[]" value="laboratorio" <?= in_array('laboratorio', $careers) ? 'checked' : '' ?>> Laboratorio
        </label>


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
            <input type="checkbox" name="careers[]" value="all" <?= in_array('all', $careers) ? 'checked' : '' ?>> Todas
        </label>

        
        <h3>Años que pueden votar</h3>


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
            <input type="checkbox" name="years[]" value="all" <?= in_array('all', $years) ? 'checked' : '' ?>> Todos
        </label>

        <br>

        <h3>Apariencia</h3>

        <label for="color">Color de la encuesta</label>
        <select id="color" name="color" notrequired>

        <option value="1" <?= ($form_data['color'] ?? '') === '1' ? 'selected' : '' ?>>Opción 1</option>
        <option value="2" <?= ($form_data['color'] ?? '') === '2' ? 'selected' : '' ?>>Opción 2</option>
        <option value="3" <?= ($form_data['color'] ?? '') === '3' ? 'selected' : '' ?>>Opción 3</option>
        <option value="4" <?= ($form_data['color'] ?? '') === '4' ? 'selected' : '' ?>>Opción 4</option>
        <option value="5" <?= ($form_data['color'] ?? '') === '5' ? 'selected' : '' ?>>Opción 5</option>


        </select>

        <br>
        
        <h3>Candidatos</h3>


        <div id="candidatesContainer">
          <?php if (!empty($form_data['candidates'])): ?>
              <?php foreach ($form_data['candidates'] as $i => $candidate): ?>
                  <div class="candidate">
                      <input type="text" name="candidates[<?= $i ?>][name]" placeholder="Nombre del nuevo candidato" value="<?= htmlspecialchars($candidate['name'] ?? '') ?>">
                      <input type="text" name="candidates[<?= $i ?>][description]" placeholder="Descripcion del nuevo candidato" value="<?= htmlspecialchars($candidate['description'] ?? '') ?>">
                      <input type="text" name="candidates[<?= $i ?>][age]" placeholder="Edad del nuevo candidato" value="<?= htmlspecialchars($candidate['age'] ?? '') ?>">
                      <input type="text" name="candidates[<?= $i ?>][career]" placeholder="Carrera del nuevo candidato" value="<?= htmlspecialchars($candidate['career'] ?? '') ?>">
                      <!-- El campo foto no se puede prellenar por seguridad -->
                      <input type="file" name="candidate<?= $i ?>[photo]" placeholder="Foto del nuevo candidato">
                      <button type="button" onclick="deleteCandidate(this)">Eliminar</button>
                  </div>
              <?php endforeach; ?>
          <?php endif; ?>
      </div>

        <button type="button" onclick="createCandidate()">Crear candidato</button><br><br>

        <h3>Elecciones de la encuesta</h3>

        <div id="optionsContainer">
          <?php if (!empty($form_data['options'])): ?>
              <?php foreach ($form_data['options'] as $i => $option): ?>
                  <div class="option">
                      <input type="text" name="options[<?= $i ?>][name]" placeholder="Nombre de la opción" value="<?= htmlspecialchars($option['name'] ?? '') ?>">
                      <input type="text" name="options[<?= $i ?>][description]" placeholder="Descripción" value="<?= htmlspecialchars($option['description'] ?? '') ?>">
                      <input type="file" name="options[<?= $i ?>][photo]">
                      <button type="button" onclick="deleteOption(this)">Eliminar</button>
                  </div>
              <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <button type="button" onclick="createOption()">Crear Opcion</button><br><br>



        <button type="submit">Crear Encuesta</button>
    </form>

    <script>
    let cont = 0;
    let cont2 = 0;

    function createCandidate() {
      cont++;
      const container = document.getElementById('candidatesContainer');

      const div = document.createElement('div');
      div.classList.add('candidate');
      div.innerHTML = `
        <input type="text" name="candidates[${cont}][name]" placeholder="Nombre del nuevo candidato" required>
        <input type="text" name="candidates[${cont}][description]" placeholder="Descripción" required>
        <input type="text" name="candidates[${cont}][age]" placeholder="Edad" required>
        <input type="text" name="candidates[${cont}][career]" placeholder="Carrera" required>
        <input type="file" name="candidates[${cont}][photo]">

        <button type="button" onclick="deleteCandidate(this)">Eliminar</button>
      `;

      container.appendChild(div);
    }

    function deleteCandidate(boton) {
      boton.parentElement.remove();
    }


    function createOption() {
      cont2++;
      const container = document.getElementById('optionsContainer');

      const div = document.createElement('div');
      div.classList.add('option');
      div.innerHTML = `
        <input type="text" name="options[${cont2}][name]" placeholder="Nombre de la opcion" notrequired>
        <input type="text" name="options[${cont2}][description]" placeholder="Descripcion de la opcion" notrequired>
        <input type="file" name="options[${cont2}][photo]" placeholder="Foto de la opcion">

        <button type="button" onclick="deleteOption(this)">Eliminar</button>
      `;

      container.appendChild(div);
    }

    function deleteOption(boton) {
      boton.parentElement.remove();
    }

  </script>

<script>
  let cont = <?= isset($form_data['candidates']) ? count($form_data['candidates']) : 0 ?>;
  let cont2 = 0; // Lo mismo si querés persistir opciones
</script>

</body>
</html>