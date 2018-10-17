<?php
if(!defined("MyTW")) {
	exit;
}

class Flags {
	static flags_list() {
		$flags = [
			1 => [
				"name" => "Przyrost surowców",
				"view" => "+%s% przyrost surowców",
				"bonus" => 4,
				"plus" => 2
			],
			2 => [
				"name" => "Prêdkoœæ rekrutacji jednostek",
				"view" => "+%s% prêdkoœæ rekrutacji jednostek",
				"bonus" => 6,
				"plus" => 2
			],
			3 => [
				"name" => "Si³a ataku",
				"view" => "+%s% si³a ataku",
				"bonus" => 2,
				"plus" => 1
			],
			4 => [
				"name" => "Si³a obrony",
				"view" => "+%s% si³a obrony",
				"bonus" => 2,
				"plus" => 1
			]
		];
	}
}
?>