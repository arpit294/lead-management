<?php
session_start();
include "includes/header.php";
include "includes/dbconnection.php";


if (!isset($_SESSION['u_id'])) {
    header("Location:./auth/login.php");
    exit();
}

$uid = $_SESSION['u_id'];


// Total leads
$total = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid'"
))['total'];

// New leads
$new = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid' AND status='new'"
))['total'];

// Pending leads
$pending = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid' AND status='pending'"
))['total'];

// Contacted leads
$contacted = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid' AND status='contacted'"
))['total'];

// Qualified leads
$qualified = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid' AND status='qualified'"
))['total'];

// Closed leads
$closed = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM leads WHERE user_id='$uid' AND status='close'"
))['total'];

// Recent leads
$recent = mysqli_query(
    $conn,
    "SELECT name, company, status
FROM leads
WHERE user_id='$uid'
ORDER BY id DESC
LIMIT 5"
);

?>



<header>
    <link rel="stylesheet" href="css/dashboard.css">
</header>
<div class="d-flex">

    <?php include "includes/sidebar.php"; ?>

    <div class="p-4 w-100">

        <h2 class="mb-6">Dashboard</h2>


        <div class="row mb-4">

            <div class="row mb-4">

                <div class="col-md-2">
                    <div class="card text-white bg-dark shadow">
                        <div class="card-body">
                            <h6>Total</h6>
                            <h3><?php echo $total; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <h6>New</h6>
                            <h3><?php echo $new; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card text-dark bg-warning shadow">
                        <div class="card-body">
                            <h6>Pending</h6>
                            <h3><?php echo $pending; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <h6>Contacted</h6>
                            <h3><?php echo $contacted; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card text-white bg-info shadow">
                        <div class="card-body">
                            <h6>Qualified</h6>
                            <h3><?php echo $qualified; ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="card text-white bg-danger shadow">
                        <div class="card-body">
                            <h6>Closed</h6>
                            <h3><?php echo $closed; ?></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

       
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Recent Leads
            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($recent)) { ?>

                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['company']; ?></td>

                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>