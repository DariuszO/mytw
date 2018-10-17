<?php
$left = $_POST['leftcolumn'];
$right = $_POST['rightcolumn'];

$configs = ["overview_leftcolumn","overview_rightcolumn"];
$values = [json_encode($left) , json_encode($right)];
User::update($user['id'],$configs,$values);
?>