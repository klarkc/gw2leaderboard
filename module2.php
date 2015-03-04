<?php
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";
/*
High Load
//Defaults: Update 1 of top 100 players more old then 20 min
$found = $leaderboard->updatePlayers(1, 1200, 1, 100);
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
*/

//Data
//$data = $leaderboard->getAllPlayers($pagination->limit,$pagination->offset);
$data = $leaderboard->getAllPlayers(10,0);
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
<div id="mainData" class="main-data">
<div class="table-wrapper">
    <!--
    <h2>Top 10 sPvP Nacional</h2>
    -->
    <table class="lb real" data-filter="universal">
    <!--
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
    -->
    <tbody>
    <?php $br_rank = $pagination->offset; ?>
    <?php $ll="even"; foreach ($data as $d) { ?>
    <?php $br_rank++; ?>
    <tr class="<?=$ll;?>">
	<td class="rank brasil number">
		<?php if($br_rank<4) echo "<span class='medal-".$br_rank."'></span>" ;?>
		<span class="cell-inner"><?php echo $br_rank;?></span>
        	<span class="additional before-arrow"><?=$d->last_update;?></span>
	</td>
	<td class="name text">
		<div>
			<b>Nome: </b><?=$d->name;?><br/>
			<b>Char: </b><?=$d->character;?>
		</div>
		<ul class="details">
			<li class="rank number <?=$d->rank_status;?>">
				<span class="hasAdditional">
					<b>Rank ANet: </b><?=($d->rank>=1000)?"1000+":$d->rank;?>
					<?php if($d->rank>0): ?>(<?=$d->rank_since;?>)<?php endif; ?>
   				</span>
			</li>
			<li class="points number <?=$d->points_status;?>">
				<span class="hasAdditional">
					<b>Pontos: </b><?=($d->points>=1000)?"1000+":$d->points;?>
					<?php if($d->points>0): ?>(<?=$d->points_since;?>)<?php endif; ?>
   				</span>
			</li>
			<li class="equal wins number">
				<span class="hasAdditional">
					<b>Vitórias: </b>
					<span class="cell-inner after-arrow"><?=($d->wins)?$d->wins:"0";?></span>
					<?php if($d->rank>0): ?>(<?=$d->wins_since;?>)<?php endif; ?>
				</span>
			</li>
			<li class="equal losses number"> 
				<b>Derrotas: </b>
				<span class="hasAdditional">
				        <span class="cell-inner after-arrow"><?=($d->losses)?$d->losses:"0";?></span>
					<?php if($d->rank>0): ?>(<?=$d->losses_since;?>)<?php endif; ?>
				</span>
			</li>
			<li class="winpct number"><b>V/D %: </b><?=($d->winpct)?$d->winpct:"0%";?></li>
			<li class="guild text"><b>Guilda: </b><?=$d->guild;?></li>
		        <li class="last_update text"><b>Última Atualização: </b><?=date("d-m-Y H:i:s", strtotime($d->last_update)-(3600*3));?></li>
			<li class="close text"><span class="btn">Fechar</span></li>
		</ul>
	</td>
    </tr>
    <?php $ll=($ll=="even")?"odd":"even"; }?>
    </tbody>
    </table>
</div>
<div class="notes">
	<a href="http://guildwars2brasil.com.br/leaderboard" target="_blank" class="btn">Atualizar/Cadastrar</a>
</div>

<?php //echo $pagination; ?>
</div>

<?php //if($GLOBALS['debug']) echo "<pre>".var_dump($data)."</pre>"; ?>
</body>
</html>
