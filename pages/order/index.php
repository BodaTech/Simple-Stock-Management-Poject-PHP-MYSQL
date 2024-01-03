<?php
include_once('../../conn/conn.php');
include("../../services/fetchData.php");
include("../../services/storeData.php");
include("../../services/updateData.php");
include("../../services/deleteData.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && !empty($_POST['client_id']) && !empty($_POST['date'])) {
        $data = [
            'client_id' => $_POST['client_id'],
            'date' => $_POST['date']
        ];
        if (updateData("orders", $data, $_POST['id'])) {
            $type = "success";
            $msg = "order updated successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    } else if(isset($_POST['delete']) && !empty($_POST['id'])){
        if (deleteData("orders" ,$_POST['id'])){ 
            $type = "success";
            $msg = "order removed successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    }
    else {
        $type = "danger";
        $msg = "all fileds are required";
    }
}

$orders = fetchData("orders");
$clients = fetchData("clients")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>Order Management</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <?php include("../../layout/header.php") ?>
    <main>
        <section>
            <h3 class="heading">Order Management</h3>
            <div class="card table-container" style="border: none">
                <div class="container">
                    <a href="/pages/order/newOrder.php" class="button warning-button" style="float: right; font-size: 13px;">
                        new order
                    </a>
                </div>
                <?php
                isset($msg) ? include("../../components/alert.php") : '';
                ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>client</th>
                                <th>date</th>
                                <th>number of order</th>
                                <th>total price</th>
                                <th>details</th>
                                <th style="min-width: 8rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) {
                            ?>
                                <?php
                                    $order_ds = fetchOrderDetails($order['id']);
                                    $total = count($order_ds);
                                    $totalPrice = 0;
                                    foreach($order_ds as $order_d){
                                        $totalPrice += $order_d['unit_price'] * $order_d['quantity'];
                                    }
                                ?>
                                <tr>
                                    <td><?= $order['id'] ?></td>
                                    <td>
                                        <?php 
                                            foreach($clients as $client){
                                                if($client['id'] === $order['client_id']) echo "$client[name]";
                                            }
                                        ?>
                                    </td>
                                    <td><?= $order['date'] ?></td>
                                    <td>
                                        <?= $total ?>
                                    </td>
                                    <td>
                                        <?= $totalPrice ?>
                                    </td>
                                    <td>
                                        <a href="/pages/order/orderDetail.php?id=<?=$order['id']?>" class="link">...</a>
                                    </td>
                                    <td style="width: 10rem">
                                        <button class="button success-button" id="openModalBtn<?= $order['id'] ?>">
                                            edit
                                        </button>
                                        <button class="button danger-button" id="delete" onclick="handleDelete(<?= $order['id'] ?>)">
                                            delete
                                        </button>
                                        <form  method="post" style="display: none">
                                            <input name="delete">
                                            <input name="id" value="<?= $order['id'] ?>">
                                            <button id="form-del-<?=$order['id']?>" >delete</button>
                                        </form>
                                        <div id="myModal<?= $order['id'] ?>" class="modal">
                                            <div class="modal-content">
                                                <div class="card new-item">
                                                    <div style="font-weight: bold; margin-bottom: 12px">
                                                        Edit Client
                                                    </div>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="update">
                                                        <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                                        <select class="input" name="client_id">
                                                            <option value="">select the client</option>
                                                            <?php 
                                                                foreach($clients as $client){
                                                                    ?>
                                                                        <option value="<?=$client['id']?>" <?php if($order['client_id'] === $client['id']) echo 'selected'; ?>>
                                                                            <?= $client['name'] ?>
                                                                        </option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <input type="date" class="input" name="date" placeholder="date" value="<?= $order['date'] ?>" />
                                                        <div class="btn-container">
                                                            <button class="button primary-button" style="padding: 8px 15px">
                                                                Save
                                                            </button>
                                                            <button class="button secondary-button" style="padding: 8px 15px" type="button" id="closeModalBtn<?= $order['id'] ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            setModal(<?= $order['id'] ?>)
                                        </script>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <script>
        const handleDelete = (id) => {
            if (confirm("delete confirmation")){
                document.getElementById('form-del-'+id).click();
            }
        }
    </script>
</body>

</html>