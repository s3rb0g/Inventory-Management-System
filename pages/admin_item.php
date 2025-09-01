<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      // header('location: admin_dashboard.php');
   } elseif ($_SESSION['user_access'] == 2) {
   }
} else {
   header('location: ../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Add Item ....................................................................................
   if (isset($_POST['add_item'])) {
      $item_name = filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $item_brand = filter_input(INPUT_POST, 'item_brand', FILTER_SANITIZE_SPECIAL_CHARS);
      $item_specification = filter_input(INPUT_POST, 'item_specification', FILTER_SANITIZE_SPECIAL_CHARS);
      $status = 1;

      $result = mysqli_query($db_conn, "INSERT INTO tbl_items (item_name, item_brand, item_specification, item_status) VALUES ('$item_name', '$item_brand', '$item_specification', '$status')");

      if ($result) {
         $inserted_id = mysqli_insert_id($db_conn);

         if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {

            $item_name = $_FILES["item_sheet"]["name"];

            $item_file_name = $inserted_id . '_ITEM.' . pathinfo($_FILES["item_image"]["name"], PATHINFO_EXTENSION);
            $item_old_path = $_FILES["item_image"]["tmp_name"];
            $item_new_path = 'upload_file/PICTURE/' . $item_file_name;
            move_uploaded_file($item_old_path, $item_new_path);

            mysqli_query($db_conn, "UPDATE tbl_items SET item_image = '$item_file_name' WHERE id = '$inserted_id'");
         }

         if (isset($_FILES['item_sheet']) && $_FILES['item_sheet']['error'] == 0) {

            $sheet_name = $_FILES["item_sheet"]["name"];

            $sheet_file_name = $inserted_id . '_DATASHEET.pdf';
            $sheet_old_path = $_FILES["item_sheet"]["tmp_name"];
            $sheet_new_path = 'upload_file/DATASHEET/' . $sheet_file_name;
            move_uploaded_file($sheet_old_path, $sheet_new_path);

            mysqli_query($db_conn, "UPDATE tbl_items SET item_datasheet = '$sheet_file_name', item_dataname = '$sheet_name' WHERE id = '$inserted_id'");
         }

         $_SESSION["message"] = "Item Registered successfully.";
      } else {
         $_SESSION["message"] = "Failed to register item.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Item List</h4>
         <button type="button" class="btn btn-primary float-right" onclick="resetForm_item();">
            <i class="fa fa-plus pr-1"></i> Add Item
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="itemTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th style="width: 50px;">ID</th>
                     <th style="width: 350px;">Item Name</th>
                     <th style="width: 200px;">Brand</th>
                     <th style="width: 130px;">Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

                  <?php
                  $result = mysqli_query($db_conn, "SELECT * FROM tbl_items ORDER BY id ASC");
                  if (mysqli_num_rows($result) > 0):
                     while ($row = mysqli_fetch_assoc($result)):
                  ?>

                        <tr>
                           <td class="text-center"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["item_name"]) ? $row["item_name"] : "" ?></td>
                           <td><?php echo !empty($row["item_brand"]) ? $row["item_brand"] : "" ?></td>
                           <td><?php echo isset($row["item_status"]) ? getStatusValue($row["item_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="editItem()" disabled>
                                 <i class="fas fa-eye"></i> View
                              </button>
                           </td>
                        </tr>

                  <?php
                     endwhile;
                  endif;
                  ?>

               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>

<script>
   $(document).ready(function() {
      $('#itemTable').DataTable();
   });

   function resetForm_item() {

      $('#registerAccountModal').modal('show');
   }
</script>