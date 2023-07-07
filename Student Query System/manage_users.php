<?php
require 'config.php';
session_start();

// Check if the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit();
}
// Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "INSERT INTO authors (name, email) VALUES (:username, :email)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    header('Location: manage_users.php');
    exit();
}

// Edit User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE authors SET name = :username, email = :email WHERE id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    header('Location: manage_users.php');
    exit();
}

// Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];

    $sql = "DELETE FROM authors WHERE id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    header('Location: manage_users.php');
    exit();
}

// Fetch all users
$sql = "SELECT * FROM authors";
$stmt = $db->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<?php require 'admin-header.inc' ?>
    <!-- Display Users -->
    <div class="container shadow py-2">

<div>
<table>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <form method="POST" action="">
                    <input class="shadow m-2"  type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button class="btn btn-danger" type="submit" name="delete_user">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    <div>
<!-- Add User Form -->
<form method="POST" action="">
    <input type="text" class="shadow m-2" name="username" placeholder="Username" required>
    <input type="email" class="shadow m-2" name="email" placeholder="Email" required>
    <button type="submit" class="btn btn-danger" name="add_user">Add User</button>
</form>
    </div>

</body>
</html>

