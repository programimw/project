<?php
error_reporting(0);
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


$query_data = "select
                    perdorues.id,
                    nr_tel,
                    sherbyer
                FROM telefonata
                left join perdorues on perdorues.id = telefonata.perdorues_id
                left join statistika on telefonata.id = statistika.call_id;";

$result_data = mysqli_query($db_conn, $query_data);

if (!$result_data){
    echo mysqli_error($db_conn);
    exit();
}

$data = array();
while ($row = mysqli_fetch_assoc($result_data)){
    $data[$row['id']]['id'] = $row['id'];
    $data[$row['id']]['number_of_tel'] ++;
    if (isset($row['sherbyer'])){
        if ($row['sherbyer'] == 'yes'){
            $data[$row['id']]['sherbyer'] ++;
        } else {
            $data[$row['id']]['sherbyer_no'] ++;
        }
    } else {
        $data[$row['id']]['no_stats'] ++;

    }
}

echo "<pre>";
print_r($data);
echo "</pre>";