<?php
include('config.php');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the GET request and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = intval($_GET['id']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to index.php after successful deletion
        header('Location: index.php');
        exit();
    } else {
        // Display error message if execution fails
        echo "Error executing query: " . htmlspecialchars($stmt->error);
    }
    
    $stmt->close();
} else {
    // Handle the case where 'id' is not set or is invalid
    echo "Invalid ID.";
}

// Close the database connection
$conn->close();
?>
