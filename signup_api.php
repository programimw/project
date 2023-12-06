<?php
error_reporting(0);
// if (PHP_SAPI != "cli" && PHP_SAPI != "cgi-fcgi") {
//     die("Accesso negato");
// }
require_once "includes/connect.php";
// Signup User
if (isset($_POST['action']) && $_POST['action'] == "signup") {
    /*
     * Marrja e te dhenave nga front-end
     * */
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $alphanumericRegex = '/^[a-zA-Z0-9]+$/';
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $password_hashed = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_BCRYPT));

    /*
     * Validimi i te dhenave
     * */
    // Validate alphanumeric
    if (!preg_match($alphanumericRegex, $name)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Name must be alphanumeric and minimum 1 letter",
                "tag" => "nameHelp"
            ));
        exit;
    }
    // Validate alphanumeric
    if (!preg_match($alphanumericRegex, $surname)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Surname must be alphanumeric and minimum 1 letter",
                "tag" => "surnameHelp"
            ));
        exit;
    }

    if (empty($email)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Email is required",
                "tag" => "emailHelp"
            ));
        exit;
    }

    if (empty($password)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Password is required",
                "tag" => "passwordHelp"
            ));
        exit;
    }

    if (empty($confirmPassword)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Confirm Password is required",
                "tag" => "confirmpasswordHelp"
            ));
        exit;
    }

    if ($password != $confirmPassword){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Password and Confirm Password does not match",
                "tag" => "passwordHelp"
            ));
        exit;
    }

    /**
     * Validimi i E-Mailit. Shohim nese E-Maili egziston
     */
    $query_check = "SELECT id 
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

    if (mysqli_num_rows($result_check)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "User with email: " . $email . " aready exists on system.",
                "tag" => "emailHelp",
                "error" => mysqli_error($conn)
            ));
        exit;
    }


    /**
     * Shtimi i te dhenave ne databaze
     */
    $query_insert = "INSERT INTO users
                     set name    = '" . $name . "',
                     surname    = '" . $surname . "',
                     password    = '" . $password_hashed . "',
                     created_at    = '" . date("Y-m-d") . "',
                     email    = '" . $email . "'";

    $result_insert = mysqli_query($conn, $query_insert);

    if (!$result_insert) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Internal Server Error " . __LINE__,
                "error" => mysqli_error($conn)
            ));
        exit;
    } else {
        http_response_code(201);
        echo json_encode(
            array(
                "message" => "Data saved successfully",
            ));
        exit;
    }
}
