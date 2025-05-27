<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea una encuesta</title>
</head>
<body>
    
    <h1>Crea una nueva encuesta</h1>

    <h3>Datos principales</h3>

    <form action="?controller=Polls&action=validatePoll" method="POST">

        <label for="title">Título de la encuesta</label>
        <br>
        <input type="text" id="title" name="title" notrequired>

        <br>
        
        <label for="description">Descripción</label>
        <br>
        <textarea id="description" name="description"></textarea>
        
        <br>
        <br>


        <label for="startDate">Fecha de inicio</label>
        <input type="date" id="startDate" name="startDate" notrequired></input>

        <label for="endDate">Fecha de cierre</label>
        <input type="date" id="endDate" name="endDate" notrequired></input>

        <br>
        <br>

        <label for="visibility">Privacidad de la encuesta</label>
        <select id="visibility" name="visibility" notrequired>
            <option value="public">Pública</option>
            <option value="private">Privada</option>

        </select>
        <br>


        <h3>Rango de votantess</h3>

        <p>Carreras</p>

        <label>
            <input type="checkbox" name="careers[]" value="sistemas"> Sistemas
        </label>


        <label>
            <input type="checkbox" name="careers[]" value="laboratorio"> Laboratorio
        </label>


        <label>
            <input type="checkbox" name="careers[]" value="clinico"> Analisis Clinicos
        </label>
        

        <label>
            <input type="checkbox" name="careers[]" value="contabilidad"> Contabilidad
        </label>

        <label>
            <input type="checkbox" name="careers[]" value="ambiental"> Ambiental
        </label>

        <label>
            <input type="checkbox" name="careers[]" value="all"> Todas
        </label>


        <p>Años</p>

        <label>
            <input type="checkbox" name="years[]" value="1"> 1° Año
        </label>


        <label>
            <input type="checkbox" name="years[]" value="2"> 2° Año
        </label>


        <label>
            <input type="checkbox" name="years[]" value="3"> 3° Año
        </label>

        <label>
            <input type="checkbox" name="years[]" value="all"> Todos
        </label>

        <br>

        <label for="color">Color de la encuesta</label>
        <select id="color" name="color" notrequired>

        <option value="1">Opción 1</option>
        <option value="2">Opción 2</option>
        <option value="3">Opción 3</option>
        <option value="4">Opción 4</option>
        <option value="5">Opción 5</option>

        </select>

        <br>
        
        <h3>Candidatos</h3>
        <div id="candidatesContainer">
        <!-- Acá se van a agregar los inputs dinámicos -->
        </div>

        <button type="button" onclick="createCandidate()">Crear candidato</button><br><br>



        <h3>Opciones</h3>
        <div id="optionsContainer">
        <!-- Acá se van a agregar los inputs dinámicos -->
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
        <input type="text" name="candidate${cont}[name]" placeholder="Nombre del nuevo candidato" notrequired>
        <input type="text" name="candidate${cont}[description]" placeholder="Descripcion del nuevo candidato" notrequired>
        <input type="text" name="candidate${cont}[age]" placeholder="Edad del nuevo candidato" notrequired>
        <input type="text" name="candidate${cont}[career]" placeholder="Carrera del nuevo candidato" notrequired>
        <input type="file" name="candidate${cont}[photo]" placeholder="Foto del nuevo candidato" notrequired>

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
        <input type="text" name="option${cont2}[name]" placeholder="Nombre de la opcion" notrequired>
        <input type="text" name="option${cont2}[description]" placeholder="Descripcion de la opcion" notrequired>
        <input type="file" name="option${cont2}[photo]" placeholder="Foto del nuevo candidato" notrequired>

        <button type="button" onclick="deleteOption(this)">Eliminar</button>
      `;

      container.appendChild(div);
    }

    function deleteOption(boton) {
      boton.parentElement.remove();
    }

  </script>




</body>
</html>