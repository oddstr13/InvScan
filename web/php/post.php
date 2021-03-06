<?php
require_once './MySQLConnect.php';

if(isset($_GET['name']) && !empty($_POST['item']))
{
	$db->prepare('DELETE FROM invscan.inventories WHERE playerName = :name')->execute(array('name' => $_GET["name"]));
	$db->prepare('INSERT INTO invscan.inventories SET playerName = :name, lastUpdated = :time')->execute(array('name' => $_GET["name"], 'time' => time()));
	
	$db->prepare('DELETE FROM invscan.items WHERE playerName = :name')->execute(array('name' => $_GET["name"]));
	$itemStmt = $db->prepare('INSERT INTO invscan.items SET playerName = :playerName, slot = :slot, itemRawName = :rawName, itemName = :name, quantity = :size');
	
	foreach($_POST['item'] as $slot => $item)
	{
		$itemStmt->execute(array('playerName' => $_GET["name"], 'slot' => $slot) + $item);
	}
}
?>