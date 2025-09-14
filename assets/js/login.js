document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();
    var errorMessage = document.getElementById('error-message');

    if (!email || !password) {
        errorMessage.textContent = 'Email and password must be filled in.';
        errorMessage.style.display = 'block';
        return;
    }

    var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        errorMessage.textContent = 'Enter a valid email address.';
        errorMessage.style.display = 'block';
        return;
    }

    var loginData = {
        type: "Login",  
        "email": email,
        "password": password
    };

    var req = new XMLHttpRequest();
    req.open("POST"," ../backend/api.php", true);
    req.setRequestHeader("Content-Type", "application/json");

    req.onreadystatechange = function () {
         console.log("Raw response:", req.responseText);
        if (req.readyState === 4) {
            if (req.status === 200) {
                console.log("Raw response:", req.responseText);
                var json = JSON.parse(req.responseText);

                if (json.status === "success") {
                    const data = json.data;

                    console.log("Login success:", json);
                    console.log(data);
                    

                    localStorage.setItem("api_key", data.apikey);
                    

                    alert("Successfully logged in! Welcome");
                    window.location.href = "index.php";
                } else {
                    errorMessage.textContent = json.message || "Wrong email or password.";
                    errorMessage.style.display = 'block';
                }
            } else {
                errorMessage.textContent = "An error occurred. Please try again later.";
                errorMessage.style.display = 'block';
                console.error("Error:", req.statusText);
            }
        }
    };

    req.send(JSON.stringify(loginData));
});