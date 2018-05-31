<?php

class processmodel extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {

        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    public function getProgramDropDown() {
        $query = 'SELECT DISTINCT program from promoter_details WHERE country='.$_SESSION['country'].' ORDER BY program ASC';
        $data = $this->selectDBraw($query);
     

        return $data;
    }
    public function getGeneralData($table, $fieldsArray=null) {
            
            
         
        $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

          foreach ($fieldsArray as $key => $value) {
                $query .= $table.".".$value.',';
              
          }

          $query .= 'admin_countries.country AS country
              FROM '.$table
                                    .' JOIN admin_countries ON '.$table.'.country = admin_countries.id';
                                    
          }else {
          $query='SELECT * from '.$table;
        }
                       
            $data = $this->selectDBraw($query);

        return $data;
    }
    public function getPromoterData($table, $fieldsArray=null) {            
                
      $query = 'SELECT ';



      if ( !empty($fieldsArray) ) {

        foreach ($fieldsArray as $key => $value) {
                                 // foreach($value["fieldsArray"] as $key2 => $value2){
                                    $query .= $table.".".$value.',';
           
                                 // }
               
                            }

        $query .= 'admin_countries.country AS country
            FROM '.$table
                                  .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                              
                                  .' AND admin_countries.id='.$_SESSION["country"];
            
      } else {
        $query='SELECT * from '.$table;
      }
    
          $data = $this->selectDBraw($query);

      return $data;
    }

    public function getCustomData($table,$fieldsArray=null) {
       
        
                
        $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                               // foreach($value["fieldsArray"] as $key2 => $value2){
                                  $query .= $table.".".$value.',';
               
                               // }
             
                          }

            $query .= 'admin_countries.country AS country,gender_category.gender as gender
                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN gender_category ON '.$table.'.gender = gender_category.id'
                                .' AND admin_countries.id='.$_SESSION["country"];
                            
        } else {
            $query='SELECT * from '.$table;
        }
                       //$query.=' LIMIT 300';
        
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getWHEREData($table='lsm_details',$field='officials',$column='id',$WHERE=1) {

       $query = 'SELECT '.$field.' from ' . $table.' WHERE '.$column.'= '.$WHERE;
       //  echo $query;
       $data = $this->selectDBraw($query);
       return $data;
    }
    public function getData($table,$fieldsArray=null) {
        $query = 'SELECT * from ' . $table;
        $query.=' WHERE country="'.$_SESSION["country"].'"';
       
        $data = $this->selectDBraw($query);

        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        */

        return $data;
    }
      public function getNonCountryData($table,$fieldsArray=null) {
        $query = 'SELECT * from ' . $table;
       
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVcsData($table,$fieldsArray){

      $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,program_setup.program as program

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN program_setup ON '.$table.'.program = program_setup.id '
                                .' AND admin_countries.id='.$_SESSION["country"];
                            
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDispenserData($table,$fieldsArray){

      $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,program_setup.program as program

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN program_setup ON '.$table.'.program = program_setup.id '
                                .' AND admin_countries.id='.$_SESSION["country"];
                            
        }
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getVcsMeetingData($table,$fieldsArray,$program='empty',$order=null){
        
      $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,program_setup.program as program,village_details.village_name as village_name,
                    staff_list.full_name as full_name

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN program_setup ON '.$table.'.program = program_setup.id '
                                .' JOIN village_details ON '.$table.'.village_name = village_details.id '
                                .' JOIN staff_list ON '.$table.'.full_name = staff_list.id ';
                                if($program!='empty'){
                                $query .=' WHERE '.$table.'.program="'.$program.'"'; 
                                } 
                                $query .=' AND admin_countries.id='.$_SESSION["country"];
                                if($order!=null){
                                $query .=' ORDER BY '.$table.'.'.$order.' ASC'; 
                                }
                             
        }
        $data = $this->selectDBraw($query);
        return $data;

    }

    public function getSiteVerificationData($table,$fieldsArray){

        $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,site_verification.program_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN village_details ON '.$table.'.village = village_details.id'
                                .' JOIN site_verification ON '.$table.'.program_id = site_verification.id '
                                .' JOIN staff_list ON '.$table.'.full_name = staff_list.id '
                                .' AND admin_countries.id='.$_SESSION["country"];
                            
        }
        $data = $this->selectDBraw($query);
        return $data;
    }
    public function getSpecificSiteVerificationData($table,$fieldsArray,$verificationId){

        $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,site_verification.program_id_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN village_details ON '.$table.'.village = village_details.id'
                                .' JOIN site_verification ON '.$table.'.program_id = site_verification.id '
                                .' JOIN staff_list ON '.$table.'.full_name = staff_list.id '
                                .' WHERE '.$table.'.site_verification_id="'.$verificationId.'" '
                                .' AND admin_countries.id='.$_SESSION["country"]
                                .' ORDER by '.$table.'.full_name';
        }

       
      
        $data = $this->selectDBraw($query);
       
        return $data;
    }
    public function getVillageVerificationData($table,$fieldsArray,$verificationId){

        $query = 'SELECT ';

        if ( !empty($fieldsArray) ) {

            foreach ($fieldsArray as $key => $value) {
                            
                    $query .= $table.".".$value.',';
               
             }

          $query .= 'admin_countries.country AS country,site_verification.program_id as program_id,
                            village_details.village_name as village,staff_list.full_name as full_name

                    FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN village_details ON '.$table.'.village = village_details.id'
                                .' JOIN site_verification ON '.$table.'.program_id = site_verification.id '
                                .' JOIN staff_list ON '.$table.'.full_name = staff_list.id '
                                .' WHERE '.$table.'.program_id="'.$verificationId.'" '
                                .' AND admin_countries.id='.$_SESSION["country"]
                                .' ORDER by '.$table.'.date,'.$table.'.village ';
        }

       

      
        $data = $this->selectDBraw($query);
     
        return $data;
    }
    public function getExpansionData($table,$fieldsArray=null,$criteria=null,$value=null) {

        if($criteria !=null){
             $query = 'SELECT * from ' . $table.' WHERE '.$criteria.'='.$value ;
        }else{
        $query = 'SELECT * from ' . $table ;
            }
    
        $data = $this->selectDBraw($query);

        return $data;
    }

  

    

  
      /**
       * 
       * @param type $table
       * @param type $fieldsArray
       * @return type
       */  
        
    public function getFlaggedPromoterData($table, $fieldsArray=null) {
            
            
        $lastMonthToday = time() - (30 * 24 * 60 * 60);
         
    		$query = 'SELECT ';

    		if ( !empty($fieldsArray) ) {

    			foreach ($fieldsArray as $key => $value) {
                                   // foreach($value["fieldsArray"] as $key2 => $value2){
                                      $query .= $table.".".$value.',';
    			   
                                   // }
                 
                              }

    			$query .= 'admin_countries.country AS country
    					FROM '.$table
                                    .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                    
                                    .' AND admin_countries.id='.$_SESSION["country"]
                     		  .' WHERE unix_timestamp<='.$lastMonthToday;
                                  	
    		}else {
    			$query='SELECT * from '.$table;
    		}
                       
            $data = $this->selectDBraw($query);

    		return $data;
    }

    		
       /**
        * Get Waterpoint Data is used to search for waterpoints that have not been 
        * communicated to 
        * @param type $lastMonthToday: Unix timestamp representation of the last 30 days
        * @return type No Of Waterpoints flagged that have no contact over the past Month
        */
                
    public function getWaterpointData($lastMonthToday) {
            
            
                
		      $query = 'SELECT count(id) as waterpoints
					FROM promoter_details'
                               .' WHERE promoter_details.unix_timestamp <='.$lastMonthToday
                         
                        . ' AND promoter_details.country='.$_SESSION["country"];
                 			
		
           $data = $this->selectDBraw($query);

		      return $data;
	}
  
   public function getWaterpointName($waterpointId){

      $query = 'SELECT waterpoint_name FROM waterpoint_details WHERE waterpoint_id="'.$waterpointId.'" LIMIT 1';
      
      $data = $this->selectDBraw($query);

      return $data;


   }     
    public function getLogData($table, $fieldsArray=null) {
            
            
                
  		$query = 'SELECT ';

  		if ( !empty($fieldsArray) ) {

  			foreach ($fieldsArray as $key => $value) {
                                 // foreach($value["fieldsArray"] as $key2 => $value2){
                                    $query .= $table.".".$value.',';
  			   
                                 // }
               
                            }

  			$query .= ' staff_category.position as position
  					FROM '.$table
                                  .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                  .' JOIN issue_types ON '.$table.'.issue_type = issue_types.id'
                                  .' JOIN staff_category ON '.$table.'.position = staff_category.id'
                                  
                                  .' AND admin_countries.id='.$_SESSION["country"];
                   			
  		}else {
  			$query='SELECT * from '.$table;
  		}
                       
  		
      $data = $this->selectDBraw($query);

  		return $data;
	  }
	
    public function addData($table, $data) {
        array_pop($data);
        $dd = $this->insertdDB($table, $data);
        // echo "<pre>";var_dump($dd);echo "</pre>";
        // exit();
    }

    public function getFields($table, $fieldsArray = null) {
        $fields = $this->getColMeta($table, $fieldsArray);
        
        return $fields;
    }

    public function getByPK($table, $id, $fieldsArray) {
        $dd = $this->selectDB(
                $table, $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function deleteData($table, $id) {
        
        // echo $id;
        // $query="DELETE FROM admin_assets WHERE id ='$id'";
        // $this->deleteDB($query,$id,'admin_assets');
        $dd = $this->deleteDB($table,$id);
        // echo "<pre>";var_dump($dd);echo "</pre>";
        // exit();
    }

    public function getByID($promoterId) {
        $rows = $this->selectDB(
                $table = "promoter_details", $filds = null, $params = array('id' => $promoterId)
        );


        $data = array(); //create the array
        foreach ($rows as $key => $row) {
            $data[] = array(
                'id' => $row['id'],
                'promoter_name' => $row['promoter_name'],
                'promoter_contact' => $row['promoter_contact'],
                'assistant_promoter_name'=>$row['assistant_promoter_name'],
                'assistant_promoter_contact' => $row['assistant_promoter_contact'],
                'waterpoint_id'=>$row['waterpoint_id']
            );
        }

        return $data;
    }
    public function runRawQuery($query){
        $data=$this->selectDBraw($query);
        return $data;
    }

    public function updateVerification($verificationId,$waterpointId){


      $sql='UPDATE waterpoint_details set verification_id="'.$verificationId.'"';
      $sql.=' WHERE waterpoint_id="'.$waterpointId.'"';

      $result=$this->runRawQuery($sql);
     return null;
    }
    public function getLastURL($url){
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens)-1];
    }
    

}

?>