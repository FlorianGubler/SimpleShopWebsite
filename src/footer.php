<div class="footer-container">
    <ul>
        <li class="footer-ul-item">
            <a href="<?php echo $rootpath ?>/src/index.php.php">Home</a>
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
        <ul style="display:flex; flex-direction: row; align-items: center; justify-content: flex-end;">
            <?php
                $alllanguages = array_diff(scandir($_SERVER['DOCUMENT_ROOT'] . "/assets/language/"), array('.', '..'));
                foreach ($alllanguages as $file) {
                    $iscurrent = "";
                    $lang = pathinfo($file, PATHINFO_FILENAME);
                    if(strtolower($lang) == $_SESSION["lang"]){
                        $iscurrent = "text-decoration: underline;";
                    }
                    echo "<li style='list-style: none; margin: 5px;' class='footer-ul-item'><a style='text-decoration: none; $iscurrent' href='$rootpath/actionmgr.php?action=changelanguage&redirect=" . $_SERVER["PHP_SELF"] . "&newlang=$lang'>" . strtoupper($lang) . "</a></li>";
                }
            ?>
        </ul>
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