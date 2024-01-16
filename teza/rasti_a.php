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



$query_calls = "SELECT 
                    telefonata.id,
                    emri,
                    username,
                    email,
                    nr_tel,
                    data,
                    gjatesia
                FROM telefonata
                left join perdorues on perdorues.id = telefonata.perdorues_id
                WHERE perdorues_id = '".mysqli_real_escape_string( $db_conn, $_SESSION['id'])."';";

$result_calls = mysqli_query($db_conn, $query_calls);

if (!$result_calls){
    echo "Error: ".mysqli_error($db_conn);
    exit;
}

$calls = array();
while ($row = mysqli_fetch_assoc($result_calls)){
    $calls[$row['id']]['id'] = $row['id'];
    $calls[$row['id']]['emri'] = $row['emri'];
    $calls[$row['id']]['username'] = $row['username'];
    $calls[$row['id']]['email'] = $row['email'];
    $calls[$row['id']]['nr_tel'] = $row['nr_tel'];
    $calls[$row['id']]['data'] = $row['data'];
    $calls[$row['id']]['gjatesia'] = $row['gjatesia'];
}
//echo "<pre>";
//print_r($calls);
//echo "</pre>";

?>

<html>
    <head></head>
    <body>
        <table border="1px solid black">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Emri</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Numri Tel</th>
                    <th>Data Tel</th>
                    <th>Gjatësia Tel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($calls as $id => $data) { ?>
                    <tr>
                        <td><a href="edit.php?id=<?=$id?>">Edit</a></td>
                        <td><nobr><?= $data['emri']?></nobr></td>
                        <td><nobr><?= $data['username']?></nobr></td>
                        <td><nobr><?= $data['email']?></nobr></td>
                        <td><nobr><?= $data['nr_tel']?></nobr></td>
                        <td><nobr><?= $data['data']?></nobr></td>
                        <td><nobr><?= $data['gjatesia']?></nobr></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


    </body>
</html>
