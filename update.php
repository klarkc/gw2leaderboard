<?php
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";

//error_reporting(E_ALL); 
//ini_set("display_errors", 1); 

/*
//Defaults: Update 1 of top 300 players more old then 4 hours
$found = $leaderboard->updatePlayers(1, 14400, 1, 300);
//Update one player between 301 and 600 more old then 8 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 28800, 301, 600);
//Update one player between 601 and 998 more old then 16 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 57600, 601, 998);
//Update one player between 999 and 1000 more old then 3 Days
if(!$found) $found = $leaderboard->updatePlayers(1, 259200, 999, 1000);
*/
if($_GET['name']) {
	header('Content-Type: application/javascript');
	$player = $leaderboard->getPlayer($_GET['name']);
	if(!empty($player)){
		if($leaderboard->findPage($player)){
			echo "alert('Jogador {$player->name} encontrado e atualizado');";
		} else {
			echo "alert('Jogador {$player->name} não encontrado na LB oficial";
			//Remove player from leaderboard
			$player->last_page = 0;
			$player->rank = 1000;
			$player->rank_br = NULL;
			//So update the data in DB
			if($leaderboard->updatePlayer($player)){
				echo "\nJogador {$player->name} rank atualizado";
			} else {
				echo "\nERRO: Jogador {$player->name} rank não atualizado";
			}
			echo "');";
		}
	} else {
		echo "alert('Jogador {$_GET['name']} não encontrado na nossa LB');";
	}
} else {
	
//Defaults: Update 1 of top 150 players more old then 1 hours
//$found = $leaderboard->updatePlayers(1, 3600, 1, 150);
//Update one player between 151 and 300 more old then 2 hours
//if(!$found) $found = $leaderboard->updatePlayers(1, 7200, 151, 300);
//Update one player between 301 and 450 more old then 4 hours
//if(!$found) $found = $leaderboard->updatePlayers(1, 14400, 301, 450);
//Update one player between 451 and 600 more old then 6 hours
//if(!$found) $found = $leaderboard->updatePlayers(1, 21600, 451, 600);
//Update one player between 601 and 998 more old then 8 hours
//if(!$found) $found = $leaderboard->updatePlayers(1, 28800, 601, 998);
//Update one player between 999 and 1000 more old then 2 Days
//if(!$found) $found = $leaderboard->updatePlayers(1, 172800, 999, 1000);

//Defaults: Update 1 of top 150 players more old then 1 hours
$found = $leaderboard->updatePlayers(1, 3600, 1, 150);
//Update one player between 151 and 300 more old then 1 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 3600, 151, 300);
//Update one player between 301 and 450 more old then 1 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 3600, 301, 450);
//Update one player between 451 and 600 more old then 1 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 3600, 451, 600);
//Update one player between 601 and 998 more old then 1 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 3600, 601, 998);
//Update one player between 999 and 1000 more old then 1 Days
if(!$found) $found = $leaderboard->updatePlayers(1, 86400, 999, 1000);

}
