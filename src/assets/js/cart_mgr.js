function expandcart(editable) {
    reloadCart(editable);
    document.getElementById("cart-container").style.display = "block";
}
function closecart() {
    document.getElementById("cart-container").style.display = "none";
}
const secondarycartshower = [];
function addCartShow(el){
    secondarycartshower.push(el);
}
function reloadCart(editable) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            document.getElementById("cart-content-container").innerHTML = this.responseText;
            try{
                secondarycartshower.forEach(el => {
                    document.getElementById(el).innerHTML = this.responseText;
                })
            } catch (e) {

            }
        }
    };
    xhttp.open("GET", rootpath + "/assets/widgets/cart.php?editable=" + editable, true);
    xhttp.send();
}

function addtocart(pkProduct, color) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            showMessage("success", TEXTE.addedtocart)
            reloadCart(true);
        } else if(this.readyState == 4){
            showMessage("error", TEXTE.error)
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=addtocart&productid=" + pkProduct + "&productcolor=" + color);
}
function deleteItemFromCart(pkProduct, color) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            showMessage("success", TEXTE.removedfromcart)
            reloadCart(true);
        } else if(this.readyState == 4){
            showMessage("error", TEXTE.error)
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=deletefromcart&productid=" + pkProduct + "&productcolor=" + color);
}
function amountMinusCart(pkProduct, color) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            reloadCart(true);
        } else if(this.readyState == 4){
            showMessage("error", TEXTE.error)
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=cartamountminus&productid=" + pkProduct + "&productcolor=" + color);
}
function amountPlusCart(pkProduct, color) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            reloadCart(true);
        } else if(this.readyState == 4){
            showMessage("error", TEXTE.error)
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=cartamountplus&productid=" + pkProduct + "&productcolor=" + color);
}