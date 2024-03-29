// This is your test publishable API key.
const stripe = Stripe("pk_test_51KjPsIHFwRqfOP6WvZA0pYrRSAb5wyCDPoDodQeahqayvw8ajxrO83YPGCFUlAkOkVXv5ZP6eKvtvM59Ku8Zvgq500ThOawqZU", {
    locale: LANG
});

let orderid;
let elements;
let paymentID;

checkStatus();

document
    .querySelector("#payment-form")
    .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
    const paymentIntent = await fetch(rootpath + "/assets/dbquerys/createcheckout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({}),
    }).then((r) => r.json());

    paymentID = paymentIntent.id;
    elements = stripe.elements({ clientSecret: paymentIntent.client_secret });

    const paymentElement = elements.create("payment");
    paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    if (orderid == undefined) {
        orderid = await fetch(rootpath + "/actionmgr.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "action=createorder&fullname=" + document.getElementById("fname").value + "&email=" + document.getElementById("email").value + "&address=" + document.getElementById("adr").value + "&city=" + document.getElementById("city").value + "&state=" + document.getElementById("state").value + "&postcode=" + document.getElementById("zip").value + "&paymentid=" + paymentID,
        }).then(response => response.text());
    }


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

    reloadCart(false);
    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        initialize();
        return;
    }

    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("success", TEXTE.paymentsuccess);
            updateOrder(new URLSearchParams(window.location.search).get("orderid"), "paid");
            clearCart();
            location.href = rootpath + "?showmsg=paymentsuccess";
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

function updateOrder(orderid, newstatus) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            reloadCart(false);
        } else if (this.readyState == 4) {
            showMessage("error", TEXTE.error);
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=updateorderstatus&orderid=" + orderid + "&newstatus=" + newstatus);
}

function clearCart() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            reloadCart(false);
        } else if (this.readyState == 4) {
            showMessage("error", TEXTE.error);
        }
    };
    xhttp.open("POST", rootpath + "/actionmgr.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("action=clearcart");
}