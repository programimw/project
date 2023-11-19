<?php
//error_reporting(0);
//session_start();
//print_r($_POST);
require_once "includes/connect.php";

// Signup User
if (isset($_POST['action']) && $_POST['action'] == "signup"){
    /*
     * Marrja e te dhenave nga front-end
     * */
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $alphanumericRegex = '/^[a-zA-Z0-9]+$/';
    /*
     * Validimi i te dhenave
     * */
    // Validate alphanumeric
    if (!preg_match($alphanumericRegex, $name)) {
      echo json_encode(
          array(
              "status"=>201,
              "message"=>"Name must be alphanumeric and minimum 1 letter",
              "tag" =>"nameHelp"
          ));
      exit;
    }

    /**
     * Shtimi i te dhenave ne databaze
     */
    $query_insert = "INSERT INTO users
                     set name    = '".$name."',
                     surname    = '".$surname."',
                     email    = '".$email."'";

    $result_insert = mysqli_query($conn, $query_insert);

    if (!$result_insert){
        echo json_encode(
            array(
                "status"=>201,
                "message"=>"Internal Server Error ".__LINE__,
                "error" => mysqli_error($conn)
            ));
        exit;
    } else{
        echo json_encode(
            array(
                "status"=>200,
                "message"=>"Data saved successfully",
            ));
        exit;
    }
}
