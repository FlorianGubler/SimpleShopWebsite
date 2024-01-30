<?php
require_once "config.php";
if (isset($_POST['getjsonofproduct'])) {
    echo $conn->getJSONofProduct($_POST['pkproduct']);
    exit;
}
?>
<script>
    const rootpath = "<?php echo $rootpath; ?>";
    const TEXTE = JSON.parse('<?php echo json_encode($texte) ?>');
    const LANG = '<?php echo $_SESSION["lang"]; ?>';
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
        if ($_SESSION["admin"]) {
            echo $_SESSION["adminuser"]["username"] . " <i style='color: darkgray'>(" . $_SESSION["adminuser"]["email"] . ")</i>";
        }
        ?>
    </div>
    <div class="navbar-logo-container">
        <img src="<?php echo $rootpath ?>/assets/img/logo.png">
    </div>
    <div id="expand-cart" class="navbar-cart-container">
        <button onclick="expandcart(<?php echo $carteditable  ? 'true' : 'false'; ?>);"><i class="fas fa-shopping-cart"></i></button>
    </div>
</div>
<div id="navbar">
    <div class="navbar-container">
        <ul>
            <li class="navbar-ul-item">
                <a href="<?php echo $rootpath ?>/index.php"><?php echo strtoupper($texte->home); ?></a>
            </li>
            <li class="navbar-ul-item">
                <a href="<?php echo $rootpath ?>/assets/sites/shop.php"><?php echo strtoupper($texte->shop); ?></a>
            </li>
            <li class="navbar-ul-item">
                <a href="<?php echo $rootpath ?>/assets/sites/story.php"><?php echo strtoupper($texte->story); ?></a>
            </li>
            <li class="navbar-ul-item">
                <a href="<?php echo $rootpath ?>/assets/sites/contact.php"><?php echo strtoupper($texte->contact); ?></a>
            </li>
            <?php
            if ($_SESSION["admin"]) {
            ?>
                <li class="navbar-ul-item">
                    <a href="<?php echo $rootpath ?>/assets/sites/admin.php"><?php echo strtoupper($texte->admin); ?></a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div onclick="expandMenuclicked()" class="navbar-onclickout"></div>
</div>
<div id="cart-container">
    <div class="cart-content-container">
        <p class="cart-title"><?php echo $texte->cart; ?> <i class="fas fa-shopping-cart"></i></p>
        <button class="close-cart-btn" onclick="closecart();"><i class="fas fa-times"></i></button>
        <div id="cart-content-container">

        </div>
        <button class="cart-checkout-btn" onclick="location.href = rootpath + '/assets/sites/checkout.php'"><i class="fa fa-shopping-cart"></i> <?php echo $texte->checkout; ?></button>
    </div>
</div>
<div id="messages-container"></div>
<noscript>You need to have JavaScript enabled to run this site</noscript>
<script>
    <?php
    if (isset($_SESSION["showmessage"])) {
        echo "showMessage('" . $_SESSION["showmessage"]["type"] . "', '" . $_SESSION["showmessage"]["text"] . "');";
        unset($_SESSION["showmessage"]);
    }
    ?>
</script>
<script src="<?php echo $rootpath; ?>/assets/js/expandmenu.js"></script>
<script src="<?php echo $rootpath; ?>/assets/js/cart_mgr.js"></script>