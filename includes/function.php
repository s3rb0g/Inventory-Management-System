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

function getAccessValue($id)
{
   if ($id == 1) {
      return "Admin";
   } elseif ($id == 2) {
      return "Editor";
   } elseif ($id == 3) {
      return "Viewer";
   } else {
      return "Unknown Access";
   }
}

function getStatusValue($id)
{
   if ($id == 0) {
      return "Inactive";
   } elseif ($id == 1) {
      return "Active";
   } else {
      return "Unknown Access";
   }
}
