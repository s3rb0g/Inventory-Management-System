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

   // Add Material ....................................................................................
   if (isset($_POST['add_material'])) {
      $material_item = $_POST['material_item'];
      $material_company = $_POST['material_item'];
      $material_vat = $_POST['material_item'];
      $material_cost = $_POST['material_item'];
      $material_unit = filter_input(INPUT_POST, 'material_unit', FILTER_SANITIZE_SPECIAL_CHARS);


      //  $_SESSION["message"] = "Item Registered successfully.";
      // } else {
      //    $_SESSION["message"] = "Failed to register item.";
      // }

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
         <h4 class="float-left">Materials List</h4>
         <button type="button" class="btn btn-primary float-right" onclick="registerMaterial()">
            <i class="fa fa-plus pr-1"></i> Add Materials
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-scollable table-hover" id="materialTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th class="d-none">ID</th>
                     <th style="width: 20%;">Name</th>
                     <th style="width: 20%;">Company</th>
                     <th style="width: 15%;">Location</th>
                     <th style="width: 10%;">VAT</th>
                     <th style="width: 10%;">Price</th>
                     <th style="width: 5%;">Unit</th>
                     <th style="width: 10%;">Status</th>
                     <th style="width: 10%;">Actions</th>
                  </tr>
               </thead>

               <tbody>
                  <td class="d-none"></td>
                  <td>asdasd asduiasd iasud</td>
                  <td>adieughf iuhd</td>
                  <td>oiasdh eojf</td>
                  <td>VAT EX</td>
                  <td>87687 6</td>
                  <td>pc</td>
                  <td>Active</td>
                  <td class="d-flex justify-content-center align-items-center">
                     <button type="button" class="btn btn-sm btn-primary mr-2" onclick="editAccount()" disabled>
                        <i class="fas fa-eye"></i> View
                     </button>
                  </td>

                  <!-- <?php
                        $result = mysqli_query($db_conn, "SELECT * FROM tbl_companies ORDER BY id ASC");
                        if (mysqli_num_rows($result) > 0):
                           while ($row = mysqli_fetch_assoc($result)):
                        ?>

                        <tr>
                           <td class="text-center"><?php echo !empty($row["id"]) ? $row["id"] : "" ?></td>
                           <td><?php echo !empty($row["company_name"]) ? $row["company_name"] : "" ?></td>
                           <td><?php echo !empty($row["company_address"]) ? $row["company_address"] : "" ?></td>
                           <td><?php echo !empty($row["contact_person"]) ? $row["contact_person"] : "" ?></td>
                           <td><?php echo isset($row["company_status"]) ? getStatusValue($row["company_status"]) : "" ?></td>
                           <td class="d-flex justify-content-center align-items-center">
                              <button type="button" class="btn btn-sm btn-primary mr-2" onclick="editAccount()" disabled>
                                 <i class="fas fa-eye"></i> View
                              </button>
                           </td>
                        </tr>

                  <?php
                           endwhile;
                        endif;
                  ?> -->

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
      $('#materialTable').DataTable();
   });

   function registerMaterial() {
      $('#registermaterialModal').modal('show');
   }
</script>