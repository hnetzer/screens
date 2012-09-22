<?php

class Theatre 
{
	private $_id;
	private $_topic;
	private $_description;
	private $_reel_id;
	private $_start_time;
	private $_num_viewers;
	private $_reel_count;
	

	public function Id() {
		return $this->_id;
	}
	
	public function Topic($topic) {
		if($topic) {
			$this->_topic = $topic;
		}
		return $this->_topic;
	}
	
	
	public function ReelCount() {
		return $this->_reel_count;
	}
	
	public function ReelId($reelId) {
		if($reelId) {
			$this->_reel_id = $reelId;
		}
		return $this->_reel_id;
	}
	
	public function StartTime($set) {
		if($set) {
			$this->_start_time = date_create();
		}
		return $this->_start_time;
	}
	
	public function Description($desc) {
		if($desc) {
			$this->_description = $desc;
		}
		return $this->_description;
	}
	
	public function NumViewers() {
		return $this->_num_viewers;
	}
	
	public function ToAssocArray() 
	{
		$arr = array ('id'=> $this->_id, 'topic' => $this->_topic, 'description' => $this->_description);
		return $arr;
	}
	
	public function UpdateCurrentVideo($reel_id) {
		$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE theatres " .
				"SET start_time = :start_time, reel_id = :reelId " .
				"WHERE id = :id ");
		$successful = $preparedStatement->execute(array( ':start_time' => Util::DatabaseDateTime($this->_start_time), ':id' => $this->_id,
												':reelId' => $reel_id));
		
		if($successful) {
			return $reel_id;
		}else {
			return null;
		}
	}
	
	public function IncrementNumViewers() {
		if((!$this->_num_viewers) || ($this->_num_viewers < 0)) {
			$this->_num_viewers = 1;
		} else {
			$this->_num_viewers = (int)$this->_num_viewers + 1;
		}
		$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE theatres " .
				"SET num_viewers = :num " .
				"WHERE id = :theatre_id ");
		$successful = $preparedStatement->execute(array(':num' => $this->_num_viewers, ':theatre_id' => $this->_id));
		
		if($successful) {
			return $this->_num_viewers;
		}else {
			return null;
		}
	}
	
	public function DecrementNumViewers() {
		if((!$this->_num_viewers) || ($this->_num_viewers < 0)) {
			$this->_num_viewers = 0;
		} else {
			$this->_num_viewers = (int)$this->_num_viewers - 1;
		}
		$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE theatres " .
				"SET num_viewers = :num " .
				"WHERE id = :theatre_id ");
		$successful = $preparedStatement->execute(array(':num' => $this->_num_viewers, ':theatre_id' => $this->_id));
		
		if($successful) {
			return $this->_num_viewers;
		}else {
			return null;
		}
	}
			
	public function FindByTopic($topic) {
		$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT topic, description, id " .
				"FROM theatres " .
				"WHERE topic = :topic");
			$successful = $preparedStatement->execute(array( ':topic' => $topic));
			$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				$theatre = new Theatre();
				$theatre->_topic = $row['topic'];
				$theatre->_description = $row['description'];
				$theatre->_id = $row['id'];
				return $theatre;
			} 
			else
			{
				return NULL;
			}		
	}
	
	public function FindById($id) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT topic, description, id, reel_id, start_time, num_viewers " .
				"FROM theatres " .
				"WHERE id = :id");
			$successful = $preparedStatement->execute(array( ':id' => $id));
			$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				$theatre = new Theatre();
				$theatre->_topic = $row['topic'];
				$theatre->_description = $row['description'];
				$theatre->_id = $row['id'];
				$theatre->_start_time = date_create($row['start_time']);
				$theatre->_reel_id = $row['reel_id'];
				$theatre->_num_viewers = $row['num_viewers'];
				return $theatre;
			} 
			else
			{
				return NULL;
			}
	}
	
	public static function FindAllWithReelCount() {
		$preparedStatement = DB::Prepare( // defined in connection.php
			'SELECT t.topic, t.description, t.id, COUNT(r.id) as "reel_count" ' .
			'FROM theatres t, reels r '.
			'WHERE t.id = r.theater_id ' .
			'GROUP BY r.theater_id '. 
			'ORDER BY COUNT(r.id) DESC ');
		$successful = $preparedStatement->execute();
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
			
		$theatres = array();
		
		foreach($rows as $row) {
			$theatre = new Theatre();
			$theatre->_topic = $row['topic'];
			$theatre->_description = $row['description'];
			$theatre->_id = $row['id'];
			$theatre->_reel_count = $row['reel_count'];
			
				
			$theatres[] = $theatre;
		} 
		return $theatres;
	}
	
	public static function SearchByName($searchstring){
		$preparedStatement = DB::Prepare(
			'SELECT distinct t.topic, t.description, t.id, COUNT(r.id) as "reel_count"' .
			'FROM reels r, theatres t ' .
			'WHERE (r.title LIKE :searchstring ' .
			'AND r.theater_id = t.id) ' .
			'GROUP BY r.theater_id ' . 
			'ORDER BY COUNT(r.id) DESC ');
	

		if ($searchstring === '*') {
			$searchstring = '';
		} else {
			$searchstring = str_replace('%', '\%', $searchstring);
			$searchstring = str_replace('_', '\_', $searchstring);
		}

		$preparedStatement->execute(array(':searchstring' => "%".$searchstring."%"));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);

		$theatres = array();
		foreach ($rows as $row) {
			$theatre = new Theatre();
			$theatre->_topic = $row['topic'];
			$theatre->_description = $row['description'];
			$theatre->_id = $row['id'];
			$theatre->_reel_count = $row['reel_count'];
					
			$theatres[] = $theatre;
		}

		return $theatres;
	}		

	public function Save()  {
		if($this->_topic && $this->_description ) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"INSERT INTO theatres (topic, description, num_viewers) " .
				"VALUES (:topic, :description, :num_viewers)");
			$successful = $preparedStatement->execute(array( ':topic' => $this->_topic,
			 ':description' => $this->_description, ':num_viewers' => '1'));
			if ($successful) {
				$this->_id = (int)DB::LastInsertId();
				return $this->_id;
			} 
			else
			{
				return NULL;
			}
		}
	}
	
}
