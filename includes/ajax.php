<?php
include("../includes/function.php");

// ===== Login ===== //
if (isset($_POST['action']) && $_POST['action'] == 'login') {
   $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $results = mysqli_query($db_conn, "SELECT * FROM tbl_accounts WHERE username = '$username' AND status = 1 LIMIT 1");

   if (mysqli_num_rows($results) > 0) {
      $account = mysqli_fetch_assoc($results);
      if (password_verify($password, $account['password'])) {
         $_SESSION['user_access'] = $account['access'];
         $_SESSION['user_id'] = $account['id'];

         if ($account['access'] == 1) {
            echo "admin";
         } elseif ($account['access'] == 2) {
            echo "user";
         } elseif ($account['access'] == 3) {
            echo "viewer";
         }
      } else {
         echo "error";
      }
   } else {
      echo "error";
   }
}

// ===== Change Password ===== //
if (isset($_POST['action']) && $_POST['action'] == 'changePassword') {
   $userId = $_SESSION['user_id'];
   $currentPassword = filter_input(INPUT_POST, 'currentPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $results = mysqli_query($db_conn, "SELECT * FROM tbl_accounts WHERE id = '$userId' LIMIT 1");

   if (mysqli_num_rows($results) > 0) {
      $acc_changePass = mysqli_fetch_assoc($results);
      if (password_verify($currentPassword, $acc_changePass['password']) && $newPassword === $confirmPassword) {
         $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

         $result1 = mysqli_query($db_conn, "UPDATE tbl_accounts SET password = '$hashedPassword' WHERE id = '$userId'");

         if ($result1) {
            echo "Password changed successfully.";
         } else {
            echo "Failed to change password.";
         }
      } else {
         echo "Incorrect current password or new passwords do not match.";
      }
   } else {
      echo "error";
   }
}

// ===== Fetch company details ===== //
if (isset($_POST['action']) && $_POST['action'] == 'company_details') {
   $company_id = $_POST['company_id'];

   $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies WHERE id = '$company_id' LIMIT 1");
   if (mysqli_num_rows($result) > 0) {
      $company = mysqli_fetch_assoc($result);

      $json_data = array(
         'company_id' => $company_id,
         'company_name' => html_entity_decode($company['company_name']),
         'company_email' => !empty($company['company_email']) ? html_entity_decode($company['company_email']) : "<i class='text-danger'>No Company Email Registered</i>",
         'company_email_edit' => html_entity_decode($company['company_email']),
         'company_address' => html_entity_decode($company['company_address']),

         'company_number' => !empty($company['company_number']) ? getContactNumber($company['company_number']) : "<i class='text-danger'>No Company Number Registered</i>",
         'company_number_edit' => explode(',', $company['company_number']),
         'contact_person' => html_entity_decode($company['contact_person']),
         'contact_number' => !empty($company['contact_number']) ? getContactNumber($company['contact_number']) : "<i class='text-danger'>No Contact Number Registered</i>",
         'contact_number_edit' => explode(',', $company['contact_number']),

         'company_status' => getStatusValue($company['company_status']),
         'company_status_edit' => $company['company_status'],

         'company_link' => !empty($company['company_link']) ? html_entity_decode($company['company_link']) : "<i class='text-danger'>No Link Address Registered</i>",
         'company_link_btn' => !empty($company['company_link']) ? "<a href=" . html_entity_decode($company['company_link']) . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",
         'company_link_edit' => html_entity_decode($company['company_link']),

         'bir_name' => !empty($company['bir_name']) ? $company['bir_name'] : "<i class='text-danger'>No file uploaded</i>",
         'bir_btn' => !empty($company['bir']) ? "<a href=upload_file/BIR/" . $company['bir'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

         'dti_name' => !empty($company['dti_name']) ? $company['dti_name'] : "<i class='text-danger'>No file uploaded</i>",
         'dti_btn' => !empty($company['dti']) ? "<a href=upload_file/DTI/" . $company['dti'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

         'permit_name' => !empty($company['permit_name']) ? $company['permit_name'] : "<i class='text-danger'>No file uploaded</i>",
         'permit_btn' => !empty($company['permit']) ? "<a href=upload_file/PERMIT/" . $company['permit'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

         'invoice_name' => !empty($company['invoice_name']) ? $company['invoice_name'] : "<i class='text-danger'>No file uploaded</i>",
         'invoice_btn' => !empty($company['invoice']) ? "<a href=upload_file/INVOICE/" . $company['invoice'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

         'certification_name' => !empty($company['certification_name']) ? $company['certification_name'] : "<i class='text-danger'>No file uploaded</i>",
         'certification_btn' => !empty($company['certification']) ? "<a href=upload_file/CERTIFICATION/" . $company['certification'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : ""
      );
   }
   echo json_encode($json_data);
}

// ===== Fetch item details ===== //
if (isset($_POST['action']) && $_POST['action'] == 'item_details') {
   $item_id = $_POST['item_id'];

   $result = mysqli_query($db_conn, "SELECT * FROM tbl_items WHERE id = '$item_id' LIMIT 1");
   if (mysqli_num_rows($result) > 0) {
      $item = mysqli_fetch_assoc($result);

      $json_data = array(
         'item_id' => $item_id,
         'item_name' => html_entity_decode($item['item_name']),
         'item_image' => !empty($item['item_image']) ? "upload_file/PICTURE/" . $item['item_image'] : "../assets/img/Not_Available.png",

         'item_brand' => !empty($item['item_brand']) ? html_entity_decode($item['item_brand']) : "<i class='text-danger'>No Brand Registered</i>",
         'item_brand_edit' => $item['item_brand'],
         'item_specification' => nl2br(html_entity_decode($item['item_specification'])),
         'item_specification_edit' => html_entity_decode($item['item_specification']),

         'item_dataname' => !empty($item['item_dataname']) ? html_entity_decode($item['item_dataname']) : "<i class='text-danger'>No Data Sheet Registered</i>",
         'item_datasheet' => !empty($item['item_datasheet']) ? "<a href=upload_file/DATASHEET/" . html_entity_decode($item['item_datasheet']) . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

         'item_status' => getStatusValue($item['item_status']),
         'item_status_edit' => $item['item_status']
      );
   }
   echo json_encode($json_data);
}

// ===== Fetch Material details ===== //
if (isset($_POST['action']) && $_POST['action'] == 'material_details') {
   $material_id = $_POST['material_id'];

   $result = mysqli_query($db_conn, "SELECT * FROM tbl_materials INNER JOIN tbl_items ON tbl_materials.material_item_id=tbl_items.id INNER JOIN tbl_companies ON tbl_materials.material_company_id=tbl_companies.id WHERE tbl_materials.id='$material_id' LIMIT 1");
   if (mysqli_num_rows($result) > 0) {
      $material = mysqli_fetch_assoc($result);

      $json_data = array(
         'material_id' => $material_id,
         'material_image' => !empty($material['item_image']) ? "upload_file/PICTURE/" . $material['item_image'] : "../assets/img/Not_Available.png",
         'material_item' => html_entity_decode($material['item_name']),
         'material_company' => html_entity_decode($material['company_name']),
         'material_address' => html_entity_decode($material['company_address']),
         'material_brand' => !empty($material['item_brand']) ? html_entity_decode($material['item_brand']) : "<i class='text-danger'>No Brand Registered</i>",
         'material_specification' => nl2br(html_entity_decode($material['item_specification'])),
         'material_vat' => getVatValue($material['material_vat']),
         'material_cost' => $material['material_cost'],
         'material_unit' => html_entity_decode($material['material_unit']),
         'material_person' => html_entity_decode($material['contact_person']),
         'material_number' => getContactNumber($material['contact_number']),

         'material_item_edit' => html_entity_decode($material['material_item_id']),
         'material_company_edit' => html_entity_decode($material['material_company_id']),
         'material_vat_edit' => $material['material_vat'],
         'material_status_edit' => $material['material_status']
      );
   }
   echo json_encode($json_data);
}

// ===== Fetch Service details ===== //
if (isset($_POST['action']) && $_POST['action'] == 'service_details') {
   $service_id = $_POST['service_id'];

   $result = mysqli_query($db_conn, "SELECT * FROM tbl_services INNER JOIN tbl_companies ON tbl_services.service_company_id=tbl_companies.id WHERE tbl_services.id='$service_id' LIMIT 1");
   if (mysqli_num_rows($result) > 0) {
      $service = mysqli_fetch_assoc($result);

      $json_data = array(
         'service_id' => $service_id,
         'service_name' => html_entity_decode($service['service_name']),
         'service_company' => html_entity_decode($service['company_name']),
         'service_address' => html_entity_decode($service['company_address']),
         'service_vat' => getVatValue($service['service_vat']),
         'service_cost' => $service['service_cost'],
         'service_unit' => html_entity_decode($service['service_unit']),
         'service_person' => html_entity_decode($service['contact_person']),
         'service_number' => getContactNumber($service['contact_number']),

         'service_company_edit' => html_entity_decode($service['service_company_id']),
         'service_vat_edit' => $service['service_vat'],
         'service_status_edit' => $service['service_status']
      );
   }
   echo json_encode($json_data);
}

// ===== Fetch Material Recent Updates ===== //
if (isset($_POST['action']) && $_POST['action'] == 'material_recent_updates') {
   $material_id = $_POST['material_id'];

   $result = mysqli_query($db_conn, "SELECT * FROM tbl_history_materials WHERE id='$material_id' ORDER BY updated_on DESC");
   if (mysqli_num_rows($result) > 0) {
      while ($history_material = mysqli_fetch_assoc($result)) {

         $id = $material_id;
         $item_name = html_entity_decode($history_material['item_name']);
         $company = html_entity_decode($history_material['company']);
         $vat = html_entity_decode($history_material['vat']);
         $unit_price = html_entity_decode($history_material['unit_price']);
         $previous_update = html_entity_decode($history_material['previous_update']);
         $updated_by = html_entity_decode($history_material['updated_by']);
         $updated_on = html_entity_decode($history_material['updated_on']);
         $status = html_entity_decode($history_material['status']);

         echo "<tr>
                  <td class=\"d-none\">$id</td>
                  <td>$item_name</td>
                  <td>$company</td>
                  <td>$vat</td>
                  <td>$unit_price</td>
                  <td>$previous_update</td>
                  <td>$updated_by</td>
                  <td>$updated_on</td>
                  <td>$status</td>
               </tr>";
      }
   } else {
      echo "<tr>
               <td class=\"d-none\">-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
               <td>-</td>
            </tr>";
   }
}
