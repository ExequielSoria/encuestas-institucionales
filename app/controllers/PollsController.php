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

            echo '<script>window.location.href="?controller=polls&action=prepareSelections&id=' . $pollId . '";</script>';

        } else {
            echo '<script>window.location.href="?controller=views&action=createPoll";</script>';
        }
    }


    //Funcion que 
    public function prepareSelections($pollId){

        echo "Preparando elecciones...";

        //verifica el dueño y guarda la encuesta
        $poll = $this->verifyOwner();

        //Si es el dueño lo redirijo a la vista de añadir selecciones y paso la encuesta por POST
        if ($poll != false) {
            $_SESSION['pollData'] = $poll;
            echo '<script>window.location.href="?controller=views&action=AddSelections&id=' . $pollId . '";</script>';
        }
    }

    //Funcion a la que apunta el formulario de añadir selecciones
    public function addSelection(){

        //Valida las selecciones

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
                return false;
            }
        }
    }

    //Aca valido que los datos del formulario esten bien
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
        if ( isset($_POST['title']) && ($_POST['title'] != '') && strlen($_POST['title']) > 0 && strlen($_POST['title']) < 100  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['title'] = $_POST['title'];

            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de encuesta no valido";
        }

        //DESCRIPCION
        if ( strlen($_POST['description']) < 255  ) {
            // Si todos los campos estan bien, lo añado al array de datos y sumo el contador
            $data['description'] = $_POST['description'];

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

