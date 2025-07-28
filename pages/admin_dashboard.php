<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      // header('location: admin.php');
   } elseif ($_SESSION['user_access'] == 2) {
   }
} else {
   header('location: ../index.php');
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
   </div>

   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Account List</h4>
      </div>

      <div class="card-body">
         <div class="table-responsive">
            <table class=" table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
               <thead class="bg-secondary text-white">
                  <tr>
                     <th>Title</th>
                     <th>Username</th>
                     <th>Password</th>
                     <th>Access</th>
                     <th>Status</th>
                     <th class="text-center" style="width: 170px;">Actions</th>
                  </tr>
               </thead>

               <tbody>

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