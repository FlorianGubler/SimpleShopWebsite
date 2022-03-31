// This is your test publishable API key.
const stripe = Stripe("pk_live_51KjPsIHFwRqfOP6WFzuToAZlbjp7LsM865wQ56eCMiUGbUnxIjo5ZJEVB1Q8X0Mrpx2SKrEvPVjfMfpDgsFMesa200iS3hxRIE", {
    locale: LANG
});

// The items the customer wants to buy
const items = [{ id: "xl-tshirt" }];

let elements;

initialize();
checkStatus();

document
    .querySelector("#payment-form")
    .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
    const { clientSecret } = await fetch(rootpath + "/assets/dbquerys/createcheckout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ items }),
    }).then((r) => r.json());

    elements = stripe.elements({ clientSecret });

    const paymentElement = elements.create("payment");
    paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    let orderid = await fetch(rootpath + "/actionmgr.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=createorder&fullname=" + document.getElementById("fname").value + "&email=" + document.getElementById("email").value + "&address=" + document.getElementById("adr").value + "&city=" + document.getElementById("city").value + "&state=" + document.getElementById("state").value + "&postcode=" + document.getElementById("zip").value,
    }).then(response => response.text());

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: rootpath + "/assets/sites/checkout.php?orderid=" + orderid,
        },
    });

    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage("error", error.message);
    } else {
        showMessage("error", TEXTE.error);
    }

    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("success", TEXTE.paymentsuccess);
            updateOrder(new URLSearchParams(window.location.search).get("orderid"), "paid");
            break;
        case "processing":
            showMessage("info", TEXTE.paymentprocessing);
            break;
        case "requires_payment_method":
            showMessage("error", TEXTE.paymentfailed);
            break;
        default:
            showMessage("error", TEXTE.error);
            break;
    }
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
}

function updateOrder(orderid, newstatus){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            reloadCart();
        } else if(this.readyState == 4){
            showMessage("error", TEXTE.error);
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=updateorderstatus&orderid=" + orderid + "&newstatus=" + newstatus);
}