<?php
    include_once('../../conn/conn.php');
    include("../../services/fetchData.php");
    include("../../services/storeData.php");
    include("../../services/updateData.php");
    include("../../services/deleteData.php");

    $clients = fetchData("clients");
    $products = fetchData("products");

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = [
            'client_id' => $_POST['client_id'],
            'date' => $_POST['date'],
            'product_id' => $_POST['product_id'],
            'quantity' => $_POST['quantity'],
            'unit_price' => $_POST['unit_price'],
        ];
        if(storeOrder($data)){
            $type = "success";
            $msg = "order created successfully";
        }else{
            $type = "danger";
            $msg = "bad request, please try again";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>New Order</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <?php include("../../layout/header.php") ?>
    <main>
        <section>
            <h3 class="heading">Order Management</h3>
            <form action="" method="post" class="card table-container" style="border: none">
                <div class="container" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                    <a href="/pages/order/index.php" class="button secondary-button" style="font-size: 12px;">
                        back
                    </a>
                    <button class="button success-button" style="font-size: 12px;">save order</button>
                </div>
                <?php isset($msg) ? include("../../components/alert.php") : ''; ?>
                <div>
                    <div class="form-group">
                        <label for="">client</label>
                        <select name="client_id">
                            <option value="">select the client</option>
                            <?php
                            foreach ($clients as $client) {
                            ?>
                                <option value="<?= $client['id'] ?>">
                                    <?= $client['name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top: 5px;">
                        <label for="">date</label>
                        <input type="date" class="input" name="date">
                    </div>
                    <div class="products-container">
                        <div class="product" style="display: flex;">
                            <div class="form-group">
                                <label for="">product</label>
                                <select name="product_id[]">
                                    <option value="">select the product</option>
                                    <?php
                                        foreach ($products as $product) {
                                            ?>
                                                <option value="<?= $product['id'] ?>">
                                                    <?= $product['name'] ?>
                                                </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-container">
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input class="input" type="number" name="quantity[]" placeholder="Quantity">
                                </div>
                                <div class="form-group">
                                    <label for="">Unit Price</label>
                                    <input class="input" type="text" name="unit_price[]" placeholder="Unit price">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="button primary-button addButton">add new product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <script>
      const Product = `<div class="product" style="display: flex;">
                            <div class="form-group">
                            <label for="">product</label>
                                <select name="product_id[]">
                                    <option value="">select the product</option>
                                    <?php
                                        foreach ($products as $product) {
                                            ?>
                                                <option value="<?= $product['id'] ?>">
                                                    <?= $product['name'] ?>
                                                </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-container">
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input class="input" type="number" name="quantity[]" placeholder="Quantity">
                                </div>
                                <div class="form-group">
                                    <label for="">Unit Price</label>
                                    <input class="input" type="text" name="unit_price[]" placeholder="Unit price">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="button danger-button deleteButton">Delete this product</button>
                            </div>
                        </div>`

      function deleteProduct() {
        const product = this.closest(".product");
        if (product) {
          product.remove();
        }
      }

      let productsContainer = document.querySelector(".products-container");

      const addButton = document.querySelector(".addButton");
      addButton.addEventListener("click", function () {
        const product = Product;

        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = product.trim();
        const productElement = tempDiv.firstChild;

        const deleteButton = productElement.querySelector(".deleteButton");
        deleteButton.addEventListener("click", function () {
          deleteProduct.call(this);
        });

        productsContainer.appendChild(productElement);
      });
    </script>
</body>

</html>