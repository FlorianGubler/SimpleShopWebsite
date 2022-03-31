<?php
    include "../../config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_cart.css">
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/stripe.css">
    <script src="https://js.stripe.com/v3/"></script>
    <title><?php echo $texte->titel ?> - <?php echo $texte->checkout ?></title>
</head>

<body>
<?php
include '../../navbar.php';
?>
<div class="site-div-content">
    <div class="row">
        <div class="col-75">
            <div class="container">
                <form method="POST" id="payment-form">
                    <div class="row">
                        <div class="col-50">
                            <h3><?php echo $texte->address ?></h3>
                            <label for="fname"><?php echo $texte->fullname ?></label>
                            <input type="text" id="fname" name="fullname" placeholder="<?php echo $texte->fullname ?>" required>
                            <label for="email"><?php echo $texte->email ?></label>
                            <input type="text" id="email" name="email" placeholder="<?php echo $texte->email ?>" required>
                            <label for="adr"><?php echo $texte->address ?></label>
                            <input type="text" id="adr" name="address" placeholder="<?php echo $texte->address ?>" required>
                            <label for="city"><?php echo $texte->city ?></label>
                            <input type="text" id="city" name="city" placeholder="<?php echo $texte->city ?>" required>

                            <div class="row">
                                <div class="col-50">
                                    <label for="state"><?php echo $texte->state ?></label>
                                    <input type="text" id="state" name="state" placeholder="<?php echo $texte->state ?>" required>
                                </div>
                                <div class="col-50">
                                    <label for="zip"><?php echo $texte->postcode ?></label>
                                    <input type="text" id="zip" name="postcode" placeholder="1234" required>
                                </div>
                            </div>
                            <div id="payment-element">
                                <!--Stripe.js injects the Payment Element-->
                            </div>
                            <button id="submit">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="button-text"><?php echo $texte->send ?></span>
                            </button>
                            <div id="payment-message" class="hidden"></div>
                        </div>
                    </div>
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
<script src="<?php echo $rootpath ?>/assets/js/checkout.js"></script>
<?php
include '../../footer.php';
?>
</body>
</html>