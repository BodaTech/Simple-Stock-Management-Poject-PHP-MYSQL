<?php 
    function deleteData($table, $id){
        $conn = getConnection();
        
        try{
            $sql = "DELETE FROM $table  WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            return false;
        }
    }