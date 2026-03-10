async function login() {

    const email = document.getElementById("email").value
    const password = document.getElementById("password").value

    const res = await fetch("../backend/auth/login.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            email: email,
            password: password
        })

    })

    const data = await res.json()

    if (data.status === "success") {

        // store role for access control
        localStorage.setItem("role", data.role)

        alert("Login successful")

        // redirect based on role
        if (data.role === "admin") {
            window.location = "admin.html"
        } else if (data.role === "ec") {
            window.location = "dashboard_ec.html"
        } else {
            window.location = "dashboard_user.html"
        }

    } else {

        alert("Invalid email or password")

    }

}