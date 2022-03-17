function showMessage(type, text) {
    console.log("test")
    container = document.getElementById("messages-container");
    msg = container.appendChild(document.createElement("div"));
    msg.className = "message";
    icon = "";
    color = "";
    switch (type) {
        case "success":
            icon = '<i class="fas fa-check"></i>';
            color = "green";
            break;
        case "info":
            icon = '<i class="fa-solid fa-circle-exclamation"></i>';
            color = "grey";
            break;
        case "error":
            icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
            color = "red";
            break;
        default:
            console.error("Unknown MSG Type");
    }
    msg.innerHTML = '<p style="color: ' + color + '">' + icon + '<span style="margin-left: 5px">' + text + '</span></p>';
}

function CreatePopUpWindow(title) {
    var PopUpContainer = document.body.appendChild(document.createElement("div"));
    PopUpContainer.className = "popup-overlay";
    PopUpEl = PopUpContainer.appendChild(document.createElement("div"));
    PopUpEl.className = "popup";
    PopUpHeader = PopUpEl.appendChild(document.createElement("div"));
    PopUpHeader.className = "popup-header";
    PopUpTitle = PopUpHeader.appendChild(document.createElement("span"));
    PopUpTitle.className = "popup-title";
    PopUpTitle.innerHTML = title;
    PopUpClose = PopUpHeader.appendChild(document.createElement("button"));
    PopUpClose.innerHTML = '<i class="fas fa-times"></i>';
    PopUpClose.addEventListener("click", e => {
        PopUpContainer.remove();
    });
    //When PopUp is removed, enable scrolling
    in_dom = false;
    var observer = new MutationObserver(function (mutations) {
        if (document.body.contains(PopUpContainer)) {
            if (!in_dom) {
                //Disable Scrolling
                document.body.classList.add("disable-scroll");
            }
            in_dom = true;
        } else if (in_dom) {
            in_dom = false;
            //Enable Scrolling
            document.body.classList.remove("disable-scroll");
        }
    });
    observer.observe(document.body, {childList: true, subtree: true});
    PopUpBody = PopUpEl.appendChild(document.createElement("div"));
    PopUpBody.className = "popup-body";
    PopUpContent = PopUpBody.appendChild(document.createElement("div"));
    PopUpContent.className = "popup-content";
    return PopUpContainer;
}