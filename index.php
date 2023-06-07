<?php
require 'flight/Flight.php';

// Conexion a la DB
Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=alumnosphp_api','root',''));


/*
    Metodo GET: Leer dato - Mostrar datos
    Consulta: http://localhost/APIS-Webservices/API_PHP_Alumnos/alumnos
*/
Flight::route('GET /alumnos', function () {
    //  Devolver los alumnos
    $sql = 'SELECT * FROM alumnos';
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute(); // Ejecucion de la sentencia sql
    $alumnos = $sentencia->fetchAll(PDO::FETCH_ASSOC); //Devolver los datos/registros
    //  Imprimir los datos en formato JSON
    Flight::json($alumnos);
});


//  Metodo POST: Envia - Guarda los datos en la DB
Flight::route('POST /alumnos', function () {
    $nombres = (Flight::request()->data->nombre);
    $apellidos = (Flight::request()->data->apellidos);
    $edad = (Flight::request()->data->edad);
    //  Insertando a la DB
    $sql = 'INSERT INTO alumnos (nombre, apellidos, edad) VALUES(?,?,?)';
    $sentencia = Flight::db()->prepare($sql);
    //$sentencia->execute(array($nombres,$apellidos));
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->bindParam(3, $edad);
    $sentencia->execute();
    //  JSON Param
    Flight::jsonp(['Alumno agregado !!']);
});


//   Metodo DELETE: Eliminar registro por ID en la DB
Flight::route('DELETE /alumnos', function () {
    $id = (Flight::request()->data->id);
    $sql = 'DELETE FROM alumnos WHERE id=?';
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    Flight::jsonp(['Alumno eliminado !!']);
});


//   Metodo PUT: Actualiza los datos de la DB
Flight::route('PUT /alumnos', function () {
    $id = (Flight::request()->data->id);
    $nombres = (Flight::request()->data->nombre);
    $apellidos = (Flight::request()->data->apellidos);
    $edad = (Flight::request()->data->edad);
    //  Actualizando al alumno
    $sql = 'UPDATE alumnos SET nombre=?, apellidos=?, edad=? WHERE id=?';
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $nombres);
    $sentencia->bindParam(2, $apellidos);
    $sentencia->bindParam(3, $edad);
    $sentencia->bindParam(4, $id);
    $sentencia->execute();
    Flight::jsonp(['Alumno actualizado !!']);
});


/*
    Metodo GET: Con Busqueda por ID
    Consulta: http://localhost/APIS-Webservices/API_PHP_Alumnos/alumnos/3
*/
Flight::route('GET /alumnos/@id', function ($id) {
    //  Obteniendo los datos del alumno por ID
    $sql = 'SELECT * FROM alumnos WHERE id=?';
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1, $id);
    $sentencia->execute();
    $alumnos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    //  Imprimir los datos en formato JSON
    Flight::json($alumnos);
});



Flight::start();