<?php
	/* Database Class */
	class Database extends Controller
	{
		
		/* Build Query based on $query variable */
		/* Example of Bind array(":id" => "1", ":soemthing" => "The value") */
		public function query($query, $bind = null) {
			global $db;
	        
	        $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			/* Prepare Statment */
			$this->statement = $this->db->prepare($query);
			/* Execute Query */
			$this->statement->execute($bind);
		}

		public function count() {
			/* Return Count */
			$result = $this->statement->rowCount();
			return $result;
		}

		public function lastId() {
			$lastId = $this->db->lastInsertId();
			return $lastId;
		}

		public function deleteDB($table,$params,$operator = 'AND') {

			$query  = 'DELETE FROM '.$table.' WHERE ';

			if (!is_array($params)) {

				$query .= 'id ='. $params;				
				$this->query($query);

			} else {

				$i=1; foreach ($params as $key => $value) {
					if ($i == count($params)) {
						$query .= $key.' = :'. $key.' ';
					} else {
						$query .= $key.' = :'. $key.' '.$operator.' ';
					}				
				$i++;}

				$bind = array();
				foreach ($params as $key => $value) {
					$bind[":".$key] = $value;
				}				
			
				$this->query($query,$bind);
			}
			// echo $table;
			// echo $params;
			// echo $query;
			// exit();
		}

		public function selectDB($table, $filds = null, $params = null, $operator = 'AND', $order = null, $limit = null) {

			$query = 'SELECT ';

			if ( !empty($filds) ) {
				$query .= implode (", ", $filds).' FROM '.$table;
			} else {
				$query .= '* FROM '.$table;
			}

			if ( !empty($params) ) {
				$query .= ' WHERE ';
				$c=count($params);
				$i=1;
				foreach ($params as $key => $value) {
					if ($i == $c) {
						$query .= $key.' = :'. $key.' ';
					} else {
						$query .= $key.' = :'. $key.' '.$operator.' ';
					}				
				$i++;}
			}
			if ( !empty($order) ) {
				$query .= ' '.$order['order'].' '.$order['order_field'];
				if ($order['order'] == 'ORDER BY') {
					$query .= ' '.$order['order_type'];
				}
			}
			if ( !empty($limit) ) {
				$query .= ' LIMIT '.$limit;
			}
			if ( !empty($params) ) { 
				$bind = array();
				foreach ($params as $key => $value) {
					$bind[":".$key] = $value;
				}
				$this->query($query,$bind);
			} else {
				$this->query($query);
			}
			//echo $query;
			$results = $this->statement->fetchall(PDO::FETCH_ASSOC);

			return $results;
		}
		
		public function selectDBraw($query,$bind = null) {

			if ($bind == null) {
				$this->query($query);
			} else {
				$this->query($query,$bind);
			}
			$results = $this->statement->fetchall(PDO::FETCH_ASSOC);
			return $results;	
		}
		
		public function insertdDB($table,$data) {
                 
			$query = 'INSERT INTO '.$table;
			$query .= '(';				
			$c=count($data); $i=1; 
			foreach ($data as $key => $value) {
				if ($i == $c) {
					$query .= $key;
				} else {
					$query .= $key.', ';
				}
			$i++;}
			$query .= ')';
			$query .= ' VALUES (';
			$j=1;
			foreach ($data as $key => $value) {
				if ($j == $c) {
					$query .= ':'.$key;
				} else {
					$query .= ':'.$key.', ';
				}
			$j++;}
			$query .= ')';		

			$bind = array();
			foreach ($data as $key => $value) {
				$bind[":".$key] = $value;
			}
			$this->query($query,$bind);
		}

		public function updateDBparams($table,$data,$params,$operator = 'AND') {
                    
			$query = 'UPDATE '.$table.' SET ';
			// $query .= '';				
			$i=1; 
			foreach ($data as $key => $value) {
				if ($i == count($data)) {
					$query .= $key.' = :'.$key;
				} else {
					$query .= $key.' = :'.$key.',';
				}
			$i++;}
			
			$query .= ' WHERE ';

			$j=1;
			foreach ($params as $key => $value) {
				if ($j == count($params)) {
					$query .= $key.' = :'. $key.' ';
				} else {
					$query .= $key.' = :'. $key.' '.$operator.' ';
				}				
			$j++;}

			$bind = array();
			foreach ($data as $key => $value) {
				$bind[":".$key] = $value;
			}
			foreach ($params as $key => $value) {
				$bind[":".$key] = $value;
			}
               // echo $query;     
			$this->query($query,$bind);
		}

		public function updateDB($table,$data,$id) {
                    
			$query = 'UPDATE '.$table.' SET ';
			// $query .= '';				
			$c=count($data); $i=1; 
			foreach ($data as $key => $value) {
				if ($i == $c) {
					$query .= $key.' = :'.$key;
				} else {
					$query .= $key.' = :'.$key.',';
				}
			$i++;}
			
			 $query .= ' WHERE id = '. $id;	

			$bind = array();
			foreach ($data as $key => $value) {
				$bind[":".$key] = $value;
			}
                   
			$this->query($query,$bind);
		}

		public function in_array_r($needle, $haystack, $strict = false) {
		    foreach ($haystack as $item) {
		        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
		            return true;
		        }
		    }

		    return false;
		}

		/* 
		* @ getFieldType - gets the field data type for a specific field in a table.
		* @ param type: text $table = The name oof a data table.
		* @ param type: text $field = A field in the data table.
		*/ 
		public function getColMeta($table, $fieldsArray = null ) {

		    $query = 'SHOW FULL COLUMNS FROM '.$table.'';
		    $this->query($query);
		    $results = $this->statement->fetchall(PDO::FETCH_ASSOC);

			$c = 0;
		    foreach ($results as $key => $value) {
			    if (!empty($fieldsArray) || ($fieldsArray != null) ) {
			    	if (!$this->in_array_r( $value['Field'], $fieldsArray) ) {
			    		unset($results[$c]);
			    	}		    		
			    }
		    $c++;}	

			$results = array_values($results);

			$i = 0;
		    foreach ($results as $key => $value) {

		   		if ( $value['Key'] == 'MUL') {
		   			$query = 'SELECT id,'.$value['Field'].' FROM '. explode('.', $results[$i]['Comment'], 2)[0].' ORDER BY '.$value['Field'].' ASC';
		    		$this->query($query);
		    		$parents = $this->statement->fetchall(PDO::FETCH_ASSOC);
		    		$j=0;
		    		foreach ($parents as $key => $value) {
		    			$results[$i]['parents'] = $parents;
		    		$j++;}	
		   		}

		   		$i++;
			}

		    return $results;
		}

		/**
		* Description : Update table.
		*
		* @param int $id
		* @param string $table
		* @param mixed $data
		*/
		public function updateData($data,$id,$table){
            array_pop($data);       
            $this->updateDB($table,$data,$id);                        
        }


	}

?>
