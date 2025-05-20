<?php

// Encargado de redirigir las peticiones a los controladores correspondientes
class Router {
    public function route() {

        // Obtenemos la URL sin GET
        $request = $_SERVER['REQUEST_URI'];
        $path = parse_url($request, PHP_URL_PATH);

        // Separamos la info de la URL
        $url = explode('/', trim($path, '/'));


        // Controlador por defecto
        $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $methodName = isset($url[1]) ? $url[1] : 'index';
        $params = array_slice($url, 2);

        // Ruta del archivo del controlador
        $controllerFile = './app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();

            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                echo "Método '$methodName' no encontrado en '$controllerName'";
            }
        } else {
            echo "Controlador '$controllerName' no encontrado";
        }
    }
}
