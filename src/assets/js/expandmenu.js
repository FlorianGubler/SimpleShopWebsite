function expandMenuclicked() {
    if (document.getElementById("nav-icon").classList.contains("open")) {
        document.getElementById("nav-icon").classList.remove("open");
        document.getElementById("navbar").classList.remove("openNav");
        document.getElementById("navbar").classList.add("closeNav");
    } else {
        document.getElementById("nav-icon").classList.add("open");
        document.getElementById("navbar").classList.remove("closeNav");
        document.getElementById("navbar").classList.add("openNav");
    }
}