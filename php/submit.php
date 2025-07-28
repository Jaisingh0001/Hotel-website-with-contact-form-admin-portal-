<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (
        isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['message']) &&
        !empty($_POST['name']) &&
        !empty($_POST['email']) &&
        !empty($_POST['phone']) &&
        !empty($_POST['message'])
    ) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $message = trim($_POST['message']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address.";
            exit;
        }

        // MySQL Connection
        $conn = new mysqli("localhost", "root", "", "contact_form");

        if ($conn->connect_error) {
            echo "Database connection failed.";
            exit;
        }

        // Insert query
        $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            echo "SQL error: " . $conn->error;
            exit;
        }

        $stmt->bind_param("ssss", $name, $email, $phone, $message);

        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Failed to save message: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill all fields correctly.";
    }

} else {
    echo "Invalid request.";
}
?>