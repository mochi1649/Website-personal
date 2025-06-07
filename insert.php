<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input (optional, but recommended)
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO user (name, email) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
}

$conn->close();
?>