<?php
require 'config.php';

try {
    $sql = "SELECT q.*, a.name AS author_name, m.name AS module_name FROM questions q
            LEFT JOIN authors a ON q.author_id = a.id
            LEFT JOIN modules m ON q.module_id = m.id
            ORDER BY created_at DESC";
    $stmt = $db->query($sql);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch questions: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Help Forum</title>
    <!-- Include CSS and JavaScript libraries/frameworks -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header.inc' ?>
    <!-- Display the list of questions -->
    <div class="container">
    <h1>Student Help Forum</h1>
    <a href="add_question.php"><button class='btn btn-danger mt-3 mb-3 px-5'>Ask Question</button></a>
    <hr>
    </div>
    <div class="heading-style container" style="margin-bottom:10px;" ><h4>All Questions</h4><br><hr><br></div>
    <div class="container" style="margin-top:12px; margin-bottom: 20px;">
    <hr style="width:20%; border:2px solid red; margin-left:0px">
    

    <?php foreach ($questions as $question) : ?>
       
            <form action="update.php" method="get">
            <?php if ($question['image']): ?>

                <div class='card shadow border card-post' style='margin-bottom:20px; margin-left:10px; margin-right:10px; display:block; width:100%; display: flex; flex: 1 1 auto; ;background-color: transparent; flex-direction: row; align-items: left; height: 320px;'> 
    <img src="images/<?php echo $question['image']; ?>"
   style='width: 40%; height: 100%;border-bottom-right-radius: 5px; object-fit: cover;'
    alt="Question Image">

    <div class='card-body' style='margin-left:20px; /*margin-bottom:20px*/'>
<?php endif; ?>
            <h3 class='card-title'><?php echo $question['title']; ?></h3>
            <p class='card-title'><?php echo $question['content']; ?></p>
            <p>Author: <?php echo $question['author_name']; ?></p>
            <p>Module: <?php echo $question['module_name']; ?></p>
            <p>Posted at: <?php echo $question['created_at']; ?></p>
            <input type="hidden" name="id" value="<?php echo $question['id']; ?>"  >
            <button type="submit" 
            style='width: 70%; background-color:antiquewhite; color:rgb(226,41,41)'
            class='btn mt-1 ml-0'
            >Edit </button>
            </div>
            </div>
            
        </form>
          
            
           
         
    <?php endforeach; ?>
    </div>
</body>
</html>
