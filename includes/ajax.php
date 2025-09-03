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
            'company_name' => html_entity_decode($company['company_name']),
            'company_email' => !empty($company['company_email']) ? html_entity_decode($company['company_email']) : "<i class='text-danger'>No Company Email Registered</i>",
            'company_email_edit' => html_entity_decode($company['company_email']),
            'company_address' => html_entity_decode($company['company_address']),

            'company_number' => !empty($company['company_number']) ? getContactNumber($company['company_number']) : "<i class='text-danger'>No Company Number Registered</i>",
            'company_number_edit' => explode(',', $company['company_number']),
            'contact_person' => html_entity_decode($company['contact_person']),
            'contact_number' => !empty($company['contact_number']) ? getContactNumber($company['contact_number']) : "<i class='text-danger'>No Contact Number Registered</i>",
            'contact_number_edit' => explode(',', $company['contact_number']),

            'company_status' => getStatusValue($company['company_status']),
            'company_status_edit' => $company['company_status'],

            'company_link' => !empty($company['company_link']) ? html_entity_decode($company['company_link']) : "<i class='text-danger'>No Link Address Registered</i>",
            'company_link_btn' => !empty($company['company_link']) ? "<a href=" . html_entity_decode($company['company_link']) . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",
            'company_link_edit' => html_entity_decode($company['company_link']),

            'bir_name' => !empty($company['bir_name']) ? $company['bir_name'] : "<i class='text-danger'>No file uploaded</i>",
            'bir_btn' => !empty($company['bir']) ? "<a href=upload_file/BIR/" . $company['bir'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

            'dti_name' => !empty($company['dti_name']) ? $company['dti_name'] : "<i class='text-danger'>No file uploaded</i>",
            'dti_btn' => !empty($company['dti']) ? "<a href=upload_file/DTI/" . $company['dti'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

            'permit_name' => !empty($company['permit_name']) ? $company['permit_name'] : "<i class='text-danger'>No file uploaded</i>",
            'permit_btn' => !empty($company['permit']) ? "<a href=upload_file/PERMIT/" . $company['permit'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

            'invoice_name' => !empty($company['invoice_name']) ? $company['invoice_name'] : "<i class='text-danger'>No file uploaded</i>",
            'invoice_btn' => !empty($company['invoice']) ? "<a href=upload_file/INVOICE/" . $company['invoice'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

            'certification_name' => !empty($company['certification_name']) ? $company['certification_name'] : "<i class='text-danger'>No file uploaded</i>",
            'certification_btn' => !empty($company['certification']) ? "<a href=upload_file/CERTIFICATION/" . $company['certification'] . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : ""
        );
    }
    echo json_encode($json_data);
}

// ===== Fetch item details ===== //
if (isset($_POST['action']) && $_POST['action'] == 'item_details') {
    $item_id = $_POST['item_id'];

    $result = mysqli_query($db_conn, "SELECT * FROM tbl_items WHERE id = '$item_id' LIMIT 1");
    if (mysqli_num_rows($result) > 0) {
        $item = mysqli_fetch_assoc($result);

        $json_data = array(
            'item_id' => $item_id,
            'item_name' => html_entity_decode($item['item_name']),
            'item_image' => !empty($item['item_image']) ? "upload_file/PICTURE/" . $item['item_image'] : "../assets/img/Not_Available.png",

            'item_brand' => !empty($item['item_brand']) ? html_entity_decode($item['item_brand']) : "<i class='text-danger'>No Brand Registered</i>",
            'item_brand_edit' => $item['item_brand'],
            'item_specification' => nl2br(html_entity_decode($item['item_specification'])),
            'item_specification_edit' => html_entity_decode($item['item_specification']),

            'item_dataname' => !empty($item['item_dataname']) ? html_entity_decode($item['item_dataname']) : "<i class='text-danger'>No Data Sheet Registered</i>",
            'item_datasheet' => !empty($item['item_datasheet']) ? "<a href=upload_file/DATASHEET/" . html_entity_decode($item['item_datasheet']) . " target='_blank'><button class='btn btn-sm bg-primary text-white'><i class='fas fa-eye mr-1'></i> View </button></a>" : "",

            'item_status' => getStatusValue($item['item_status']),
            'item_status_edit' => $item['item_status']
        );
    }
    echo json_encode($json_data);
}
