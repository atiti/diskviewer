<?php

class Drives {
	private $drives_array = array(); // Drive array
	private $render_settings = array(); // Render settings

	public function __construct($settings, $drives) {
		$this->drives_array = $drives;
		$this->render_settings = $settings;
	}
	
	public function render() {
		$result = "";
		$disk_stat = $this->drives_array;	
		$disk_num = 1;
		for($i=0;$i<$this->render_settings["num_cols"];$i++) {
        		for($j=0;$j<$this->render_settings["num_rows"];$j++) {
		                $startx = $this->render_settings["offset_x"] + $i*($this->render_settings["disk_width"]+$this->render_settings["space_between_cols"]);
		                $endx = $startx + $this->render_settings["disk_width"];
		                $starty = $this->render_settings["offset_y"] + $j*($this->render_settings["disk_height"]+$this->render_settings["space_between_rows"]);
		                $endy = $starty + $this->render_settings["disk_height"];

				if ($this->render_settings["show_good_status"])
					$disk_status_img = $this->render_settings["base_path"].$this->render_settings["disk_good"];
				else
					$disk_status_img = NULL;

				$status = "";
				if (isset($this->drives_array[$disk_num])) {
					$state = $this->drives_array[$disk_num]["state"];
					if ($state == 0) {
						$status = "Good";
					} if ($state == 1) {
						$disk_status_img = $this->render_settings["base_path"].$this->render_settings["disk_warning"];
						$status = "Warning";
					} else if ($state == 2) {
						$disk_status_img = $this->render_settings["base_path"].$this->render_settings["disk_bad"];
						$status = "Error";
					}
				}
				if ($disk_status_img != NULL) {				
			                $result .= '<a href="#" alt="disk-'.$disk_num.'" title="disk-'.$disk_num.': '.$status.', Temp: '.$this->drives_array[$disk_num]["temp"].'C">';   
			                $result .= '<img style="position: absolute; top: '.($starty).'px; left: '.($startx).'px;" src="'.$disk_status_img.'" alt="disk-'.$disk_num.'" />';
			                $result .= "</a>\n";
				}
		                $disk_num++;
		        }
		}	
		return $result;
	}
}
