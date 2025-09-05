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

   // Delete item .................................................................................
   if (isset($_POST['delete_item'])) {
      $id = $_POST['id'];
      $result = mysqli_query($db_conn, "DELETE FROM tbl_items WHERE id='$id' ");

      if ($result) {
         $_SESSION["message"] = "Item deleted successfully.";
      } else {
         $_SESSION["message"] = "Failed to item item.";
      }

      header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
      ob_end_flush();
      exit;
   }

   // Edit item ...................................................................................
   if (isset($_POST['edit_item'])) {
      $edit_item_id = $_POST['edit_item_id'];
      $edit_item_name = filter_input(INPUT_POST, 'edit_item_name', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_item_brand = filter_input(INPUT_POST, 'edit_item_brand', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_item_specification = filter_input(INPUT_POST, 'edit_item_specification', FILTER_SANITIZE_SPECIAL_CHARS);
      $edit_item_status = $_POST['edit_item_status'];

      $result = mysqli_query($db_conn, "UPDATE tbl_items SET item_name='$edit_item_name', item_brand='$edit_item_brand', item_specification='$edit_item_specification', item_status='$edit_item_status' WHERE id='$edit_item_id'");

      if ($result) {

         if (isset($_FILES['edit_item_image']) && $_FILES['edit_item_image']['error'] == 0) {

            $edit_item_file_name = $edit_item_id . '_ITEM.' . pathinfo($_FILES["edit_item_image"]["name"], PATHINFO_EXTENSION);
            $edit_item_old_path = $_FILES["edit_item_image"]["tmp_name"];
            $edit_item_new_path = 'upload_file/PICTURE/' . $edit_item_file_name;
            move_uploaded_file($edit_item_old_path, $edit_item_new_path);

            mysqli_query($db_conn, "UPDATE tbl_items SET item_image = '$edit_item_file_name' WHERE id = '$edit_item_id'");
         }

         if (isset($_FILES['edit_item_sheet']) && $_FILES['edit_item_sheet']['error'] == 0) {

            $edit_sheet_name = $_FILES["edit_item_sheet"]["name"];

            $edit_sheet_file_name = $edit_item_id . '_DATASHEET.pdf';
            $edit_sheet_old_path = $_FILES["edit_item_sheet"]["tmp_name"];
            $edit_sheet_new_path = 'upload_file/DATASHEET/' . $edit_sheet_file_name;
            move_uploaded_file($edit_sheet_old_path, $edit_sheet_new_path);

            mysqli_query($db_conn, "UPDATE tbl_items SET item_datasheet = '$edit_sheet_file_name', item_dataname = '$edit_sheet_name' WHERE id = '$edit_item_id'");
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
         <button type="button" class="btn btn-primary float-right" onclick="resetForm();">
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
                     <th style="width: 170px;">Action</th>
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
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="viewItemDetails('<?php echo $row['id']; ?>')">
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

   function resetForm() {
      $('#registerAccountModal').modal('show');
   }

   function viewItemDetails(item_id) {
      $.ajax({
         url: '../includes/ajax.php',
         type: 'POST',
         data: {
            action: 'item_details',
            item_id: item_id
         },
         dataType: 'json',
         success: function(response) {
            $('#itemDetails_image').attr('src', response.item_image);
            $('#itemDetails_name').text(response.item_name);
            $('#itemDetails_brand').html(response.item_brand);
            $('#itemDetails_specification').html(response.item_specification);

            $('#itemDetails_sheet').html(response.item_dataname);
            $('#itemDetails_sheet_btn').html(response.item_datasheet);

            $('#itemDetails_status').html(response.item_status);

            $('#deleteItem_btn').attr('onclick', "deleteItem('" + response.item_id + "')");

            $('#editItem_btn').attr("onclick",
               "editItem(" +
               JSON.stringify(response.item_id) + ", " +
               JSON.stringify(response.item_name) + ", " +
               JSON.stringify(response.item_brand_edit) + ", " +
               JSON.stringify(response.item_specification_edit) + ", " +
               JSON.stringify(response.item_status_edit) +
               ")"
            );

            $('#viewItemModal').modal('show');
         },
         error: function(xhr, status, error) {
            console.error("AJAX Error:");
            console.error("Response Text: " + xhr.responseText);
         }
      });
   }

   function deleteItem(id) {
      $('#delete_item_id').val(id);
      $('#viewItemModal').modal('hide');
      $('#deleteItemModal').modal('show');
   }

   function editItem(id, name, brand, specification, status) {

      $('#edit_item_id').val(id);
      $('#edit_item_name').val(name);
      $('#edit_item_brand').val(brand);
      $('#edit_item_specification').html(specification);
      $('#edit_itemstatus').val(status).text(status == 1 ? "Active" : "Inactive");

      $('#viewItemModal').modal('hide');
      $('#editItemModal').modal('show');
   }
</script>