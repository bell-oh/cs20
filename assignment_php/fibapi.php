<?php
    $num = $_GET["num"];
    $sequence = array(0, 1);
    for ($x = 0; $x < $num - 2; $x++) {
        $prev_num = end($sequence);
        $prev_prev_num = prev($sequence);
        $next_num = $prev_prev_num + $prev_num;
        array_push($sequence, $next_num);
    }
    $arr = array("data"=>$sequence);
    header('Content-Type: application/json');
    echo json_encode($arr);
?>