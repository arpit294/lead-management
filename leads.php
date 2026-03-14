<?php
session_start();
include "includes/header.php";
include "includes/dbconnection.php";

if (!isset($_SESSION['u_id'])) {
    header("Location:./auth/login.php");
    exit();
}

$uid = $_SESSION['u_id'];
// $query = "SELECT * FROM leads WHERE user_id='$uid' limit 10";
// $query2 = "SELECT COUNT(*) FROM leads WHERE user_id='$uid'";
// $result = mysqli_query($conn, $query);

$limitPerPage = 10;

$query2 = "SELECT COUNT(*) as total_count FROM leads WHERE user_id='$uid'";
$count = mysqli_query($conn, $query2);
$total_count = mysqli_fetch_assoc($count)['total_count'];
$total_pages = ceil($total_count / $limitPerPage);

// current page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// offset
$offset = ($page - 1) * $limitPerPage;

$query = "SELECT * FROM leads WHERE user_id='$uid' LIMIT $limitPerPage OFFSET $offset";

$result = mysqli_query($conn, $query);


//for status selection 

if (isset($_POST['status']) && isset($_POST['id'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];


    $query = "UPDATE leads SET status='$status' WHERE id='$id'";
    mysqli_query($conn, $query);

    header("Location:leads.php");
}

//for source and status section
if (isset($_GET['source']) || isset($_GET['status']) || isset($_GET['search'])) {

    $query = "SELECT * FROM leads WHERE user_id='$uid'";
    $countQuery = "SELECT COUNT(*) as total_count FROM leads WHERE user_id='$uid'";

    if (isset($_GET['source']) && $_GET['source'] != "") {
        $source = $_GET['source'];
        $query .= " AND source='$source'";
        $countQuery .= " AND source='$source'";
    }

    if (isset($_GET['status']) && $_GET['status'] != "") {
        $status = $_GET['status'];
        $query .= " AND status='$status'";
        $countQuery .= " AND status='$status'";
    }

    if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = $_GET['search'];
        $query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR company LIKE '%$search%')";
        $countQuery .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR company LIKE '%$search%')";
    }

    // pagination
    $query .= " LIMIT $limitPerPage OFFSET $offset";

    $result = mysqli_query($conn, $query);

    $countResult = mysqli_query($conn, $countQuery);
    $total_count = mysqli_fetch_assoc($countResult)['total_count'];
    $total_pages = ceil($total_count / $limitPerPage);
}
?>

<div class="d-flex">

    <?php include "includes/sidebar.php"; ?>

    <div class="p-4 w-100">

        <form method="GET">

            <div class="d-flex justify-content-between mb-3">


                <div class="d-flex gap-2">

                    <select name="source" class="form-select" value="<?php if (isset($_GET['source'])) echo $_GET['source']; ?>" onchange="this.form.submit()">
                        <option value="">Filter by Source</option>
                        <option value="website" <?php if (isset($_GET['source']) && $_GET['source'] == 'website') echo 'selected'; ?>>Website</option>
                        <option value="referral" <?php if (isset($_GET['source']) && $_GET['source'] == 'referral') echo 'selected'; ?>>Referral</option>
                        <option value="social media" <?php if (isset($_GET['source']) && $_GET['source'] == 'social media') echo 'selected'; ?>>Social Media</option>
                        <option value="other" <?php if (isset($_GET['source']) && $_GET['source'] == 'other') echo 'selected'; ?>>Other</option>
                    </select>

                    <select name="status" class="form-select" value="<?php if (isset($_GET['status'])) echo $_GET['status']; ?>" onchange="this.form.submit()">
                        <option value="">Filter by Status</option>
                        <option value="new" <?php if (isset($_GET['status']) && $_GET['status'] == 'new') echo 'selected'; ?>>New</option>
                        <option value="contacted" <?php if (isset($_GET['status']) && $_GET['status'] == 'contacted') echo 'selected'; ?>>Contacted</option>
                        <option value="pending" <?php if (isset($_GET['status']) && $_GET['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="qualified" <?php if (isset($_GET['status']) && $_GET['status'] == 'qualified') echo 'selected'; ?>>Qualified</option>
                        <option value="close" <?php if (isset($_GET['status']) && $_GET['status'] == 'close') echo 'selected'; ?>>Close</option>
                        <option value="lost" <?php if (isset($_GET['status']) && $_GET['status'] == 'lost') echo 'selected'; ?>>Lost</option>
                    </select>

                </div>

                <div class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email or company"
                        value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
                    <?php if (
                        (isset($_GET['source']) && $_GET['source'] != "") || (isset($_GET['search']) && $_GET['search'] != "")  ||
                        (isset($_GET['status']) && $_GET['status'] != "")
                    ) { ?>
                        <a href="leads.php" class="btn btn-secondary">Clear</a>
                    <?php } ?>
                    <button type="submit" class="btn btn-success">Search</button>
                </div>

            </div>

        </form>



        <div class="table-responsive">
            <table class="table table-dark table-bordered">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Followup Date</th>
                    <th>Action</th>
                </tr>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>

                        <tr>

                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['company']; ?></td>
                            <td><?php echo $row['source']; ?></td>
                            <td>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <select class="form-select form-select-sm" name="status" aria-label="Small select example" onchange="this.form.submit()">
                                        <option selected>select status</option>
                                        <option value="New" <?php if ($row['status'] == "new") echo "selected"; ?>>New</option>
                                        <option value="Contacted" <?php if ($row['status'] == "contacted") echo "selected"; ?>>Contacted</option>
                                        <option value="Qualified" <?php if ($row['status'] == "qualified") echo "selected"; ?>>Qualified</option>
                                        <option value="Pending" <?php if ($row['status'] == "pending") echo "selected"; ?>>Pending</option>
                                        <option value="Close" <?php if ($row['status'] == "close") echo "selected"; ?>>Closed</option>
                                        <option value="Lost" <?php if ($row['status'] == "lost") echo "selected"; ?>>Lost</option>
                                    </select>
                                </form>
                            </td>
                            <td><?php echo $row['notes']; ?></td>
                            <td><?php echo $row['followup_date']; ?></td>

                            <td>
                                <a href="edit_lead.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="controller/leadController.php?id=<?php echo $row['id']; ?>&type=delete" class="btn btn-danger btn-sm">Delete</a>
                            </td>

                        </tr>

                <?php
                    }
                }
                ?>

            </table>
            <nav>
                <ul class="pagination">

                    <!-- Previous Button -->
                    <li class="page-item <?php if ($page <= 1) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>
&status=<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>
&source=<?php echo isset($_GET['source']) ? $_GET['source'] : ''; ?>
&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            Previous
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>

                        <li class="page-item <?php if ($page == $i) {
                                                    echo 'active';
                                                } ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>
&status=<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>
&source=<?php echo isset($_GET['source']) ? $_GET['source'] : ''; ?>
&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>

                    <?php } ?>

                    <!-- Next Button -->
                    <li class="page-item <?php if ($page >= $total_pages) {
                                                echo 'disabled';
                                            } ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>
&status=<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>
&source=<?php echo isset($_GET['source']) ? $_GET['source'] : ''; ?>
&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            Next
                        </a>
                    </li>

                </ul>
            </nav>

        </div>

    </div>

</div>



<?php include "includes/footer.php"; ?>