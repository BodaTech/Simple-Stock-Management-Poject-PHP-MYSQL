<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="/assets/icon/stock.png" type="image/x-icon">
    <title>Home Page</title>
    <title>Document</title>
  </head>
  <body>
    <?php include("layout/header.php") ?> 
    <main>
      <section class="main-section">
        <div class="content">
          <h2>Welcome to the Store Management System</h2>
          <p>
            This system allows you to easily manage the products, customers, and
            orders in your store.
          </p>
        </div>
        <a href="#functionality" class="btn btn-light btn-md">Our Features</a>
      </section>
      <section
        class="functionality"
        id="functionality"
        style="padding-top: 25px"
      >
        <h2>Main Features:</h2>
        <div class="card-container">
          <div class="card">
            <div class="card-header">Client Management</div>
            <div class="card-body">
              <p>
                Our client management system allows you to easily track
                information about your customers.
              </p>
            </div>
            <div class="card-footer">
              <a href="pages/client/index.php" class="btn btn-dark btn-md">Learn More</a>
            </div>
          </div>
          <div class="card">
            <div class="card-header">Product Management</div>
            <div class="card-body">
              <p>
                Product management enables you to add, modify, and delete
                products in your catalog.
              </p>
            </div>
            <div class="card-footer">
              <a href="/pages/product/index.php" class="btn btn-dark btn-md">Learn More</a>
            </div>
          </div>
          <div class="card">
            <div class="card-header">Order Management</div>
            <div class="card-body">
              <p>
                Simplify the management of your customer's orders and ensure fast and reliable
                service.
              </p>
            </div>
            <div class="card-footer">
              <a href="/pages/order/index.php" class="btn btn-primary btn-dark btn-md">Learn More</a>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include("layout/footer.php") ?>
  </body>
</html>
