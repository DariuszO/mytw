<?php
$map_size = $_GET['map_size'];
$minimap_size = $_GET['minimap_size'];
$sizes = [
	"map" => explode("x",$map_size),
	"mini" => explode("x",$minimap_size)
];
if (count($sizes["map"]) != 2 || count($sizes["mini"]) != 2) {
	MyTW_json_exit(["error"=>"Podane rozmiary są nieprawidłowe!"]);
} else {
	$configs = ["map_size_x","map_size_y","map_mini_size_x","map_mini_size_y"];
	$values = [$sizes["map"][0],$sizes["map"][1],$sizes["mini"][0],$sizes["mini"][1]];
	User::update($user['id'],$configs,$values);
}
?>