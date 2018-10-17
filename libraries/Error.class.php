<?php
if (!defined("MyTW")) {
	exit;
}


class Error {
	var $titleE = "Wyst¹pi³ b³¹d!";
	var $errorE = "Wyst¹pi³ b³¹d serwera!";
	var $log_file = "/logs/errors_cl.log";
	
	public function title($title) {
		$this->titleE = $title;
		return $title;
	}
	
	public function err($err) {
		$this->errorE = $err;
		return $err;
	}
	
	public function log() {
		$file = $this->log_file;
		return NewLog($this->titleE . ":" . $this->errorE,"ERROR",$file);
	}
	
	public function view() {
		echo "<html><head><title>{$this->titleE}</title></head><body>";
		echo "<h2 style=\"text-align:center;\">{$this->titleE}</h2>";
		echo "<pre style=\"text-align: center;\">{$this->errorE}</pre>";
		echo "</body></html>";
		return true;
	}
	
	public function clear() {
		$this->titleE = "Wyst¹pi³ b³¹d!";
		$this->errorE = "Wyst¹pi³ b³¹d serwera!";
		return true;
	}
}

$cl_error = New Error();
?>