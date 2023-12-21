
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

</style>
<?php
error_reporting(0);
// Header
require_once "includes/header.php";

$host = "localhost";
$username = "root";
$password = "";
$database = "test_paga";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo "Error ne lidhjen e databazes";
    exit;
}

function isWeekend($date) {
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
}

function printArray($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function get_off_days($connection)
{
    $query_off_days = "SELECT date FROM off_days";

    $result_off_days = mysqli_query($connection, $query_off_days);
    if (!$result_off_days){
        echo "Internal server error on function";
        exit;
    }

    $special_days = array();
    while ($row = mysqli_fetch_assoc($result_off_days)){
        $special_days[$row['date']] = $row['date'];
    }

    return $special_days;
}


$query_users_data = "SELECT 
                            users.id,
                            total_paga,
                            full_name,
                            date,
                            hours 
                     FROM working_days 
                         left join users on working_days.user_id = users.id";

$result_users_data = mysqli_query($conn,$query_users_data);

if (!$result_users_data){
    echo "Internal server error";
    exit;
}

// if there are data We need off days during our calculation process
if (mysqli_num_rows($result_users_data)){
    $off_days = get_off_days($conn);
}

$data = array();

while ($row = mysqli_fetch_assoc($result_users_data)){

    $data[$row['id']]['id'] = $row['id'];
    $data[$row['id']]['full_name'] = $row['full_name'];
    $hourly_payment = $row['total_paga']/22/8;
    $data[$row['id']]['hourly_payment'] = $row['total_paga']/22/8;

    $hours_in = $row['hours'];
    $hours_out = 0;

    if ($row['hours'] >8){
        $hours_in = 8;
        $hours_out = $row['hours'] - 8;
    }

    // cal totale
    $data[$row['id']]['hours_in'] += $hours_in;
    $data[$row['id']]['hours_out'] += $hours_out;
    $data[$row['id']]['total_hours'] += $row['hours'];

    // cal date
    $data[$row['id']]['date'][$row['date']]['hours_in'] += $hours_in;
    $data[$row['id']]['date'][$row['date']]['hours_out'] += $hours_out;
    $data[$row['id']]['date'][$row['date']]['total_hours'] += $row['hours'];

    // Special Day
    if (isset($off_days[$row['date']])){
        $k_in = 1.5;
        $k_out = 2;
    } else if (isWeekend($row['date'])){
        $k_in = 1.25;
        $k_out = 1.5;
    } else {
        $k_in = 1;
        $k_out = 1.25;
    }

    $paga_in = $hourly_payment * $hours_in * $k_in;
    $paga_out = $hourly_payment * $hours_out * $k_out;
    // cal totale
    $data[$row['id']]['paga_in'] += round($paga_in,2);
    $data[$row['id']]['paga_out'] += round($paga_out,2);
    $data[$row['id']]['tot_paga'] += round(($paga_in + $paga_out),2);

    // cal date
    $data[$row['id']]['date'][$row['date']]['paga_in'] += round($paga_in,2);
    $data[$row['id']]['date'][$row['date']]['paga_out'] += round($paga_out,2);
    $data[$row['id']]['date'][$row['date']]['tot_paga'] += round(($paga_in + $paga_out),2);
}

//printArray($data);
//exit;
?>

<style>
    .toogle {
        display: none;
    }
</style>
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Nr</th>
        <th scope="col">Full Name</th>
        <th scope="col">Hours In</th>
        <th scope="col">Hours Out</th>
        <th scope="col">Totale Hours</th>
        <th scope="col">Paga In</th>
        <th scope="col">Paga Out</th>
        <th scope="col">Total Paga</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $id => $user_data) { ?>
        <tr>
            <td><i class="fa fa-plus" id = "toogle_<?=$id?>" onclick="toogle('<?=$id?>')"></i></td>
            <td><?= $user_data['full_name']?></td>
            <td><?= $user_data['hours_in']?></td>
            <td><?= $user_data['hours_out']?></td>
            <td><?= $user_data['total_hours']?></td>
            <td><?= $user_data['paga_in']?> All</td>
            <td><?= $user_data['paga_out']?> All</td>
            <td><?= $user_data['tot_paga']?> All</td>
        </tr>

        <?php foreach ($user_data['date'] as $data => $user_details) { ?>
            <tr class="details_<?=$id?> toogle">
                <td><i class="fa fa-date"></i></td>
                <td><?= $data?></td>
                <td><?= $user_details['hours_in']?></td>
                <td><?= $user_details['hours_out']?></td>
                <td><?= $user_details['total_hours']?></td>
                <td><?= $user_details['paga_in']?> All</td>
                <td><?= $user_details['paga_out']?> All</td>
                <td><?= $user_details['tot_paga']?> All</td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>

<script>
    function toogle(id){
        var class_name = $("#toogle_"+id).attr("class");
        if (class_name == 'fa fa-plus'){
            $("#toogle_"+id).removeClass()
            $("#toogle_"+id).addClass("fa fa-minus");

            $(".details_"+id).removeClass("toogle")


        } else {
            $("#toogle_"+id).removeClass()
            $("#toogle_"+id).addClass("fa fa-plus");

            $(".details_"+id).addClass("toogle")

        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>
</html>