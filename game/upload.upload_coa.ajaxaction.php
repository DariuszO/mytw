<?php
NewLog(json_encode($_POST),"INFORMATION","/logs/coa.log");
$Utype = $_GET['type'];
$types = [
	"ally",
	"player"
];
if (in_array($UType,$types)) {
	MyTW_json_exit(["error"=>"Upload siê nie uda³."]);
}
$name = $_SERVER["HTTP_X_FILE_NAME"];
$size = $_SERVER["HTTP_X_FILE_SIZE"];
$type = $_SERVER["HTTP_X_FILE_TYPE"];
$allow_types = [
	"image/png",
	"image/jpeg",
	"image/gif"
];
if (!in_array($type,$allow_types)) {
	MyTW_json_exit(["error"=>"Upload siê nie uda³."]);
}

//$nextid = DB::Fetch(DB::Query("SELECT COUNT(`id`) FROM `avatars`"))[0];
//$nextid++;
//$upload = @copy($name , PATH . "/uploads/avatars/{$nextid}_large");
MyTW_json_exit(["error"=>"Upload siê nie uda³."]);
?>