<?php
include "../../config.php";
$contact_upload_failed = false;
$contact_uploaded = false;
$failed = false;

if(isset($_POST["addproduct"])){
    if($_SESSION["admin"]){
        $conn->Admin_AddProduct($_POST["productname"], $_POST["productprice"], $_POST["productcolors"], $_FILES["productpictures"]);
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
}

if(isset($_POST["addcolor"])){
    if($_SESSION["admin"]){
        $conn->Admin_AddColor(strtolower($_POST["colortag"]), $_POST["colorcode"]);
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
}

if(isset($_POST["deleteproduct"])){
    if($_SESSION["admin"]){
        $conn->Admin_DeleteProduct($_POST["productid"]);
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
}

if(isset($_GET["logout"])){
    $_SESSION["admin"] = false;
    $_SESSION["adminid"] = null;
    $_SESSION["adminuser"] = false;
    header("Location: " . $_SERVER["PHP_SELF"]);
}

if(isset($_POST['admin-login'])){
    $admincheck = $conn->checkLogin($_POST['email'], $_POST['password']);
    if($admincheck != false){
        $_SESSION["admin"] = true;
        $_SESSION["adminid"] = $admincheck;
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
    else{
        $failed = true;
    }
}

if(isset($_POST["add-admin"])){
    $conn->Admin_AddUser($_POST["username"], $_POST["email"], $_POST["password"]);
    header("Location: " . $_SERVER["PHP_SELF"]);
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
    <title><?php echo $texte->titel ?> - <?php echo $texte->admin ?></title>
</head>

<body>
<?php
include '../../navbar.php';
?>
<div class="site-div-content admintools">
    <?php
        if(!$_SESSION["admin"]){
            ?>
                <div class="contact-form-container">
                    <form action="" method="post">
                        <div class="contact-inputs-container">
                            <label for="input-email"><?php echo $texte->email ?></label>
                            <input id="input-email" type="email" autocomplete="username" name="email" placeholder="<?php echo $texte->email ?>" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for=input-password"><?php echo $texte->password ?></label>
                            <input id="input-subject" autocomplete="password" type="password" name="password" placeholder="<?php echo $texte->password ?>" required>
                        </div>

                        <button type="submit" name="admin-login"><?php echo $texte->login ?></button>
                    </form>
                </div>
                <?php
                    if($failed){
                        ?>
                            <div class="contact-upload-failed">
                                <p><i class="fas fa-times"></i> <?php echo $texte->loginfailed ?></p>
                            </div>
                        <?php
                    }
                ?>
            <?php
        } else{
            $contacts = $conn->getCustomerRequest();
            $allcolors = $conn->getAllColors();
            $products = $conn->getAllProducts();
            $orders = $conn->Admin_getAllOrders();
            ?>
            <h3><?php echo $texte->admintools ?></h3>
            <div style="display: flex; flex-direction: row;">
                <div class="add-product-form" style="width: 100%">
                    <span class="title"><?php echo $texte->addproduct ?></span>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="contact-inputs-container">
                            <label for="inp-productname"><?php echo $texte->productname ?></label>
                            <input type="text" id="inp-productname" name="productname" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for="inp-price"><?php echo $texte->productprice ?></label>
                            <input type="number" step="0.01" id="inp-price" name="productprice" required>
                        </div>
                        <div class="contact-inputs-container">
                            <div style="display: flex; flex-direction: row; align-items: center; justify-content: left; width: 100%">
                                <label for="inp-colors"><?php echo $texte->productcolors ?></label>
                                <button class="icon-btn" type="button" style="margin-left: 5px" onclick="OpenAddColorWindow();"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <select id="inp-colors" name="productcolors[]" multiple required size="<?php echo count($allcolors); ?>" style="overflow-y: auto; padding: 3px">
                                <?php
                                foreach ($allcolors as $color){
                                    echo "<option style='padding: 3px' value='" . $color["PK_color"] . "'>" . strtoupper($color["color_tag"]) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="contact-inputs-container">
                            <label for="inp-pictures"><?php echo $texte->productpictures ?></label>
                            <input id="inp-pictures" type="file" name="productpictures[]" multiple required accept="image/png, image/gif, image/jpeg">
                        </div>
                        <button type="submit" name="addproduct" class="normal-btn"><?php echo $texte->addproduct ?></button>
                    </form>
                    <form action="" method="POST">
                        <div class="contact-inputs-container">
                            <label for="inp-username"><?php echo $texte->username ?></label>
                            <input id="inp-username" type="text" name="username" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for="inp-email"><?php echo $texte->email ?></label>
                            <input id="inp-email" type="email" name="email" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for="inp-password"><?php echo $texte->password ?></label>
                            <input id="inp-password" autocomplete="new-password" type="password" name="password" required>
                        </div>
                        <button type="submit" name="add-admin" class="normal-btn"><?php echo $texte->adduser ?></button>
                    </form>
                </div>
                <div style="width: 100%" class="table-overflow">
                    <span class="title"><?php echo $texte->products ?></span>
                    <table>
                        <tr>
                            <th><?php echo $texte->productid ?></th>
                            <th><?php echo $texte->productname ?></th>
                            <th><?php echo $texte->productprice ?></th>
                            <th><?php echo $texte->status ?></th>
                            <th><?php echo $texte->tools ?></th>
                        </tr>
                        <?php
                        foreach ($products as $product){
                            ?>
                            <tr>
                                <td><?php echo "#" . $product["PK_product"]?></td>
                                <td><?php echo $product["productname"]?></td>
                                <td><?php echo $product["price"]?></td>
                                <td>
                                    <select name="status" onchange="SubmitChangeProductStatus(<?php echo $product["PK_product"]; ?>, this.value)">
                                        <?php
                                            foreach ($conn->Admin_get_enum_values("products", "status") as $statusval){
                                                $selected = "";
                                                if($statusval == $product["status"]) $selected = "selected";
                                                ?>
                                                    <option <?php echo $selected?> value="<?php echo $statusval; ?>"><?php echo strtoupper($statusval) ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="productid" value="<?php echo $product["PK_product"]?>">
                                        <button type="submit" class="normal-btn" name="deleteproduct"><?php echo $texte->deleteproduct ?></button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="contact-table">
                <div class="table-container table-overflow">
                    <span class="title"><?php echo $texte->contactrequests ?></span>
                    <table>
                        <tr>
                            <th><?php echo $texte->requestid ?></th>
                            <th><?php echo $texte->email ?></th>
                            <th><?php echo $texte->subject ?></th>
                            <th><?php echo $texte->message ?></th>
                        </tr>
                        <?php
                        foreach ($contacts as $contact){
                            ?>
                            <tr>
                                <td><?php echo "#" . $contact["PK_contact"]?></td>
                                <td><?php echo $contact["email"]?></td>
                                <td><?php echo $contact["subject"]?></td>
                                <td><button class="normal-btn" onclick="popup = CreatePopUpWindow(TEXTE.contactrequests + ': <?php echo $contact["subject"]; ?>'); popup.getElementsByClassName('popup-content')[0].innerHTML = '<?php echo $contact["text"]; ?>';"><?php echo $texte->showmessage ?></button></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="table-container table-overflow">
                    <span class="title"><?php echo $texte->orders ?></span>
                    <table class="table-small">
                        <tr>
                            <th><?php echo $texte->orderid ?></th>
                            <th><?php echo $texte->address ?></th>
                            <th><?php echo $texte->customer ?></th>
                            <th><?php echo $texte->status ?></th>
                            <th><?php echo $texte->product ?></th>
                        </tr>
                        <?php
                        foreach ($orders as $order){
                            ?>
                            <tr>
                                <td><?php echo "#" . $order["PK_order"]?></td>
                                <td><?php echo $order["address"] . ", " . $order["state"] . ", " . $order["city"] . " " .  $order["postcode"]; ?></td>
                                <td><?php echo $order["fullname"] . " (" . $order["email"] . ")"; ?></td>
                                <td>
                                    <select name="status" onchange="SubmitChangeOrderStatus(<?php echo $order["PK_order"]; ?>, this.value)">
                                        <?php
                                        foreach ($conn->Admin_get_enum_values("orders", "status") as $statusval){
                                            $selected = "";
                                            if($statusval == $order["status"]) $selected = "selected";
                                            ?>
                                            <option <?php echo $selected?> value="<?php echo $statusval; ?>"><?php echo strtoupper($statusval) ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <button class="normal-btn" onclick="ShowHiddenRow(<?php echo $order["PK_order"]; ?>);"><?php echo $texte->orderedproducts ?></button>
                                </td>
                            </tr>
                            <tr id="hidden-row-<?php echo $order["PK_order"]; ?>" style="display: none">
                                <td colspan="5">
                                    <div style="display: flex; flex-direction: row; align-items: center; flex-wrap: wrap; width: 100%">
                                        <?php
                                        foreach ($order["products"] as $orderproduct){
                                            ?>
                                            <div class="order-list-product">
                                                <span><?php echo $texte->productname ?>: <?php echo "#" . $orderproduct["PK_product"] . " - " . $orderproduct["productname"] ?></span>
                                                <span><?php echo $texte->productcolor ?>: <?php echo strtoupper($orderproduct["color_tag"]) ?></span>
                                                <span><?php echo $texte->amount ?>: <?php echo $orderproduct["amount"] ?></span>
                                            </div>
                                            <?php
                                        }
                                        if(count($order["products"]) == 0){
                                            echo $texte->nothingfound;
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <script>
                function ShowHiddenRow(id){
                    el = document.getElementById('hidden-row-' + id);
                    el.style.display == "table-row" ? el.style.display = "none" : el.style.display = "table-row";
                }
                function SubmitChangeProductStatus(ProductID, newstatus){
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            showMessage("success", TEXTE.productstatuschanged)
                        } else if(this.readyState == 4){
                            showMessage("error", TEXTE.error)
                        }
                    };
                    xhttp.open("POST", rootpath + "/actionmgr.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.send("action=adminchangeproductstatus&productid=" + ProductID + "&newstatus=" + newstatus);
                }
                function SubmitChangeOrderStatus(OrderID, newstatus){
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            showMessage("success", TEXTE.orderstatuschanged)
                        } else if(this.readyState == 4){
                            showMessage("error", TEXTE.error)
                        }
                    };
                    xhttp.open("POST", rootpath + "/actionmgr.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.send("action=adminchangeorderstatus&orderid=" + OrderID + "&newstatus=" + newstatus);
                }
                function OpenAddColorWindow(){
                    container = CreatePopUpWindow(TEXTE.createcolor);
                    content = container.getElementsByClassName("popup-content")[0];
                    form = content.appendChild(document.createElement("form"));
                    form.method = "POST";
                    form.className = "form-column";
                    colortaginp = form.appendChild(document.createElement("input"));
                    colortaginp.placeholder = TEXTE.colortag;
                    colortaginp.name = "colortag";
                    colortaginp.type = "text";
                    colortaginp.required = "true";
                    colorcodecontainer = form.appendChild(document.createElement("div"));
                    colorcodecontainer.className = "colorcodecontainer";
                    colorcodeinplabel = colorcodecontainer.appendChild(document.createElement("label"));
                    colorcodeinplabel.innerHTML = TEXTE.color + " ";
                    colorcodeinp = colorcodecontainer.appendChild(document.createElement("input"));
                    colorcodeinp.type = "color";
                    colorcodeinp.name = "colorcode";
                    colorcodeinp.required = "true";
                    submitbtn = form.appendChild(document.createElement("button"));
                    submitbtn.type = "submit";
                    submitbtn.innerHTML = TEXTE.createcolor;
                    submitbtn.name = "addcolor";
                    submitbtn.className = "normal-btn";
                }
            </script>
            <?php
        }
    ?>
</div>
<?php
include '../../footer.php';
?>
</body>

</html>