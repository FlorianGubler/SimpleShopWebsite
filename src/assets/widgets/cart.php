<?php
require_once "../../config.php";
$endprice = 0;
$shippingprice = 5;
?>
<ul class="cart-container-list">
    <?php
    if(count($_SESSION["cart"]) > 0){
    ?>
    <li>
        <ul id="cart-items-list">
            <?php
                foreach ($_SESSION["cart"] as $cartobj){ //cartobj: [productid, count, colorid]
                    $cartproduct = $conn->getProduct($cartobj[0]);
                    $endprice += $cartobj[1] * $cartproduct["price"];
                    ?>
                    <li>
                        <div class="cart-product-container">
                            <button class="cart-product-removeBtn" onclick="deleteItemFromCart(<?php echo $cartobj[0]; ?>, <?php echo $cartobj[2]; ?>)">
                                <svg class="svg-inline--fa fa-times-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="far" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z"></path>
                                </svg>
                            </button>
                            <div class="cart-data-img-container">
                                <div class="cart-product-img-container">
                                    <img src="http://shop/assets/img/product_images/<?php echo $cartproduct['picture']; ?>">
                                </div>
                                <div class="cart-product-data-container">
                                    <p><?php echo $cartproduct['productname']; ?></p>
                                    <div class="cart-color-container">
                                        <?php
                                            $choosencolor = $conn->getColorByID($cartobj[2]);
                                        ?>
                                        <div class="product-color-coloritem cart-color-coloritem" style="background-color: <?php echo $choosencolor['colorcode']; ?>"></div>
                                    </div>
                                    <div class="cart-amount-container">
                                        <button class="cart-changeAmount-minus" onclick="amountMinusCart(<?php echo $cartobj[0]; ?>, <?php echo $cartobj[2]; ?>)">
                                            <svg class="svg-inline--fa fa-minus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
                                            </svg>
                                        </button>
                                        <span class="cart-product-amount"><?php echo $cartobj[1]; ?></span>
                                        <button class="cart-changeAmount-plus" onclick="amountPlusCart(<?php echo $cartobj[0]; ?>, <?php echo $cartobj[2]; ?>)">
                                            <svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="price-status-container"><p class="priceTag">CHF <?php echo $cartproduct['price'] * $cartobj[1]; ?></p>
                                <p class="statusTag" style="color: <?php if($cartproduct['status'] == 'available') {echo 'green';} else {echo 'red';} ?>;"><?php echo $cartproduct['status']; ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="cart-splitline"></li>
                    <?php
                }
            ?>
        </ul>
    </li>
    <?php
        $endprice = round($endprice, 2);
    ?>
    <li id="cart-calc-price" class="cart-calc-price">
        <table>
            <tbody><tr>
                <th>Price products: </th>
                <td>CHF <?php echo $endprice; ?></td>
            </tr>
            <tr>
                <th>Shipping: </th>
                <td>CHF <?php echo $shippingprice; ?></td>
            </tr>
            <tr>
                <th>Endprice: </th>
                <td>CHF <?php echo $endprice + $shippingprice; ?></td>
            </tr>
            </tbody>
        </table>
    </li>
    <?php
    } else{
        ?>
        <li style="width: 100%; text-align: center; margin-top: 10px" class="cart-empty">Cart is empty</li>
        <?php
    }
    ?>
</ul>