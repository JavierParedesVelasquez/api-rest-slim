<?php
// Importaciones
use Psr\Http\Message\RequestInterface as Request;//Objeto Request
use Psr\Http\Message\ResponseInterface as Response;//Objeto Response

// Requiere el archivo autoload, se encarga de cargar automaticamente todas las dependencias del proyecto
require '../vendor/autoload.php';
// Require Conexion
require '../src/config/conexion.php';


$app = new \Slim\App();

// Ruta Clientes
require '../src/rutas/clientes.php';

// Run app
$app->run();