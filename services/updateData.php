<?php 

function updateData($table, $data, $id){
    $conn = getConnection();
    
    $setClause = '';
    foreach($data as $key => $value){
        $setClause .= $key . '=:' . $key . ', ';
    }
    $setClause = rtrim($setClause, ', ');

    try{
        $sql = "UPDATE $table SET $setClause WHERE id = :id";
        $stmt = $conn->prepare($sql);

        foreach($data as $key => &$value){
            $stmt->bindParam(':'.$key, $value);
        }
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return true;
    }catch(PDOException $e){
        return false;
    }
}