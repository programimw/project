<?php
require_once "includes/connect.php";

// Signup User
if (isset($_POST['action']) && $_POST['action'] == "login") {
    /*
     * Marrja e te dhenave nga front-end
     * */
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    /*
     * Validimi i te dhenave
     * */
    // Validate email
    if (empty($email)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Email is required",
                "tag" => "emailHelp"
            ));
        exit;
    }

    // Validate password nese eshte bosh. Todo Validim Regex
    if (empty($password)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Password is required",
                "tag" => "passwordHelp"
            ));
        exit;
    }

    /**
     * Validimi i E-Mailit. Shohim nese E-Maili egziston ne platforme
     */
    $query_check = "SELECT id, password 
                    FROM users 
                    WHERE email = '" . $email . "'";

    $result_check = mysqli_query($conn, $query_check);


    if (!$result_check) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Internal Server Error " . __LINE__,
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    if (mysqli_num_rows($result_check) == 0) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "User with email: " . $email . " does not exists on system.",
                "tag" => "emailHelp",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    $data_check = array();
    $row_data = mysqli_fetch_assoc($result_check);
    $data_check["id"] = $row_data["id"];
    $data_check["password_hashed"] = $row_data["password"];

    /**
     * Verifkimi i passwordit
     */
    if (!password_verify($password, $data_check["password_hashed"])){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Password Incorrect",
                "tag" => "passwordHelp",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    session_start();
    $_SESSION["id"] = $data_check["id"];
    $_SESSION["email"] = $email;

    http_response_code(200);
    echo json_encode(
        array(
            "message" => "User Authenticated successfully",
        ));
    exit;
}
