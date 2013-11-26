<?
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";

//Data
//$data = $leaderboard->getAllPlayers($pagination->limit,$pagination->offset);
$data = $leaderboard->getAllPlayers(100,0);
?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/module.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script>
$(function(){

$('.main-data td.name > div').click(function(){
	$(this).next('.details').fadeIn();
});

$('.main-data td.name ul.details li.close').click(function(){
	$('.details').fadeOut();
});

});
</script>
</head>
<body>
<? if($leaderboard->getMode()=='soloarena'): ?>
<h4 class="head">Solo Arena</h4>
<? else: ?>
<h4 class="head">Team Arena</h4>
<? endif; ?>
<div id="mainData" class="main-data">
<div class="table-wrapper">
    <table class="lb real soloarena" data-filter="universal">
    <thead>
    <tr>
	<th class="rank desc odd number">
		<span class="tooltip">Rank</span>
	</th>
        <th class="name text">
                <span class="tooltip">Jogador</span>
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
	<td class="name text">
		<div>
			<b>Nome: </b><?=$d->name;?><br/>
			<? if($leaderboard->getMode()=='teamarena' && $d->team): ?>
			<b>Team: </b><span style="color: red" ?><?=$d->team;?></span>
			<? else: ?>
			<b>Char: </b><?=$d->character;?>
			<? endif; ?>			
		</div>
		<ul class="details">
			<li class="charname text"><b>Personagem: </b><?=$d->character;?></li>
			<li class="rank number <?=$d->rank_status;?>">
				<span class="hasAdditional">
					<b>Rank ANet: </b><?=($d->rank>=1000)?"1000+":$d->rank;?>
					<? if($d->rank>0): ?>(<?=$d->rank_since;?>)<? endif; ?>
   				</span>
			</li>
			<li class="equal wins number">
				<span class="hasAdditional">
					<b>Vitórias: </b>
					<span class="cell-inner after-arrow"><?=($d->wins)?$d->wins:"0";?></span>
					<? if($d->rank>0): ?>(<?=$d->wins_since;?>)<? endif; ?>
				</span>
			</li>
			<li class="equal losses number"> 
				<b>Derrotas: </b>
				<span class="hasAdditional">
				        <span class="cell-inner after-arrow"><?=($d->losses)?$d->losses:"0";?></span>
					<? if($d->rank>0): ?>(<?=$d->losses_since;?>)<? endif; ?>
				</span>
			</li>
			<li class="winpct number"><b>Porcentagem V/D: </b><?=($d->winpct)?$d->winpct:"0%";?></li>
			<li class="guild text"><b>Guild: </b><?=$d->guild;?></li>
			<? if($leaderboard->getMode()=='teamarena' && $d->team): ?>
			<li class="team text"><b>Team: </b><?=$d->team;?></li>
			<? endif; ?>
		        <li class="world text"><b>World: </b><?=$d->world;?></li>
		        <li class="last_update text"><b>Última Atualização: </b><?=date("d-m-Y H:i:s", strtotime($d->last_update)-(3600*3));?></li>
			<li class="close text"><span class="btn">Fechar</span></li>
		</ul>
	</td>
    </tr>
    <? $ll=($ll=="even")?"odd":"even"; }?>
    </tbody>
    </table>
</div>
<div class="notes">
<!--
	<? if($leaderboard->getMode()=='soloarena'): ?>
	<a href="module.php?leaderboard=teamarena" class="btn">Team Leaderboard</a>
	<? else: ?>
	<a href="module.php?leaderboard=soloarena" class="btn">Solo Leaderboard</a>
	<? endif; ?>
-->
	<a href="<?=($leaderboard->getMode()=='soloarena')?'http://www.guildwars2brasil.com.br/?page_id=4940':'http://www.guildwars2brasil.com.br/?page_id=5022';?>" target="_blank" class="btn">Atualizar/Cadastrar</a>
</div>

<? //echo $pagination; ?>
</div>

<? //if($GLOBALS['debug']) echo "<pre>".var_dump($data)."</pre>"; ?>
</body>
</html>
