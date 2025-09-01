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
            }
        } else {
            echo "error";
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
            'company_name' => $company['company_name'],
            'company_email' => $company['company_email'],
            'company_address' => $company['company_address'],
            'company_number' => $company['company_number'],
            'contact_person' => $company['contact_person'],
            'contact_number' => $company['contact_number'],
            'company_link' => $company['company_link'],
            'company_status' => getStatusValue($company['company_status']),
            'bir' => $company['bir'],
            'bir_name' => $company['bir_name'],
            'dti' => $company['dti'],
            'dti_name' => $company['dti_name'],
            'permit' => $company['permit'],
            'permit_name' => $company['permit_name'],
            'invoice' => $company['invoice'],
            'invoice_name' => $company['invoice_name'],
            'certtification' => $company['certtification'],
            'certtification_name' => $company['certtification_name']
        );
    }
    echo json_encode($json_data);
}
