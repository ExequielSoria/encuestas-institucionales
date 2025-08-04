<?php

require_once __DIR__ . '/../models/UsersModel.php';

//Clase encargada de gestionar las acciones sobre los usuarios
class UsersController {

    public function validatePasswordUpdate() {

        //Validar que la contraseña sea correcta
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword === $confirmPassword) {
                // Actualizar contraseña
                $usersModel = new UsersModel();
                $usersModel->updatePassword($id, $newPassword);
                echo "<script>alert('Contraseña actualizada correctamente');</script>";
                echo "<script> window.location.href='?controller=views&action=editUser&id=$id';</script>";
            } else {
                echo "<script>alert('Las contraseñas no coinciden');</script>";
            }
        }
    }

    public function validateUserEdit(){

        $id = $_POST['idToEdit'];
        $newUsername = $_POST['editedUsername'];
        $newState = $_POST['editedState'];
        $newRole = $_POST['editedRole'];

        //Valido el estado y rol
        if (  $newState != '1' ){
            $newState = '0';
        } else {
            $newState = '1';
        }

        if (  $newRole != 'ADMIN' ){
            $newRole = 'CREATOR';
        } else {
            $newRole = 'ADMIN';
        }

        //Se recibe y procesan los datos del usuario a editar

        $usersModel = new UsersModel();

        //Verificar que sea admin
        if (isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {

            if( $newUsername != "" &&  strlen($newUsername) < 100){

                if($usersModel->userExists($newUsername, $id)){
                    echo "<script>alert('El nombre de usuario ya existe');</script>";
                } else {
                    // Actualizar usuario
                    $usersModel->updateUser($id, $newUsername, $newState, $newRole);
                    echo "<script>alert('Usuario actualizado correctamente');</script>";
                    echo "<script>window.location.href='?controller=views&action=editUser&id=$id';</script>";
                }

            } else {
                echo "<script>alert('El nombre de usuario no es valido');</script>";
                echo "<script>window.location.href='?controller=views&action=editUser&id=$id';</script>";
                return;
            }

        echo $_POST['idToEdit'];
        echo $_POST['editedUsername'];
        echo $_POST['editedState'];



        } 

        //Traer los datos del usuario
        //Volcarlos en el formulario

        //formulario enviable a editar

    }



    public function howManyUsers() {
        //Para ver cuantos usuarios hay creados
        $userModel = new UsersModel();
        return $userModel->howManyUsers();
    }

    public function getUserInfoById($id) {
        //Obtiene un usuario por su ID
        $userModel = new UsersModel();
        return $userModel->getUserInfoById($id);
    }

    //Funcion encargada del login en general
    public function login() {

        //Si se usa el metodo POST, recojo los datos que vienen desde POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Recojo los datos del formulario
            if ( $_POST['isCreator'] == "on" ){
                $_POST['isCreator'] = true;
            } else {
                $_POST['isCreator'] = false;
            }

            $username = $_POST['username'] ?? '';
            $pass = $_POST['password'] ?? '';
            $isCreator = $_POST['isCreator'] ?? false ;
            
            //Si es true busco en la base de datos interna
            if ( $isCreator == true ){
                $login = UsersModel::loginInternDB($username, $pass);

                if ($login == false){
                    echo "<script>alert('Usuario o contraseña incorrecto para el admin');</script>";
                    echo "<script>window.location.href='?controller=views&action=login';</script>";
                    var_dump($login);

                } else {

                    $_SESSION['username'] = $login['USERNAME'];
                    $_SESSION['id'] = $login['ID_USER'];
                    $_SESSION['role'] = $login['ROLE'];
                    echo "<script>window.location.href='?controller=views&action=home';</script>";
                    //header('Location: ?controller=views&action=home');
                }
                //var_dump($login);

            } else { 
                $login = UsersModel::loginExternDB($username, $pass);
                
                //var_dump( $login );

                if( $login != false ){
                    $_SESSION['username'] = $login['FIRST_NAME']." ".$login['LAST_NAME'];
                    $_SESSION['idVoter'] = $login['ID_USER'];
                    $_SESSION['legajo'] = $login['LEGAJO'];
                    $_SESSION['career'] = $login['ID_CAREER'];
                    $_SESSION['year'] = $login['ID_YEAR'];

                    $_SESSION['role'] = "VOTER";

                    //var_dump($login);

                    echo "<script>window.location.href='?controller=views&action=home';</script>";
                

                } else {                     
                    echo "<script>alert('Usuario o contraseña incorrecto');</script>";
                    echo "<script>window.location.href='?controller=views&action=login';</script>";}
                
            }


        }

    }

    public function endSession() {
        // Cerrar la sesión
        session_start();
        session_destroy();
        header('Location: ?controller=views&action=login');
    }

    
    public function create(){

        //include __DIR__ . '/../views/createUser.php';


        //Si se usa el metodo POST, recojo los datos que vienen desde POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Recojo los datos del formulario
            if ( $_POST['isAdmin'] == "on" ){
                $_POST['isAdmin'] = "ADMIN";
            } else {
                $_POST['isAdmin'] = "CREATOR";
            }

            $role = $_POST['isAdmin'];
            $newUsername = $_POST['newUsername'] ?? '';
            $newPass = $_POST['newPassword'] ?? '';

            //Creo el usuario
            $newUser = UsersModel::createUser($newUsername, $newPass, $role);
            
            echo "<script>alert('Usuario creado correctamente');</script>";
            echo "<script>window.location.href='?controller=views&action=home';</script>";

            //var_dump($newUser);

        }



    }

    public function dashboard() {
            redirigir('?controller=users&action=home');
        }

    public function hola() {
        echo 'Buenas';
    }

}
