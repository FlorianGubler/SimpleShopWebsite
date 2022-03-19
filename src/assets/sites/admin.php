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
        //header("Location: " . $_SERVER["PHP_SELF"]);
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../../header.php'
    ?>
    <link rel="stylesheet" href="<?php echo $rootpath?>/assets/css/style_admin.css">
    <link rel="stylesheet" href="<?php echo $rootpath?>/assets/css/style_contact.css">
    <title>Shop Gruppenprojekt - Admin</title>
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
                            <label for="input-email">Email</label>
                            <input id="input-email" type="email" name="email" placeholder="max@example.net" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for=input-password">Password</label>
                            <input id="input-subject" type="password" name="password" placeholder="Your Password" required>
                        </div>

                        <button type="submit" name="admin-login">Login</button>
                    </form>
                </div>
                <?php
                    if($failed){
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
            $allcolors = $conn->getAllColors();
            $products = $conn->getAllProducts();
            $orders = $conn->Admin_getAllOrders();
            ?>
            <h3>Admin Tools</h3>
            <div style="display: flex; flex-direction: row;">
                <div class="add-product-form" style="width: 100%">
                    <span class="title">Add Product</span>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="contact-inputs-container">
                            <label for="inp-productname">Product Name</label>
                            <input type="text" id="inp-productname" name="productname" required>
                        </div>
                        <div class="contact-inputs-container">
                            <label for="inp-price">Product Price</label>
                            <input type="number" step="0.01" id="inp-price" name="productprice" required>
                        </div>
                        <div class="contact-inputs-container">
                            <div style="display: flex; flex-direction: row; align-items: center; justify-content: left; width: 100%">
                                <label for="inp-colors">Product Colors</label>
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
                            <label for="inp-pictures">Product Pictures</label>
                            <input id="inp-pictures" type="file" name="productpictures[]" multiple required accept="image/png, image/gif, image/jpeg">
                        </div>
                        <button type="submit" name="addproduct" class="normal-btn">Add Product</button>
                    </form>
                </div>
                <div style="width: 100%">
                    <span class="title">Products</span>
                    <table>
                        <tr>
                            <th>Product-ID</th>
                            <th>Productname</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                        <button type="submit" class="normal-btn" name="deleteproduct">Delete Product</button>
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
                                <td><button class="normal-btn" onclick="popup = CreatePopUpWindow('Contact Message: <?php echo $contact["subject"]; ?>'); popup.getElementsByClassName('popup-content')[0].innerHTML = '<?php echo $contact["text"]; ?>';">Show Message</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="table-container">
                    <span class="title">Orders</span>
                    <table class="table-small">
                        <tr>
                            <th>Request-ID</th>
                            <th>Adress</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Product</th>
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
                                    <button class="normal-btn" onclick="ShowHiddenRow(<?php echo $order["PK_order"]; ?>);">Show Ordered Products</button>
                                </td>
                            </tr>
                            <tr id="hidden-row-<?php echo $order["PK_order"]; ?>" style="display: none">
                                <td colspan="5">
                                    <div style="display: flex; flex-direction: row; align-items: center; flex-wrap: wrap; width: 100%">
                                        <?php
                                        foreach ($order["products"] as $orderproduct){
                                            ?>
                                            <div class="order-list-product">
                                                <span>Product: <?php echo "#" . $orderproduct["PK_product"] . " - " . $orderproduct["productname"] ?></span>
                                                <span>Color: <?php echo $orderproduct["color_tag"] ?></span>
                                                <span>Amount: <?php echo $orderproduct["amount"] ?></span>
                                            </div>
                                            <?php
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
                            showMessage("success", "Successfully updated Product Status")
                        } else if(this.readyState == 4){
                            showMessage("error", "Something went wrong, please try again later")
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
                            showMessage("success", "Successfully updated Order Status")
                        } else if(this.readyState == 4){
                            showMessage("error", "Something went wrong, please try again later")
                        }
                    };
                    xhttp.open("POST", rootpath + "/actionmgr.php", true);
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.send("action=adminchangeorderstatus&orderid=" + OrderID + "&newstatus=" + newstatus);
                }
                function OpenAddColorWindow(){
                    container = CreatePopUpWindow("Create New Color");
                    content = container.getElementsByClassName("popup-content")[0];
                    form = content.appendChild(document.createElement("form"));
                    form.method = "POST";
                    form.className = "form-column";
                    colortaginp = form.appendChild(document.createElement("input"));
                    colortaginp.placeholder = "Color Tag";
                    colortaginp.name = "colortag";
                    colortaginp.type = "text";
                    colortaginp.required = "true";
                    colorcodecontainer = form.appendChild(document.createElement("div"));
                    colorcodecontainer.className = "colorcodecontainer";
                    colorcodeinplabel = colorcodecontainer.appendChild(document.createElement("label"));
                    colorcodeinplabel.innerHTML = "Color ";
                    colorcodeinp = colorcodecontainer.appendChild(document.createElement("input"));
                    colorcodeinp.type = "color";
                    colorcodeinp.name = "colorcode";
                    colorcodeinp.required = "true";
                    submitbtn = form.appendChild(document.createElement("button"));
                    submitbtn.type = "submit";
                    submitbtn.innerHTML = "Create Color";
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