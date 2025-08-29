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
?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Service List</h4>
         <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createCompanyModal" disabled>
            <i class="fa fa-plus pr-1"></i> Add Service
         </button>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-hover" id="serviceTable" width="100%" cellspacing="0">
               <thead class="bg-primary text-white">
                  <tr class="text-center">
                     <th>ID</th>
                     <th>Name</th>
                     <th>Company</th>
                     <th>Price</th>
                     <th>Status</th>
                     <th style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

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
      $('#serviceTable').DataTable();
   });
</script>