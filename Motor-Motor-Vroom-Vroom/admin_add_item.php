<?php
//Guard
require_once 'avengers.php';
Guard::adminOnly();

$categories = Category::all();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Categories</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="icon" href="uploads/logo-circle.png" type="image/png">
</head>
<body>

    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="wrapper">
                <div class="w-40p">
                    <div class="subtitle">Add New Product</div>
                    <hr/>

                    <div class="card">
                        <div class="card-content">
                            <form method="POST" action="api/product_controller.php?action=add">

                                <?php displayFlashMessage('add_product') ?>

                                <div class="form-control">
                                    <label>Name</label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        required="" 
                                    />
                                </div>

                                <div class="form-control mt-16">
                                    <label>Category</label>
                                    <select name="category_id" required="">
                                        <option value=""> -- Select Category --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-control mt-16">
                                    <label>Quantity</label>
                                    <input required="" type="number" step="1" min="0" name="quantity" />
                                </div>

                                <div class="form-control mt-16">
                                    <label>Price</label>
                                    <input required="" type="number" step=".25" name="price" />
                                </div>

                                <div class="mt-16">
                                    <button class="btn btn-primary w-full" type="submit">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>
<style>
*{
    font-family: "Oswald";
    font-size: 14px;
}
</style>