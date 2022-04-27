<?php

function Createdb(){
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="yugioh";
    //create connection
    $con = mysqli_connect($servername,$username,$password);
    //check connection
    if(!$con){
        die("Connection Failed".mysqli_connect_error());
    }

    //create Database
    $sql="CREATE DATABASE IF NOT EXISTS $dbname";

    if(mysqli_query($con, $sql)){
        $con = mysqli_connect($servername,$username,$password, $dbname);
    
        $sql="
            CREATE TABLE IF NOT EXISTS yugioh(
                id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                card_name VARCHAR(50) NOT NULL,
                card_type VARCHAR(20),
                card_set VARCHAR(5),
                price FLOAT
            );
        ";
        
        if(mysqli_query($con,$sql)){
            return $con;
        }else{
            echo "Cannot created table.";
        }
    }else{
        echo "Error while creating database.". mysqli_error($con);
    }

}