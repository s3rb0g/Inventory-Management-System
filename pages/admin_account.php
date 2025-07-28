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
    <h1>Accounts</h1>
</div>
<!-- /.container-fluid -->

<?php
include('../includes/footer.php');
?>