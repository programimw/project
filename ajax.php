<?php
session_start();
require_once "includes/connect.php";


if (isset($_POST['action']) && $_POST['action'] == "updateProfile") {
    /*
     * Marrja e te dhenave nga front-end
     * */
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
//    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $alphanumericRegex = '/^[a-zA-Z0-9]+$/';
//    $password = mysqli_real_escape_string($conn,$_POST['password']);
//    $password_hashed = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_BCRYPT));
    $types = array('png', 'jpg','PNG', 'JPG','jpeg','JPEG');
    $photo_name = $_FILES['photo']['name'];
    $photo_name_array = explode(".", $photo_name);
    $type = end($photo_name_array);

    if (!in_array($type, $types)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Photo type not allowed",
                "tag" => "photoHelp"
            ));
        exit;
    }

    $photo_path = 'img/profile_photo/'.$_SESSION['id'].".".$type;
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photo_path)) {
//        http_response_code(200);
//        echo json_encode(
//            array(
//                "message" => "Photo Uploaded",
//            ));
//        exit;
    } else {
//        http_response_code(203);
//        echo json_encode(
//            array(
//                "message" => "Internal server error on photo upload",
//                "tag" => "photoHelp"
//            ));
//        exit;
    }
//    exit;
//    $photo_name_array
//    echo '<pre>';
//    print_r($type);
//    print_r($_FILES);
//    print_r($_POST);
//    exit;
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

    /**
     * Validimi i E-Mailit. Shohim nese E-Maili egziston
     */
//    $query_check = "SELECT id
//                    FROM users
//                    WHERE email = '" . $email . "'";
//
//    $result_check = mysqli_query($conn, $query_check);
//
//    if (!$result_check) {
//        http_response_code(203);
//        echo json_encode(
//            array(
//                "message" => "Internal Server Error " . __LINE__,
//                "error" => mysqli_error($conn)
//            ));
//        exit;
//    }
//
//    if (mysqli_num_rows($result_check)) {
//        http_response_code(203);
//        echo json_encode(
//            array(
//                "message" => "User with email: " . $email . " aready exists on system.",
//                "tag" => "emailHelp",
//                "error" => mysqli_error($conn)
//            ));
//        exit;
//    }


    /**
     * Shtimi i te dhenave ne databaze
     */
    $query_update = "UPDATE users
                     set name    = '" . $name . "',
                     surname    = '" . $surname . "',
                     photo    = '" . mysqli_real_escape_string($conn,$photo_path) . "',
                     updated_at    = '" . date("Y-m-d") . "',
                     email    = '" . $email . "'
                     WHERE id = '".$_SESSION['id']."'
                     ";
//    print_r($query_update);
//    exit;
    $result_insert = mysqli_query($conn, $query_update);

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
