const loginForm = document.querySelector(".login-form")
const username = document.querySelector(".username")
const password = document.querySelector(".password")

const toast = new MToast()
loginForm.onsubmit = (event) => {
    event.preventDefault()

    if(username === null) {
        toast.push({
            title: "Error Message",
            content: "Username is empty",
            width: 300,
            style: "error",
            dismissAfter: "3s"
        })
    }
    if(password === null) {

    }
}