<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert the data into the database
    $sql = "INSERT INTO messages (email, message) VALUES (:email, :message)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo "Message sent successfully.";
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
</head>
<body>
<?php require 'header.inc' ?>
<div class="container shadow py-2 text-center">
   <!-- Contact Form -->
   <h1>Contact Admin</h1>
<form method="POST" action="">
    <input type="email" name="email" class="shadow m-2" placeholder="Your Email" required><br>
    <textarea name="message" placeholder="Your Message" class="shadow m-2"  required></textarea><br>
    <button type="submit" class="btn btn-danger px-2">Send Message</button>
</form> 
</div>
</body>
</html>

