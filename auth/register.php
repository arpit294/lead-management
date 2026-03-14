   <?php
session_start();

    include "../includes/dbconnection.php";

    if (isset($_SESSION['u_id'])) {
        header("Location:../dashboard.php");
        exit();
    }
    ?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Register</title>

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="../css/reg.css">

   </head>

   <body>



       <div id="background"></div>
       <div class="register-box">

           <form action="regvali.php" method="post" id="myform">

               <h2 class="text-center mb-4">Register</h2>

               <div class="mb-3">
                   <label class="form-label">Name</label>
                   <input type="text" id="name" class="form-control" name="name" placeholder="Enter your name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?>">
                   <span class="text-danger nameErr">
                       <?php echo isset($_SESSION['nameErr']) ? $_SESSION['nameErr'] : "";
                        unset($_SESSION['nameErr']); ?>
                   </span>
               </div>

               <div class="mb-3">
                   <label class="form-label">Email</label>
                   <input type="email" id="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ""; ?>">
                   <span class="text-danger emailErr">
                       <?php echo isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : "";
                        unset($_SESSION['emailErr']); ?>
                   </span>
               </div>

               <div class="mb-3">
                   <label class="form-label">Phone</label>
                   <input type="text" id="phone" class="form-control" name="phone" placeholder="Enter your phone number" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ""; ?>">
                   <span class="text-danger phoneErr">
                       <?php echo isset($_SESSION['phoneErr']) ? $_SESSION['phoneErr'] : "";
                        unset($_SESSION['phoneErr']); ?>
                   </span>
               </div>

               <div class="mb-3">
                   <label class="form-label">Password</label>
                   <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : ""; ?>">
                   <span class="text-danger passwordErr">
                       <?php echo isset($_SESSION['passwordErr_r']) ? $_SESSION['passwordErr_r'] : "";
                        unset($_SESSION['passwordErr_r']); ?>
                   </span>
               </div>

               <div class="mb-3">
                   <label class="form-label">Confirm Password</label>
                   <input type="password" id="Cpassword" class="form-control" name="Cpassword" placeholder="Enter confirm password">
                   <span class="text-danger CpasswordErr">
                       <?php echo isset($_SESSION['CpasswordErr']) ? $_SESSION['CpasswordErr'] : "";
                        unset($_SESSION['CpasswordErr']); ?>
                   </span>
               </div>

               <div class="text-success success">
                   <?php
                    echo isset($_SESSION['success']) ? $_SESSION['success'] : "";
                    unset($_SESSION['success']);
                    ?>
               </div>

               <button type="submit" name="submit" id="submit" style="background-color: #e1be8d" class="btn btn-primary w-100">Register</button>



               <div class="text-center mt-3">
                   <p>Do you have an account? <a href="login.php">Login</a></p>
               </div>

           </form>



       </div>

       <script>
           const nameErr = document.querySelector(".nameErr");
           const emailErr = document.querySelector(".emailErr");
           const phoneErr = document.querySelector(".phoneErr");
           const passwordErr = document.querySelector(".passwordErr");
           const CpasswordErr = document.querySelector(".CpasswordErr");

           document.getElementById("myform").addEventListener("submit", function(e) {
               let valid = true;
               const name = document.getElementById("name").value;
               const email = document.getElementById("email").value;
               const phone = document.getElementById("phone").value;
               const password = document.getElementById("password").value;
               const Cpassword = document.getElementById("Cpassword").value;

               if (name === "") {
                   nameErr.innerHTML = "Name must be filled out!";
                   valid = false;
               } else {
                   nameErr.innerHTML = "";
               }

               if (email === "") {
                   emailErr.innerHTML = "Email must be filled out!";
                   valid = false;
               } else {
                   emailErr.innerHTML = "";
               }

               if (phone === "") {
                   phoneErr.innerHTML = "Phone must be filled out!";
                   valid = false;
               } else {
                   phoneErr.innerHTML = "";
               }

               if (password === "") {
                   passwordErr.innerHTML = "Password must be filled out!";
                   valid = false;
               } else if (password.length < 6) {
                   passwordErr.innerHTML = "Minimum 6 characters required";
                   valid = false;
               } else {
                   passwordErr.innerHTML = "";
               }

               if (Cpassword === "") {
                   CpasswordErr.innerHTML = "Confirm password must be filled out!";
                   valid = false;
               } else {
                   CpasswordErr.innerHTML = "";
               }

               if (Cpassword !== password) {
                   CpasswordErr.innerHTML = "Password and Confirm password does not match!";
                   valid = false;
               } else {
                   CpasswordErr.innerHTML = "";
               }

               if (!valid) {
                   e.preventDefault();
               }
           });
       </script>

   </body>

   </html>