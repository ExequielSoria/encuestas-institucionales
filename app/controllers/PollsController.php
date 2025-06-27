<?php

require_once __DIR__ . '/../models/PollsModel.php';

class PollsController {

    //El formulario de crear encuesta apunta a esta funcion
    public function createPoll(){

        //Valido la encuesta y la guardo
        $currentPoll = $this->validatePoll();

        var_dump($currentPoll);

        //Si la encuesta es valida, la guardo en la base de datos y redirijo con el id de la encuesta creada
        if ($currentPoll != false){
            $pollId = PollsModel::createPoll($currentPoll);

            echo '<script>window.location.href="?controller=polls&action=prepareElections&id=' . $pollId . '";</script>';

        } else {
            echo '<script>window.location.href="?controller=views&action=createPoll";</script>';
        }
    }


    //Funcion que debe ser llamada para cargar los datos de una encuesta antes de añadirle opciones
    public function prepareElections($pollId){

        echo "Preparando elecciones...";

        //verifica el dueño y guarda la encuesta en la variable
        $poll = $this->verifyOwner();

        //Si es el dueño lo redirijo a la vista de añadir selecciones y paso la encuesta por POST
        if ($poll != false) {
            $_SESSION['pollData'] = $poll;
            echo '<script>window.location.href="?controller=views&action=AddElections&id=' . $pollId . '";</script>';
        }
    }

    //Funcion a la que apunta el formulario de añadir candidatos. DEBE ESTAR PREVIAMENTE CARGADA CON prepareElections
    public function validateCandidate(){

        //Guardo el form en la sesion al enviarse el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['sendCandidate'] ) ) {
            $_SESSION['candidateData'] = $_POST;        
        }

        //Contador de validaciones
        $_SESSION['greenFlags'] = 0;

        //NOMBRE
        if ( isset($_POST['candidateName']) && ($_POST['candidateName'] != '') && strlen($_POST['candidateName']) > 0 && strlen($_POST['optionTitle']) < 100  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $candidateData['candidateName'] = $_POST['candidateName'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de candidato no valido";
        }

        //INFO
        if ( strlen($_POST['candidateInfo']) < 255  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $candidateData['candidateInfo'] = $_POST['candidateInfo'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Descripcion de candidato no valido";
        }

        //EDAD
        if ( isset($_POST['candidateAge']) && is_numeric($_POST['candidateAge']) && $_POST['candidateAge'] > 0 && $_POST['candidateAge'] < 126 ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $candidateData['candidateAge'] = $_POST['candidateAge'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Edad de candidato no valida";
        }

        //CARRERA
        if ( strlen($_POST['candidateCareer']) < 20  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $candidateData['candidateCareer'] = $_POST['candidateCareer'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Descripcion de candidato no valido";
        }



        //ID DE LA ENCUESTA
        if( isset( $_SESSION['pollData'] ) ){
            $pollData = $_SESSION['pollData'];            
            $idCreatedPoll = $pollData['ID_POLL'];

            $candidateData['idPoll'] = $idCreatedPoll;
            $_SESSION['greenFlags']++;
        }


        //VALIDACION FINAL, SI TODO ESTA BIEN DEVUELVO DATA
        if ($_SESSION['greenFlags'] == 5 && isset($_POST['sendCandidate']) && ($_SESSION['role'] == "ADMIN"  || $_SESSION['role'] == "CREATOR") ) {

            // Limpio los datos del formulario 
            //unset($_SESSION['candidateData']);
            
            //var_dump($candidateData);

            $createdCandidate = PollsModel::createCandidate($candidateData);
            
            echo '<script> alert("Se añadio correctamente al candidato"); </script>';

            //var_dump($createdCandidate);
            echo '<script>window.location.href="?controller=polls&action=prepareElections&id=' . $idCreatedPoll . '";</script>';

        } else {
            // Si no, muestro un mensaje de error
            echo "Algo salio mal, no se añadio la opcion";
            echo '<script> alert("NO se añadio al candidato"); </script>';
            echo '<script>window.location.href="?controller=polls&action=prepareElections&id=' . $idCreatedPoll . '";</script>';

            return false;
        }

        //Las carga a la base de datos

        //Redirige a la vista de VER la encuesta con el id por get
        //O sea, http://localhost:8085/index.php?controller=polls&action=viewPoll&id=X

    }

    //Funcion a la que apunta el formulario de añadir selecciones. DEBE ESTAR PREVIAMENTE CARGADA CON prepareElections
    public function validateOption(){

        //Guardo el form en la sesion al enviarse el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['sendOption'] ) ) {
            $_SESSION['optionData'] = $_POST;        
        }

        //Contador de validaciones
        $_SESSION['greenFlags'] = 0;

        //TITULO
        if ( isset($_POST['optionTitle']) && ($_POST['optionTitle'] != '') && strlen($_POST['optionTitle']) > 0 && strlen($_POST['optionTitle']) < 100  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['optionTitle'] = $_POST['optionTitle'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de encuesta no valido";
        }

        //INFO
        if ( strlen($_POST['optionInfo']) < 255  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['optionInfo'] = $_POST['optionInfo'];

            $_SESSION['greenFlags']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Descripcion de encuesta no valido";
        }

        //ID DE LA ENCUESTA
        if( isset( $_SESSION['pollData'] ) ){
            $pollData = $_SESSION['pollData'];            
            $idCreatedPoll = $pollData['ID_POLL'];

            $data['idPoll'] = $idCreatedPoll;
            $_SESSION['greenFlags']++;
        }


        //VALIDACION FINAL, SI TODO ESTA BIEN DEVUELVO DATA
        if ($_SESSION['greenFlags'] == 3 && isset($_POST['sendOption']) && ($_SESSION['role'] == "ADMIN"  || $_SESSION['role'] == "CREATOR") ) {

            // Limpio los datos del formulario 
            unset($_SESSION['optionData']);
            
            $createdOption = PollsModel::createOption($data);
            
            echo 'Opcion añadida correctamente';
            echo '<script> alert("Se añadio correctamente la opcion"); </script>';
            echo '<script>window.location.href="?controller=polls&action=prepareElections&id=' . $idCreatedPoll . '";</script>';



        } else {
            // Si no, muestro un mensaje de error
            echo "Algo salio mal, no se añadio la opcion";
            echo '<script> alert("No se añadio la opcion"); </script>';
            echo '<script>window.location.href="?controller=polls&action=prepareElections&id=' . $idCreatedPoll . '";</script>';

            return false;
        }

        //Las carga a la base de datos

        //Redirige a la vista de VER la encuesta con el id por get
        //O sea, http://localhost:8085/index.php?controller=polls&action=viewPoll&id=X

    }

    //Funcion encargada de verificar si el usuario es el dueño de la encuesta
    public function verifyOwner(){
        if ( isset($_GET['id']) && is_numeric($_GET['id']) ) {

            //Extraigo el id que viene por GET
            $pollId = $_GET['id'];
            $pollData = PollsModel::getPollById($pollId);

            //Doy luz verde si el usuario es el dueño de la encuesta o es admin
            if( $pollData['ID_USER'] == $_SESSION['id'] || $_SESSION['role'] == "ADMIN" ) {
                return $pollData;
            } else {

                echo " <script> alert('No tienes permiso para acceder a esta encuesta'); </script>";
                echo '<script>window.location.href="?controller=views&action=home";</script>';


                return false;
            }
        }
    }

    //Aca valido que los datos del formulario esten bien y devuelvo 
    public function validatePoll() {
        
        //Guarda el form en la sesion si esta marcada la opcion
        if ( isset($_POST['saveForm']) ) {
            $_SESSION['form_data'] = $_POST;

            //redirijo a la vista de crear encuesta
           echo "<script>window.location.href='?controller=views&action=CreatePoll';</script>";
        }

        //Guardo el form en la sesion al enviarse el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['sendForm'] ) ) {
            $_SESSION['form_data'] = $_POST;
        
        }

        //Contador de validaciones
        $_SESSION['counter'] = 0;

        //TITULO
        if ( isset($_POST['optionTitle']) && ($_POST['optionTitle'] != '') && strlen($_POST['optionTitle']) > 0 && strlen($_POST['optionTitle']) < 100  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['optionTitle'] = $_POST['optionTitle'];

            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de encuesta no valido";
        }

        //DESCRIPCION
        if ( strlen($_POST['optionInfo']) < 255  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['optionInfo'] = $_POST['optionInfo'];

            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Descripcion de encuesta no valido";
        }

        //PLAZOS
        $startDate = new DateTime($_POST['startDate']);
        $endDate = new DateTime($_POST['endDate']);

        if ( isset($_POST['startDate']) && isset($_POST['endDate']) && $startDate < $endDate ) {
            // Si todos los campos  estan bien, lo añado al array de datos y sumo el contador
            $data['startDate'] = $_POST['startDate'];
            $data['endDate'] = $_POST['endDate'];

            $_SESSION['counter']++;
        } else {
            // Si no, muestro un mensaje de error
            echo "Fechas no validas";
        }

        //APARIENCIA
        if ( isset($_POST['colour']) && ($_POST['colour'] != '') ) {
            //Si el color es valido, lo añado al array de datos y sumo el contador
            $data['colour'] = $_POST['colour'];

            $_SESSION['counter']++;
        } else {
            $data['colour'] = "1"; // Por defecto es el colour 1
            $_SESSION['counter']++;

        }

        //CARRERAS
        if ( isset($_POST['careers']) && is_array($_POST['careers']) && count($_POST['careers']) > 0 ) {
            //Si las carreras son validas, las añado al array de datos y sumo el contador
            $data['careers'] =  json_encode( $_POST['careers'] );

            $_SESSION['counter']++;
        } else {
            $data['careers'] = json_encode(["ALL"]);
            $_SESSION['counter']++;

            
        }

        //AÑOS
        if ( isset($_POST['years']) && is_array($_POST['years']) && count($_POST['years']) > 0 ) {
            //Si los años son validos, los añado al array de datos y sumo el contador
            $data['years'] = json_encode( $_POST['years'] );

            $_SESSION['counter']++;

        } else {
            $data['years'] = json_encode(["3"]);
            $_SESSION['counter']++;

        }

        //MULTIPLE CHOICE
        if ( isset($_POST['multipleChoice']) && ($_POST['multipleChoice'] != '') ) {
            // Si el campo multipleChoice esta marcado, lo añado al array de datos y sumo el contador
            $data['multipleChoice'] = 1;

            $_SESSION['counter']++;

        } else {
            $data['multipleChoice'] = 0; // Por defecto es 0
            $_SESSION['counter']++;

        }

        //VISIBILIDAD
        if ( isset($_POST['visibility']) && ($_POST['visibility'] != '') ) {
            //echo 'visibilidad valida';
            $data['visibility'] = $_POST['visibility'];
            $_SESSION['counter']++;
        } else {
            $date['visibility'] = "public"; // Por defecto es publica
            $_SESSION['counter']++;

        }
        
        //VALIDACION FINAL, SI TODO ESTA BIEN DEVUELVO DATA
        if ($_SESSION['counter'] == 8 && isset($_POST['sendForm']) && ($_SESSION['role'] == "ADMIN"  || $_SESSION['role'] == "CREATOR") ) {

            // Limpio los datos del formulario 
            unset($_SESSION['form_data']);
            
            return $data;

        } else {
            // Si no, muestro un mensaje de error
            echo "Algo salio mal, no se creo la encuesta";
            return false;
        }
    }
}

