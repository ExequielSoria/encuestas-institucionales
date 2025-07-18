<?php

require_once './app/models/PollsModel.php';

require_once './app/controllers/UsersController.php';

class ViewsController {

    public function viewPoll($pollId){
        //Verifica que seas dueño y luego
        //Carga los datos de la encuesta y luego carga la pagina
        // getPollById

        //Cargo los datos de la encuesta por la id
        $pollModel = new PollsModel();

        $pollData = $pollModel->getPollById($pollId);        

        $optionsData = $pollModel->getOptionsByPollId($pollId);

        $candidatesData = $pollModel->getCandidatesByPollId($pollId);

        $userController = new UsersController();

        $creatorData = $userController->getUserInfoById($pollData['ID_USER']);

        require_once './app/views/viewPoll.php';


    }

    public function home() {
        // Cargar la vista de inicio

        if (isset($_SESSION['username']) && $_SESSION['username'] != null) {
            //Si el usuario esta logueado, lo redirijo al Home
            include_once './app/views/home.php';
        } else {
            //Si el usuario NO esta logueado, lo redirijo al login
            echo "Necesitas estar logeado para entrar";
            include_once './app/views/login.php';
        }

    }

    public function login() {
        // Cargar la vista del login
        include_once './app/views/login.php';
    }

    public function createPollCandidate() {
        // Cargar la vista de inicio

        if ( isset($_SESSION['role']) && $_SESSION['role'] != null && ( $_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "CREATOR" ) ) {
            //Si el usuario esta logueado, lo redirijo al creador de encuestas
            include_once './app/views/createPollCandidate.php';
        } else {
            //Si el usuario NO esta logueado, lo redirijo al login
            echo "Necesitas estar logeado para entrar";
            include_once './app/views/login.php';
        }

    }

    public function createPoll() {
        // Cargar la vista de inicio

        if ( isset($_SESSION['role']) && $_SESSION['role'] != null && ( $_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "CREATOR" ) ) {
            //Si el usuario esta logueado, lo redirijo al creador de encuestas
            include_once './app/views/createPoll.php';
        } else {
            //Si el usuario NO esta logueado, lo redirijo al login
            echo "Necesitas estar logeado para entrar";
            include_once './app/views/login.php';
        }

    }

    public function addElections() {
        // Cargar la vista de inicio

        if ( isset($_SESSION['role']) && $_SESSION['role'] != null && ( $_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "CREATOR" ) ) {
            //Si el usuario esta logueado, lo redirijo al creador de selecciones
            include_once './app/views/addElections.php';
        } else {
            //Si el usuario NO esta logueado, lo redirijo al login
            echo "Necesitas estar logeado para entrar";
            include_once './app/views/login.php';
        }

    }





    public function about() {
        // Cargar la vista de inicio
        include_once './app/views/aboutUs.php';
    }



    
    public function saludo() {
        // Cargar la vista de inicio
        echo "hola";
    }

}
