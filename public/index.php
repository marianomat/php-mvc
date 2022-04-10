<?php
// Todas las request van a entrar por index.php

// Con Composer no hace falta importar los archivos php (composer init)
// Al agregar en el composer.json autoload psr-4l, hace que cualquier clase creada en el proyecto esta bajo el namespace "app", evitando los require poniendo el namespace en las clases
require_once __DIR__ . "/../vendor/autoload.php"; // Con esto cada clase en namespace app, esta requerida.
use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

// En la carpeta core se encuentras las clases definidas
// creamos la variable App que es un objeto Application.
$app = new Application(dirname(__DIR__));



// Creamos la variable router que es un objeto Router donde se configuran las rutas
//$router = new Router();


// Configuracion de rutas (3 opciones)

// ** Opcion 1: usando nombres de las vistas
// Cuando tenemos un request get a la ruta "/", se ejecuta la callback
// $app->router->get("/", "home");

// ** Opcion 2: Usando callbacks
// $app->router->get("/", function() {
//      return "home";
//});

// ** Opcion 3: Usando controllers
// Cuando usamos los controllers, el segundo argumento es un array
// El primer elemento del array es la clase y el segundo el metodo a ejecutar
$app->router->post("/contact", [SiteController::class, "handleContact"]);
$app->router->get("/contact", [SiteController::class, "contact"]);
$app->router->get("/", [SiteController::class, "home"]);

// Auth routes
$app->router->get("/login", [AuthController::class, "login"]);
$app->router->post("/login", [AuthController::class, "login"]);
$app->router->get("/register", [AuthController::class, "register"]);
$app->router->post("/register", [AuthController::class, "register"]);


//$app->userRouter($router);

// Inicia la aplicacion, se ejecuta al recibir un request
$app->run();

