<?php
include_once('../../conn/conn.php');
include("../../services/fetchData.php");
include("../../services/storeData.php");
include("../../services/updateData.php");
include("../../services/deleteData.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && !empty($_POST['product_id']) && !empty($_POST['id'])) {
        $data = [
            'product_id' => $_POST['product_id'],
            'unit_price' => $_POST['unit_price'],
            'quantity' => $_POST['quantity']
        ];
        if (updateData("order_details", $data, $_POST['id'])) {
            $type = "success";
            $msg = "order updated successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    }else if (isset($_POST['store']) && !empty($_POST['product_id'])) {
        $data = [
            'order_id' => $_GET['id'],
            'product_id' => $_POST['product_id'],
            'unit_price' => $_POST['unit_price'],
            'quantity' => $_POST['quantity']
        ];
        if (storeData("order_details", $data)) {
            $type = "success";
            $msg = "order added successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    } else if (isset($_POST['delete']) && !empty($_POST['id'])) {
        if (deleteData("order_details", $_POST['id'])) {
            $type = "success";
            $msg = "order removed successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    } else {
        $type = "danger";
        $msg = "all fileds are required";
    }
}

if(!isset($_GET['id'])){
    header('Location: /pages/order/index.php');
}

$order_detail_details = fetchOrderDetails($_GET['id']);
$clients = fetchData("clients");
$products = fetchData("products");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>Order Detail</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <?php include("../../layout/header.php") ?>
    <main>
        <section>
            <h3 class="heading">Order <?=$_GET['id']?></h3>
            <div class="card table-container" style="border: none">
                <div class="container" style="
                                                display: flex;
                                                flex-wrap: wrap;
                                                justify-content: space-between;
                                                ">
                    <a href="/pages/order/index.php" class="button secondary-button" style="font-size: 12px">
                        back
                    </a>
                    <button id="new-order" class="button warning-button" style="font-size: 12px">
                        new order
                    </button>
                </div>
                <div class="card new-item" id="new-order-form">
                    <form action="" method="post">
                        <input type="hidden" name="store">
                        <select type="text" class="input" name="product_id"  placeholder="Product">
                            <option value="">chose the product</option>
                            <?php
                            foreach ($products as $product) {
                            ?>
                                <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="text" class="input" name="quantity" id="quantity" placeholder="Quantity" />
                        <input type="text" class="input" name="unit_price" id="unit_price" placeholder="Unit Price" />
                        <div class="btn-container">
                            <button class="button primary-button" style="padding: 8px 15px">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
                <?php
                isset($msg) ? include("../../components/alert.php") : '';
                ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th style="min-width: 8rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($order_detail_details as $order_detail) {
                            ?>
                                <tr>
                                    <td><?= $order_detail['id'] ?></td>
                                    <td>
                                        <?php
                                        foreach ($products as $product) {
                                            if ($product['id'] === $order_detail['product_id']) echo "$product[name]";
                                        }
                                        ?>
                                    </td>
                                    <td><?= $order_detail['quantity'] ?></td>
                                    <td>
                                        <?= $order_detail['unit_price'] ?>
                                    </td>
                                    <td style="width: 10rem">
                                        <button class="button success-button" id="openModalBtn<?= $order_detail['id'] ?>">
                                            edit
                                        </button>
                                        <button class="button danger-button" id="delete" onclick="handleDelete(<?= $order_detail['id'] ?>)">
                                            delete
                                        </button>
                                        <form method="post" style="display: none">
                                            <input name="delete">
                                            <input name="id" value="<?= $order_detail['id'] ?>">
                                            <button id="form-del-<?= $order_detail['id'] ?>">delete</button>
                                        </form>
                                        <div id="myModal<?= $order_detail['id'] ?>" class="modal">
                                            <div class="modal-content">
                                                <div class="card new-item">
                                                    <div style="font-weight: bold; margin-bottom: 12px">
                                                        Edit Order Detail
                                                    </div>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="update">
                                                        <input type="hidden" name="id" value="<?= $order_detail['id'] ?>">
                                                        <select type="text" class="input" name="product_id" placeholder="Product">
                                                            <option value="">chose the product</option>
                                                            <?php
                                                            foreach ($products as $product) {
                                                            ?>
                                                                <option 
                                                                <?php if($product['id'] == $order_detail['product_id']) echo 'selected' ;?>
                                                                value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="text" class="input" name="quantity" id="quantity" value="<?= $order_detail['quantity']?>" placeholder="Quantity" />
                                                        <input type="text" class="input" name="unit_price" id="unit_price" value="<?= $order_detail['unit_price']?>" placeholder="Unit Price" />
                                                        <div class="btn-container">
                                                            <button class="button primary-button" style="padding: 8px 15px">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            setModal(<?= $order_detail['id'] ?>)
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
    <script src="../../assets/js/script.js"></script>
    <script>
        new_item_content = document.getElementById("new-order-form");
        new_item_content.classList.toggle("d-none");
        let button = document.getElementById("new-order");
        button.addEventListener("click", () => {
            new_item_content.classList.toggle("d-none");
        });
    </script>
    <script>
        const handleDelete = (id) => {
            if (confirm("delete confirmation")) {
                document.getElementById('form-del-' + id).click();
            }
        }
    </script>
</body>

</html>