<?php
    include "../../config.php";
    $contact_upload_failed = false;
    $contact_uploaded = false;

    if(isset($_GET['upload'])){
        $contact_uploaded = $_GET['upload'];
    }

    if(isset($_POST['contact-submit'])){
        if($conn->createCustomerRequest($_POST['contact-email'], $_POST['contact-subject'], $_POST['contact-text'])){
            header("Location: $rootpath/assets/sites/contact.php?upload=true");
        }
        else{
            $contact_upload_failed = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath?>/assets/css/style_contact.css">
    <title><?php echo $texte->titel ?> - <?php echo $texte->contact ?></title>
</head>

<body>
    <?php
        include '../../navbar.php';
    ?>
    <div class="site-div-content">
        <div class="contact-form-container">
            <form action="" method="post">
                <div class="contact-inputs-container">
                    <label for="contact-input-email"><?php echo $texte->email ?></label>
                    <input id="contact-input-email" type="email" name="contact-email" placeholder="max@example.net" required>
                </div>

                <div class="contact-inputs-container">
                    <label for="contact-input-subject"><?php echo $texte->subject ?></label>
                    <input id="contact-input-subject" type="text" maxlength="255" name="contact-subject" placeholder="<?php echo $texte->subject ?>" required>
                </div>

                <div class="contact-inputs-container">
                    <label for="contact-input-text"><?php echo $texte->question ?></label>
                    <textarea id="contact-input-text" name="contact-text" placeholder="<?php echo $texte->question ?>" required></textarea>
                </div>

                <button type="submit" name="contact-submit"><?php echo $texte->send ?></button>
            </form>
        </div>
        <?php
            if($contact_upload_failed){
                ?>
                    <div class="contact-upload-failed">
                        <p><i class="fas fa-times"></i><?php echo $texte->error ?></p>
                    </div>
                <?php
            }
            else if(!$contact_upload_failed && $contact_uploaded){
                ?>
                    <div class="contact-upload-success">
                        <p><i class="fas fa-check"></i><?php echo $texte->contactformuploaded ?></p>
                    </div>
                <?php
            }
        ?>
    </div>
    <?php
        include '../../footer.php';
    ?>
</body>

</html>