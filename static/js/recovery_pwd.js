// send email form
const emailForm = document.getElementById("sendmail-form");
const sendMsgEle = document.getElementById("send-msg-display");

// recover password form
const recoverForm = document.getElementById("recoverpwd-form");
const recoverMsgEle = document.getElementById("recover-msg-display");

const msgDisplay = document.getElementById("msg-display");
const urlParams = new URLSearchParams(location.search);
const token = urlParams.get("token");

// check token valid or not
async function checkToken(token) {
    const response = await fetch(`../../src/recovery/recovery_handler.php?token=${token}`, {
        method: "GET", 
    })

    if (!response.ok) {
        throw new Error("Error when calling API checking token");
    }

    const data = await response.json();
    if (data["success"] === false) {
        msgDisplay.style.display = "block";
        msgDisplay.innerHTML = `<p class="error-token">${data["msg"]}</p>`;
    } else {
        recoverForm.style.display = "flex";
    }
}

// if access url without token
if (!token) {
    // display the email form
    emailForm.style.display = "flex";
    emailForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        const formData = new FormData(emailForm);
        try {
            const response = await fetch("../../src/recovery/recovery_handler.php", {
                method: "POST",
                body: formData,
            })

            if (!response.ok) {
                throw new Error("Error when handling send recorver email");
            }
            
            const data = await response.text();
            sendMsgEle.innerText = data;
        } catch (error) {
            sendMsgEle.innerText = error;
        }
    })
} else { // access url with token
    try {
        checkToken(token);
    } catch (error) {
        emailForm.style.display = "none";
        recoverForm.style.display = "none";
        msgDisplay.innerHTML = `<p>${error}</p>`;
    }
}

recoverForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    try {
        const formData = new FormData(recoverForm);
        formData.append("token", token);

        const response = await fetch("../../src/recovery/recovery_handler.php", {
            method: "POST",
            body: formData,
        })

        if (!response.ok) {
            throw new Error("Error when handling recorver password");
        }
                
        const data = await response.json();
        if (data["success"] === true) {
            recoverForm.style.display = "none";
            msgDisplay.style.display = "block";
            msgDisplay.innerHTML = `<p class="success">${data["msg"]}</p>`;
        } else {
            recoverMsgEle.innerText = data["msg"];
        }
    } catch (error) {
        recoverMsgEle.innerText = error;
    }
})