<?
/**
/* @author Walker Gusmão - walker@praiseweb.com.br
/* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
*/

class Leaderboard extends Database {
	private $mode;

	/**
	* Clear variable from strange characters
	*/
	private function clear($var){
		$var = html_entity_decode($var);
		$var = preg_replace('/(\s)+/', ' ', trim($var));
		$var = preg_replace("'[\n\r\t]'","", $var);
		return $var;
	}

	/**
	* Set mode of the leaderboard
	*/
	public function setMode($mode='soloarena'){$this->mode = $mode;}

	/**
	* Get mode of the leaderboard
	*/
	public function getMode(){ return $this->mode;}

	/**
	/* Binary search page for a player
	/* Returns TRUE if a player has found and updated, otherwise FALSE
	*/
	private function findPage($player){
		$player->last_page = (int) $player->last_page;
		if ($player->last_page>0){
			// Page hasn't changed at all
			if ($this->searchAndUpdate($player)) return true;

			// Dual walk (sensibly reduce algorithm complexity O(N-k))
			$goFw=$player->last_page;
			$goBw=$player->last_page;
	
			while($goFw<=ANET_PAGES||$goBw>0){
				if ($goFw<=ANET_PAGES){
					$player->last_page = ++$goFw;
					//echo "Player: ".$player->name." Searched in the next page: ".$player->last_page."<br>";
					if ($this->searchAndUpdate($player)) return true;
				}

				if ($goBw>0){
					$player->last_page = --$goBw;
					//echo "Player: ".$player->name." Searched in the prev page: ".$player->last_page."<br>";
					if ($this->searchAndUpdate($player)) return true;
				}
			}
		}else{
			// Linear walk-through (O(N))
			for ($p=1;$p<=ANET_PAGES;$p++){
				$player->last_page = $p;
				//echo "Player: ".$player->name." linearly Searched in the page: ".$player->last_page."<br>";
				if ($this->searchAndUpdate($player)) return true;
			}
		}
 
		// Error! We couldn't find a player
		return false;
	}

	/**
	/* Return player by name
	*/
	public function getPlayer($name) {
		$sql = "SELECT * FROM ".$this->mode." WHERE `name` = ? LIMIT 1";
        	$sel = self::db()->prepare( $sql );
	        $sel->execute($name);
	        $sel->setFetchMode( PDO::FETCH_OBJ );
	        $obj = $sel->fetch();
		return $obj;
	}
	
	/**
	/* Return count of records
	*/
	public function count(){
		$sql = "SELECT count(*) FROM ".$this->mode."";
	        $sel = self::db()->prepare( $sql );
        	$sel->execute();
	        $sel->setFetchMode( PDO::FETCH_COLUMN, 0 );
	        $obj = $sel->fetch();
		return $obj;
	}

	/**
	/* Return all players (with pagination)
	*/
	public function getAllPlayers($limit,$offset, $limbo = false){
		$sql = "SELECT * FROM ".$this->mode;
		if(!$limbo) $sql .= " WHERE `rank` < 1000";
		$sql .= " ORDER BY rank, last_update DESC LIMIT ? OFFSET ?";
	        $sel = self::db()->prepare( $sql );
		$sel->bindParam(1, $limit, PDO::PARAM_INT);
		$sel->bindParam(2, $offset, PDO::PARAM_INT);
	        $sel->execute();
	        $sel->setFetchMode( PDO::FETCH_CLASS , "stdClass");
	        $obj = $sel->fetchAll();
		return $obj;
	}

	/**
	/* Update data for an specific player
	*/
	public function updatePlayer($player){
		$sql = "UPDATE `".$this->mode."` SET ";
		$sql .= "`rank`=:rank, ";
		$sql .= "`rank_status`=:rank_status, ";
		$sql .= "`rank_since`=:rank_since, ";
		$sql .= "`name`=:name, ";
		$sql .= "`character`=:character, ";
		$sql .= "`wins`=:wins, ";
		$sql .= "`wins_status`=:wins_status, ";
		$sql .= "`wins_since`=:wins_since, ";
		$sql .= "`losses`=:losses, ";
		$sql .= "`losses_status`=:losses_status, ";
		$sql .= "`losses_since`=:losses_since, ";
		$sql .= "`winpct`=:winpct, ";
		$sql .= "`guild`=:guild, ";
		$sql .= "`world`=:world, ";
		$sql .= "`last_update`=NOW(), ";
		$sql .= "`last_page`=:last_page";
		$sql .= " WHERE `id`=:id";
		
	        $sel = self::db()->prepare( $sql );
		$sel->bindParam(":rank", $player->rank, PDO::PARAM_INT);
		$sel->bindParam(":rank_status", $player->rank_status, PDO::PARAM_STR);
		$sel->bindParam(":rank_since", $player->rank_since, PDO::PARAM_STR);
		$sel->bindParam(":name", $player->name, PDO::PARAM_STR);
		$sel->bindParam(":character", $player->character, PDO::PARAM_STR);
		$sel->bindParam(":wins", $player->wins, PDO::PARAM_INT);
		$sel->bindParam(":wins_status", $player->wins_status, PDO::PARAM_STR);
		$sel->bindParam(":wins_since", $player->wins_since, PDO::PARAM_STR);
		$sel->bindParam(":losses", $player->losses, PDO::PARAM_INT);
		$sel->bindParam(":losses_status", $player->losses_status, PDO::PARAM_STR);
		$sel->bindParam(":losses_since", $player->losses_since, PDO::PARAM_STR);
		$sel->bindParam(":winpct", $player->winpct, PDO::PARAM_STR);
		$sel->bindParam(":guild", $player->guild, PDO::PARAM_STR);
		$sel->bindParam(":world", $player->world, PDO::PARAM_STR);
		$sel->bindParam(":last_page", $player->last_page, PDO::PARAM_INT);
		$sel->bindParam(":id", $player->id, PDO::PARAM_INT);
		//var_dump($player);
	        return $sel->execute();
	}

	/**
	/* Insert data for an new player
	*/
	public function insertPlayer($player){
		$sql = "INSERT INTO `".$this->mode."` (rank,name,guild,last_update) VALUES ";
		$sql .= "(:rank,:name,:guild,NOW())";
	        $sel = self::db()->prepare( $sql );
		$rank=1000;
		$sel->bindParam(":rank", $rank, PDO::PARAM_INT);
		$sel->bindParam(":name", $player->name, PDO::PARAM_STR);
		$sel->bindParam(":guild", $player->guild, PDO::PARAM_STR);
	        $return = $sel->execute();

		//After the insert, update Player and check if are in rank, otherwise stay on the limbo (1000+ players)
		if($return) {
			$player->id = (int) self::db()->lastInsertId();
			if(!$this->findPage($player)) echo "alert('Não encontramos você na leaderboard da Arena Net, isso significa que seu rank é maior que 1000, mas não se preocupe. Adicionaremos você mesmo assim, e se por um acaso seu rank ficar menor que 1000, você aparecerá automaticamente na lista.');\n";
		}
		
		return $return;
	}

	/**
	* Check if player exists in an leaderboard table and update if true.
	* Return: True if player has found, False otherwise
	*/
	private function searchAndUpdate($player){
		if($player->last_page<1||$player->last_page>ANET_PAGES) return false;
		//Load nextPage from anet servers
		$html = file_get_html(ANET_URL."&page=".$player->last_page);
		if(!method_exists($html,'find')){
			return false;
		} else {
			$dom = $html->find('#mainData .table-wrapper .real tbody tr');
			$found=false;
			//For each line into the table, look for the player
			foreach( $dom as $line){
				$playername = $this->clear($line->find('td.name',0)->plaintext);
				if(strcasecmp($playername,$player->name)==0){
					//We found the player, so we create a temp player for future comparation
					$p = new stdClass();
					#Id
					$p->id = $player->id;
					#Rank
					$p->rank = $this->clear($line->find('td.rank span.cell-inner',0)->plaintext);
					$class = explode(" ",$line->find('td.rank',0)->class);
					$p->rank_status = $class[0];
					$p->rank_since = $this->clear($line->find('td.rank .additional',0)->plaintext);
					#Account name
					$p->name = $this->clear($line->find('td.name',0)->plaintext);
					#Character name
					$p->character = $this->clear($line->find('td.charname',0)->plaintext);
					#Wins
					$p->wins = $this->clear($line->find('td.wins span.cell-inner',0)->plaintext);
					$class = explode(" ",$line->find('td.wins',0)->class);
					$p->wins_status = $class[0];
					$p->wins_since = $this->clear($line->find('td.wins .additional',0)->plaintext);
					#Losses
					$p->losses = $this->clear($line->find('td.losses span.cell-inner',0)->plaintext);
					$class = explode(" ",$line->find('td.losses',0)->class);
					$p->losses_status = $class[0];
					$p->losses_since = $this->clear($line->find('td.losses .additional',0)->plaintext);
					#Win Rate
					$p->winpct = $this->clear($line->find('td.winpct',0)->plaintext);
					#Guild
					$p->guild = ucwords($this->clear($player->guild));
					#World
					$p->world = $this->clear($line->find('td.world',0)->plaintext);
					#Last Update
					$p->last_update = $player->last_update;
					#Last Page
					$p->last_page = $player->last_page;
	
					$this->updatePlayer($p);
	
					//The player has been found
					$found = true;
				} 
			}
			unset($dom);
		}
		$html->clear();
		return $found;
	}
	
	/**
	* Update The oldest $count players oldest then $time in seconds between firstrank and lastrank
	* Return TRUE if at last player has be analysed, FALSE otherwise.
	*/
	public function updatePlayers($count, $time = 0, $firstrank = 1, $lastrank = 1000){
		$sql = 	"SELECT * FROM ".$this->mode;
		$sql .= " WHERE `last_update` < (NOW() - INTERVAL ? SECOND)";
		$sql .= " AND `rank` >= ?";
		$sql .= " AND `rank` <= ?";
		$sql .= " ORDER BY `last_update` LIMIT ?";
	        $sel = self::db()->prepare( $sql );
		$sel->bindParam(1, $time, PDO::PARAM_INT);
		$sel->bindParam(2, $firstrank, PDO::PARAM_INT);
		$sel->bindParam(3, $lastrank, PDO::PARAM_INT);
		$sel->bindParam(4, $count, PDO::PARAM_INT);
	        $sel->execute();
	        $sel->setFetchMode( PDO::FETCH_CLASS , "Player");
	        $obj = $sel->fetchAll();
		//var_dump($obj); echo "<br>";
		foreach($obj as $player){
			$found = $this->findPage($player);
			//Update last_update
			if(!$found) $this->updatePlayer($player);
			//echo "<p><strong>Dados na arena net foram encontrados para jogador ".$player->name."? ".($found==true?"Sim":"Not")."</strong></p>";
			//var_dump($player);
		}
		return (sizeof($obj)>0)?true:false;
	}
}
