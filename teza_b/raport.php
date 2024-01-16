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

$query_data = "SELECT korrieri.id,
                      emri,
                      email,
                      derguar
                FROM porosi
                left join korrieri on porosi.korrier_id = korrieri.id
                left join statistika on porosi.id = statistika.porosi_id; ";

$result_data = mysqli_query($db_conn, $query_data);
if (!$result_data){
    echo "Error ne db";
    exit;
}

$data = array();
while ($row = mysqli_fetch_assoc($result_data)) {
    $data[$row['id']]['id'] = $row['id'];
    $data[$row['id']]['emri'] = $row['emri'];
    $data[$row['id']]['email'] = $row['email'];
    $data[$row['id']]['nr_porosi']++;
    if ($row['derguar'] == 'yes') {
        $data[$row['id']]['delivered']++;
    }
}

?>

<html>
<head></head>
<body>

<table border="1px solid black">
    <thead>
    <tr>
        <th>ID</th>
        <th>Emri</th>
        <th>E-Mail</th>
        <th>Nr Porosi</th>
        <th>Delivered</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $id => $details) { ?>
        <tr>
            <td><?=$id?></td>
            <td><?=$details['emri']?></td>
            <td><?=$details['email']?></td>
            <td><?=$details['nr_porosi']?></td>
            <td><?=$details['delivered']?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>


</body>
</html>

