<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath ?>/assets/css/style_story.css">
    <title><?php echo $texte->titel ?> - <?php echo $texte->story ?></title>
</head>

<body>
    <?php
    include '../../navbar.php';
    ?>
    <div class="site-div-content" style="padding: 10px">
        <h2>About Us</h2>
        <h5>TBZ Modul 133</h5>
        <img src="<?php echo $rootpath ?>/assets/img/tbzlogo.png" alt="TBZ Logo" width="400px" style="margin: 5px;">
        <p>TBZ Projekt in Modul 133 von Jon Bunjaku, Milka Grolp und Florian Gubler</p>
    </div>
    <?php
        include '../../footer.php';
    ?>
</body>

</html>