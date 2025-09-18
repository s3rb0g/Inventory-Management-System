<?php
include('../includes/header.php');

if (isset($_SESSION['user_access'])) {
   if ($_SESSION['user_access'] == 1) {
      header('location: admin.php');
   } elseif ($_SESSION['user_access'] == 2) {
      //   header('location: user_dashboard.php');
   } elseif ($_SESSION['user_access'] == 3) {
      header('location: viewer_dashboard.php');
   }
} else {
   header('location: ../index.php');
}

$total_accounts = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT COUNT(*) as total FROM tbl_accounts"))['total'] ?? 0;
$total_companies = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT COUNT(*) as total FROM tbl_companies"))['total'] ?? 0;
$total_items = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT COUNT(*) as total FROM tbl_items"))['total'] ?? 0;
$total_materials = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT COUNT(*) as total FROM tbl_materials"))['total'] ?? 0;
$total_services = mysqli_fetch_assoc(mysqli_query($db_conn, "SELECT COUNT(*) as total FROM tbl_services"))['total'] ?? 0;

?>

<!-- Begin Page Content -->
<div class="container-fluid">
   <div class="card shadow mb-4">
      <div class="card-header py-3.5 pt-4">
         <h4 class="float-left">Dashboard</h4>
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-xl-3 col-md-6 mb-3">
               <div class="card bg-white border-left-info shadow h-100">
                  <div class="card-body text-info d-flex align-items-center py-2">
                     <div class="mr-3 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-city fa-3x"></i>
                     </div>
                     <div class="ml-auto text-right">
                        <div class="h1 mb-0 font-weight-bold"><?php echo $total_companies ?></div>
                        <div class="text-sm">Companies</div>
                     </div>
                  </div>
                  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                     <a href="user_company.php" class="text-info font-weight-bold text-decoration-none">
                        View details
                     </a>
                     <a href="user_company.php">
                        <i class="fas fa-arrow-right text-info"></i>
                     </a>
                  </div>
               </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
               <div class="card bg-white border-left-warning shadow h-100">
                  <div class="card-body text-warning d-flex align-items-center py-2">
                     <div class="mr-3 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-cubes fa-3x"></i>
                     </div>
                     <div class="ml-auto text-right">
                        <div class="h1 mb-0 font-weight-bold"><?php echo $total_items ?></div>
                        <div class="text-sm">Items</div>
                     </div>
                  </div>
                  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                     <a href="user_item.php" class="text-warning font-weight-bold text-decoration-none">
                        View details
                     </a>
                     <a href="user_item.php">
                        <i class="fas fa-arrow-right text-warning"></i>
                     </a>
                  </div>
               </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
               <div class="card bg-white border-left-success shadow h-100">
                  <div class="card-body text-success d-flex align-items-center py-2">
                     <div class="mr-3 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-tools fa-3x"></i>
                     </div>
                     <div class="ml-auto text-right">
                        <div class="h1 mb-0 font-weight-bold"><?php echo $total_materials ?></div>
                        <div class="text-sm">Materials</div>
                     </div>
                  </div>
                  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                     <a href="user_material.php" class="text-success font-weight-bold text-decoration-none">
                        View details
                     </a>
                     <a href="user_material.php">
                        <i class="fas fa-arrow-right text-success"></i>
                     </a>
                  </div>
               </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
               <div class="card bg-white border-left-primary shadow h-100">
                  <div class="card-body text-primary d-flex align-items-center py-2">
                     <div class="mr-3 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa fa-concierge-bell fa-3x"></i>
                     </div>
                     <div class="ml-auto text-right">
                        <div class="h1 mb-0 font-weight-bold"><?php echo $total_services ?></div>
                        <div class="text-sm">Services</div>
                     </div>
                  </div>
                  <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                     <a href="user_service.php" class="text-primary font-weight-bold text-decoration-none">
                        View details
                     </a>
                     <a href="user_service.php">
                        <i class="fas fa-arrow-right text-primary"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>