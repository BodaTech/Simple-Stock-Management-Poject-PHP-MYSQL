<?php
include_once('../../conn/conn.php');
include("../../services/fetchData.php");
include("../../services/storeData.php");
include("../../services/updateData.php");
include("../../services/deleteData.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && !empty($_POST['name']) 
    && !empty($_POST['price']) && !empty($_POST['stock_quantity'])) {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'stock_quantity' => $_POST['stock_quantity']
        ];
        if (updateData("products", $data, $_POST['id'])) {
            $type = "success";
            $msg = "product updated successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    } else if (isset($_POST['store']) && !empty($_POST['name']) 
    && !empty($_POST['price']) && !empty($_POST['stock_quantity'])) {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'stock_quantity' => $_POST['stock_quantity']
        ];
        if (storeData("products", $data)) {
            $type = "success";
            $msg = "product created successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    }else if(isset($_POST['delete']) && !empty($_POST['id'])){
        if (deleteData("products" ,$_POST['id'])){ 
            $type = "success";
            $msg = "product removed successfully";
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

$products = fetchData("products");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>Product Management</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <?php include("../../layout/header.php") ?>
    <main>
        <section>
            <h3 class="heading">Product Management</h3>
            <div class="card table-container" style="border: none">
                <div class="container">
                    <button id="new-product" class="button warning-button" style="float: right">
                        new product
                    </button>
                </div>
                <?php
                isset($msg) ? include("../../components/alert.php") : '';
                ?>
                <div class="card new-item" id="new-product-form">
                    <form action="" method="post">
                        <input type="hidden" name="store">
                        <input type="text" class="input" name="name" placeholder="name" />
                        <input type="price" class="input" name="price"  placeholder="price" />
                        <input type="text" class="input" name="stock_quantity" placeholder="stock quantity" />
                        <button class="button primary-button" style="padding: 8px 15px">
                            Save
                        </button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>price</th>
                                <th>Stock Quantity</th>
                                <th style="min-width: 8rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $product) {
                            ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['price'] ?></td>
                                    <td><?= $product['stock_quantity'] ?></td>
                                    <td style="width: 10rem">
                                        <button class="button success-button" id="openModalBtn<?= $product['id'] ?>">
                                            edit
                                        </button>
                                        <button class="button danger-button" id="delete" onclick="handleDelete(<?= $product['id'] ?>)">
                                            delete
                                        </button>
                                        <form  method="post" style="display: none">
                                            <input name="delete">
                                            <input name="id" value="<?= $product['id'] ?>">
                                            <button id="form-del-<?=$product['id']?>" >delete</button>
                                        </form>
                                        <div id="myModal<?= $product['id'] ?>" class="modal">
                                            <div class="modal-content">
                                                <div class="card new-item">
                                                    <div style="font-weight: bold; margin-bottom: 12px">
                                                        Edit product
                                                    </div>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="update">
                                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                        <input type="text" class="input" name="name" placeholder="Name" value="<?= $product['name']  ?>" />
                                                        <input type="price" class="input" name="price" placeholder="price" value="<?= $product['price']  ?>" />
                                                        <input type="text" class="input" name="stock_quantity" placeholder="stock_quantity" value="<?= $product['stock_quantity'] ?>" />
                                                        <div class="btn-container">
                                                            <button class="button primary-button" style="padding: 8px 15px">
                                                                Save
                                                            </button>
                                                            <button class="button secondary-button" style="padding: 8px 15px" type="button" id="closeModalBtn<?= $product['id'] ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            setModal(<?= $product['id'] ?>)
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
        new_item_content = document.getElementById("new-product-form");
        new_item_content.classList.toggle("d-none");
        let button = document.getElementById("new-product");
        button.addEventListener("click", () => {
            new_item_content.classList.toggle("d-none");
        });
        const handleDelete = (id) => {
            if (confirm("delete confirmation")){
                document.getElementById('form-del-'+id).click();
            }
        }
    </script>
</body>

</html>