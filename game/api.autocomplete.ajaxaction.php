<?php
$type = $_POST['type'];
$text = parse($_POST['text']);
NewLog(json_encode($_POST),"POST","/logs/autocomplete.log");
$json = Array();
if ($type==="player") {
	$result = DB::Query("SELECT * FROM `{$DB}`.`users` WHERE `name` REGEXP '{$text}'");
	while($row = DB::fetch($result)) {
		$com[] = ["label"=>entparse($row['name']),"value"=>entparse($row['name']),"meta"=>""];
	}
}
$json[] = [
	"targeted" => [],
	"common" => $com
];
NewLog(json_encode($json),"RETURN","/logs/autocomplete.log");
MyTW_json_exit($json);
?>