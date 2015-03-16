<?php
include '../inc/ChromePhp.php';
$debug = 0;
$order = $_POST['order'];
$split = "-----";
ChromePhp::log($order);
if ($debug==1) {
	$debugfile = fopen("updateOrder.out", "a") or die("Unable to open file!");
	fwrite($debugfile, $order);
	fwrite($debugfile, $split);
	fwrite($debugfile, $dump);
	fwrite($debugfile, $split);
	fwrite($debugfile, $orderArray);
	fwrite($debugfile, $split);
	fwrite($debugfile, var_dump($orderArray, true));
	fclose($debugfile);
}
require('../inc/db.php');
$db = new \labmanager\db();
ChromePhp::log('Query string: UPDATE racks set deviceorder="'. $order .'" WHERE id=2;');
if ($db->query('UPDATE racks set deviceorder="'. $order .'" WHERE id=2;')) {
	ChromePhp::log('ok');
} else {
	ChromePhp::log('fail');
}
ChromePhp::log($db->lastErrorMsg());
?>
