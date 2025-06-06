<?php

require_once __DIR__ . '/../models/PollsModel.php';



class PollsController {

    //Aca valido que todos los datos del formulario esten bien antes de crear la encuesta
    public function validatePoll() {

        

        //Guardar el form en la sesion
        if ( isset($_POST['saveForm']) ) {

            $_SESSION['form_data'] = $_POST;

            //redirijo a la vista de crear encuesta
           echo "<script>window.location.href='?controller=views&action=CreatePoll';</script>";

        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset( $_POST['saveForm'] ) ) {
            $_SESSION['form_data'] = $_POST;
        
        }
        //var_dump($_POST);  

        //Contador de validaciones
        $_SESSION['counter'] = 0;

        //TITULO
        if ( isset($_POST['title']) && ($_POST['title'] != '') && strlen($_POST['title']) > 0 && strlen($_POST['title']) < 100  ) {
            // Si todos los campos estan completos, creo la encuesta
            //echo 'titulo valido';
            $data['title'] = $_POST['title'];
            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de encuesta no valido";
        }

        //DESCRIPCION
        if ( strlen($_POST['description']) < 255  ) {
            // Si todos los campos estan completos, creo la encuesta
            //echo 'descripcion valida';
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
            // Si todos los campos estan completos, creo la encuesta
            //echo 'fechas validas';
            $data['startDate'] = $_POST['startDate'];
            $data['endDate'] = $_POST['endDate'];
            $_SESSION['counter']++;
        } else {
            // Si no, muestro un mensaje de error
            echo "Fechas no validas";
        }

        //APARIENCIA
        if ( isset($_POST['colour']) && ($_POST['colour'] != '') ) {
            //echo 'colour valido';
            $data['colour'] = $_POST['colour'];
            $_SESSION['counter']++;
        } else {
            $data['colour'] = "1"; // Por defecto es el colour 1
            $_SESSION['counter']++;

        }


        //CARRERAS
        if ( isset($_POST['careers']) && is_array($_POST['careers']) && count($_POST['careers']) > 0 ) {
            //echo 'carreras validas';
            $data['careers'] =  json_encode( $_POST['careers'] );
            $_SESSION['counter']++;
        } else {
            $data['careers'] = json_encode(["ALL"]);
            $_SESSION['counter']++;

            
        }

        //AÑOS
        if ( isset($_POST['years']) && is_array($_POST['years']) && count($_POST['years']) > 0 ) {
            //echo 'años validos';
            $data['years'] = json_encode( $_POST['years'] ) ;
        } else {
            $data['years'] = json_encode(["3"]);
        }


        //VOTACIONES


        //MULTIPLE CHOICE
        if ( isset($_POST['multipleChoice']) && ($_POST['multipleChoice'] != '') ) {
            $data['multipleChoice'] = 1;
        } else {
            $data['multipleChoice'] = 0; // Por defecto es 0
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


    /*

        //Candidatos y opciones
        if ( isset($_POST['options']) || isset($_POST['candidates']) ){
            //echo 'alguna de las 2 está seteada';
            $_SESSION['counter']++;
        } else {
            // Si no, muestro un mensaje de error
            //echo "Candidatos no validos";
        }


        //candidatos
        for ($i = 1; $i <= 10; $i++) {
            if ( isset($_POST['candidate' . $i]) && isset($_POST['candidate' . $i]['name']) && isset($_POST['candidate' . $i]['description']) ) {
                if ( strlen($_POST['candidate' . $i]['name']) > 0 && strlen($_POST['candidate' . $i]['name']) < 100 && strlen($_POST['candidate' . $i]['description']) < 255 ) {
                    //echo 'candidato ' . $i . ' valido';
                } else {
                        echo "Candidato " . $i . " no valido";
                    
                    $_SESSION['counter'] = 0;

                }
            }
        }


        //opciones
        for ($i = 1; $i <= 10; $i++) {
            if ( isset($_POST['option' . $i]) && isset($_POST['option' . $i]['name']) && isset($_POST['option' . $i]['description']) ) {
                if ( strlen($_POST['option' . $i]['name']) > 0 && strlen($_POST['option' . $i]['name']) < 100 && strlen($_POST['option' . $i]['description']) < 255 ) {
                    //echo 'opcion ' . $i . ' valida';
                } else {
                    echo "Opcion " . $i . " no valida";

                    $_SESSION['counter'] = 0;

                }
            }
        }
        
    */

        if ($_SESSION['counter'] == 6  /*$_SESSION['role'] == "ADMIN"*/)  {
            // Si todos los campos estan completos, creo la encuesta
            //echo "Encuesta validada";

            $newPoll = PollsModel::createPoll($data);
            var_dump($newPoll);
            //$this->cleanDataForm();


            // Limpio los datos del formulario 
            //unset($_SESSION['form_data']);

        } else {
            // Si no, muestro un mensaje de error
            echo "Algo salio mal, no se creo la encuesta";
            //unset($_SESSION['form_data']);
        }
    }

    /*
    public function cleanDataForm() {
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $startDate = $_POST['startDate'] ?? null;
        $endDate = $_POST['endDate'] ?? null;
        $visibility = $_POST['visibility'] ?? null;
        $colour = $_POST['colour'] ?? null;    
        
        $careers = $_POST['careers'] ?? []; // array
        $years = $_POST['years'] ?? [];     // array

        /*
        $candidates = [];
        foreach ($_POST as $key => $value) {
            if (preg_match('/^candidate(\d+)$/', $key, $matches)) {
                $index = $matches[1];
                $candidate = $_POST[$key];
        
                // Procesar archivo de imagen
                $photoName = null;
                if (isset($_FILES[$key]['photo']) && $_FILES[$key]['photo']['error'] === UPLOAD_ERR_OK) {
                    $photoTmp = $_FILES[$key]['photo']['tmp_name'];
                    $photoName = basename($_FILES[$key]['photo']['name']);
                    move_uploaded_file($photoTmp, "uploads/$photoName");
                }
        
                $candidates[] = [
                    'name' => $candidate['name'] ?? '',
                    'description' => $candidate['description'] ?? '',
                    'age' => $candidate['age'] ?? '',
                    'career' => $candidate['career'] ?? '',
                    'photo' => $photoName,
                ];
            }
        }

        $candidates = $_POST['candidates'] ?? [];
        // Y las fotos las manejás así:
        foreach ($_FILES['candidates']['tmp_name'] as $i => $fields) {
            if ($_FILES['candidates']['error'][$i]['photo'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['candidates']['tmp_name'][$i]['photo'];
                $photoName = $_FILES['candidates']['name'][$i]['photo'];
                move_uploaded_file($tmpName, "uploads/$photoName");
                $candidates[$i]['photo'] = $photoName;
            }
        }


        $options = $_POST['options'] ?? [];

        foreach ($_FILES['options']['tmp_name'] as $i => $fields) {
            if ($_FILES['options']['error'][$i]['photo'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['options']['tmp_name'][$i]['photo'];
                $photoName = $_FILES['options']['name'][$i]['photo'];
                move_uploaded_file($tmpName, "uploads/$photoName");
                $options[$i]['photo'] = $photoName;
            }
        }
        
        

        

        $data = [
            'title' => $title,
            'description' => $description,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'visibility' => $visibility,
            'colour' => $colour,
            'careers' => $careers,
            'years' => $years,
        ];

        var_dump($data);


    }
    
    */

}

