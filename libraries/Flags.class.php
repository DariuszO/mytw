<?php
if(!defined("MyTW")) {
	exit;
}

class Flags {
	static flags_list() {
		$flags = [
			1 => [
				"name" => "Przyrost surowc�w",
				"view" => "+%s% przyrost surowc�w",
				"bonus" => 4,
				"plus" => 2
			],
			2 => [
				"name" => "Pr�dko�� rekrutacji jednostek",
				"view" => "+%s% pr�dko�� rekrutacji jednostek",
				"bonus" => 6,
				"plus" => 2
			],
			3 => [
				"name" => "Si�a ataku",
				"view" => "+%s% si�a ataku",
				"bonus" => 2,
				"plus" => 1
			],
			4 => [
				"name" => "Si�a obrony",
				"view" => "+%s% si�a obrony",
				"bonus" => 2,
				"plus" => 1
			]
		];
	}
}
?>