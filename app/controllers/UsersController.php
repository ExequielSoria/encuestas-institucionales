<?php

require_once __DIR__ . '/../models/UsersModel.php';

//Clase encargada de gestionar las acciones sobre los usuarios
class UsersController {

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
                    echo "<script>alert('Usuario o contraseña incorrecto');</script>";
                    echo "<script>window.location.href='?controller=views&action=login';</script>";



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
                //var_dump($login);
                
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
            echo $newUser = UsersModel::createUser($newUsername, $newPass, $role);
            
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
