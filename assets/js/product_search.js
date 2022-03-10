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
    filters = document.getElementsByClassName("filter-option");
    for (let i = 0; i < filters.length; i++) {
        if (String(filters[i].value) != "None" && String(filters[i].value) != "Color") {
            products = document.getElementsByClassName("product-container");
            for (let b = 0; b < products.length; b++) {
                if (products[b].getAttributeNode("excluded_from_priceFilter") == null && products[b].getAttributeNode("excluded_from_Search") == null) {
                    if (filters[i].name == "color") {
                        coloritems = products[b].getElementsByClassName("product-color-container")[0].getElementsByClassName("product-color-coloritem");
                        for (let c = 0; c < coloritems.length; c++) {
                            if (rgb2hex(coloritems[c].style.backgroundColor) == getHashCodeOfColorTag(filters[i].value)) {
                                products[b].style.display = "block";
                                if (products[b].getAttributeNode("excluded_from_colorFilter") != null && products[b].getAttributeNode("excluded_from_colorFilter") != false) {
                                    products[b].removeAttributeNode(products[b].getAttributeNode("excluded_from_colorFilter"));
                                }
                                break;
                            }
                            else {
                                products[b].style.display = "none";
                                excludedFromColorFilter = document.createAttribute("excluded_from_colorFilter");
                                products[b].setAttributeNode(excludedFromColorFilter);
                            }
                        }
                    }
                }
                else {
                    products[b].style.display = "none";
                }
            }
        }
        else {
            for (let b = 0; b < products.length; b++) {
                if (filters[i].name == "color") {
                    products[b].style.display = "block";
                    if (products[b].getAttributeNode("excluded_from_colorFilter") != null && products[b].getAttributeNode("excluded_from_colorFilter") != false) {
                        products[b].removeAttributeNode(products[b].getAttributeNode("excluded_from_colorFilter"));
                    }
                }
            }
        }
    }
}
function filterPrice() {
    filters = document.getElementsByClassName("filter-option");
    for (let i = 0; i < filters.length; i++) {
        products = document.getElementsByClassName("product-container");
        for (let b = 0; b < products.length; b++) {
            if (products[b].getAttributeNode("excluded_from_colorFilter") == null && products[b].getAttributeNode("excluded_from_Search") == null) {
                if (filters[i].name == "price") {
                    if (parseFloat(products[b].getElementsByClassName("product-data-container")[0].getElementsByClassName("product-productprice")[0].innerHTML.replace("CHF", "").replace(".-", "")) <= filters[i].value) {
                        products[b].style.display = "block";
                        if (products[b].getAttributeNode("excluded_from_priceFilter") != null && products[b].getAttributeNode("excluded_from_priceFilter") != false) {
                            products[b].removeAttributeNode(products[b].getAttributeNode("excluded_from_priceFilter"));
                        }
                    }
                    else {
                        products[b].style.display = "none";
                        excludedFromPriceFilter = document.createAttribute("excluded_from_priceFilter");
                        products[b].setAttributeNode(excludedFromPriceFilter);
                    }
                }
            }
            else {
                products[b].style.display = "none";
            }
        }
    }
}
function filterAvailable() {
    filters = document.getElementsByClassName("filter-option");
    for (let i = 0; i < filters.length; i++) {
        products = document.getElementsByClassName("product-container");
        for (let b = 0; b < products.length; b++) {
            if (products[b].getAttributeNode("excluded_from_colorFilter") == null && products[b].getAttributeNode("excluded_from_Search") == null) {
                if (filters[i].name == "available") {
                    if (parseFloat(products[b].getElementsByClassName("product-data-container")[0].getElementsByClassName("product-productprice")[0].innerHTML.replace("CHF", "").replace(".-", "")) <= filters[i].value) {
                        products[b].style.display = "block";
                        if (products[b].getAttributeNode("excluded_from_priceFilter") != null && products[b].getAttributeNode("excluded_from_priceFilter") != false) {
                            products[b].removeAttributeNode(products[b].getAttributeNode("excluded_from_priceFilter"));
                        }
                    }
                    else {
                        products[b].style.display = "none";
                        excludedFromPriceFilter = document.createAttribute("excluded_from_priceFilter");
                        products[b].setAttributeNode(excludedFromPriceFilter);
                    }
                }
            }
            else {
                products[b].style.display = "none";
            }
        }
    }
}
function getHashCodeOfColorTag(colorTag) {
    found = false;
    foundedval = undefined;
    colorsWithCodes.forEach(color => {
        if (color.color_tag == colorTag) {
            found = true;
            foundedval = color.colorcode;
        }
    })
    if (found) {
        return foundedval;
    }
    else {
        return false;
    }
}
const rgb2hex = (rgb) => `#${rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/).slice(1).map(n => parseInt(n, 10).toString(16).padStart(2, '0')).join('')}`

