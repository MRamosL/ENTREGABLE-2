<?php

    require_once("models/profesorModel.php");

    $profesor = new profesorModel();
    $result = $profesor->getProfesores();
    require_once("views/profesor/lista.php");