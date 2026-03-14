<?php
include "../includes/dbconnection.php";
session_start();


if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // call select query
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {

        $row = $result->fetch_assoc();


        if (password_verify($password, $row['password'])) {
            $_SESSION['u_id'] = $row['id'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['passwordErr'] = "Invalid password";
            header("Location:login.php");
            exit();
        }
    } else {
        $_SESSION['emailErr'] = "Email not found";
        header("Location:login.php");
        exit();
    }
}
