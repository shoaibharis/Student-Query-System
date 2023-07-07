<?php
require 'config.php';

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS authors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS modules (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS questions (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        author_id INT(11) NOT NULL,
        module_id INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (author_id) REFERENCES authors(id),
        FOREIGN KEY (module_id) REFERENCES modules(id)
    );

    CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
    ";

    $db->exec($sql);

    // Insert sample data into authors table
    $authorData = [
        ['name' => 'Jon Snow', 'email' => 'john@gmail.com'],
        ['name' => 'Jaime lannister', 'email' => 'jaime@gmail.com'],
        ['name' => 'Arya Stark', 'email' => 'arya@gmail.com']
        // Add more authors as needed
    ];

    $sql = "INSERT INTO authors (name, email) VALUES (:name, :email)";
    $stmt = $db->prepare($sql);

    foreach ($authorData as $author) {
        $stmt->execute($author);
    }

    // Insert sample data into modules table
    $moduleData = [
        ['name' => 'Mathematics'],
        ['name' => 'Computer Science'],
        ['name' => 'Physics'],
        // Add more modules as needed
    ];

    $sql = "INSERT INTO modules (name) VALUES (:name)";
    $stmt = $db->prepare($sql);

    foreach ($moduleData as $module) {
        $stmt->execute($module);
    }

    echo "Tables created and data inserted successfully.";
} catch (PDOException $e) {
    die("Table creation and data insertion failed: " . $e->getMessage());
}
?>
