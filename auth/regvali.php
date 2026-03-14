<?php
session_start();

include "../includes/dbconnection.php";

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';
$Cpassword = $_POST['Cpassword'] ?? '';


$_SESSION['name'] = "";
$_SESSION['email']  = "";
$_SESSION['phone'] = "";
$_SESSION['password']  = "";
$_SESSION['Cpassword'] = "";



if (isset($_POST['submit'])) {

    $valid = true;

    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['password'] = $password;
    $_SESSION['Cpassword'] = $Cpassword;
    //password hasing database me password hide karne ke liye
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    //this is for existing email and phone number because email and phone is unique field
    $emailCheck = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $phoneCheck = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone'");



    if (empty($name)) {
        $_SESSION['nameErr'] = "Name must be filled out!";
        $valid = false;
    } else {
        $_SESSION['nameErr'] = "";
    }

    if (empty($email)) {
        $_SESSION['emailErr'] = "Email must be filled out!";
        $valid = false;
    } elseif ($emailCheck->num_rows == 1) {
        $_SESSION['emailErr'] = "Email already exists";
        $valid = false;
    } else {
        $_SESSION['emailErr'] = "";
    }

    if (empty($phone)) {
        $_SESSION['phoneErr'] = "Phone must be filled out!";
        $valid = false;
    } elseif ($phoneCheck->num_rows > 0) {
        $_SESSION['phoneErr'] = "Phone already exists";
        $valid = false;
    } else {
        $_SESSION['phoneErr'] = "";
    }

    if (empty($password)) {
        $_SESSION['passwordErr_r'] = "Password must be filled out!";
        $valid = false;
    } elseif (strlen($password) < 6) {
        $_SESSION['passwordErr_r'] = "Password must be at least 6 characters";
        $valid = false;
    } else {
        $_SESSION['passwordErr_r'] = "";
    }

    if (empty($Cpassword)) {
        $_SESSION['CpasswordErr'] = "confirm password must be filled out";
        $valid = false;
    } elseif ($Cpassword !== $password) {
        $_SESSION['CpasswordErr'] = "Password and Cpassword does not match";
        $valid = false;
    } else {
        $_SESSION['CpasswordErr'] = "";
    }

    if ($valid) {

        // sare validation clear hone par hi query run ho
        $query = "INSERT INTO users(name,email,phone,password)
                  VALUES('$name','$email','$phone','$hashedPassword')";

        if ($conn->query($query)) {
            $_SESSION['success'] = "Registration Successfull";


            unset($_SESSION['name']);
            unset($_SESSION['email']);
            unset($_SESSION['phone']);
            unset($_SESSION['password']);
            unset($_SESSION['Cpassword']);
            header("Location:register.php");
        }
    }

    if (!$valid) {
        header("Location:register.php");
        exit();
    }
}
