<div class="footer-container">
    <ul>
        <li class="footer-ul-item">
            <a href="<?php echo $rootpath ?>/index.php">Home</a>
        </li>
        <li class="footer-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/shop.php">Shop</a>
        </li>
        <li class="footer-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/story.php">Background Story</a>
        </li>
        <li class="footer-ul-item">
            <a href="<?php echo $rootpath ?>/assets/sites/contact.php">Contact</a>
        </li>
    </ul>
    <div class="footer-socialmedia-container">
        <ul>
            <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
            <li><a href="mailto:"><i class="far fa-envelope"></i></a></li>
        </ul>
    </div>
    <div class="footer-extra-container">
        <p class="footer-cp-text">
            &copy; by Florian Gubler, Jon Bunjaku, Milka Grolp 2022 (Projekt Modul 133)
        </p>
        <?php
            if(!$_SESSION["admin"]){
                ?>
                    <a class="footer-login" href="<?php echo $rootpath ?>/assets/sites/admin.php">Login</a>
                <?php
            } else{
                ?>
                    <a class="footer-login" href="<?php echo $rootpath ?>/assets/sites/admin.php?logout=true">Logout</a>
                <?php
            }
        ?>
    </div>
</div>