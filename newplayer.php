<?php
include "Config.php";
function validate($player){
	$name= explode('.',$player->name);
	if( sizeof($name)!=2 || strlen($name[1]) !=4 ) {
		echo "alert('Nome de usuário inválido, certifique-se que você colocou seu usuário e id (ex: klarkc.3754)');\n";
		return false;
	}
	return true;
}

//New Player or Update Player
function execute(){
	global $leaderboard;
	$player = new Player();
	$player->name = $_POST['name'];
	$player->guild = $_POST['guild'];
	$player->team = $_POST['team'];
	if(!$player->name || $player->name=="MeuNick.1234" || $player->name=="") {
		echo "alert('Você precisa preencher o campo ID do Jogador');\n";
	} else {
		if($player->guild=="Minha Guilda Sem Tag") $player->guild=NULL;
		if($player->team=="[TAG] Minha Guilda") $player->team=NULL;
		//TODO: RegExp e validação dos campos acima
		try{
			if(validate($player)){
				echo "/*"; //Fix javascript + php errors output commenting them
				if(!$leaderboard->insertPlayer($player)){
					echo "*/";
					echo "alert('Ups, erro desconhecido ao cadastrar jogador. Comunique ao administrador!');\n";
				} else {
					echo "*/";
					echo "alert('Jogador cadastrado com sucesso!');\n";
					echo "location.reload();";
				}
			}
		} catch(Exception $e){
			//var_dump($e);
			echo "*/";
			switch($e->errorInfo[0]){
				case "23000":
					//Update Player
					$player = $leaderboard->getPlayer($player->name);
					if($_POST['guild']) $player->guild = $_POST['guild'];
					if($_POST['team']) $player->team = $_POST['team'];
					if($leaderboard->updatePlayer($player)){
						echo "alert('* Você já se encontra cadastrado, seu cadastro foi atualizado.');\n";
					} else {
						echo "alert('* Você já se encontra cadastrado, porém não foi possível atualizar os seus dados, entre em contato com o administrador.');\n";
					}
					echo "location.reload();";
				break;
				default:
					echo "alert('Ups, erro desconhecido ao cadastrar jogador. Comunique ao administrador!');\n";
				break;
			}
		}
	}
}

//Captcha
// if form with $_POST['vcptca'] is submited and $_SESSION['captcha'] exists
if(isset($_POST['vcptca']) && isset($_SESSION['captcha'])) {
  //Error wrong captcha
  if($_POST['vcptca'] != $_SESSION['captcha']){
  	echo "alert('* A resposta da soma está errada');\n";
  } else {
  	execute();
  }
} else {
  echo "alert('* A resposta da soma não foi fornecida');\n";
}
