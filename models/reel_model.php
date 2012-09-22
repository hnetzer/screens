<?php

class Reel
{
	private $_id;
	private $_theater_id;
	private $_url;
	private $_thumb_url;
	private $_user_id;
	private $_title;
	private $_upvotes = 0;
	private $_downvotes = 0;
	private $_duration; //time of video in secs
	private $_view_count;

	public function ViewCount($viewCount)
	{
		if($viewCount) {
			$this->_view_count =  $viewCount;
		}
		return $this->_view_count;
	}
	
	public function Id()
	{
		return $this->_id;
	}
	
	public function Upvotes($upvotes)
	{
		if($upvotes)
			$this->_upvotes = $this->_upvotes + 1;
		return $this->_upvotes;
	}
		
	public function Downvotes($downvotes)
	{
		if($downvotes)
			$this->_downvotes = $this->_downvotes + 1;
		return $this->_downvotes;
	}
	
	public function Duration($duration)
	{
		if($duration) {
			$this->_duration = $duration;
		}
		return $this->_duration;
	}
	
	public function TheaterId($theater_id)
	{
		if($theater_id)
		{
			$this->_theater_id = $theater_id;
		}
		return $this->_theater_id;
	}
	
	public function ThumbUrl($thumbUrl) {
		if($thumbUrl) {
			$this->_thumb_url = $thumbUrl;
		}
		return $this->_thumb_url;
	}
	
	public function Title($title) {
		if($title) {
			$this->_title = $title;
		}
		return $this->_title;
	}
	
	public function Url($url)
	{
		if($url)
		{
			$this->_url = $url;
		}
		return $this->_url;
	}
	
	public function UserId($user_id)
	{
		if($user_id)
		{
			$this->_user_id = $user_id;
		}
		return $this->_user_id;
	}
	
	public function AddVideo() 
	{
		if($this->_theater_id && $this->_url
			&& $this->_user_id && $this->_thumb_url && $this->_title)
		{
			$preparedStatement = DB::Prepare( // defined in connection.php
					"INSERT INTO reels (theater_id,url,user_id, thumb_url, title, duration) " .
					"VALUES (:theater_id, :url, :user_id, :thumb_url, :title, :duration)");
			$successful = $preparedStatement->execute(array( ':theater_id' => $this->_theater_id,
			 ':url'=> $this->_url, ':user_id'=>$this->_user_id, ':thumb_url' => $this->_thumb_url,
			 ':title' => $this->_title, ':duration' => $this->_duration));
			if ($successful) {
				$this->_id = (int)DB::LastInsertId();
				return $this->_id;
			}
			else
			{
				return NULL;
			}
		} else {
			return NULL;
		}
	}
	
	public function IncrementViewCount()
	{
		$count = (int)$this->_view_count + 1;
		$preparedStatement = DB::Prepare( // defined in connection.php
				"UPDATE reels ".
				"SET viewcount=:views ".
				"WHERE id=:id ");
		$successful=$preparedStatement->execute(array(":views"=>$count, ":id" => $this->_id));
		return $count;
	}
	
	public function GetDownvotes()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT downvotes " .
				"FROM reels " .
				"WHERE id =:id ".
				"AND theater_id = :theatreId ".
				"ORDER BY id LIMIT 1");
		$successful = $preparedStatement->execute(array( ":id" => $this->_id, ":theatreId" => $this->_theater_id));
		$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
		//return $row;
		return $row;
	}
	
	public function Upvote()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
			"UPDATE reels ".
			"SET upvotes=upvotes+1 ".
			"WHERE id=:id ".
			"AND theater_id=:theatreID");
		$successful=$preparedStatement->execute(array( ":id" => $this->_id, ":theatreID" => $this->_theater_id));
		return $successful;		
	}
	
	public function Downvote()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
			"UPDATE reels ".
			"SET downvotes=downvotes+1 ".
			"WHERE id=:id ".
			"AND theater_id=:theatreID");
		$successful=$preparedStatement->execute(array( ":id" => $this->_id, ":theatreID" => $this->_theater_id));
		return $successful;		
	}
	
	public function RemoveUpvote()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
			"UPDATE reels ".
			"SET upvotes=upvotes-1 ".
			"WHERE id=:id ".
			"AND theater_id=:theatreID");
		$successful=$preparedStatement->execute(array( ":id" => $this->_id, ":theatreID" => $this->_theater_id));
		return $successful;		
	}

	public function RemoveDownvote()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
			"UPDATE reels ".
			"SET downvotes=downvotes-1 ".
			"WHERE id=:id ".
			"AND theater_id=:theatreID");
		$successful=$preparedStatement->execute(array( ":id" => $this->_id, ":theatreID" => $this->_theater_id));
		return $successful;		
	}
	
	public function UpdateVotes()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
			"UPDATE reels ".
			"SET upvotes=:upv, ".
			"downvotes=:downv ".
			"WHERE id=:id ".
			"AND theater_id=:theatreID");
		$preparedStatement->bindParam(':upv',$this->_upvotes,PDO::PARAM_INT);
		$preparedStatement->bindParam(':downv',$this->_downvotes,PDO::PARAM_INT);
		$preparedStatement->bindParam(':id',$this->_id,PDO::PARAM_INT);
		$preparedStatement->bindParam(':theatreID',$this->_theater_id,PDO::PARAM_INT);
		$successful=$preparedStatement->execute();
		return $successful;
	}
		
	public function GetUpvotes()
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT upvotes " .
				"FROM reels " .
				"WHERE id =:id ".
				"AND theater_id = :theatreId ".
				"ORDER BY id LIMIT 1");
		$successful = $preparedStatement->execute(array( ":id" => $this->_id, ":theatreId" => $this->_theater_id));
		$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public static function GetNextByTheatreId($prevReelId, $theatreId)
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT * " .
				"FROM reels " .
				"WHERE id <>:prevReelId ".
				"AND theater_id = :theatreId ".
				"ORDER BY viewcount asc, upvotes/(upvotes+downvotes) desc, id asc LIMIT 1");
		$successful = $preparedStatement->execute(array( ":prevReelId" => $prevReelId, ":theatreId" => $theatreId));
		if($preparedStatement->rowCount()==0)
		{
			$preparedStatement = DB::Prepare( // defined in connection.php
					"SELECT * " .
					"FROM reels " .
					"WHERE theater_id = :theatreId " .
					"ORDER BY id LIMIT 1");
			$successful = $preparedStatement->execute(array(":theatreId" => $theatreId));
		}
		$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
		if($row) {
			$reel = new Reel();
			$reel->_id = $row['id'];
			$reel->_theater_id = $row['theater_id'];
			$reel->_url = $row['url'];
			$reel->_user_id = $row['user_id'];
			$reel->_thumb_url = $row['thumb_url'];
			$reel->_title = $row['title'];
			$reel->_duration = $row['duration'];
			$reel->_view_count = $row['viewCount'];
			$reel->_upvotes=$row['upvotes'];
			$reel->_upvotes=$row['downvotes'];
			return $reel;
		} else {
			return NULL;
		}
	}
	
	public static function FindById($id) {
		if($id) {
			$preparedStatement = DB::Prepare( // defined in connection.php
				"SELECT * FROM reels " .
				"WHERE id = :id");
			$successful = $preparedStatement->execute(array(':id' => $id));
			$row = $preparedStatement->fetch(PDO::FETCH_ASSOC);
			if($row) {
				$reel = new Reel();
				$reel->_id = $row['id'];
				$reel->_theater_id = $row['theater_id'];
				$reel->_url = $row['url'];
				$reel->_user_id = $row['user_id'];
				$reel->_thumb_url = $row['thumb_url'];
				$reel->_title = $row['title'];
				$reel->_duration = $row['duration'];
				$reel->_view_count = $row['viewCount'];
				$reel->_upvotes=$row['upvotes'];
				$reel->_upvotes=$row['downvotes'];
				return $reel;
			} else {
				return NULL;
			}
		}
		return NULL;
	}
	
	public static function FindByTheaterId($theater_id)
	{
		$preparedStatement = DB::Prepare( // defined in connection.php
							"SELECT * FROM reels " .
							"WHERE theater_id = :theater_id");
		$successful = $preparedStatement->execute(array(':theater_id' => $theater_id));
		$rows = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
		$reels = array();
		if($rows) {
			foreach($rows as $row) {
				$reel = new Reel();
				$reel->_id = $row['id'];
				$reel->_theater_id = $row['theater_id'];
				$reel->_url = $row['url'];
				$reel->_user_id = $row['user_id'];
				$reel->_thumb_url = $row['thumb_url'];
				$reel->_title = $row['title'];
				$reel->_duration = $row['duration'];
				$reel->_view_count = $row['viewCount'];
				
				$reels[] = $reel;
			}
		}
		return $reels;
	}
		
	public static function SearchByName($searchstring){
		$preparedStatement = DB::Prepare(
			"SELECT topic " .
			"FROM reels r, theatres t " .
			"WHERE r.title LIKE :searchstring " .
			"AND r.theatre_id = t.id");

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
			$reel = new topic();
			$topic->_id = $row['id'];
			$topic->_name = $row['name'];
			$topic->_datetime = date_create($row['datetime']);
			
			$topics[] = $topic;
		}

		return $topics;
	}	
}