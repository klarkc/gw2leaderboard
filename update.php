<?
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";

//Defaults: Update 1 of top 300 players more old then 4 hours
$found = $leaderboard->updatePlayers(1, 14400, 1, 300);
//Update one player between 301 and 600 more old then 8 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 28800, 301, 600);
//Update one player between 601 and 998 more old then 16 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 57600, 601, 998);
//Update one player between 999 and 1000 more old then 3 Days
if(!$found) $found = $leaderboard->updatePlayers(1, 259200, 999, 1000);