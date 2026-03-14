<?php
session_start();

include "../includes/dbconnection.php";

if (isset($_SESSION['u_id'])) {
    header("Location: ./dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">

</head>

<body>
    <div id="background"></div>
    <div class="container-box">
        <div class="background"></div>
        <form action="loginvali.php" method="post" id="myform">
            <h2 class="text-center mb-4">Login</h2>
            <p>Login to access your dashboard</p>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : "";
                                                                                                                        unset($_SESSION['email']); ?>">
                <span class="text-danger emailErr">
                    <?php echo isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : ""; ?>
                </span>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                <span class="text-danger passwordErr">
                    <?php echo isset($_SESSION['passwordErr']) ? $_SESSION['passwordErr'] : "";
                    unset($_SESSION['passwordErr']); ?>
                </span>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #e1be8d;" name="submit">Login</button>

            <div class="text-center mt-3">
                <p style="color: black;">you don't have an account?
                    <a href="register.php">Register</a>
                </p>
            </div>




        </form>

    </div>

    <script>
        const emailErr = document.querySelector(".emailErr");
        const passwordErr = document.querySelector(".passwordErr");

        document.getElementById("myform").addEventListener("submit", function(e) {

            let valid = true;

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;


            if (email === "") {
                emailErr.innerHTML = "Enter email";
                valid = false;
            } else if (!email.includes("@") || !email.includes(".")) {
                emailErr.innerHTML = "Invalid email";
                valid = false;
            } else {
                emailErr.innerHTML = "";
            }

            if (password === "") {
                passwordErr.innerHTML = "Enter password";
                valid = false;
            } else if (password.length < 6) {
                passwordErr.innerHTML = "Minimum 6 characters required";
                valid = false;
            } else {
                passwordErr.innerHTML = "";
            }

            if (!valid) {
                e.preventDefault();
            }

        });
    </script>
</body>

</html>