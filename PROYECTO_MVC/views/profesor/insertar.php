<?php

if(isset($_POST["btnInsertar"])){
    require_once("models/profesorModel.php");

    $profesor = new profesorModel();

    $datos = array(
        'id' => $_POST['id'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'job' => $_POST['job']
    );
    //$profesor->insertarProfesor($datos['id'], $datos['nombre'], $datos['apellido'], $datos['job']);
}