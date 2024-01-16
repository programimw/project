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

$query_data = "SELECT  porosi.id,
                       emri,
                       username,
                       email,
                       nr_klient,
                       data,
                       adresa
                FROM porosi
                left join korrieri on porosi.korrier_id = korrieri.id
                WHERE porosi.korrier_id = '".$_SESSION['id']."';";

$result_data = mysqli_query($db_conn, $query_data);
if(!$result_data){
    echo "Error ne db";
    exit;
}

$orders = array();
while ($row = mysqli_fetch_assoc($result_data)){

    $orders[$row['id']]['id'] = $row['id'];
    $orders[$row['id']]['emri'] = $row['emri'];
    $orders[$row['id']]['username'] = $row['username'];
    $orders[$row['id']]['email'] = $row['email'];
    $orders[$row['id']]['nr_klient'] = $row['nr_klient'];
    $orders[$row['id']]['data'] = $row['data'];
    $orders[$row['id']]['adresa'] = $row['adresa'];
}

//echo "<pre>";
//print_r($orders);
//echo "</pre>";
?>

<html>
<head></head>
<body>

    <table border="1px solid black">
        <thead>
        <tr>
            <th>Edit</th>
            <th>Emri</th>
            <th>Username</th>
            <th>E-Mail</th>
            <th>Nr Klient</th>
            <th>Data</th>
            <th>Address</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $id => $data) { ?>
                <tr>
                    <td><a href="edit.php?id=<?=$id?>">Edit</a></td>
                    <td><?=$data['emri']?></td>
                    <td><?=$data['username']?></td>
                    <td><?=$data['email']?></td>
                    <td><?=$data['nr_klient']?></td>
                    <td><?=$data['data']?></td>
                    <td><?=$data['adresa']?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


</body>
</html>
