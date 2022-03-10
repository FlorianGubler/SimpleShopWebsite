<?php
include "config.php";
if (isset($_POST['getjsonofproduct'])) {
    echo $conn->getJSONofProduct($_POST['pkproduct']);
    exit;
}
?>
<script>
    const rootpath = "<?php echo $rootpath; ?>";
</script>

<div class="expand-navbar">
    <a onclick="expandMenuclicked();">
        <div id="nav-icon">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </a>
</div>
<div class="header-bar">
    <div style="margin-left: 70px;">
        <?php
            if($_SESSION["admin"]){
                echo $_SESSION["adminuser"]["username"] . " <i style='color: darkgray'>(" . $_SESSION["adminuser"]["email"] . ")</i>";
            }
        ?>
    </div>
    <div class="navbar-logo-container">
        <img src="<?php echo $rootpath ?>/assets/img/logo.png">
    </div>
    <div id="expand-cart" class="navbar-cart-container">
        <button onclick="expandcart();"><i class="fas fa-shopping-cart"></i></button>
    </div>
</div>
<div id="navbar" class="navbar-container">
    <ul>
        <li class="navbar-ul-item">
            <a href="<?php echo $rootpath ?>/index.php">HOME</a>
        </li>
        <li class="navbar-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/shop.php">SHOP</a>
        </li>
        <li class="navbar-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/story.php">OUR STORY</a>
        </li>
        <li class="navbar-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/contact.php">CONTACT</a>
        </li>
        <?php
            if($_SESSION["admin"]){
                ?>
                    <li class="navbar-ul-item">
                        <a href="<?php echo $rootpath ?>/assets/sites/admin.php">ADMIN</a>
                    </li>
                <?php
            }
        ?>
    </ul>
</div>
<div id="cart-container">
    <div class="cart-content-container">
        <p class="cart-title">Cart <i class="fas fa-shopping-cart"></i></p>
        <button class="close-cart-btn" onclick="closecart();"><i class="fas fa-times"></i></button>
        <ul class="cart-container-list">
            <li>
                <ul id="cart-items-list">

                </ul>
            </li>
            <li id="cart-calc-price" class="cart-calc-price">
                <table>
                    <tr>
                        <th>Price products: </th>
                        <td>CHF <span id="products-endprice"></span>.-</td>
                    </tr>
                    <tr>
                        <th>Shipping: </th>
                        <td>CHF <span id="products-shippingprice"></span>.-</td>
                    </tr>
                    <tr>
                        <th>Endprice: </th>
                        <td>CHF <span id="endprice"></span>.-</td>
                    </tr>
                </table>
            </li>
        </ul>
        <div id="cart-items-empty">Cart is empty</div>
        <button class="cart-checkout-btn">Checkout</button>
    </div>
</div>
<noscript>You need to have JavaScript enabled to run this site</noscript>
<script src="<?php echo $rootpath; ?>/assets/js/expandmenu.js"></script>
<script src="<?php echo $rootpath; ?>/assets/js/cart_mgr.js"></script>