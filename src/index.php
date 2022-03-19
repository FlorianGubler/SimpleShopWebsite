<?php
include "config.php";

$newestproducts = $conn->getNewestProducts(3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_home.css">
    <title>Gruppenprojekt - Home</title>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="site-div-content-container">
        <div class="site-div-content">
            <div class="title-content">
                <div class="title-content-text">
                    <h1>Willkommen, Bienvenue, Benvenuto</h1>
                    <a href="<?php echo $rootpath; ?>/assets/sites/shop.php">SHOP</a>
                </div>
                <img src="assets/img/title_image.jpg">
            </div>
            <div class="splitline"></div>
            <div class="newest-products-container">
                <?php
                foreach ($newestproducts as $product) {
                ?>
                    <div class="product-container">
                        <div id="product-<?php echo $product["PK_product"]; ?>" class="product-image-container">
                            <?php
                            if ($product["status"] == "sold_out") {
                            ?>
                                <div class="product-addtocart-container" style="width: 50px;">
                                    <p style="color: red; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">sold out</p>
                                </div>

                            <?php
                            }
                            foreach ($product["pictures"] as $product_picture) {
                                echo "<img class='product-image-img' src='$rootpath/assets/img/product_images/" . $product_picture . "'>";
                            }
                            echo "<div class='product-images-slider-container'>";
                            for ($i = 1; $i <= count($product["pictures"]); $i++) {
                                echo "<div class='product-images-sliderBtn' onclick='currentDiv(this.parentElement.parentElement.id, $i)'></div>";
                            }
                            echo "</div>";
                            ?>
                        </div>
                        <div class="product-data-container">
                            <p class="product-productname"><?php echo $product["productname"]; ?></p>
                            <p class="product-productprice">CHF <?php echo $product["price"]; ?></p>
                        </div>
                        <div class="product-color-container">
                            <?php
                            foreach ($product["colors"] as $product_color) {
                            ?>
                                <div class="product-color-coloritem" style="background-color: <?php echo $product_color['colorcode']; ?>;"></div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script src="assets/js/slider.js"></script>
    <?php
    include 'footer.php';
    ?>
</body>

</html>