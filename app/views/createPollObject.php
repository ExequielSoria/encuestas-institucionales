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

    <form action="?controller=Polls&action=CreatePollObject" method="POST">

        <label for="title">Título de la encuesta</label>
        <br>
        <input type="text" id="title" name="title" required>

        <br>
        
        <label for="description">Descripción</label>
        <br>
        <textarea id="description" name="description"></textarea>
        
        <br>
        <br>


        <label for="startDate">Fecha de inicio</label>
        <input type="date" id="startDate" name="startDate" required></input>

        <label for="endDate">Fecha de cierre</label>
        <input type="date" id="endDate" name="endDate" required></input>

        <br>
        <br>

        <label for="visibility">Privacidad de la encuesta</label>
        <select id="visibility" name="visibility" required>
            <option value="public">Pública</option>
            <option value="private">Privada</option>

        </select>
        <br>


        <h3>Rango de votantess</h3>

        <p>Carreras</p>

        <label>
            <input type="checkbox" name="careers[]" value="1"> Sistemas
        </label>


        <label>
            <input type="checkbox" name="careers[]" value="2"> Laboratorio
        </label>


        <label>
            <input type="checkbox" name="careers[]" value="3"> Analisis Clinicos
        </label>
        

        <label>
            <input type="checkbox" name="careers[]" value="4"> Contabilidad
        </label>

        <label>
            <input type="checkbox" name="careers[]" value="5"> Ambiental
        </label>

        <label>
            <input type="checkbox" name="careers[]" value="6"> Todas
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
            <input type="checkbox" name="years[]" value="4"> Todos
        </label>

        <br>

        <label for="color">Color de la encuesta</label>
        <select id="color" name="color" required>

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

        <button type="submit">Crear Encuesta</button>
    </form>

    <script>
    let cont = 0;

    function createCandidate() {
      cont++;
      const container = document.getElementById('candidatesContainer');

      const div = document.createElement('div');
      div.classList.add('candidate');
      div.innerHTML = `
        <input type="text" name="candidate${cont}[]" placeholder="Nombre del nuevo candidato" required>
        <input type="text" name="candidate${cont}[]" placeholder="Descripcion del nuevo candidato" required>
        <input type="text" name="candidate${cont}[]" placeholder="Edad del nuevo candidato" required>
        <input type="text" name="candidate${cont}[]" placeholder="Carrera del nuevo candidato" required>
        <input type="file" name="candidate${cont}[]" placeholder="Foto del nuevo candidato" required>





        <button type="button" onclick="eliminarOpcion(this)">Eliminar</button>
      `;

      container.appendChild(div);
    }

    function eliminarOpcion(boton) {
      boton.parentElement.remove();
    }
  </script>




</body>
</html>