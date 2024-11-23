<?php
session_start();
include_once 'https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/config.php'; // For DB connection
include_once 'https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/functions.php'; // For utility functions

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if the delete request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and execute the query to delete the user from the database
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // Optionally, delete all user-related data (e.g., expenses) from other tables
        $stmt = $pdo->prepare("DELETE FROM expenses WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // Destroy the session and log the user out
        session_destroy();

        // Redirect the user to the register page or a goodbye message
        header("Location: https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/styles.css">
    <title>Delete Account</title>
</head>
<body>
    <h1>Delete Your Account</h1>
    <p>Are you sure you want to delete your account? This action is irreversible.</p>
    <form method="post" action="https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/delete_user.php">
        <button type="submit">Yes, delete my account</button>
        <a href="https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/dashboard.php">No, take me back</a>
    </form>
</body>
</html>
