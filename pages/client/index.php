<?php
include_once('../../conn/conn.php');
include("../../services/fetchData.php");
include("../../services/storeData.php");
include("../../services/updateData.php");
include("../../services/deleteData.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && !empty($_POST['name']) 
    && !empty($_POST['email']) && !empty($_POST['address'])) {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'address' => $_POST['address']
        ];
        if (updateData("clients", $data, $_POST['id'])) {
            $type = "success";
            $msg = "client updated successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    } else if (isset($_POST['store']) && !empty($_POST['name']) 
    && !empty($_POST['email']) && !empty($_POST['address'])) {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'address' => $_POST['address']
        ];
        if (storeData("clients", $data)) {
            $type = "success";
            $msg = "client created successfully";
        } else {
            $type = "danger";
            $msg = "bad request, please try again";
        }
    }else if(isset($_POST['delete']) && !empty($_POST['id'])){
        if (deleteData("clients" ,$_POST['id'])){ 
            $type = "success";
            $msg = "client removed successfully";
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

$clients = fetchData("clients");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>Client Management</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <?php include("../../layout/header.php") ?>
    <main>
        <section>
            <h3 class="heading">Client Management</h3>
            <div class="card table-container" style="border: none">
                <div class="container">
                    <button id="new-product" class="button warning-button" style="float: right">
                        new client
                    </button>
                </div>
                <?php
                isset($msg) ? include("../../components/alert.php") : '';
                ?>
                <div class="card new-item" id="new-product-form">
                    <form action="" method="post">
                        <input type="hidden" name="store">
                        <input type="text" class="input" name="name" id="name" placeholder="Name" />
                        <input type="email" class="input" name="email" id="email" placeholder="Email" />
                        <input type="text" class="input" name="address" id="address" placeholder="Address" />
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
                                <th>Email</th>
                                <th>Address</th>
                                <th style="min-width: 8rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($clients as $client) {
                            ?>
                                <tr>
                                    <td><?= $client['id'] ?></td>
                                    <td><?= $client['name'] ?></td>
                                    <td><?= $client['email'] ?></td>
                                    <td><?= $client['address'] ?></td>
                                    <td style="width: 10rem">
                                        <button class="button success-button" id="openModalBtn<?= $client['id'] ?>">
                                            edit
                                        </button>
                                        <button class="button danger-button" id="delete" onclick="handleDelete(<?= $client['id'] ?>)">
                                            delete
                                        </button>
                                        <form  method="post" style="display: none">
                                            <input name="delete">
                                            <input name="id" value="<?= $client['id'] ?>">
                                            <button id="form-del-<?=$client['id']?>" >delete</button>
                                        </form>
                                        <div id="myModal<?= $client['id'] ?>" class="modal">
                                            <div class="modal-content">
                                                <div class="card new-item">
                                                    <div style="font-weight: bold; margin-bottom: 12px">
                                                        Edit Client
                                                    </div>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="update">
                                                        <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                                        <input type="text" class="input" name="name" placeholder="Name" value="<?= $client['name']  ?>" />
                                                        <input type="email" class="input" name="email" placeholder="Email" value="<?= $client['email']  ?>" />
                                                        <input type="text" class="input" name="address" placeholder="Address" value="<?= $client['address'] ?>" />
                                                        <div class="btn-container">
                                                            <button class="button primary-button" style="padding: 8px 15px">
                                                                Save
                                                            </button>
                                                            <button class="button secondary-button" style="padding: 8px 15px" type="button" id="closeModalBtn<?= $client['id'] ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            setModal(<?= $client['id'] ?>)
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