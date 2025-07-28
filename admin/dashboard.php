<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Database Connection
$conn = new mysqli("localhost", "root", "", "contact_form");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages
$sql = "SELECT * FROM messages ORDER BY id asc";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard - Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Welcome, Admin!</h2>
        <a href="logout.php" class="btn btn-danger mb-4">Logout</a>

        <h4>Contact Form Submissions:</h4>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Message deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>


                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1; 
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $counter++ ?></td> 
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['message']) ?></td>
                                <td><?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A' ?></td>
                                <td>
                                    <a href="../
                                    php/delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this message?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>
</body>

</html>