<?
/**
/* @author Walker Gusmão - walker@praiseweb.com.br
/* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
*/

include "Config.php";

//Defaults: Update 1 of top 100 players more old then 10 min
$found = $leaderboard->updatePlayers(1, 600, 1, 100);
//Update one player between 100 and 200 more old then 30 min
if(!$found) $found = $leaderboard->updatePlayers(1, 1800, 100, 200);
//Update one player between 200 and 300 more old then 35 min
if(!$found) $found = $leaderboard->updatePlayers(1, 2100, 200, 300);
//Update one player between 300 and 400 more old then 40 min
if(!$found) $found = $leaderboard->updatePlayers(1, 2400, 300, 400);
//Update one player between 400 and 500 more old then 45 min
if(!$found) $found = $leaderboard->updatePlayers(1, 2700, 400, 500);
//Update one player between 500 and 600 more old then 50 min
if(!$found) $found = $leaderboard->updatePlayers(1, 3000, 400, 500);
//Update one player between 600 and 700 more old then 55 min
if(!$found) $found = $leaderboard->updatePlayers(1, 3300, 400, 500);
//Update one player between 700 and 800 more old then 60 min
if(!$found) $found = $leaderboard->updatePlayers(1, 3600, 400, 500);
//Update one player between 800 and 900 more old then 65 min
if(!$found) $found = $leaderboard->updatePlayers(1, 3900, 400, 500);
//Update one player between 900 and 999 more old then 70 min
if(!$found) $found = $leaderboard->updatePlayers(1, 4200, 400, 999);
//Update one player between 999 and 1000 more old then 24 hours
if(!$found) $found = $leaderboard->updatePlayers(1, 86400, 999, 1000);

//Data
//$data = $leaderboard->getAllPlayers($pagination->limit,$pagination->offset);
$data = $leaderboard->getAllPlayers(100,0);
//Captcha
$nrs = setCaptcha('captcha');
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/custom.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script> 
// wait for the DOM to be loaded 
$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 
        $('#newPlayer').ajaxForm({
		dataType: "script",
		beforeSend: function(){
			$('#newPlayer .loading').show();
			$('#newPlayer .submit').attr("disabled", true);
		},
		success: function(){
			$('#newPlayer .loading').hide();
			$('#newPlayer .submit').attr("disabled", false);
		}
        }); 
}); 
</script> 
</head>
<body>
<h1>Cadastro de Jogadores Brasileiros de sPvP</h1>
<div id="mainData" class="main-data">
<div class="table-wrapper">
    <table class="lb real soloarena" data-filter="universal">
    <thead>
    <tr>
	<th class="rank brasil desc odd number">
		<span class="tooltip">Rank</span>
	</th>
        <th class="rank arena odd number"><span class="tooltip">Rank</span></th>
        <th class="name text">
                <span class="tooltip">Name</span>
        </th>
        <th class="charname odd text">
	 	<span class="tooltip">Character</span>
        </th>
        <th class="wins number">
		<span class="tooltip ">Wins</span>
        </th>
        <th class="losses odd number">
		<span class="tooltip">Losses</span>
        </th>
        <th class="winpct number">
		<span class="tooltip">Win %</span>
        </th>
        <th class="guild text">
		<span class="tooltip">Guild</span>
        </th>
        <th class="world odd text">
		<span class="tooltip">World</span>
        </th>
        <th class="world odd text">
		<span class="tooltip">Última Atualização</span>
        </th>
    </tr>
    </thead>
    <tbody>
    <? $br_rank = $pagination->offset; ?>
    <? $ll="even"; foreach ($data as $d) { ?>
    <? $br_rank++; ?>
    <tr class="<?=$ll;?>">
	<td class="rank brasil number">
		<?if($br_rank<4) echo "<span class='medal-".$br_rank."'></span>";?>
		<span class="cell-inner"><?=$br_rank;?></span>
        	<span class="additional before-arrow"><?=$d->last_update;?></span>
	</td>
	<td class="rank number <?=$d->rank_status;?>">
		<span class="hasAdditional">
			<span class="cell-inner after-arrow"><?=($d->rank>=1000)?"1000+":$d->rank;?></span>
			<? if($d->rank>0): ?>
        		<span class="additional before-arrow"><?=$d->rank_since;?></span>
			<? endif; ?>
    		</span>
	</td>
	<td class="name text"><?=$d->name;?></td>
	<td class="charname text"><?=$d->character;?></td>
	<td class="equal wins number">
		<span class="hasAdditional">
			<span class="cell-inner after-arrow"><?=($d->wins)?$d->wins:"0";?></span>
			<? if($d->rank>0): ?>
		        <span class="additional before-arrow"><?=$d->wins_since;?></span>
			<? endif; ?>
		</span>
	</td>   
	<td class="equal losses number"> 
		<span class="hasAdditional">
		        <span class="cell-inner after-arrow"><?=($d->losses)?$d->losses:"0";?></span>
			<? if($d->rank>0): ?>
		        <span class="additional before-arrow"><?=$d->losses_since;?></span>
			<? endif; ?>
		</span>
	</td>
	<td class="winpct number"><?=($d->winpct)?$d->winpct:"0%";?></td>
	<td class="guild text"><?=$d->guild;?></td>
        <td class="world text"><?=$d->world;?></td>
        <td class="last_update text"><?=date("d-m-Y H:i:s", strtotime($d->last_update)-(3600*3));?></td>
    </tr>
    <? $ll=($ll=="even")?"odd":"even"; }?>
    </tbody>
    </table>
</div>
<div class="notes">Nota¹: Somente estão inclusos os jogadores com rank inferior a 1000, quanto maior o rank mais atualizado ele estará.</div>

<? //echo $pagination; ?>

<!-- Submit Form -->
<div class="form_container">
<!--<h3>Cadastre-se!</h3>-->
<form id="newPlayer" action="newplayer.php" method="post"> 
    ID do Jogador: <input type="text" name="name" /> 
    Guilda do Jogador: <input type="text" name="guild"></input> 
    Quanto é <?=$nrs[0].'&nbsp;+&nbsp;'.$nrs[1];?>: <input type="text" name="vcptca" size=3></input> 
    <input type="hidden" name="leaderboard" value="<?=$leaderboard->getMode();?>"></input> 
    <input class="submit" type="submit" value="Registrar Jogador" />
    <img class="loading" src="images/ajax.gif" style="display: none" />
</form>
</div>
<!-- End Submit Form -->
</div>

<? if($GLOBALS['debug']) echo "<pre>".var_dump($data)."</pre>"; ?>
</body>
</html>
