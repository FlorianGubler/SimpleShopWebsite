function showMessage(type, text){
    console.log("test")
    container = document.getElementById("messages-container");
    msg = container.appendChild(document.createElement("div"));
    msg.className = "message";
    icon = "";
    color = "";
    switch (type){
        case "success": icon = '<i class="fas fa-check"></i>'; color = "green"; break;
        case "info": icon = '<i class="fa-solid fa-circle-exclamation"></i>'; color = "grey"; break;
        case "error": icon = '<i class="fa-solid fa-triangle-exclamation"></i>';  color = "red"; break;
        default: console.error("Unknown MSG Type");
    }
    msg.innerHTML = '<p style="color: ' + color + '">' + icon + '<span style="margin-left: 5px">' + text + '</span></p>';
}