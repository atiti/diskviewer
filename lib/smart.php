<?php

class Smart {
	private $devices = array();
	public function __construct($devices) {
		$this->devices = $devices;
	}

	public function run() {
		$res = array();
		foreach($this->devices as $k => $d) {
			$data = explode("\n", file_get_contents("tests/".$d));
			$res[$k] = $this->parse($data);
		}
		return $res;
	}

	public function parse($data) {
		$props = array();
		foreach($data as $l) {
			$v2 = explode(" ", $l);
			$v = array_values(array_filter($v2));
			if (count($v)) {
				if ($v[0] == "194")
					$props["temp"] = $v[9];
			}
		}
		$props["status"] = "Warning";
		$props["state"] = 1;
		return $props;
	}
}


?>
