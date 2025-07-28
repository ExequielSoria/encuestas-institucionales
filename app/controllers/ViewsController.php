<?php

require_once './app/models/PollsModel.php';

require_once './app/controllers/UsersController.php';

require_once './app/controllers/PollsController.php';


class ViewsController {

    public function viewUser($idToSearch){
        //Validar admin***

        //Busco al usuario, traigo los datos y luego cargo la vista
        $usersController = new UsersController();

        $userData = $usersController->getUserInfoById($idToSearch);

        //var_dump($userData);

        // Cargo la vista de ver usuario
        if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {
            include_once './app/views/viewUser.php';
        } else {
            echo "<script> alert('Necesitas ser administrador para ver un usuario')</script>";
            include_once './app/views/home.php';
        }
    }

    public function createUser(){
        // Cargo la vista de crear usuario
        if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {
            include_once './app/views/createUser.php';
        } else {
            echo "<script> alert('Necesitas ser administrador para crear un usuario')</script>";
            include_once './app/views/home.php';
        }
    }

    public function viewPoll($pollId){

        //Carga los datos de la encuesta, verifico y luego carga la pagina
        
        //Instancio los Controladores y Modelos que necesito
        $pollModel = new PollsModel();

        $pollData = $pollModel->getPollById($pollId);
        $optionsData = $pollModel->getOptionsByPollId($pollId);
        $candidatesData = $pollModel->getCandidatesByPollId($pollId);

        $usersController = new UsersController();

        $creatorData = $usersController->getUserInfoById($pollData['ID_USER']);
        
        
        //Verificar que se cumpla alguna de las condiciones: Ser admin, el creador, haber votado, resultados PUBLICOS 
        $pollsController = new PollsController();
        $isAllowed = $pollsController->allowViewPoll($pollId, $_SESSION['id']);

        //Cargo la cantidad total de encuestas
        $totalPolls = $pollsController->howManyPolls();

        $totalPolls = (int)$totalPolls;
        
        if( $pollId > $totalPolls && $pollId < 0  ){
            echo " <script>alert('ID de encuesta no valido');</script>";
        }

        //Cargo los datos de la encuesta por la id
        if ( $isAllowed == false ){
            echo " <script>alert('No puedes ver esta encuesta');</script> ";
            include_once './app/views/home.php';
        } else {            
            require_once './app/views/viewPoll.php';

        }



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
