<?php
/**
/* 16/08/2013
/* Created by Walker Gusmão - walker@praiseweb.com.br
/* All Rights Reserved
*/

include "Config.php";
/*
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
			$('#newPlayer .submit').val("Registrando, pode demorar...");
		},
		success: function(){
			$('#newPlayer .loading').hide();
			$('#newPlayer .submit').attr("disabled", false);
			$('#newPlayer .submit').val("Registrar Jogador");
		}
        }); 
	$('td.actions .update').click(function(){
		column = $(this).closest('td');
		$(this).hide();
		$(column).find('.loading').css({display: 'block'});
		name = $(column).closest('tr').find('td.name').text();
		$.ajax('update.php?name='+name).done(function(){
			location.reload();
		}).fail(function(){
			alert('Falha ao atualizar');
			location.reload();
		});
	});
        //Transform UTC to Local
        $('td.last_update').each(function(){
        	var date = new Date($(this).text()+' UTC');
        	$(this).html(date.toLocaleString());
        });
}); 
</script> 
</head>
<body>
<h1>Cadastro de Jogadores Brasileiros de sPvP</h1>
<div id="mainData" class="main-data">
<div class="table-wrapper">
    <table class="lb real" data-filter="universal">
    <thead>
    <tr>
	<th class="rank brasil desc odd number">
		<span class="tooltip">Rank</span>
	</th>
        <th class="rank arena odd number"><span class="tooltip">Rank</span></th>
	<th class="points odd number">
		<span class="tooltip">Pontos</span>
	</th>
        <th class="name text">
                <span class="tooltip">Nome</span>
        </th>
        <th class="charname odd text">
	 	<span class="tooltip">Personagem</span>
        </th>
        <th class="wins number">
		<span class="tooltip ">Vitórias</span>
        </th>
        <th class="losses odd number">
		<span class="tooltip">Derrotas</span>
        </th>
        <th class="winpct number">
		<span class="tooltip">V/D %</span>
        </th>
        <th class="guild text">
		<span class="tooltip">Guilda</span>
        </th>
        <th class="last_update odd text">
		<span class="tooltip">Última Atualização</span>
        </th>
	<th class="actions">
	</th>
    </tr>
    </thead>
    <tbody>
    <?php $br_rank = $pagination->offset; ?>
    <?php $ll="even"; foreach ($data as $d) { ?>
    <?php $br_rank++; ?>
    <tr class="<?=$ll;?>">
	<td class="rank brasil number">
		<?php if($br_rank<4) echo "<span class='medal-".$br_rank."'></span>"; ?>
		<span class="cell-inner"><?=$br_rank;?></span>
        	<span class="additional before-arrow"><?=$d->last_update;?></span>
	</td>
	<td class="rank number <?=$d->rank_status;?>">
		<span class="hasAdditional">
			<span class="cell-inner after-arrow"><?=($d->rank>=1000)?"1000+":$d->rank;?></span>
			<?php if($d->rank>0): ?>
        		<span class="additional before-arrow"><?=$d->rank_since;?></span>
			<?php endif; ?>
    		</span>
	</td>
	<td class="points number <?=$d->points_status;?>">
		<span class="hasAdditional">
			<span class="cell-inner after-arrow"><?=($d->points>=1000)?"1000+":$d->points;?></span>
			<?php if($d->points>0): ?>
        		<span class="additional before-arrow"><?=$d->points_since;?></span>
			<?php endif; ?>
    		</span>
	</td>
	<td class="name text"><?=$d->name;?></td>
	<td class="charname text"><?=$d->character;?></td>
	<td class="equal wins number">
		<span class="hasAdditional">
			<span class="cell-inner after-arrow"><?=($d->wins)?$d->wins:"0"; ?></span>
			<?php if($d->rank>0): ?>
		        <span class="additional before-arrow"><?=$d->wins_since;?></span>
			<?php endif; ?>
		</span>
	</td>   
	<td class="equal losses number"> 
		<span class="hasAdditional">
		        <span class="cell-inner after-arrow"><?=($d->losses)?$d->losses:"0"; ?></span>
			<?php if($d->rank>0): ?>
		        <span class="additional before-arrow"><?=$d->losses_since;?></span>
			<?php endif; ?>
		</span>
	</td>
	<td class="winpct number"><?php echo ($d->winpct)?$d->winpct:"0%"; ?></td>
	<td class="guild text"><?php echo $d->guild;?></td>
        <td class="last_update text"><?php echo $d->last_update;?></td>
	<td class="actions"><span class="loading"></span><span class="update"></span></td>
    </tr>
    <?php $ll=($ll=="even")?"odd":"even"; }?>
    </tbody>
    </table>
</div>
<div class="notes">Nota¹: Somente estão inclusos os jogadores com rank inferior ao 999, a tabela é atualizada de hora em hora.</div>

<?php //echo $pagination; ?>

<!-- Submit Form -->
<div class="form_container">
<!--<h3>Cadastre-se!</h3>-->
<form id="newPlayer" action="newplayer.php" method="post"> 
    ID do Jogador: <input type="text" name="name" value="MeuNick.1234"/> 
    Guilda do Jogador: <input type="text" name="guild" value="Minha Guilda Sem Tag"></input> 
    Quanto é <?=$nrs[0].'&nbsp;+&nbsp;'.$nrs[1];?>: <input type="text" name="vcptca" size=3></input> 
    <input type="hidden" name="leaderboard" value="<?=$leaderboard->getMode();?>"></input> 
    <input class="submit" type="submit" value="Registrar Jogador" />
    <img class="loading" src="images/ajax.gif" style="display: none" />
</form>
</div>
<!-- End Submit Form -->
</div>
<?php if($GLOBALS['debug']) echo "<pre>".var_dump($data)."</pre>"; ?>
</body>
</html>
