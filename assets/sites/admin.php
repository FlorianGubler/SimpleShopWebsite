<?php
include "../../config.php";
$contact_upload_failed = false;
$contact_uploaded = false;

if(isset($_GET['upload'])){
    $contact_uploaded = $_GET['upload'];
}

if(isset($_GET["logout"])){
    $_SESSION["admin"] = false;
    $_SESSION["adminuser"] = false;
    session_destroy();
    header("Location: " . $_SERVER["PHP_SELF"]);
}

if(isset($_POST['admin-login'])){
    if($conn->checkLogin($_POST['email'], $_POST['password'])){
        $_SESSION["admin"] = true;
        header("Location: " . $_SERVER["PHP_SELF"]);
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
    <link rel="stylesheet" href="<?php echo $rootpath?>/assets/css/style_admin.css">
    <link rel="stylesheet" href="<?php echo $rootpath?>/assets/css/style_contact.css">
    <title>Shop Gruppenprojekt - Admin Login</title>
</head>

<body>
<?php
include '../../navbar.php';
?>
<div class="site-div-content">
    <?php
        if(!$_SESSION["admin"]){
            ?>
                <div class="contact-form-container">
                    <form action="" method="post">
                        <div class="contact-inputs-container">
                            <label for="input-email">Email</label>
                            <input id="input-email" type="email" name="email" placeholder="max@example.net" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for=input-password">Password</label>
                            <input id="input-subject" type="password" name="password" placeholder="" required>
                        </div>

                        <button type="submit" name="admin-login">Login</button>
                    </form>
                </div>
                <?php
                    if($contact_upload_failed){
                        ?>
                            <div class="contact-upload-failed">
                                <p><i class="fas fa-times"></i> Login failed, please try again</p>
                            </div>
                        <?php
                    }
                ?>
            <?php
        } else{
            $contacts = $conn->getCustomerRequest();
            ?>
            <h3>Admin Tools</h3>
            <div class="add-product-form">
                <span class="title">Add Product</span>
                <form action="" method="POST">
                    <div class="contact-inputs-container">
                        <label for="inp-productname">Product Name</label>
                        <input type="inp-productname" name="productname" required>
                    </div>
                </form>
            </div>
            <div class="contact-table">
                <div class="table-container">
                    <span class="title">Contact Requests</span>
                    <table>
                        <tr>
                            <th>Request-ID</th>
                            <th>E-Mail</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                        <?php
                        foreach ($contacts as $contact){
                            ?>
                            <tr>
                                <td><?php echo "#" . $contact["PK_contact"]?></td>
                                <td><?php echo $contact["email"]?></td>
                                <td><?php echo $contact["subject"]?></td>
                                <td><?php echo $contact["text"]?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="table-container">
                    <span class="title">Orders</span>
                    <table>
                        <tr>
                            <th>Request-ID</th>
                            <th>Adress</th>
                            <th>Product</th>
                            <th>Status</th>
                        </tr>
                        <?php

                        ?>
                    </table>
                </div>
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