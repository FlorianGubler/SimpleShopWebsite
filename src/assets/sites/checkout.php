<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_cart.css">
    <title>Shop Gruppenprojekt - Checkout</title>
</head>

<body>
<?php
include '../../navbar.php';
?>
<div class="site-div-content">
    <div class="row">
        <div class="col-75">
            <div class="container">
                <form action="<?php echo $rootpath; ?>/src/actionmgr.php.php" method="POST">
                    <div class="row">
                        <div class="col-50">
                            <h3>Address</h3>
                            <label for="fname">Full Name</label>
                            <input type="text" id="fname" name="fullname" placeholder="Max Muster">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" placeholder="maxmuster@example.com">
                            <label for="adr">Address</label>
                            <input type="text" id="adr" name="address" placeholder="Beispielstrasse 1">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="City">

                            <div class="row">
                                <div class="col-50">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" placeholder="State">
                                </div>
                                <div class="col-50">
                                    <label for="zip">Postcode</label>
                                    <input type="text" id="zip" name="zip" placeholder="1234">
                                </div>
                            </div>
                        </div>

                        <div class="col-50">
                            <h3>Payment</h3>
                            <label for="fname">Accepted Cards</label>
                            <div class="icon-container">
                                <i class="fa-brands fa-cc-visa" style="color:navy;"></i>
                                <i class="fa-brands fa-cc-amex" style="color:blue;"></i>
                                <i class="fa-brands fa-cc-mastercard" style="color:red;"></i>
                                <i class="fa-brands fa-cc-discover" style="color:orange;"></i>
                            </div>
                            <label for="cname">Name on Card</label>
                            <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                            <label for="ccnum">Credit card number</label>
                            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                            <label for="expmonth">Exp Month</label>
                            <input type="text" id="expmonth" name="expmonth" placeholder="September">
                            <div class="row">
                                <div class="col-50">
                                    <label for="expyear">Exp Year</label>
                                    <input type="text" id="expyear" name="expyear" placeholder="2018">
                                </div>
                                <div class="col-50">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="352">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Checkout" class="btn">
                </form>
            </div>
        </div>
        <div class="col-25">
            <div class="container" style="background-color: white" id="checkout-cart-container">
            </div>
            <script>
                addCartShow("checkout-cart-container");
                reloadCart();
            </script>
        </div>
    </div>
</div>
<?php
include '../../footer.php';
?>
</body>
</html>