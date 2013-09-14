<?php
/**
/* @author Walker Gusmão - walker@praiseweb.com.br
/* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
*/

include "Config.php";
function validate($player){
	$name= explode('.',$player->name);
	if( sizeof($name)!=2 || strlen($name[1]) !=4 ) {
		echo "alert('Nome de usuário inválido, certifique-se que você colocou seu usuário e id (ex: klarkc.3754)');\n";
		return false;
	}
	return true;
}

//Captcha
// if form with $_POST['vcptca'] is submited and $_SESSION['captcha'] exists
if(isset($_POST['vcptca']) && isset($_SESSION['captcha'])) {
  //Error wrong captcha
  if($_POST['vcptca'] != $_SESSION['captcha']) echo "alert('* A resposta da soma está errada');\n";
} else {
  echo "alert('* A resposta da soma não foi fornecida');\n";
}
//New Player
$player = new Player();
$player->name = $_POST['name'];
$player->guild = $_POST['guild'];
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
			echo "alert('* Você já se encontra cadastrado, se não estiver aparecendo, é porque você consta como rank superior ao 1000');\n";
		break;
		default:
			echo "alert('Ups, erro desconhecido ao cadastrar jogador. Comunique ao administrador!');\n";
		break;
	}
}
