<?php
//Inicio la sesion para guardar la info del usuario y el rol
session_start();



//Capturo los datos de la url que me sirven para defirnir el controlador y la accion
// Si no, se asignan valores por defecto
$controller = $_GET['controller'] ?? 'users';
$action = $_GET['action'] ?? 'login';

// Capturo cualquier parametro extra con $_GET
$params = $_GET;


//Defino la ruta del controlador
$controllerFile = './app/controllers/' . ucfirst($controller) . 'Controller.php';

//Si el controlador existe, lo incluyo y creo una instancia de la clase
if (file_exists($controllerFile)) {

    //incluyo el archivo del controlador
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';

    //Instancio la clase
    $instance = new $controllerClass();

    //Uso un metodo de la clase instanciada
    if (method_exists($instance, $action)) {
        // Remuevo controller y action del array para quedarme solo con los parametros
        unset($params['controller'], $params['action']);

        // Llamo al metodo con los parametros
        call_user_func_array([$instance, $action], $params);

    } else {
        echo "Acción '$action' no encontrada.";
    }
} else {
    echo "Controlador '$controller' no encontrado.";
}
