const shippingprice = 5;

function expandcart() {
    reloadCart();
    document.getElementById("cart-container").style.display = "block";
}
function closecart() {
    document.getElementById("cart-container").style.display = "none";
}
function reloadCart() {
    if (localStorage.hasOwnProperty('cart-items')) {
        document.getElementById("cart-items-empty").style.display = "none";
        items = JSON.parse(localStorage.getItem('cart-items'));
        if (items.length == 0) {
            document.getElementById("cart-items-list").innerHTML = "";
            document.getElementById("cart-items-empty").style.display = "block";
            document.getElementById("cart-calc-price").style.display = "none";
        }
        else {
            document.getElementById("products-endprice").innerHTML = "0";
            document.getElementById("products-shippingprice").innerHTML = shippingprice;
            document.getElementById("endprice").innerHTML = "0";
            document.getElementById("cart-items-list").innerHTML = "";
            document.getElementById("cart-items-empty").style.display = "none";
            document.getElementById("cart-calc-price").style.display = "block";

            items.forEach(productinlocal => {
                if (productinlocal[1] > 0) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", rootpath + '/navbar.php', true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function () {
                        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                            product = JSON.parse(this.responseText);

                            items = JSON.parse(localStorage.getItem('cart-items'));
                            items.forEach(item => {
                                if (item[0] == product["PK_product"]) {
                                    productinfo = item;
                                }
                            })

                            li = document.createElement("li");

                            splitline = document.createElement("li");
                            splitline.className = "cart-splitline";

                            removeBtn = document.createElement("button");
                            removeBtn.className = "cart-product-removeBtn";
                            removeBtn.innerHTML = "<i class='far fa-times-circle'></i>";
                            removeBtn.addEventListener("click", function () {
                                deleteItemFromCart(product["PK_product"], true);
                            })

                            container = document.createElement("div");
                            container.className = "cart-product-container";

                            img_container = document.createElement("div");
                            img_container.className = "cart-product-img-container";
                            img = document.createElement("img");
                            img.src = rootpath + "/assets/img/product_images/" + product["picture"];
                            img_container.appendChild(img);

                            data_container = document.createElement("div");
                            data_container.className = "cart-product-data-container";

                            Productname = document.createElement("p");
                            Productname.innerHTML = product["productname"];
                            data_container.appendChild(Productname);

                            color_container = document.createElement("div");
                            color_container.className = "cart-color-container"
                            product["colors"].forEach(color => {
                                colorDiv = document.createElement("div");
                                colorDiv.className = "product-color-coloritem cart-color-coloritem";
                                colorDiv.style.backgroundColor = color;
                                color_container.appendChild(colorDiv);
                            })
                            data_container.appendChild(color_container);

                            minus_btn = document.createElement("button");
                            minus_btn.innerHTML = "<i class='fas fa-minus'></i>";
                            minus_btn.className = "cart-changeAmount-minus";
                            minus_btn.addEventListener("click", function () {
                                amountMinusCart(product["PK_product"]);
                            });
                            plus_btn = document.createElement("button");
                            plus_btn.innerHTML = "<i class='fas fa-plus'></i>";
                            plus_btn.className = "cart-changeAmount-minus";
                            plus_btn.addEventListener("click", function () {
                                amountPlusCart(product["PK_product"]);
                            });
                            amount = document.createElement("span");
                            amount.className = "cart-product-amount";
                            amount.innerHTML = productinfo[1];

                            amount_container = document.createElement("div");
                            amount_container.className = "cart-amount-container";

                            amount_container.appendChild(minus_btn);
                            amount_container.appendChild(amount);
                            amount_container.appendChild(plus_btn);
                            data_container.appendChild(amount_container);

                            price_status_container = document.createElement("div");
                            price_status_container.className = "price-status-container";

                            price = document.createElement("p");
                            price.innerHTML = "CHF " + product["price"] + ".-";
                            price.className = "priceTag";
                            price_status_container.appendChild(price);

                            Productstatus = document.createElement("p");
                            Productstatus.innerHTML = product["status"];
                            Productstatus.className = "statusTag";
                            if (product["status"] == "available") {
                                Productstatus.style.color = "green";
                            }
                            else {
                                Productstatus.style.color = "red";
                            }
                            price_status_container.appendChild(Productstatus);

                            cart_data_img_container = document.createElement("div");
                            cart_data_img_container.className = "cart-data-img-container";
                            cart_data_img_container.appendChild(img_container);
                            cart_data_img_container.appendChild(data_container);

                            container.appendChild(removeBtn);
                            container.appendChild(cart_data_img_container);
                            container.appendChild(price_status_container);
                            li.appendChild(container);
                            document.getElementById("cart-items-list").appendChild(li);
                            document.getElementById("cart-items-list").appendChild(splitline);

                            document.getElementById("products-endprice").innerHTML = (parseFloat(document.getElementById("products-endprice").innerHTML) + parseFloat(product["price"]) * productinlocal[1]).toString();
                            document.getElementById("endprice").innerHTML = (parseFloat(document.getElementById("products-endprice").innerHTML) + shippingprice).toString();
                        }
                    }
                    xhr.send("getjsonofproduct=true&pkproduct=" + productinlocal[0]);
                }
                else {
                    items.splice(checkifProductisinCart(items, product[0]), 1);
                    localStorage.setItem("cart-items", JSON.stringify(items));
                    reloadCart();
                }
            })
        }
    }
    else {
        document.getElementById("cart-items-list").innerHTML = "";
        document.getElementById("cart-items-empty").style.display = "block";
        document.getElementById("cart-calc-price").style.display = "none";
    }
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