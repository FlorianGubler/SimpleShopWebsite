var slideIndex = 1;
products = document.getElementsByClassName("product-image-container");
for (let i = 0; i < products.length; i++) {
    showDivs(products[i].id, slideIndex)
}

function currentDiv(id, n) {
    showDivs(id, slideIndex = n);
}

function showDivs(id, n) {
    var i;
    var x = document.getElementById(id).getElementsByClassName("product-image-img");
    var dots = document.getElementById(id).getElementsByClassName("product-images-sliderBtn");
    if (n > x.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = x.length
    }
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" product-image-slider-choosen", "");
    }
    x[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " product-image-slider-choosen";
}
