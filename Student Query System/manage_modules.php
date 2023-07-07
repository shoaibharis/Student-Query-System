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

// Add Module
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_module'])) {
    $moduleName = $_POST['module_name'];

    $sql = "INSERT INTO modules (name) VALUES (:module_name)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':module_name', $moduleName);
    $stmt->execute();

    header('Location: manage_modules.php');
    exit();
}

// Delete Module
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_module'])) {
    $moduleId = $_POST['module_id'];

    $sql = "DELETE FROM modules WHERE id = :module_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':module_id', $moduleId);
    $stmt->execute();

    header('Location: manage_modules.php');
    exit();
}

// Fetch all modules
$sql = "SELECT * FROM modules";
$stmt = $db->query($sql);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<!-- Display Modules -->
<div class="container shadow">


<table>
    <tr>
        <th>Module Name</th>
        <th>Action</th>
    </tr>
    <?php foreach ($modules as $module) : ?>
        <tr>
            <td><?php echo $module['name']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" class="shadow m-2" name="module_id" value="<?php echo $module['id']; ?>">
                    <button type="submit" class="btn btn-danger" name="delete_module">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
 

<!-- Add Module Form -->
<form method="POST" action="">
    <input type="text" name="module_name" class="shadow m-2" placeholder="Module Name" required>
    <button type="submit" name="add_module"  class="btn btn-primary px-3 mt-3 mb-3 shadow">Add Module</button>
</form>
    </div>
</body>
</html>

