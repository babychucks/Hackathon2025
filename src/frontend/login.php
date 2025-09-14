<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashLens Login</title>
    
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
<div class="container d-flex align-items-center justify-content-center " style="margin:70px;"  >
    <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Login</h3>

      <form id = "loginForm" >

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control bg-light" id="email" placeholder="Enter your email" required>
        </div>

        
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control bg-light" id="password" placeholder="Enter your password" required>
        </div>
        
        <button type="submit" class="btn btn-outline-success w-100">Login</button>
      </form>
      <div class="text-center mt-3">
        Don't have an account? | <a href="signup.php">Sign up</a>
      </div>

    </div>
  </div>
</div>
  


    <script src="../../assets/js/login.js"></script>

</body>
</html>