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
   header("Refresh: .3; url=" . $_SERVER['PHP_SELF']);
   ob_end_flush();
   exit;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>