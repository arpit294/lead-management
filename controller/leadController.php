<?php
session_start();
include "../includes/dbconnection.php";

if ($_POST['type'] == "create") {
    AddLead();
} elseif ($_POST['type'] == "edit") {
    editLead();
} elseif (isset($_GET['type'])) {
    deleteLead();
}
function AddLead()
{
    if (!isset($_SESSION['u_id'])) {
        header("Location:./auth/login.php");
        exit();
    }

    $con = $GLOBALS['conn'];
    $uid = $_SESSION['u_id'];

    if (isset($_POST['submit'])) {

        $data = array('name' => $_POST['name'], 'email' => $_POST['email'], 'phone' => $_POST['phone'], 'company' => $_POST['company'], 'source' => $_POST['source'], 'status' => $_POST['status'], 'notes' => $_POST['notes'], 'followup_date' => $_POST['followup_date']);

        $valid = true;

        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }

        foreach ($data as $key => $value) {
            if (empty($value)) {
                //concationation
                $_SESSION[$key . "Err"] = $key . " required";
                $valid = false;
            }
        }



        if (!$valid) {
            header("Location:./add_lead.php");
            exit();
        }

        $query = "INSERT INTO leads(user_id,name,email,phone,company,source,status,notes,followup_date)
VALUES(?,?,?,?,?,?,?,?,?)";

        try {
            if ($stmt = mysqli_prepare($con, $query)) {
                // Bind parameters
                $stmt->bind_param("issssssss", $_SESSION['u_id'], $data["name"], $data["email"], $data["phone"], $data["company"], $data["source"], $data["status"], $data["notes"], $data["followup_date"]);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {

                    foreach ($data as $key => $value) {
                        unset($_SESSION[$key]);
                    }
                    header("Location:../leads.php");
                    exit();
                }
            } else {
                echo "error";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}



function editLead()
{

    if (!isset($_SESSION['u_id'])) {
        header("Location:login.php");
        exit();
    }



    $con = $GLOBALS['conn'];
    $uid = $_SESSION['u_id'];
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {

        

        $valid = true;

        $data = array('name' => $_POST['name'], 'email' => $_POST['email'], 'phone' => $_POST['phone'], 'company' => $_POST['company'], 'source' => $_POST['source'], 'status' => $_POST['status'], 'notes' => $_POST['notes'], 'followup_date' => $_POST['followup_date']);

        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }

        foreach ($data as $key => $value) {
            if (empty($value)) {
                $_SESSION[$key . 'Err'] = $key . " required";
                $valid = false;
            }
        }

        if (!$valid) {
            header("Location:edit_lead.php?id=" . $id);
            exit();
        }

        $query = "UPDATE leads SET user_id=?, name=?, email=?, phone=?, company=?, source=?, status=?, notes=?, followup_date=? WHERE id=?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssssssi", $uid, $data['name'],$data['email'], $data['phone'], $data['company'], $data['source'], $data['status'], $data['notes'], $data['followup_date'], $id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            header("Location:../leads.php");
            exit();
        }


        if (!$valid) {
            header("Location:edit_lead.php?id=" . $id);
            exit();
        }
    }
}





function deleteLead()
{
    $con = $GLOBALS['conn'];

    if (!isset($_SESSION['u_id'])) {
        header("Location:./auth/login.php");
        exit();
    }

    $uid = $_SESSION['u_id'];
    $id = $_GET['id'];

    $query = "SELECT * FROM leads WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);


    if (isset($_GET['id'])) {


        $id = $_GET['id'];
        $query = "DELETE FROM leads WHERE id=$id AND user_id=$uid";

        if (mysqli_query($con, $query)) {
            header("Location:../leads.php");
            exit();
        }
    }
}
