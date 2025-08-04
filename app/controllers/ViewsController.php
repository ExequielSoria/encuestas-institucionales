<?php

require_once './app/models/PollsModel.php';

require_once './app/controllers/UsersController.php';

require_once './app/controllers/PollsController.php';


class ViewsController {

    public function deletePoll($pollId) {

        if( $pollId <= 0 || !is_numeric($pollId) ){
            echo "<script>alert('El id de la encuesta no es valido');</script>";
            echo "<script> window.location.href='?controller=views&action=home'</script>";
            return;
        }

        $pollModel = new PollsModel();

        $pollData = $pollModel->getPollById($pollId);

        $usersController = new UsersController();
        $creatorData = $usersController->getUserInfoById($pollData['ID_USER']);

        $pollId = (int)$pollId;

        //Verifico que sea Admin o el creador
        if( $_SESSION['role'] == "ADMIN" || $creatorData['ID_USER'] == $_SESSION['id'] ){

            //Cargo la vista de editar encuesta
            include_once './app/views/deletePoll.php';

        } else {            
            echo " <script>alert('No tenes permiso para borrar esta encuesta');</script> ";
            echo "<script> window.location.href='?controller=views&action=home'</script>";
            return;
        }

    }

    public function editPoll($pollId) {

        if( $pollId <= 0 || !is_numeric($pollId) ){
            echo "<script>alert('El id de la encuesta no es valido');</script>";
            echo "<script> window.location.href='?controller=views&action=home'</script>";
            return;

        }

        $pollModel = new PollsModel();

        $pollData = $pollModel->getPollById($pollId);
        $optionsData = $pollModel->getOptionsByPollId($pollId);
        $candidatesData = $pollModel->getCandidatesByPollId($pollId);

        $usersController = new UsersController();
        $creatorData = $usersController->getUserInfoById($pollData['ID_USER']);

        $pollId = (int)$pollId;

        //Verifico que sea Admin o el creador
        if( $_SESSION['role'] == "ADMIN" || $creatorData['ID_USER'] == $_SESSION['id'] ){

            //Cargo la vista de editar encuesta
            include_once './app/views/editPoll.php';

        } else {            
            echo " <script>alert('No podes editar esta encuesta');</script> ";
            echo "<script> window.location.href='?controller=views&action=home'</script>";
            
        }
}


    public function userPolls($id) {
        // Cargar la vista de mis encuestas
        if (isset($_SESSION['role']) && $_SESSION['role'] != null && $_SESSION['role'] == "CREATOR" ) {

            $usersController = new UsersController();
            $pollsController = new PollsController();

            $userInfo = $usersController->getUserInfoById($id);
            $userPolls = $pollsController->getUserPolls($id);

            //var_dump($userPolls);
            include_once './app/views/userPolls.php';

        } else {

            if( $_SESSION['role'] == "ADMIN" ){

            $usersController = new UsersController();
            $pollsController = new PollsController();

            $userInfo = $usersController->getUserInfoById($id);
            $userPolls = $pollsController->getUserPollsAdmin($id);
            include_once './app/views/userPolls.php';


            } else {
        
                echo "<script> alert('No se pudieron cargar las encuestas del usuario')</script>";
                include_once './app/views/home.php';
            }
        }
    }

    public function editUser($id){

        $usersController = new UsersController();

        //Verificar que sea admin
        if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {

            
            //Traigo los datos del usuario
            $userData = $usersController->getUserInfoById($id);

            //var_dump($userData);

            include_once './app/views/editUser.php';
        } else {
            echo "<script> alert('Necesitas ser administrador para editar un usuario')</script>";
            include_once './app/views/home.php';
        }
        

        //Traer los datos del usuario
        //Volcarlos en el formulario

        //formulario enviable a editar

    }

    public function viewUser($idToSearch){

        //Aca recibo el id desde el formulario de viewUser
        if( $_POST['send'] && isset($_POST['idUser']) ){
            $idToSearch = (int)$_POST['idUser'];
        }

        $idToSearch = (int)$idToSearch;


        //Busco al usuario, traigo los datos y luego cargo la vista


        //Instancio el controlador de usuarios para traer el nombre y la cantidad de usuarios creados
        $usersController = new UsersController();

        $usersCount = $usersController->howManyUsers();
        //echo $usersCount;

        $usersCount = (int)$usersCount;

        if( $idToSearch <= $usersCount &&  $idToSearch > 0){

            // Cargo la vista de ver usuario
            if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {
                //Traigo los datos del usuario
                $userData = $usersController->getUserInfoById($idToSearch);

                include_once './app/views/viewUser.php';
            } else {
                echo "<script> alert('Necesitas ser administrador para ver un usuario')</script>";
                include_once './app/views/home.php';
            }


            //No me gusta que primero se haga la verificacion de usuario y luego la consulta de rol, pero 

        } else {
            echo " <script>alert('Ese usuario no existe');</script> ";
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

        //Pasare info del usuario actual para ser evaluado en caso de ser alumno


        //Aca recibo el id desde el formulario de viewPoll
        if( $_POST['send'] && isset($_POST['idPoll']) ){
            $pollId = (int)$_POST['idPoll'];
        }

        $pollId = (int)$pollId;

        //Primero uso el PollsController para ver el total de encuestas creadas
        $pollsController = new PollsController();
        
        //Cargo la cantidad total de encuestas
        $totalPolls = $pollsController->howManyPolls();
        $totalPolls = (int)$totalPolls;

        //Verifico que sea Admin, el creador, haber votado, resultados PUBLICOS
        $isAllowed = $pollsController->allowViewPoll($pollId, $_SESSION['id']);
        
        //Primero verifico el id, para no buscar datos al pepe
        if( $pollId <= $totalPolls && $pollId > 0 ){

            if($isAllowed == true){
                //Instancio los modelos y traigo datos, colta
                $pollModel = new PollsModel();
    
                $pollData = $pollModel->getPollById($pollId);
                $optionsData = $pollModel->getOptionsByPollId($pollId);
                $candidatesData = $pollModel->getCandidatesByPollId($pollId);
    
                $usersController = new UsersController();
                $creatorData = $usersController->getUserInfoById($pollData['ID_USER']);
    
                require_once './app/views/viewPoll.php';
            } else {            
            echo " <script>alert('No podes ver esta encuesta');</script> ";
            include_once './app/views/home.php';
        }



        } else {            
            echo " <script>alert('Esa encuesta no existe');</script> ";
            include_once './app/views/home.php';
        }

    }

    public function home() {

        $usersController = new UsersController();


        // Cargar la vista de inicio
        $pollsController = new PollsController();

        if (isset($_SESSION['username']) && $_SESSION['username'] != null) {

            if($_SESSION['role'] == "ADMIN"){
                $lastestPolls = $pollsController->getLastestPollsAdmin(9);

                include_once './app/views/home.php';
            } else {

                if( $_SESSION['role'] == "CREATOR" ){
                    $lastestPolls = $pollsController->getLastestPolls(9);
                    include_once './app/views/home.php';
                    
                } else {
                    $lastestPolls = $pollsController->getLastestPollsVoter(9);
                    include_once './app/views/home.php';                    
                }
            }

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
