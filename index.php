<?php
// Todas las request van a entrar por index.php

// Con Composer no hace falta importar los archivos php (composer init)
// Al agregar en el composer.json autoload psr-4l, hace que cualquier clase creada en el proyecto esta bajo el namespace "app", evitando los require poniendo el namespace en las clases
require_once __DIR__."/vendor/autoload.php"; // Con esto cada clase en namespace app, esta requerida.
use app\core\Application;

// En la carpeta core se encuentras las clases definidas
// creamos la variable App que es un objeto Application.
$app = new Application();



// Creamos la variable router que es un objeto Router donde se configuran las rutas
//$router = new Router();

// Configuracion de rutas
// Cuando tenemos un request get a la ruta "/", se ejecuta la callback
$app->router->get("/", function() {
    return "Hello";
});
$app->router->get("/contact", function() {
    return "Contact";
});


//$app->userRouter($router);

// Inicia la aplicacion, se ejecuta al recibir un request
echo $app->run();

