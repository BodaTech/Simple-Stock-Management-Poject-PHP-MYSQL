<?php 
    function fetchData($table){
        $conn = getConnection();
        
        $sql = "SELECT * FROM $table";
        $query = $conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    function fetchOrderDetails($id){
        $conn = getConnection();
        
        $sql = "SELECT * FROM order_details WHERE order_id=:order_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':order_id', $id);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
