<?php
session_start();
if (!isset($_SESSION['id'])){
    http_response_code(401);
    echo json_encode(
        array(
            "message" => "Unauthorized",
        ));
    exit;
}


require_once "includes/connect.php";
require_once "functions.php";


if (isset($_POST['action']) && $_POST['action'] == "updateProfile") {
    /*
     * Marrja e te dhenave nga front-end
     * */
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alphanumericRegex = '/^[a-zA-Z0-9]+$/';
    /**
     * Validimi i te dhenave
     */
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

    if (empty($email)) {
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
    $query_check = "SELECT id,
                           photo
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

    if (!mysqli_num_rows($result_check)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "User does not exists",
                "tag" => "emailHelp",
                "error" => mysqli_error($conn)
            ));
        exit;
    }
    $user_data = mysqli_fetch_assoc($result_check);
    // Verifikojme nese useri qe po perditeson te dhenat
    // eshte useri te cilit i perkasin te dhenat
    if ($_SESSION['id'] != $user_data['id']) {
        http_response_code(401);
        echo json_encode(
            array(
                "message" => "Unauthorized request"
            ));
        exit;
    }


    // Ngarkimi i fotos pasi jane validuar te gjitha te dhenat
    if (isset($_FILES['photo'])){
        $photo_name = $_FILES['photo']['name'];
        $photo_name_array = explode(".", $photo_name);
        $type = end($photo_name_array);
        $new_path = 'img/profile_photo/' . $_SESSION['id'] . "." . $type;

        if ( !uploadFile($photo_name, $_FILES["photo"]["tmp_name"], $new_path)) {
            http_response_code(203);
            echo json_encode(
                array(
                    "message" => "Photo type not allowed or internal error.",
                    "tag" => "photoHelp"
                ));
            exit;
        }
    } else {
        $new_path = $user_data['photo'];
    }


    /**
     * perditesimi i te dhenave ne databaze
     */
    $query_update = "UPDATE users
                     set name    = '" . $name . "',
                     surname    = '" . $surname . "',
                     photo    = '" . mysqli_real_escape_string($conn, $new_path) . "',
                     updated_at    = '" . date("Y-m-d H:i:s") . "',
                     email    = '" . $email . "'
                     WHERE id = '" . $_SESSION['id'] . "'
                     ";
//
    $result_update = mysqli_query($conn, $query_update);

    if (!$result_update) {
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
