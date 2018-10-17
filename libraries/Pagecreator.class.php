<?php
if (!defined("MyTW")) {
	exit;
}

class HTML {
	var $head = "";
	var $meta_tags = "";
	var $body = "";
	var $spectags = [];
	var $efect = "<!DOCYPTE html>";
	function Tag($tag,$view,$options=[],$closed_normal=true) {
		static $i;
		$i++;
		$return = "<{$tag}";
		foreach($options as $opt => $val) {
			$return .= " {$opt}=\"{$val}\"";
		}
		if ($closed_normal!==true) {
			if (!empty($view)) {
				$return .= " value=\"{$view}\"";
			}
			$return .= " />";
		} else {
			$return .= ">{$view}</{$tag}>";
		}
		$this->spectags[$tag][$i] = $return;
		return $return;
	}
	
	function MetaTags($mt) {
		$return = "";
		foreach ($mt as $meta) {
			$return .= $this->Tag("meta","",$meta,false);
		}
		return $return;
	}
	
	function plus($pp) {
		$this->efect .= $pp;
		return $this->efect;
	}
	
	function Full() {
		return $this->efect;
	}
}
?>