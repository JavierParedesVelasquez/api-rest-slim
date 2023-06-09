<?php
// Importaciones
// use Psr\Http\Message\RequestInterface as Request; //Objeto Request
use Slim\Http\Request;
use Psr\Http\Message\ResponseInterface as Response; //Objeto Response

// Creamos una variable
$app = new \Slim\App;// Require Conexion
require '../src/config/conexion.php';

// Listos para trabajar con la primera ruta

// GET Todos los clientes
// /api/clientes  :  ruta
$app->get('/api/clientes', function (Request $request, Response $response) { //tengo mi ruta
    // Creamos una variable y se inserta la consulta SQL
    $sql = "SELECT * FROM clientes";
    // El bloque try-catch es una construcción en PHP utilizada para manejar excepciones
    try {
        // Creando una instancia
        $db = new db();
        $db =  $db->conectDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen clientes en la base de datos.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" :{"text":' . $e->getMessage() . '}';
    }
});

// GET Recuperar cliente por ID
// /api/clientes/{id}  :  ruta
$app->get('/api/clientes/{id}', function (Request $request, Response $response) { //tengo mi ruta
    // Recuperamos el id del cliente
    $id_cliente = $request->getAttribute('id');
    // Creamos una variable y se inserta la consulta SQL
    $sql = "SELECT * FROM clientes WHERE id =$id_cliente";
    // El bloque try-catch es una construcción en PHP utilizada para manejar excepciones
    try {
        // Creando una instancia
        $db = new db();
        $db =  $db->conectDB();
        $resultado = $db->query($sql);
        if ($resultado->rowCount() > 0) {
            $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($clientes);
        } else {
            echo json_encode("No existen clientes en la base de datos con este ID.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" :{"text":' . $e->getMessage() . '}';
    }
});

// POST Crear Nuevo Cliente
// /api/clientes/nuevo :  ruta
$app->post('/api/clientes/nuevo', function(Request $request, Response $response) { //tengo mi ruta
    // Necesitamos recuperar cuando nos envien desde nuestro frontend los campos.
    $nombre = $request ->getParam('nombre');
    $apellidos = $request ->getParam('apellidos');
    $telefono = $request ->getParam('telefono');
    $email = $request ->getParam('email');
    $direccion = $request ->getParam('direccion');
    $ciudad = $request ->getParam('ciudad');
    // Creamos una variable y se inserta la consulta SQL
    $sql = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad) VALUES (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad)";
    // El bloque try-catch es una construcción en PHP utilizada para manejar excepciones
    try {
        // Creando una instancia
        $db = new db();
        $db =  $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':apellidos', $apellidos);
        $resultado->bindParam(':telefono', $telefono);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':direccion', $direccion);
        $resultado->bindParam(':ciudad', $ciudad);

        $resultado->execute();
        echo json_encode("Nuevo cliente guardado");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" :{"text":' . $e->getMessage() . '}';
    }
});

// PUT Modificar cliente
// /api/clientes/nuevo :  ruta
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response) { //tengo mi ruta
    // Pedimos el id del cliente
    $id_cliente = $request->getAttribute('id');
    // Necesitamos recuperar cuando nos envien desde nuestro frontend los campos.
    $nombre = $request ->getParam('nombre');
    $apellidos = $request ->getParam('apellidos');
    $telefono = $request ->getParam('telefono');
    $email = $request ->getParam('email');
    $direccion = $request ->getParam('direccion');
    $ciudad = $request ->getParam('ciudad');
    // Creamos una variable y se inserta la consulta SQL
    $sql = "UPDATE clientes SET
        nombre = :nombre,
        apellidos =:apellidos,
        telefono =:telefono,
        email = :email,
        direccion = :direccion,
        ciudad = :ciudad
        WHERE id = $id_cliente
    ";
    // El bloque try-catch es una construcción en PHP utilizada para manejar excepciones
    try {
        // Creando una instancia
        $db = new db();
        $db =  $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':apellidos', $apellidos);
        $resultado->bindParam(':telefono', $telefono);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':direccion', $direccion);
        $resultado->bindParam(':ciudad', $ciudad);

        $resultado->execute();
        echo json_encode("cliente Modificado");

        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" :{"text":' . $e->getMessage() . '}';
    }
});

// DELETE Borrar cliente
// /api/clientes/nuevo :  ruta
$app->delete('/api/clientes/delete/{id}', function(Request $request, Response $response) { //tengo mi ruta
    // Pedimos el id del cliente
    $id_cliente = $request->getAttribute('id');

    // Creamos una variable y se inserta la consulta SQL
    $sql = "DELETE FROM clientes
        WHERE id = $id_cliente
    ";
    // El bloque try-catch es una construcción en PHP utilizada para manejar excepciones
    try {
        // Creando una instancia
        $db = new db();
        $db =  $db->conectDB();
        $resultado = $db->prepare($sql);
        $resultado->execute();
        if($resultado->rowCount() >0){
            echo json_encode("cliente Eliminado.");

        }else{
            echo json_encode("No existe cliente con este ID.");
        }
        $resultado = null;
        $db = null;
    } catch (PDOException $e) {
        echo '{"error" :{"text":' . $e->getMessage() . '}';
    }
});

