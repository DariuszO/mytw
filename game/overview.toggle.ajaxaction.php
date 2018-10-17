<?php
$widget = $_POST['widget'];
$hide = $_POST['hide'];
newlog(json_encode($_POST));
User::update($user['id'],["overview_{$widget}"],[$hide]);
?>