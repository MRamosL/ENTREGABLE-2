<?php

class profesorModel{
    private $db;
    private $profesores;

    function __construct(){
        $this->db = Conexion::conectar();
        $this->profesores = array();
    }

    public function getProfesores(){
        $sql = "SELECT * FROM Empleados";

        $result = $this->db->query($sql);

        while($row = $result->fetch_assoc()){
            $this->profesores[] = $row;
        }

        return $this->profesores;
    }

    public function insertProfesor($id, $name, $lastname, $edad, $salario, $area){
        $sql = "INSERT INTO Empleados (id, name, lastname, edad, salario, area) VALUES ('$id', '$name', '$lastname', '$edad', $salario, $area)";

        if($this->db->query($sql)===TRUE){
            echo "New record created successfully";
        } else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
        }
    }
}