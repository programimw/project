
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
    return (date('N', strtotime($date)) >= 6);
}
function printArray($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function get_off_days($conn)
{
    $query_off_days = "SELECT date 
                       FROM off_days";

    $result_off_days = mysqli_query($conn, $query_off_days);

    if (!$result_off_days){
        echo "Error";
        exit;
    }
    $special_days = array();
    while ($row = mysqli_fetch_assoc($result_off_days)){
        $special_days[$row['date']] = $row['date'];
    }

    return $special_days;
}

/**
 * Calculate the data for each user on each day
 */
$query_data = " SELECT users.id,
                       full_name,
                       total_paga,
                       date,
                       hours 
                FROM working_days 
                left join users on working_days.user_id = users.id order by date DESC";

$result_data = mysqli_query($conn, $query_data);

if (!$result_data){
    echo "Error";
    exit;
}

// if there are data to calculate get the special days.
if (mysqli_num_rows($result_data)){
    $special_days = get_off_days($conn);
}

$users_data = array();
$weekends = array();
while ($row = mysqli_fetch_assoc($result_data)){
    $users_data[$row['id']]['id'] = $row['id'];
    $users_data[$row['id']]['full_name'] = $row['full_name'];
    $users_data[$row['id']]['total_paga'] = $row['total_paga'];
    $users_data[$row['id']]['hourly_payment'] = $row['total_paga']/22/8;
    $hourly_payment = $row['total_paga']/22/8;

    $hours_in = $row['hours'];
    $hours_out = 0;

    if ($row['hours'] > 8){
        $hours_in = 8;
        $hours_out = $row['hours'] - 8;
    }

    $users_data[$row['id']]['hours_in'] += $hours_in;
    $users_data[$row['id']]['hours_out'] += $hours_out;
    $users_data[$row['id']]['hours'] += $row['hours'];

    $users_data[$row['id']]['date'][$row['date']]['hours_in'] += $hours_in;
    $users_data[$row['id']]['date'][$row['date']]['hours_out'] += $hours_out;
    $users_data[$row['id']]['date'][$row['date']]['hours'] += $row['hours'];

    // Paga cal
    $k_in = 0;
    $k_out = 0;
    if (isset($special_days[$row['date']])){
        $k_in = 1.5;
        $k_out = 2;
    } else if (isWeekend($row['date'])){
//    } else if (isset($weekends[$row['date']]) | isWeekend($row['date'])){
        $weekends[$row['date']] = $row['date'];
        $k_in = 1.25;
        $k_out = 1.5;
    } else {
        $k_in = 1;
        $k_out = 1.25;
    }

    $paga_in = $hours_in * $hourly_payment * $k_in;
    $paga_out = $hours_out * $hourly_payment * $k_out;
    $users_data[$row['id']]['paga_in'] += round($paga_in,2);
    $users_data[$row['id']]['paga_out'] += round($paga_out,2);
    $users_data[$row['id']]['tot_paga'] += round(($paga_in + $paga_out),2);

    $users_data[$row['id']]['date'][$row['date']]['paga_in'] += round($paga_in,2);
    $users_data[$row['id']]['date'][$row['date']]['paga_out'] += round($paga_out,2);
    $users_data[$row['id']]['date'][$row['date']]['tot_paga'] += round(($paga_in + $paga_out),2);
}

?>
<style>
    .toogle{
        display: none;
    }
</style>

<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">NR</th>
        <th scope="col">Full Name</th>
        <th scope="col">Hours In</th>
        <th scope="col">Hours Out</th>
        <th scope="col">Total Hours</th>
        <th scope="col">Paga In</th>
        <th scope="col">Paga Out</th>
        <th scope="col">Total Payment</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $k = 1;
        foreach ($users_data as $id => $data) {
    ?>
        <tr>
            <th scope="row"><i class="fa fa-plus" id = "icon_<?=$id?>" onclick="toogle('<?=$id?>')"></i></th>
            <td style="font-weight: bold"><?=$data['full_name']?></td>
            <td><?=$data['hours_in']?></td>
            <td><?=$data['hours_out']?></td>
            <td><?=$data['hours']?></td>
            <td><?=$data['paga_in']?></td>
            <td><?=$data['paga_out']?></td>
            <td><?=$data['tot_paga']?></td>
        </tr>

            <?php
                foreach ($data['date'] as $date => $details){
            ?>
                <tr class="details_<?=$id?> toogle">
                    <td style="font-weight: bold" colspan="2" class="text-center"><?=$date?></td>
                    <td><?=$details['hours_in']?></td>
                    <td><?=$details['hours_out']?></td>
                    <td><?=$details['hours']?></td>
                    <td><?=$details['paga_in']?></td>
                    <td><?=$details['paga_out']?></td>
                    <td><?=$details['tot_paga']?></td>
                </tr>

            <?php }?>
    <?php }?>
    </tbody>
</table>


<script>
    function toogle(id){
        var class_name = $("#icon_"+id).attr("class");
        if (class_name == 'fa fa-plus'){
            $("#icon_"+id).removeClass()
            $("#icon_"+id).addClass("fa fa-minus");

            $(".details_"+id).removeClass("toogle")


        } else {
            $("#icon_"+id).removeClass()
            $("#icon_"+id).addClass("fa fa-plus");

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