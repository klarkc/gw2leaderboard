<?php
include "Config.php";
$gspreadsheet = file_get_contents(SPREADSHEET);

$lines = explode("\n", $gspreadsheet);
foreach($lines as $key => $line) {
		if($key != 0) {
			$fields = explode(',',$line);
			$player = new Player();
			$player->name = $fields[1];
			$player->guild = $fields[3];
			try{
				$leaderboard->insertPlayer($player);
			}catch(Exception $e){echo "Player error: ".$player->name;}
		}
}
