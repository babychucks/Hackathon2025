<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
<div class="container d-flex align-items-center justify-content-center " style=" margin:20px;"  >
    <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">SignUp</h3>

      <form>

      <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="name" class="form-control bg-light" id="name" placeholder="Enter your name" required>
        </div>

      <div class="mb-3">
          <label for="surname" class="form-label">Surname</label>
          <input type="surname" class="form-control bg-light" id="surname" placeholder="Enter your surname" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control bg-light" id="email" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth: </label>
            <input type="date" class="form-control bg-light" id="dob" required>
          </div>
          
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control bg-light" id="password" placeholder="Enter your password" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label"> Confirm Password</label>
          <input type="confirmed-password" class="form-control bg-light" id="confirmed-password" placeholder="Please confirm password" required>
        </div> 

        
        
        <button type="submit" class="btn btn-outline-success w-100">SignUp</button>
      </form>

    </div>
  </div>
</div>
  


    <script src="../../assets/js/signup.js"></script>

</body>
</html>