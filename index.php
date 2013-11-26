<?
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";
//Data
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
        //Transform UTC to Local
        $('td.last_update').each(function(){
        	var date = new Date($(this).html());
        	$(this).html(date.toLocaleString());
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
        <?php if($leaderboard->getMode()=="teamarena"): ?>
        <th class="team text">
		<span class="tooltip">Team</span>
        </th>
        <?php else: ?>
        <th class="guild text">
		<span class="tooltip">Guild</span>
        </th>
        <th class="world odd text">
		<span class="tooltip">World</span>
        </th>
	<?php endif; ?>
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
	<?php if($leaderboard->getMode()=="teamarena"): ?>
	<td class="team text"><?=$d->team;?></td>	
	<?php else: ?>
	<td class="guild text"><?=$d->guild;?></td>
	<td class="world text"><?=$d->world;?></td>
	<?php endif; ?>
        <td class="last_update text"><?=date("m/d/Y h:m:s A e", strtotime($d->last_update));?></td>
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
    ID do Jogador: <input type="text" name="name" value="MeuNick.1234"/> 
    Guilda do Jogador: <input type="text" name="guild" value="Minha Guilda Sem Tag"></input> 
    <?php if($leaderboard->getMode()=="teamarena"): ?>
    <br />
    Time do Jogador: <input type="text" name="team" value="[TAG] Minha Guilda"></input> 
    <?php endif; ?>
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
