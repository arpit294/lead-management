<?php
include "includes/header.php";
include "includes/dbconnection.php";
session_start();

if (!isset($_SESSION['u_id'])) {
    header("Location:./auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM leads WHERE id='$id'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Lead</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .form-card {
            max-width: 420px;
            margin: auto;
            margin-top: 60px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .form-label {
            color: #c58c45;
            font-weight: 500;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="form-card">

            <h4 class="text-center mb-4">Update Lead</h4>

            <form action="controller/leadController.php" method="POST" id="lead_form">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="<?php echo $row['name'] ?? '' ?>">
                    <span class="error nameErr"><?php echo $_SESSION['nameErr'] ?? '';
                                                unset($_SESSION['nameErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                        value="<?php echo $row['email'] ?? '' ?>">
                    <span class="error emailErr"><?php echo $_SESSION['emailErr'] ?? '';
                                                    unset($_SESSION['emailErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone"
                        value="<?php echo $row['phone'] ?? '' ?>">
                    <span class="error phoneErr"><?php echo $_SESSION['phoneErr'] ?? '';
                                                    unset($_SESSION['phoneErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" name="company" class="form-control" id="company"
                        value="<?php echo $row['company'] ?? '' ?>">
                    <span class="error companyErr"><?php echo $_SESSION['companyErr'] ?? '';
                                                    unset($_SESSION['companyErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Source</label>
                    <select name="source" class="form-select" id="source">
                        <option value="">Select Source</option>
                        <option <?php echo $row['source'] == 'website' ? 'selected' : ''; ?>>Website</option>
                        <option <?php echo $row['source'] == 'referral' ? 'selected' : ''; ?>>Referral</option>
                        <option <?php echo $row['source'] == 'social media' ? 'selected' : ''; ?>>Social Media</option>
                        <option <?php echo $row['source'] == 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <span class="error sourceErr"><?php echo $_SESSION['sourceErr'] ?? '';
                                                    unset($_SESSION['sourceErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="status">
                        <option value="">Select Status</option>
                        <option <?php echo $row['status'] == 'new' ? 'selected' : ''; ?>>New</option>
                        <option <?php echo $row['status'] == 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                        <option <?php echo $row['status'] == 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                        <option <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option <?php echo $row['status'] == 'lost' ? 'selected' : ''; ?>>Lost</option>
                    </select>
                    <span class="error statusErr"><?php echo $_SESSION['statusErr'] ?? '';
                                                    unset($_SESSION['statusErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" id="notes"><?php echo $row['notes'] ?? '' ?></textarea>
                    <span class="error notesErr"><?php echo $_SESSION['notesErr'] ?? '';
                                                    unset($_SESSION['notesErr']); ?></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Followup Date</label>
                    <input type="date" name="followup_date" class="form-control" id="followup_date"
                        value="<?php echo $row['followup_date'] ?? '' ?>">
                    <span class="error followupErr"><?php echo $_SESSION['followup_dateErr'] ?? '';
                                                    unset($_SESSION['followup_dateErr']); ?></span>
                </div>

                <input type="hidden" name="type" value="edit">

                <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>

            </form>

        </div>

    </div>
    <script>
        const nameErr = document.querySelector(".nameErr");
        const emailErr = document.querySelector(".emailErr");
        const phoneErr = document.querySelector(".phoneErr");
        const companyErr = document.querySelector(".companyErr");
        const sourceErr = document.querySelector(".sourceErr");
        const statusErr = document.querySelector(".statusErr");
        const notesErr = document.querySelector(".notesErr");
        const followupErr = document.querySelector(".followupErr");

        document.getElementById("lead_form").addEventListener("submit", function(e) {

            let valid = true;

            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const company = document.getElementById("company").value;
            const source = document.getElementById("source").value;
            const status = document.getElementById("status").value;
            const notes = document.getElementById("notes").value;
            const followup = document.getElementById("followup_date").value;


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
            } else if (phone.length != 10) {
                phoneErr.innerHTML = "Phone must be 10 digits!";
                valid = false;
            } else {
                phoneErr.innerHTML = "";
            }


            if (company === "") {
                companyErr.innerHTML = "Company must be filled out!";
                valid = false;
            } else {
                companyErr.innerHTML = "";
            }


            if (source === "") {
                sourceErr.innerHTML = "Source must be selected!";
                valid = false;
            } else {
                sourceErr.innerHTML = "";
            }


            if (status === "") {
                statusErr.innerHTML = "Status must be selected!";
                valid = false;
            } else {
                statusErr.innerHTML = "";
            }


            if (notes === "") {
                notesErr.innerHTML = "Notes must be filled out!";
                valid = false;
            } else {
                notesErr.innerHTML = "";
            }


            if (followup === "") {
                followupErr.innerHTML = "Followup date must be selected!";
                valid = false;
            } else {
                followupErr.innerHTML = "";
            }


            if (!valid) {
                e.preventDefault();
            }

        });
    </script>
</body>

</html>