document.getElementById('price-filter-slider-textval').innerHTML = "CHF " + document.getElementById("price-filter-slider").value;

function searchProducts() {
    searching = document.getElementById("products-searching").value;
    products = document.getElementsByClassName("product-container");
    for (let i = 0; i < products.length; i++) {
        if (products[i].getAttributeNode("excluded_from_priceFilter") == null && products[i].getAttributeNode("excluded_from_colorFilter") == null) {
            if (products[i].getElementsByClassName("product-data-container")[0].getElementsByClassName("product-productname")[0].innerHTML.toLowerCase().includes(searching.toLowerCase())) {
                products[i].style.display = "block";
                if (products[i].getAttributeNode("excluded_from_Search") != null && products[i].getAttributeNode("excluded_from_Search") != false) {
                    products[i].removeAttributeNode(products[i].getAttributeNode("excluded_from_Search"));
                }
            }
            else {
                products[i].style.display = "none";
                excludedFromSearch = document.createAttribute("excluded_from_Search");
                products[i].setAttributeNode(excludedFromSearch);
            }
        }
        else {
            products[i].style.display = "none";
        }
    }
    if (countDisplayedProducts() == 0) {
        document.getElementById("nothing-found").style.display = "block";
    }
    else {
        document.getElementById("nothing-found").style.display = "none";
    }

}
function countDisplayedProducts() {
    counter = 0;
    products = document.getElementsByClassName("product-container");
    for (let i = 0; i < products.length; i++) {
        if (products[i].style.display != "none") {
            counter++;
        }
    }
    return counter;
}
function filterProducts() {
    filterColor();
    filterPrice();
    searchProducts();
    if (countDisplayedProducts() == 0) {
        document.getElementById("nothing-found").style.display = "block";
    }
    else {
        document.getElementById("nothing-found").style.display = "none";
    }
}
function filterColor() {
    colorfilter = document.getElementById("filter-color");
    products = document.getElementsByClassName("product-container");
    for (let b = 0; b < products.length; b++) {
        if (products[b].getAttribute("excluded_from_priceFilter") == null && products[b].getAttribute("excluded_from_Search") == null) {
            if (colorarrcontains(JSON.parse(products[b].getAttribute("productcolors")), colorfilter.value) || colorfilter.value == -1) {
                products[b].style.display = "block";
                products[b].removeAttribute("excluded_from_colorFilter");
            }
            else {
                products[b].style.display = "none";
                products[b].setAttribute("excluded_from_colorFilter", "true");
            }
        }
    }
}
function filterPrice() {
    pricefilter = document.getElementById("price-filter-slider");
    products = document.getElementsByClassName("product-container");
    for (let b = 0; b < products.length; b++) {
        if (products[b].getAttribute("excluded_from_colorFilter") == null && products[b].getAttribute("excluded_from_Search") == null) {
            if (parseFloat(products[b].getAttribute("productprice")) <= pricefilter.value) {
                products[b].style.display = "block";
                products[b].removeAttribute("excluded_from_priceFilter");
            }
            else {
                products[b].style.display = "none";
                products[b].setAttribute("excluded_from_priceFilter", "true");
            }
        }
    }
}
function colorarrcontains(arr, colortag) {
    for(i = 0; i < arr.length; i++){
        if(arr[i].color_tag == colortag.toLowerCase()){
            return true;
        }
    }
    return false;
}
