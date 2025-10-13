const logoutEle = document.getElementById("logout");

logoutEle.addEventListener("click", async (event) => {
    event.preventDefault();
    const response = await fetch("../../src/auth/logout.php", {
        method: "POST",
    })

    if (!response.ok) {
        throw new Error("Error when calling log out API");
    }

    const data = await response.json();
    if (data["success"] === true) {
        window.location.href = "./login.php";
    } else {
        console.log(data["msg"]);
    }
})