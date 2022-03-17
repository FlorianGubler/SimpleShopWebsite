<?php
require_once "config.php";
if(isset($_POST["action"]) || isset($_GET["action"])){
    $method = isset($_POST["action"]) ? $_POST : $_GET;
    switch ($method["action"]){
        case "addtocart": addToCart($method["productid"], $method["productcolor"]); break;
        case "deletefromcart": removeFromCart($method["productid"], $method["productcolor"]); break;
        case "cartamountminus": CartAmountMinus($method["productid"], $method["productcolor"]); break;
        case "cartamountplus": CartAmountPlus($method["productid"], $method["productcolor"]); break;
        case "changelanguage": changeLanguage(strtolower($method["newlang"])); break;
        default: throw new Exception("Unknown Action");
    }
    if(isset($method["redirect"])){
        header("Location: " . $rootpath . $method["redirect"]);
    }
} else {
    throw new Exception("Action not given");
}
function addToCart($pkProduct, $color){
    foreach ($_SESSION["cart"] as $index=>$product){
        if($product[0] == $pkProduct && $product[2] == $color){
            CartAmountPlus($pkProduct, $color);
            return;
        }
    }
    array_push($_SESSION["cart"], [$pkProduct, 1, $color]);
}
function removeFromCart($pkProduct, $color){
    foreach ($_SESSION["cart"] as $index=>$product){
        if($product[0] == $pkProduct && $product[2] == $color){
            array_splice($_SESSION["cart"], $index, 1);
            return;
        }
    }
}
function CartAmountPlus($pkProduct, $color){
    foreach ($_SESSION["cart"] as $index=>$product){
        if($product[0] == $pkProduct && $product[2] == $color){
            $_SESSION["cart"][$index][1]++;
            return;
        }
    }
}
function CartAmountMinus($pkProduct, $color){
    foreach ($_SESSION["cart"] as $index=>$product){
        if($product[0] == $pkProduct && $product[2] == $color){
            if($_SESSION["cart"][$index][1] > 1){
                $_SESSION["cart"][$index][1]--;

            } else if($_SESSION["cart"][$index][1] == 1){
                removeFromCart($pkProduct, $color);
            }
            return;
        }
    }
}

function changeLanguage($lang){
    global $rootpath;
    if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/assets/language/" . $lang . ".php")){
        $_SESSION["lang"] = $lang;
    }
}