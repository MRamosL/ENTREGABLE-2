<?php

if(isset($_POST["btnInsertar"])){
    require_once("models/profesorModel.php");

    $profesor = new profesorModel();

    $datos = array(
        'id' => $_POST['id'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'edad' => $_POST['edad']
        'salario' => $_POST['salario']
        'area' => $_POST['area']
    );
    //$profesor->insertarProfesor($datos['id'], $datos['nombre'], $datos['apellido'], $datos['job']);
}