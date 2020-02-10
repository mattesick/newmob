<?php 
// echo "<pre>";print_r($_POST['route_data']);exit;
$route_data = $_POST['route_data'];
$total_distance = 0;
$total_time = 0;
foreach ($route_data as $key => $value) {
    $total_distance += $value['distance']['value'];
    $total_time += $value['duration']['value'];
}
// echo $total_time;

$total_distance = number_format(($total_distance/1000),1);

$total_time_lbl = ""; 

$total_hours = floor($total_time / 3600);
$total_min = round($total_time / 60 % 60);
$secs = floor($total_time % 60);
/*if ($secs != 0) {
    $total_min++;
}*/

if ($total_hours != "") {
    $total_time_lbl .= $total_hours." Hours";
}

if ($total_min != "") {
    $total_time_lbl .= " ".$total_min." Min";
}

 ?>
<h1 class="section-trip-summary-title"> 
        <span style="vertical-align: middle;"> 
            <img width="70px" src="https://cdn4.iconfinder.com/data/icons/car-silhouettes/1000/sedan-512.png">
        </span>
        <span style="vertical-align: middle;"> 
            <span jstcache="1283"><?php echo $total_time_lbl; ?></span> 
            <span class="section-trip-summary-subtitle">(<span jstcache="1284"><?php echo $total_distance." km" ?></span>)</span> 
        </span> 
    </h1>
    <hr>

    <?php $j=1; foreach ($route_data as $key => $value) { ?>        
        <div class="row">
            <div style="float: left;height: 60px;font-size: 23px;padding: 15px;">
                <span class="fa fa-arrow-down"></span>
            </div>
            <div>
                <b>Route Segment: <?php echo $j; ?></b><br>
                <?php echo $value['start_address']." to ".$value['end_address']; ?>
                <br><?php echo $value['distance']['text'] ?>,&nbsp;<?php echo $value['duration']['text'] ?><br><br>
            </div>
        </div>
    <?php $j++; } ?>

    