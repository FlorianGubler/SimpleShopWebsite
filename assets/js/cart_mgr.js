function expandcart() {
    reloadCart();
    document.getElementById("cart-container").style.display = "block";
}
function closecart() {
    document.getElementById("cart-container").style.display = "none";
}
function reloadCart() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Typical action to be performed when the document is ready:
            document.getElementById("cart-content-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", rootpath + "/assets/widgets/cart.php", true);
    xhttp.send();
}

function addtocart(pkProduct) {
    if (localStorage.hasOwnProperty('cart-items')) {
        if (JSON.parse(localStorage.getItem('cart-items')).length != 0) {
            items = JSON.parse(localStorage.getItem('cart-items'));
            if (!checkifProductisinCart(items, pkProduct)) {
                items.push([pkProduct, 1]);
            }
            else {
                items.forEach(item => {
                    if (item[0] == pkProduct) {
                        item[1] += 1;
                    }
                })
            }
            localStorage.setItem('cart-items', JSON.stringify(items));
        }
        else {
            createcartwithitem(pkProduct);
        }
    } else {
        createcartwithitem(pkProduct);
    }
    document.getElementById("addtocart-success").style.display = "block";
    reloadCart();
}
function deleteItemFromCart(pkProduct, reload) {
    items = JSON.parse(localStorage.getItem("cart-items"));
    counter = 0;
    items.forEach(item => {
        if (item[0] == pkProduct) {
            items.splice(counter, 1);
        }
        counter++;
    })
    localStorage.setItem('cart-items', JSON.stringify(items));
    if (reload) {
        reloadCart();
    }
}
function amountMinusCart(pkProduct) {
    items = JSON.parse(localStorage.getItem("cart-items"));
    items.forEach(item => {
        if (item[0] == pkProduct) {
            item[1] -= 1;
            if (item[1] <= 0) {
                deleteItemFromCart(pkProduct, false);
            }
        }
    })
    localStorage.setItem('cart-items', JSON.stringify(items));
    reloadCart();
}
function amountPlusCart(pkProduct) {
    items = JSON.parse(localStorage.getItem("cart-items"));
    items.forEach(item => {
        if (item[0] == pkProduct) {
            item[1] += 1;
        }
    })
    localStorage.setItem('cart-items', JSON.stringify(items));
    reloadCart();
}
function createcartwithitem(pkProduct) {
    localStorage.setItem('cart-items', JSON.stringify([[pkProduct, 1]]));
}
function checkifProductisinCart(items, pkProduct) {
    for (let i = 0; i < items.length; i++) {
        if (items[i][0] == pkProduct) {
            return items[i];
        }
    }
    return false;
}