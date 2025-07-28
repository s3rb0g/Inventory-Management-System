<?php
include("../includes/auth.php");

function getFullname()
{
    global $db_conn;
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($db_conn, "SELECT * FROM tbl_accounts WHERE id = '$user_id'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

        return "$title $firstname $lastname";
    }
    return "Unknown User";
}
