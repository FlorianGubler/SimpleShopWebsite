<?php
include "../../config.php";

$products = $conn->getAllProducts();
$allActiveColors = $conn->getAllActiveColors();

$maxminPrice = $conn->getMaxMinPrice();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php';
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_shop.css">
    <title>Shop Gruppenprojekt - Shop</title>
</head>

<body>
    <script>
        const colorsWithCodes = JSON.parse('<?php echo json_encode($conn->getAllColors()); ?>');
    </script>
    <?php
    include '../../navbar.php';
    ?>
    <div class="site-div-content-container">
        <div class="searchbar-container">
            <div class="searchbar-content-container">
                <p class="searchbar-icon-container"><i class="fas fa-search"></i></p>
                <input type="text" id="products-searching" onkeyup="searchProducts();" placeholder="Search products...">
            </div>
            <div class="searchbar-filter-container">
                <select class="filter-option" name="color" onchange="filterProducts();">
                    <option disabled selected>Color</option>
                    <option>None</option>
                    <?php
                    foreach ($allActiveColors as $color) {
                    ?>
                        <option><?php echo strtoupper($color["color_tag"]); ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="price-filter-container">
                    <label>Price</label>
                    <div class="price-filter-slider-container">
                        <input id="price-filter-slider" step="0.01" type="range" min="<?php echo $maxminPrice["min_price"]; ?>" max="<?php echo $maxminPrice["max_price"]; ?>" value="<?php echo $maxminPrice["max_price"]; ?>" class="filter-option" name="price" oninput="document.getElementById('price-filter-slider-textval').innerHTML = 'CHF ' + this.value;" onchange="filterProducts();">
                        <p id="price-filter-slider-textval"></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo "<div class='products-content-container'>";
        echo "<div id='nothing-found'><p>Nothing found</p></div>";
        foreach ($products as $product) {
        ?>
            <div class="product-container">
                <div id="product-<?php echo $product["PK_product"]; ?>" class="product-image-container">
                    <?php
                    if ($product["status"] != "sold_out") {
                    ?>
                        <div class="product-addtocart-container">
                            <button onclick="openColorChoose(JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode($product['colors'])); ?>')), <?php echo $product["PK_product"]; ?>)"><i class="fas fa-cart-arrow-down"></i></button>
                        </div>
                    <?php
                    } else {
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
        echo "</div>";
        ?>
    </div>
    <script>
        function openColorChoose(colors, productid){
            container = CreatePopUpWindow('Choose Product Color');
            content = container.getElementsByClassName("popup-content")[0];
            label = content.appendChild(document.createElement("p"));
            label.innerHTML = "Choose a Color";
            label.className = "center-label";
            colorcontainer = content.appendChild(document.createElement("div"));
            colorcontainer.className = "colorcontainer";
            colors.forEach(color => {
                coloritem = colorcontainer.appendChild(document.createElement("div"));
                coloritem.className = "product-color-coloritem cart-color-coloritem cart-color-btn";
                coloritem.style.backgroundColor = color['colorcode'];
                coloritem.addEventListener("click", e => {
                    addtocart(productid, color['PK_color']);
                    container.remove();
                });
            })
        }
    </script>
    <script src="<?php echo $rootpath; ?>/assets/js/slider.js"></script>
    <script src="<?php echo $rootpath; ?>/assets/js/product_search.js"></script>
    <?php
    include '../../footer.php';
    ?>
</body>

</html>