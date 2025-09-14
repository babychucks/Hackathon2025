<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      
      <a class="navbar-brand" href="index.php">
        <img src="/assets/imgs/cashlens.png" alt="Logo" class="d-inline-block align-text-top" style="height:80px;">
      </a>

      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto text-center">

          <li class="nav-item d-none" id="points-link">
            <a class="nav-link" href="points.php">
              <img src="/assets/imgs/Star.png" alt="Points" class="me-1" style="height:34px;"> Points
            </a>
          </li>

          <li class="nav-item" id="signup-link">
            <a class="nav-link" href="signup.php">
              <img src="/assets/imgs/SignUp.png" alt="Sign Up" class="me-1" style="height:34px;"> Sign Up
            </a>
          </li>

          <li class="nav-item" id="login-link">
            <a class="nav-link" href="login.php">
              <img src="/assets/imgs/Login.png" alt="Login" class="me-1" style="height:34px;"> Login
            </a>
          </li>

          <li class="nav-item d-none" id="logout-link">
            <a class="nav-link" href="products.php">
              <img src="/assets/imgs/Logout.png" alt="Logout" class="me-1" style="height:34px;"> Logout
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const isLoggedIn = localStorage.getItem("username") !== null;//SET USERNAME/EMAIL LOCAL STOARGE
    
    const loginLink = document.getElementById("login-link");
    const signupLink = document.getElementById("signup-link");
    const logoutLink = document.getElementById("logout-link");
    const pointsLink = document.getElementById("points-link");

    if (isLoggedIn) {
        loginLink.classList.add("d-none");
        signupLink.classList.add("d-none");
        logoutLink.classList.remove("d-none");
        pointsLink.classList.remove("d-none");

        logoutLink.addEventListener("click", function () {
            localStorage.clear();
            window.location.href = "login.php";
        });

    } else {
        loginLink.classList.remove("d-none");
        signupLink.classList.remove("d-none");
        logoutLink.classList.add("d-none");
        pointsLink.classList.add("d-none");
    }
});
</script>