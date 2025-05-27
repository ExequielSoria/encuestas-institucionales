<?php

class PollsController {

    //Aca valido que todos los datos del formulario esten bien antes de crear la encuesta
    public function validatePoll() {
        //var_dump($_POST);    
        //Contador de validaciones
        $_SESSION['counter'] = 0;

        //titulo
        if ( isset($_POST['title']) && ($_POST['title'] != '') && strlen($_POST['title']) > 0 && strlen($_POST['title']) < 100  ) {
            // Si todos los campos estan completos, creo la encuesta
            //echo 'titulo valido';
            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Nombre de encuesta no valido";
        }

        //descripcion
        if ( strlen($_POST['description']) < 255  ) {
            // Si todos los campos estan completos, creo la encuesta
            //echo 'descripcion valida';
            $_SESSION['counter']++;
        }else{
            // Si no, muestro un mensaje de error
            echo "Descripcion de encuesta no valido";
        }

        //fechas
        $startDate = new DateTime($_POST['startDate']);
        $endDate = new DateTime($_POST['endDate']);

        if ( isset($_POST['startDate']) && isset($_POST['endDate']) && $startDate < $endDate ) {
            // Si todos los campos estan completos, creo la encuesta
            //echo 'fechas validas';
            $_SESSION['counter']++;
        } else {
            // Si no, muestro un mensaje de error
            echo "Fechas no validas";
        }




        //Candidatos y opciones
        if ( isset($_POST['option1']) || isset($_POST['candidate1']) ){
            //echo 'alguna de las 2 está seteada';
            $_SESSION['counter']++;
        } else {
            // Si no, muestro un mensaje de error
            echo "Candidatos no validos";
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
        
        if ($_SESSION['counter'] == 4) {
            // Si todos los campos estan completos, creo la encuesta
            echo "Creo la encuesta";
        } else {
            // Si no, muestro un mensaje de error
            echo "Algo salio mal, no se creo la encuesta";
        }
    }


    public function createPoll() {
        var_dump($_POST);
    }

}

