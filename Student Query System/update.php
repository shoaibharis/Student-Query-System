<?php
require 'config.php';

$questionId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            $sql = "DELETE FROM questions WHERE id = :question_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':question_id', $questionId);
            $stmt->execute();

            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            die("Failed to delete question: " . $e->getMessage());
        }
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $authorId = $_POST['author_id'];
        $moduleId = $_POST['module_id'];

        // Process image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFile = $_FILES['image']['tmp_name'];
        $imageFileName = $_FILES['image']['name'];
        move_uploaded_file($imageFile, 'images/' . $imageFileName);

        // Save the image filename in the database
        $sql = "UPDATE questions SET image = :image WHERE id = :question_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':image', $imageFileName);
        $stmt->bindParam(':question_id', $questionId);
        $stmt->execute();
    }

        try {
            $sql = "UPDATE questions SET title = :title, content = :content, author_id = :author_id, module_id = :module_id
                    WHERE id = :question_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author_id', $authorId);
            $stmt->bindParam(':module_id', $moduleId);
            $stmt->bindParam(':question_id', $questionId);
            $stmt->execute();

            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            die("Failed to update question: " . $e->getMessage());
        }
    }
}

try {
    $sql = "SELECT * FROM questions WHERE id = :question_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':question_id', $questionId);
    $stmt->execute();
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM authors";
    $stmt = $db->query($sql);
    $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM modules";
    $stmt = $db->query($sql);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch question/authors/modules: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <!-- Include CSS and JavaScript libraries/frameworks -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header.inc'?>
    <!-- Create the form to edit a question -->
    <div class="container shadow text-center">
    <h1>Edit Question</h1>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" class="shadow m-2" name="title" value="<?php echo $question['title']; ?>" required><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content"  class="shadow m-2" required><?php echo $question['content']; ?></textarea><br>

        <label for="image">Image:</label>
    <input type="file" id="image"  class="shadow m-2" name="image"><br>
    
        <label for="author_id">Author:</label>
        <select id="author_id" name="author_id"  class="shadow m-2" required>
            <?php foreach ($authors as $author) : ?>
                <option value="<?php echo $author['id']; ?>" <?php echo ($author['id'] == $question['author_id']) ? 'selected' : ''; ?>><?php echo $author['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="module_id">Module:</label>
        <select id="module_id" name="module_id"  class="shadow m-2" required>
            <?php foreach ($modules as $module) : ?>
                <option value="<?php echo $module['id']; ?>" <?php echo ($module['id'] == $question['module_id']) ? 'selected' : ''; ?>><?php echo $module['name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <button class= "btn btn-primary "type="submit">Save Changes</button>
    </form>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
        <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">
        <button type="submit" class="btn btn-danger px-3 mt-3 mb-3 shadow" name="delete">Delete Question</button>
    </form>
            </div>
</body>
</html>
