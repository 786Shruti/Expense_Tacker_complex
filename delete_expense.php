<?php
session_start();
include_once 'https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com//functions.php'; // Corrected path
if (!isset($_SESSION['user_id'])) {
    header('Location: https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $expenseId = $_GET['id'];
    deleteExpense($expenseId);
}

header('Location: https://ec2-13-233-150-88.ap-south-1.compute.amazonaws.com/dashboard.php');
exit;
