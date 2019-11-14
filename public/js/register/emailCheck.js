document.addEventListener(
    "DOMContentLoaded",
    function() {
        document.querySelector("#registration-email").onkeyup = check;
    },
    false
);

function check() {
    let token = document.getElementsByName("csrf-token")[0].content;
    let emailInput = document.querySelector("#registration-email");
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    //If input matched mail format then make ajax request to /check-email route
    if (emailInput.value.match(mailformat)) {
        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "/check-email", true);
        xhttp.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded"
        );
        xhttp.setRequestHeader("X-CSRF-TOKEN", token);
        xhttp.send(`email=${emailInput.value}`);

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                if (xhttp.responseText == "true") {
                    emailInput.style.borderColor = "#ced4da";
                } else {
                    emailInput.style.borderColor = "red";
                }
            }
        };
    } else {
        emailInput.style.borderColor = "red";
    }
}
