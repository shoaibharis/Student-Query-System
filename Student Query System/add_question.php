<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $authorId = $_POST['author_id'];
    $moduleId = $_POST['module_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFile = $_FILES['image']['tmp_name'];
        $imageFileName = $_FILES['image']['name'];
        move_uploaded_file($imageFile, 'images/' . $imageFileName);
    }

    try {
        $sql = "INSERT INTO questions (title, content, image, author_id, module_id)
            VALUES (:title, :content, :image, :author_id, :module_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $imageFileName);
    $stmt->bindParam(':author_id', $authorId);
    $stmt->bindParam(':module_id', $moduleId);
    $stmt->execute();

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die("Failed to add question: " . $e->getMessage());
    }
}

try {
    $sql = "SELECT * FROM authors";
    $stmt = $db->query($sql);
    $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM modules";
    $stmt = $db->query($sql);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch authors/modules: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <!-- Include CSS and JavaScript libraries/frameworks -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header.inc'?>
    <!-- Create the form to add a question -->
    <div class="container shadow text-center">
    <h1>Add Question</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" class="shadow m-2" required><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" class="shadow m-2" required></textarea><br>

        <label for="author_id">Author:</label>
        <select id="author_id" name="author_id" class="shadow m-2" required>
            <?php foreach ($authors as $author) : ?>
                <option value="<?php echo $author['id']; ?>"><?php echo $author['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="module_id">Module:</label>
        <select id="module_id" name="module_id" class="shadow m-2" required>
            <?php foreach ($modules as $module) : ?>
                <option value="<?php echo $module['id']; ?>"><?php echo $module['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="image">Image:</label>
    <input type="file" id="image" class="shadowm-2" name="image"><br>

        <button type="submit" class="btn btn-danger px-3 mt-3 mb-3 shadow">Add Question</button>
    </form>
    </div>
</body>
</html>
