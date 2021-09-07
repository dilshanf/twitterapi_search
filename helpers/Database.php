<?php
	class Database{
		public $connection;
		
		public function __construct(){
			
			mysqli_report(MYSQLI_REPORT_STRICT);
			
			$this->connection = null;
			try{
				$this->connection = new mysqli(getenv('DATABASE_SERVER'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'), getenv('DATABASE_NAME'));
			}
			catch(Exception $exception){
				throw new \Exception("Connection error: " . $exception->getMessage());
			}
		}
		
		public function Insert($table, array $rows){
			$rows = $this->sqlWithArray($this->connection,$rows);
			
			$keys = "(".implode(" ,", array_keys($rows)).")";
			$values = " VALUES (".implode(" ,", array_values($rows)).")";
			
			$query = "INSERT INTO $table $keys $values";
			
			return $this->Execute($query);
		}
		
		private function Execute($query){
			
			$return             = array();
			$execute = $this->Query($query);
			
			// duplicate
			if (mysqli_errno($this->connection) == 1062) {
				return true;
			}
			
			if($execute === false){
				$e = mysqli_error($this->connection);
				
				return false;
			}
			if(!is_bool($execute)){
				while($row = mysqli_fetch_array($execute)){
					$return[] = $row;
				}
			}
			return $return;
		}
		
		protected function Query($query){
			
			$execute = mysqli_query($this->connection,$query);
			
			if(!$execute){
				$e = mysqli_error($this->connection);
			}
			return $execute;
		}
		
		public function sqlWithArray($connection,$array){
			$return = array();
			foreach($array as $field=>$val){
				$return[$field] = "'".mysqli_real_escape_string($connection,htmlspecialchars($this->Value($val)))."'";
			}
			return $return;
		}
		
		public function Value($val){
			return trim($val);
		}
		
	}
?>