<?php
session_start();
if (!isset($_SESSION['u_id'])) {
    header("Location:./auth/login.php");
    exit();
}

?>

<?php include "includes/header.php"; ?>

<div class="d-flex">

    <?php include "includes/sidebar.php"; ?>

    <div class="p-4 w-100">

        <h2>Dashboard</h2>

        <div class="row">



        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>