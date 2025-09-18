<?php
include("../includes/auth.php");

function getFullname($user_id)
{
   global $db_conn;
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

function getAccessValue($access)
{
   if ($access == 1) {
      return "Admin";
   } elseif ($access == 2) {
      return "Editor";
   } elseif ($access == 3) {
      return "Viewer";
   } else {
      return "Unknown Access";
   }
}

function getStatusValue($status)
{
   if ($status == 0) {
      return "Inactive";
   } elseif ($status == 1) {
      return "Active";
   } else {
      return "Unknown Access";
   }
}

function getContactNumber($contact_number)
{
   $string_number = "";
   $array_number = explode(',', $contact_number);

   foreach ($array_number as $index => $number) {
      $string_number .= $number . "<br>";
   }

   return $string_number;
}

function getItemName($item_id)
{
   global $db_conn;
   $result = mysqli_query($db_conn, "SELECT item_name FROM tbl_items WHERE id = '$item_id'");

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $item_name = $row['item_name'];

      return $item_name;
   }
   return "Unknown User";
}

function getCompanyName($company_id)
{
   global $db_conn;
   $result = mysqli_query($db_conn, "SELECT company_name FROM tbl_companies WHERE id = '$company_id'");

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $company_name = $row['company_name'];

      return $company_name;
   }
   return "Unknown User";
}

function getVatValue($vat)
{
   if ($vat == 0) {
      return "VAT EX";
   } elseif ($vat == 1) {
      return "VAT IN";
   } else {
      return "Unknown Access";
   }
}

function getDisplay()
{
   if ($_SESSION['user_access'] == 3) {
      return "style='display: none;'";
   } else {
      return "";
   }
}
