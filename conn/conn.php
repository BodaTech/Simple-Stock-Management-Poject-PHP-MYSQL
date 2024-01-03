<?php 
    #adjust your database config here
    function getConnection(){
        try{
            $conn = new PDO("mysql:host=localhost;dbname=stock_management", 'root', '');
            return $conn;
        }catch(Exception $e){
            die('erros : ' . $e->getMessage());
        }
    }