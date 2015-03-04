<?php

/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";
//Data

$data = $leaderboard->getAllPlayers(10,0);
$br_rank = $pagination->offset;
?>
<div class="leaderboard">
<ul class="box gray">
<?php foreach ($data as $d): ?>
	<?php $br_rank++; ?>
	<li class="player">
		<div class="rank">
			<?php if($br_rank<4) echo "<span class='medal-".$br_rank."'></span>" ;?>
			<span class="cell-inner"><?php echo $br_rank;?>º&nbsp</span>
		</div>
		<div class="name"><span>Char: <?php echo $d->character;?></span><br/><?php echo $d->name;?></div>
	</li>
	<li class="details">
	<ul>
			<li class="rank <?=$d->rank_status;?>">
				<span class="hasAdditional">
					<b>Rank ANet: </b><span class="value"><?=($d->rank>=1000)?"1000+":$d->rank;?></span>
					<?php if($d->rank>0): ?>(<?=$d->rank_since;?>)<?php endif; ?></span>
   				</span>
			</li>
			<li class="points <?=$d->points_status;?>">
				<span class="hasAdditional">
					<b>Pontos: </b><span class="value"><?=($d->points>=1000)?"1000+":$d->points;?></span>
					<?php if($d->points>0): ?>(<?=$d->points_since;?>)<?php endif; ?>
   				</span>
			</li>
			<li class="wins <?=$d->wins_status;?>">
				<span class="hasAdditional">
					<b>Vitórias: </b>
					<span class="value"><?=($d->wins)?$d->wins:"0";?></span>
					<?php if($d->rank>0): ?>(<?=$d->wins_since;?>)<?php endif; ?>
				</span>
			</li>
			<li class="losses <?=$d->losses_status;?>"> 
				<b>Derrotas: </b>
				<span class="hasAdditional">
				        <span class="value"><?=($d->losses)?$d->losses:"0";?></span>
					<?php if($d->rank>0): ?>(<?=$d->losses_since;?>)<?php endif; ?>
				</span>
			</li>
			<li class="winpct"><b>V/D %: </b><?=($d->winpct)?$d->winpct:"0%";?></li>
			<li class="guild"><b>Guilda: </b><?=$d->guild;?></li>
		        <li class="last_update"><b>Última Atualização: </b><?=date("d-m-Y H:i:s", strtotime($d->last_update)-(3600*3));?></li>
	</ul>
	</li>
<?php endforeach; ?>
</ul>
<a href="http://guildwars2brasil.com.br/leaderboard" target="_blank" class="btn">Atualizar/Cadastrar</a>
</div>

