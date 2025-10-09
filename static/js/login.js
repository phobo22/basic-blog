const form = document.getElementById("login-form");
const usernameEle = document.getElementById("username");
const pwdEle = document.getElementById("password");
const errorEle = document.getElementById("error-display");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    try {
        const formData = new FormData(form);
        const response = await fetch("../src/auth/loginhandler.php", {
            method: "POST",
            body: formData,
        })

        if (!response.ok) {
            throw new Error("Error when login");
        }

        const data = await response.json();
        if (data["success"] === false) {
            errorEle.innerText = data["msg"];
        }
        else {
            window.location.href = "../src/dashboard.php";
        }
    } catch (error) {
        errorEle.innerText = error;
    }

})