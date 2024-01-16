<?php
session_start();
$_SESSION['id'] = '1';
$_SESSION['email'] = 'perdorues_1@gmail.com';


if (!isset($_SESSION['email']) && !isset($_SESSION['id'])) {
    header("Location: login.php");
} else if (empty($_SESSION['email']) || empty($_SESSION['id'])){
    header("Location: login.php");
}

$host = 'localhost';
$username = 'root';
$password = '';
$db = 'shërbim_klienti';

$db_conn = mysqli_connect($host, $username, $password, $db);
if (!$db_conn){
    echo mysqli_connect_error();
    exit();
}
$call_id = $_GET['id'];
$query_call_data = "SELECT 
                    id,
                    nr_tel,
                    data,
                    gjatesia
                FROM telefonata WHERE id = '".$call_id."' ";

$result_call_data = mysqli_query($db_conn,$query_call_data );
$call_data = mysqli_fetch_assoc($result_call_data);


if (isset($_POST['ruaj'])){

    $emri = mysqli_real_escape_string($db_conn, $_POST['emri']);
    $adresa = mysqli_real_escape_string($db_conn, $_POST['adresa']);
    $sherbyer = mysqli_real_escape_string($db_conn, $_POST['sherbyer']);

    $query_check = "SELECT id from statistika where call_id = '".$call_id."'";
    $result_check = mysqli_query($db_conn, $query_check);
    if (!$result_check){
        echo "Error";
        exit;
    }

    if (mysqli_num_rows($result_check)){
        $query_update = "UPDATE statistika set 
                           emri_klient = '".$emri."',
                           adresa_klient = '".$adresa."',
                           sherbyer = '".$sherbyer."'
                     where call_id = '".$call_id."';
                   ";
        $result_update = mysqli_query($db_conn, $query_update);
        if (!$result_update){
            echo "Error";
            exit;
        }
    } else {
        $query_insert = "INSERT into statistika set 
                           emri_klient = '".$emri."',
                           adresa_klient = '".$adresa."',
                           sherbyer = '".$sherbyer."',
                           call_id = '".$call_id."';";
        $result_insert = mysqli_query($db_conn, $query_insert);
        if (!$result_insert){
            echo "Error";
            exit;
        }
    }
    header("Location: rasti_a.php");
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
}
?>

<html>
<head></head>
<body>
<form action="#">
    <label for="nr_tel">Nr Tel</label>
    <input type="text" value="<?=$call_data['nr_tel']?>">
    <br><br>
    <label for="data">Data</label>
    <input type="text" value="<?=$call_data['data']?>">
    <br><br>
    <label for="gjatesia">Gjatesia</label>
    <input type="text" value="<?=$call_data['gjatesia']?>">
    <br><br>
</form>


<form action="" method="post" style="border: 1px solid black; width: 50%; padding: 10px">
    <label for="emri_klient">Emri Klientit</label>
    <input type="text" name="emri" placeholder="Vendosni emrin e klientit">
    <br><br>
    <label for="adresa">Adresa Klientit</label>
    <input type="text" name="adresa" placeholder="Vendosni adresen e klientit">
    <br><br>
    <label for="sherbyer">Sherbyer</label>
    <select name="sherbyer" id="sherbyer">
        <option value="yes">po</option>
        <option value="no">jo</option>
    </select>
    <br><br>
    <input type="submit" value="ruaj" name="ruaj">
</form>


</body>
</html>

