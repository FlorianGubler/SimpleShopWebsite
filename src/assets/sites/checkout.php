<?php
    include "../../config.php";
    if(isset($_POST["checkout"])){
        $conn->CreateOrder($_POST["fullname"], $_POST["email"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["postcode"], $_SESSION["cart"]);
        //Add Payment
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_cart.css">
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
                <form method="POST">
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
                        </div>

                        <div class="col-50">
                            <h3>Payment</h3>
                            <label for="fname"><?php echo $texte->acceptedcards ?></label>
                            <div class="icon-container">
                                <i class="fa-brands fa-cc-visa" style="color:navy;"></i>
                                <i class="fa-brands fa-cc-amex" style="color:blue;"></i>
                                <i class="fa-brands fa-cc-mastercard" style="color:red;"></i>
                                <i class="fa-brands fa-cc-discover" style="color:orange;"></i>
                            </div>
                            <label for="cname"><?php echo $texte->nameoncard ?></label>
                            <input type="text" id="cname" name="cardname" placeholder="<?php echo $texte->nameoncard ?>">
                            <label for="ccnum"><?php echo $texte->cardnumber ?></label>
                            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                            <label for="expmonth"><?php echo $texte->expirationmonth ?></label>
                            <input type="text" id="expmonth" name="expmonth" placeholder="<?php echo $texte->expirationmonth ?>">
                            <div class="row">
                                <div class="col-50">
                                    <label for="expyear"><?php echo $texte->expirationyear ?></label>
                                    <input type="text" id="expyear" name="<?php echo $texte->expirationyear ?>" placeholder="2018">
                                </div>
                                <div class="col-50">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" name="CVV" placeholder="352">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="checkout" class="btn"><?php echo $texte->send ?></button>
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