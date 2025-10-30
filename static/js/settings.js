const pwdForm = document.getElementById("pwd-form");
const emailForm = document.getElementById("email-form");
const pwdMsgDisplay = document.getElementById("pwd-msg-display");
const emailMsgDisplay = document.getElementById("email-msg-display");

// change password form submit
pwdForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(pwdForm);
    const params = new URLSearchParams(formData);

    const response = await fetch("../../src/settings/change_pwd.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    })

    if (!response.ok) {
        throw new Error("Error when calling change password API");
    }

    const data = await response.json();
    pwdMsgDisplay.innerText = data["msg"];
    if (data["success"] === true) {
       pwdMsgDisplay.style.color = "green";
    }
})

// change email form submit
emailForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(emailForm);
    const params = new URLSearchParams(formData);

    const response = await fetch("../../src/settings/change_email.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    })

    if (!response.ok) {
        throw new Error("Error when calling change email API");
    }

    const data = await response.json();
    emailMsgDisplay.innerText = data["msg"];
    if (data["success"] === true) {
       emailMsgDisplay.style.color = "green";
    }
})