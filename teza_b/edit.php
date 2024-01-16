<?php
error_reporting(0);
session_start();
$_SESSION['email'] = 'test@test.com';
$_SESSION['id'] = '2';

if (!isset($_SESSION['email']) || !isset($_SESSION['id'])){
    header("Location: login.php");
} else if (empty($_SESSION['email']) || empty($_SESSION['id'])){
    header("Location: login.php");
}
$host = "localhost";
$username = "root";
$password = "";
$db = "delivery";

$db_conn = mysqli_connect($host, $username, $password, $db);
if (!$db_conn){
    echo "Error ne lidhjen e db";
    exit;
}

$id = mysqli_real_escape_string($db_conn, $_GET['id']);

$query_order_data = "SELECT 
                            nr_klient,
                            data,
                            adresa   
                     FROM porosi where id = '".$id."'; ";

$result_order_data = mysqli_query($db_conn, $query_order_data);

if (!$result_order_data){
    echo "Error ne db";
    exit;
}
if (mysqli_num_rows($result_order_data) == 0){
    echo "No data found";
    exit;
}
$order_data = mysqli_fetch_assoc($result_order_data);

//echo "<pre>";
//print_r($order_data);
//echo "</pre>";

if (isset($_POST['ruaj'])){
    $name = mysqli_real_escape_string($db_conn, $_POST['name']);
    $adresa = mysqli_real_escape_string($db_conn, $_POST['adresa']);
    $derguar = mysqli_real_escape_string($db_conn, $_POST['derguar']);


    $query_check = "SELECT id from 
                    statistika 
                    where porosi_id = '".$id."' ";

    $result_check = mysqli_query($db_conn, $query_check);
    if (!$result_check){
        echo "Error ne db";
        exit;
    }

    // nese statistika egziston
    if (mysqli_num_rows($result_check) > 0){
        $query_update = "UPDATE statistika set 
                         derguar = '".$derguar."',
                         emri_klient = '".$name."',
                         adresa_klient = '".$adresa."'
                         WHERE porosi_id = '".$id."';
                         ";

        $result_update = mysqli_query($db_conn, $query_update);
        if (!$result_update){
            echo "Error ne db";
            exit;
        }
    } else {
        $query_insert = "insert into statistika set 
                         derguar = '".$derguar."',
                         emri_klient = '".$name."',
                         adresa_klient = '".$adresa."',
                         porosi_id = '".$id."';
                         ";

        $result_insert = mysqli_query($db_conn, $query_insert);
        if (!$result_insert){
            echo "Error ne db";
            exit;
        }
    }

    header("Location:rasti_a.php");
}

?>

<html>
<head>
    
</head>
<body>
<form action="#" style="border: 1px solid black; width: 50%; padding: 20px">
    <label for="nr">Numri Klientit</label>
    <input type="text" value="<?=$order_data['nr_klient']?>">
    <br><br>
    <label for="data">Data</label>
    <input type="text" value="<?=$order_data['data']?>">
    <br><br>
    <label for="adresa">Adresa</label>
    <input type="text" value="<?=$order_data['adresa']?>">
    <br><br>
</form>

<form method="post" style="border: 1px solid black; width: 50%;  padding: 20px">
    <label for="name">Emri Klientit</label>
    <input type="text" name="name" id="name" placeholder="Vendosni emrin e klientit">
    <br><br>
    <label for="adresa">Adresa</label>
    <input type="text" name="adresa" id="adresa" placeholder="Vendosni adresen e klientit">
    <br><br>
    <label for="derguar">Derguar</label>
    <select name="derguar" id="derguar">
        <option value="yes">po</option>
        <option value="no">jo</option>
    </select>
    <br><br>
    <input type="submit" name="ruaj" value="Ruaj">
</form>

</body>
</html>
