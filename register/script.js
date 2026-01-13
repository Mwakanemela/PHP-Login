const registerForm = document.querySelector(".login-form")
const username = document.getElementById("username").value
const password = document.getElementById("password").value
const email = document.getElementById("email").value

const toast = new MToast()
registerForm.onsubmit = (event) => {
    event.preventDefault()
    
    const formData = new FormData(registerForm)

    // Send via AJAX
    fetch("register-process.php", {
    method: "POST",
    body: formData
    })
    .then(response => {
        if (!response.ok) {
            // Throw an error so it goes to .catch()
            throw new Error("Server Error: " + response.status);
        }
        return response.json(); // or response.text()
    })
    .then(data => {
        if(data.success) {
            toast.push({
                title: "Success Message",
                content: data.message,
                width: 300,
                style: "success",
                dismissAfter: "3s"
            });

            window.location.href = "home.php"
        }else {
            toast.push({
                title: "Error Message",
                content: data.message, // use .message for cleaner output
                style: "error",
                dismissAfter: "3s"
            });
        }
    })
    .catch(error => {
        toast.push({
            title: "Error Message",
            content: error.message, // use .message for cleaner output
            style: "error",
            dismissAfter: "3s"
        });
    });

}