<?php
//Script encargado de redirigir todas las peticiones al index

// Si el archivo existe físicamente, lo dejamos pasar
if (file_exists(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Si no, redirigimos todo a index.php
require_once __DIR__ . '../../index.php';