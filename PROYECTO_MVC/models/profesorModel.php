<?php

class profesorModel{
    private $db;
    private $profesores;

    function __construct(){
        $this->db = Conexion::conectar();
        $this->profesores = array();
    }

    public function getProfesores(){
        $sql = "SELECT * FROM Profesor";

        $result = $this->db->query($sql);

        while($row = $result->fetch_assoc()){
            $this->profesores[] = $row;
        }

        return $this->profesores;
    }

    public function insertProfesor($id, $name, $lastname, $job){
        $sql = "INSERT INTO Profesor (id, name, lastname, job, enable) VALUES ('$id', '$name', '$lastname', '$job', 1)";

        if($this->db->query($sql)===TRUE){
            echo "New record created successfully";
        } else{
            echo "Error: " . $sql . "<br>" . $this->db->error;
        }
    }
}