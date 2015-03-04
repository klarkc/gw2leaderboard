<?php
include "Config.php";

global $leaderboard;
$player = new Player();
$player->name = strtolower($_GET['name']);
if(!$player->name || $player->name=="") {
	json_encode(NULL);
} else {
	$player = $leaderboard->getPlayer($player->name);
	if(empty($player)){
		json_encode(NULL);
	} else {
		echo json_encode($player);

	}
}
		
