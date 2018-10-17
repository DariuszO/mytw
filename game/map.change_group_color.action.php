<?php
$r = (int)$_POST['color_picker_r'];
$g = (int)$_POST['color_picker_g'];
$b = (int)$_POST['color_picker_b'];
$gid = (int)$_POST['group_id'];
$icon = $_POST['icon_url'];
DB::Query("UPDATE `{$DB}`.`map_groups` SET `r` = '{$r}' , `b` = '{$b}' , `g` = '{$g}' WHERE `id` = '{$gid}' AND `uid` = '{$user['id']}'");
header("LOCATION: /game.php?village={$village['id']}&screen=map&con_update=1&update_colors");
?>