<?php
// Start session to ensure only logged-in admin can delete
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "contact_form");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../admin/dashboard.php?deleted=success");
        exit;
    } else {
        echo "Error deleting message: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>