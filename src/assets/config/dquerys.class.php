<?php
class DBquery
{
    public $dbconn;

    function __construct($dbconn)
    {
        $this->dbconn = $dbconn;
    }

    function createCustomerRequest($email, $subject, $text)
    {
        $email = $this->dbconn->real_escape_string($email);
        $subject = $this->dbconn->real_escape_string($subject);
        $text = $this->dbconn->real_escape_string($text);

        $sql = "INSERT INTO contact (email, subject, text) VALUES ('$email', '$subject', '$text');";
        return $this->dbconn->query($sql);
    }

    function getCustomerRequest()
    {
        $contacts = array();
        $sql = "SELECT * FROM contact";
        $qry = $this->dbconn->query($sql);
        while ($result = $qry->fetch_assoc()) {
            array_push($contacts, $result);
        }

        return $contacts;
    }

    function getColorsOfProduct($PK_product)
    {
        $colors = array();
        $sql = "SELECT * FROM product_colors INNER JOIN shop_colors ON FK_color = PK_color WHERE FK_product=$PK_product";
        $qry = $this->dbconn->query($sql);
        while ($result = $qry->fetch_assoc()) {
            array_push($colors, $result);
        }
        return $colors;
    }

    function getPicturesOfProduct($PK_product)
    {
        $pictures = array();
        $sql = "SELECT * FROM product_images WHERE FK_product=$PK_product";
        $qry = $this->dbconn->query($sql);
        while ($result = $qry->fetch_assoc()) {
            if (!file_exists($result['pictureurl'])) {
                array_push($pictures, $result['pictureurl']);
            } else {
                array_push($pictures, "default_product.jpg");
            }
        }
        if (count($pictures) == 0) {
            array_push($pictures, "default_product.jpg");
        }
        return $pictures;
    }

    function getAllProducts()
    {
        $products = array();
        $sql = "SELECT * FROM products";
        $qry = $this->dbconn->query($sql);

        while ($result = $qry->fetch_assoc()) {
            $result["pictures"] = $this->getPicturesOfProduct($result['PK_product']);;
            $result["colors"] = $this->getColorsOfProduct($result['PK_product']);
            array_push($products, $result);
        }
        return $products;
    }

    function getNewestProducts($product_count)
    {
        $products = array();
        $newestproducts = array();

        $sql = "SELECT * FROM products ORDER BY upload_date DESC";
        $qry = $this->dbconn->query($sql);

        while ($result = $qry->fetch_assoc()) {
            $result["pictures"] = $this->getPicturesOfProduct($result['PK_product']);;
            $result["colors"] = $this->getColorsOfProduct($result['PK_product']);
            array_push($products, $result);
        }
        if (count($products) >= $product_count) {
            for ($i = 0; $i < $product_count; $i++) {
                array_push($newestproducts, $products[$i]);
            }
            return $newestproducts;
        } else {
            return $products;
        }
    }

    function getAllActiveColors()
    {
        $colors = array();
        $sql = "SELECT * FROM product_colors INNER JOIN shop_colors ON FK_color = PK_color";
        $qry = $this->dbconn->query($sql);

        while ($result = $qry->fetch_assoc()) {
            array_push($colors, $result);
        }
        return $colors;
    }

    function getColorByID($colorid){
        $sql = "SELECT * FROM shop_colors WHERE PK_color = $colorid";
        return $this->dbconn->query($sql)->fetch_assoc();
    }

    function getAllColors()
    {
        $colors = array();
        $sql = "SELECT * FROM shop_colors";
        $qry = $this->dbconn->query($sql);

        while ($result = $qry->fetch_assoc()) {
            array_push($colors, $result);
        }
        return $colors;
    }

    function getProduct($PKproduct)
    {
        $sql = "SELECT * FROM products WHERE PK_product=$PKproduct;";
        $result = $this->dbconn->query($sql)->fetch_assoc();
        $result["picture"] = $this->getPicturesOfProduct($PKproduct)[0];
        $result["colors"] = $this->getColorsOfProduct($PKproduct);
        return $result;
    }

    function getMaxMinPrice()
    {
        $arr = array();

        $sql = "SELECT MAX(price) FROM products";
        $qry = $this->dbconn->query($sql);
        $arr["max_price"] = $qry->fetch_assoc()["MAX(price)"];

        $sql = "SELECT MIN(price) FROM products";
        $qry = $this->dbconn->query($sql);
        $arr["min_price"] = $qry->fetch_assoc()["MIN(price)"];

        return $arr;
    }

    function checkLogin($email, $password){
        $passwordhash = hash("sha256", $email . $password);
        $email = $this->dbconn->real_escape_string($email);
        $passwordhash = $this->dbconn->real_escape_string($passwordhash);
        $sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$passwordhash'";
        $qry = $this->dbconn->query($sql);

        if($qry->num_rows > 0){
            return true;
        }
        return false;
    }

    function getUserData($id){
        $id = $this->dbconn->real_escape_string($id);
        $sql = "SELECT * FROM admins WHERE PK_admin = $id";
        return $this->dbconn->query($sql)->fetch_assoc();
    }

    function Admin_AddProduct($productname, $productprice, $productcolors, $productpictures){
        $error = true;
        $total_count = count($productpictures['name']);
        if($total_count == 0 || count($productcolors) == 0){
            return false;
        }
        for( $i=0 ; $i < $total_count ; $i++ ) {
            $tmpFilePath = $productpictures['tmp_name'][$i];
            if ($tmpFilePath != ""){
                $newFilePath = $_SERVER["DOCUMENT_ROOT"] . "/assets/img/product_images/" . $productpictures['name'][$i];
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $error = false;
                } else{
                    $error = true;
                }
            } else{
                return false;
            }
        }
        if(!$error){
            $productname = $this->dbconn->real_escape_string($productname);
            $productprice = $this->dbconn->real_escape_string($productprice);
            $sql = "INSERT INTO products (productname, price, status) VALUES ('$productname', '$productprice', 'available');";

            if($this->dbconn->query($sql)){
                $productid = $this->dbconn->insert_id;
                foreach ($productcolors as $color){
                    $sql = "INSERT INTO product_colors (FK_product, FK_color) VALUES ($productid, $color);";
                    $this->dbconn->query($sql);
                }
                foreach ($productpictures["name"] as $picture){
                    $sql = "INSERT INTO product_images (FK_product, pictureurl) VALUES ($productid, '$picture');";
                    $this->dbconn->query($sql);
                }
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }

    function Admin_ChangeProductStatus($pkProduct, $newstatus){
        $sql = "UPDATE products SET status = '$newstatus' WHERE PK_product = $pkProduct;";
        return $this->dbconn->query($sql);
    }

    function Admin_DeleteProduct($pkProduct){
        $this->dbconn->query("DELETE FROM product_colors WHERE FK_product = $pkProduct");
        foreach ($this->getPicturesOfProduct($pkProduct) as $picture){
            unlink($_SERVER["DOCUMENT_ROOT"] . "/assets/img/product_images/" . $picture);
        }
        $this->dbconn->query("DELETE FROM product_images WHERE FK_product = $pkProduct;");
        return $this->dbconn->query("DELETE FROM products WHERE PK_product = $pkProduct;");
    }

    function Admin_get_enum_values($table, $field){
        $type = $this->dbconn->query( "SHOW COLUMNS FROM $table WHERE Field = '$field'" )->fetch_assoc()["Type"];
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }
}
