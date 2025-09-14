document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var name = document.getElementById('name').value.trim();
        var surname = document.getElementById('surname').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var confirmed = document.getElementById('confirmed-password').value.trim();
        var dob = document.getElementById('dob').value;
        var uid = document.getElementById('userid').value;
        var errorMessage = document.getElementById('error-message');

        if (!name || !surname || !email || !password || !confirmed || !dob
            || !uid
        ) {
            errorMessage.textContent = 'All fields are required.';
            errorMessage.style.display = 'block';
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessage.textContent = 'Enter a valid email address.';
            errorMessage.style.display = 'block';
            return;
        }

        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!passwordRegex.test(password)) {
            errorMessage.textContent = 'Password must be at least 9 characters long, contain uppercase and lowercase letters, at least one digit, and one symbol.';
            errorMessage.style.display = 'block';
            return;
        }

        if (!password == confirmed) {
            errorMessage.textContent = 'Passwords do not match.';
            errorMessage.style.display = 'block';
            return;
        }

        var signupData = {
            "type": "Sign_Up",
            "id": uid,
            "name": name,
            "surname": surname,
            "date_of_birth": dob,
            "email": email,
            "password": password
        };

        var req = new XMLHttpRequest();
        req.open("POST", "../backend/api.php", true);
        req.setRequestHeader("Content-Type", "application/json");

        req.onreadystatechange = function () {
            if (req.readyState === 4) {
                console.log(req.responseText);
                console.log(req.status);

                if (req.status === 200) {
                    console.log(req.responseText);
                    var json = JSON.parse(req.responseText);
                    if (json.status === "success") {
                        alert("Successful registration!\n\nPlease log in.");
                        window.location.href = "login.php";
                    } else {
                        errorMessage.textContent = "Registration error: " + json.message;
                        errorMessage.style.display = 'block';
                        console.log("Error:", json.message);
                    }
                } else {
                    errorMessage.textContent = "An error occurred. Please try again later.";
                    errorMessage.style.display = 'block';
                }
            }
        };

        req.send(JSON.stringify(signupData));
    });
});