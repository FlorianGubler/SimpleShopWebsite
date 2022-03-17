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
    <title>Shop Gruppenprojekt - Contact</title>
</head>

<body>
    <?php
        include '../../navbar.php';
    ?>
    <div class="site-div-content">
        <div class="contact-form-container">
            <form action="" method="post">
                <div class="contact-inputs-container">
                    <label for="contact-input-email">Email</label>
                    <input id="contact-input-email" type="email" name="contact-email" placeholder="max@example.net" required>
                </div>

                <div class="contact-inputs-container">
                    <label for="contact-input-subject">Subject</label>
                    <input id="contact-input-subject" type="text" maxlength="255" name="contact-subject" placeholder="I have a question about..." required>
                </div>

                <div class="contact-inputs-container">
                    <label for="contact-input-text">Request / Question</label>
                    <textarea id="contact-input-text" type="text" name="contact-text" placeholder="My question is..." required></textarea>
                </div>

                <button type="submit" name="contact-submit">Submit</button>
            </form>
        </div>
        <?php
            if($contact_upload_failed){
                ?>
                    <div class="contact-upload-failed">
                        <p><i class="fas fa-times"></i> Something went wrong, please try again</p>
                    </div>
                <?php
            }
            else if(!$contact_upload_failed && $contact_uploaded){
                ?>
                    <div class="contact-upload-success">
                        <p><i class="fas fa-check"></i> Request succesfully uploaded</p>
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