const form = document.getElementById("signup-form");
const user = document.getElementById("username");
const pwdEle = document.getElementById("password");
const emailEle = document.getElementById("email");
const errorEle = document.getElementById("error-display");

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    try {
        const formData = new FormData(form);
        const response = await fetch("../../src/auth/signup_handler.php", {
            method: "POST",
            body: formData,
        });

        if (!response.ok) throw new Error("Error when signing up");
        
        const data = await response.json();
        if (data["success"] === false) {
            errorEle.innerText = data["msg"];
        } else {
            window.location.href = "./login.php";
        }
    } catch (error) {
        errorEle.innerText = error;
    }
})