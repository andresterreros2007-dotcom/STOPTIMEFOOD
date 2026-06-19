
function togglePassword() {
    const password = document.getElementById("clave");

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}





