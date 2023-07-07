<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['admin'])) {
    header('Location: manage_users.php');
    exit();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate admin credentials (replace with your own validation logic)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: manage_users.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

</head>
<body>

<?php require 'header.inc'?>
<div class="col-xxl-8 mb-5 mb-xxl-0">
						
<div class=" container bg-secondary-soft emp-profile px-4 py-5 rounded">
							
    <!-- Admin Login Form -->
    
    <h1 class="mb-4 mt-0">Admin Login</h1>
<form method="POST" action="">
<div class="col-md-12">
									<label class="form-label">User Name*</label>
									<div class="input-group shadow">
        							<div class="input-group-prepend">
        							  <span class="input-group-text p-3" id="inputGroupPrepend3"><i class="fa-solid fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="" required="" name="username">
								</div></div>


                                <div class="col-md-12">
									<label class="form-label">Password *</label>
                                    <div class="input-group shadow">
        							<div class="input-group-prepend">
        							  <span class="input-group-text p-3" id="inputGroupPrepend3"><i class="fa-solid fa-lock"></i></span>
                                    </div>
									<input type="password" class="form-control" placeholder="" required="" name="password" >
								</div></div>
                    
      <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <div class="col-md-12 d-flex justify-content-center ">
                                <button type="submit"  style="width: 100%; height:55%; margin:25px; font-weight:700" class="btn shadow reg-btn btn-outline-danger">Login</button>
</div>                              
</form>
    </div>
      </div>
    

</body>
</html>
