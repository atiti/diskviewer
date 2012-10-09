<?php

if (isset($_GET["device"]))
	$DEVICE = $_GET["device"];
else
	$DEVICE = "backblaze";


/* Do not edit below this line */
require_once("lib/template.php");
require_once("lib/drives.php");
require_once("lib/smart.php");
require_once("device/".$DEVICE."/config.php");

$tmplt = new Template("device/".$DEVICE."/index.html");

$smart = new Smart(array(1 => "hdc", 2 => "hde", 3 =>"hdg", 4=>"hdi"));

$disk_stats = $smart->run();

$disk_stats[11] = array("status" => "Bad", "state"=>2);
$disk_stats[22] = array("status" => "Bad", "state"=>2);
$disk_stats[33] = array("status" => "Bad", "state"=>2);

$disk_handler = new Drives($settings, $disk_stats);

$disks = $disk_handler->render();

$tmplt->replace(array("DRIVE_LIST"=>$disks));

$tmplt->display();

?>
