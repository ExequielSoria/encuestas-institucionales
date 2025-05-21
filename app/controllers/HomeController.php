<?php

class HomeController {
    public function index() {
        // Cargar la vista de inicio
        include_once './app/views/home.php';
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
