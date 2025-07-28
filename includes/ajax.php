<?php
include("../includes/function.php");

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
            }
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
