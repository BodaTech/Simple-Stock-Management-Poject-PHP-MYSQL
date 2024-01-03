<?php 
    function storeData($table, $data){
        $conn = getConnection();
        
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        try{
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $stmt = $conn->prepare($sql);

            foreach($data as $key => &$value){
                $stmt->bindParam(':'.$key, $value);
            }

            $stmt->execute();

            return $conn->lastInsertId();
        }catch(PDOException $e){
            return false;
        }

    }

    function storeOrder($data){
        // store in order table
        $data_ = [
            'client_id' => $data['client_id'],
            'date' => $data['date']
        ];
        $order_id = storeData("orders", $data_);
        if($order_id == false){
            return false;
        };
        // store in order_detail table
        $len = count($data['product_id']);
        for($i = 0; $i < $len; $i++){
            $data_ = array();
            $data_['order_id'] = $order_id;
            $data_['product_id'] = $data['product_id'][$i];
            $data_['quantity'] = $data['quantity'][$i];
            $data_['unit_price'] = $data['unit_price'][$i];
            if(!storeData("order_details", $data_)){
                return false;
            }
        }
        return true;
    }