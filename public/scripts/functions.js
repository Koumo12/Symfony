const togglePassword = () => {
    const passwordInput = document.querySelector("#user_password")
    passwordInput.type = passwordInput.type === "text" ? "password" : "text"

    const eyeIcon = document.querySelector("#eye")
    const  eyeSlashIcon = document.querySelector("#eye-slash")
    eyeIcon.style.display = eyeIcon.style.display === "block" ? "none" : "block"
    eyeSlashIcon.style.display = eyeSlashIcon.style.display === "none" ? "block" : "none"
}




