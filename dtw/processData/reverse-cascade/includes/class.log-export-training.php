<?php 
  /**
  * 
  */
  // require "global.php";
  require "../../includes/class.evidenceAction.php";
  
error_reporting(E_ALL ^ E_NOTICE);
  class logExport extends evidenceAction
  {
    Public $db;  

    Public $hello="Hello";

    public $table_name ="reverse_log_export_training";
    public $table_rollout ="rollout_activity";
    Public $no_data= 'N/A';

    function __construct(){
      $this->connDB(); //make db connection
    }

    public function create(){
        
        // add all the values together in the array
        $arg_list = func_get_args();
        $id="";

      $sql="INSERT INTO $this->table_name VALUES(
              :id,
              :district_id,
              :division_id,
              :end_date,
              :ttrb_qty,
              :ttrb_received,
              :ttrb_couriered
              
              )";

      $params = array(':id'=>$id,
              ':district_id'    => $arg_list[0],
              ':division_id'    => $arg_list[1],
              ':end_date'     => $arg_list[2],
              ':ttrb_qty' => $arg_list[3],
              ':ttrb_received' => $arg_list[4],
              ':ttrb_couriered' => $arg_list[5]      

               );


      //execute the insert
      $this->exec($sql,$params);

         $sql = "SELECT * FROM reverse_log_export_planning";
         $this->exec($sql);
         $row = $this->single();

         // echo "<pre>";var_dump($row);echo "</pre>";

    }

  public function getWarning(){
      echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign glyphicon-ok-sign-blue warning"></span>';
      //echo '<span title="OK. All forms received" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';

    }

    public function getAll(){

      $sql = "SELECT * FROM reverse_log_export_training";
      $this->exec($sql);
      $rows = $this->resultset();

      $data = array();
      foreach ($rows as $row){
        $data[] = array(
                'id'      => $row['id'],
                'district_id'   =>$row['district_id'],
                'division_id'   =>$row['division_id'],
                'ttrb_qty'      =>$row['ttrb_qty'],
                'ttrb_received' =>$row['ttrb_received'],
                'ttrb_couriered' =>$row['ttrb_couriered']           
                           
                );  
      }

      return $data;
    }

    /**
    * Description : this checks whether all documents have been received.
    *
    * @param string  $form_type
    * @param int  $district_id
    */
    
    public function formsReturned($district_id,$form_type){
      $command="SELECT * FROM $this->table_name WHERE district_id = '$district_id' AND form_type = '$form_type'";
      $this->exec($command);
      $row = $this->single();
      $expected= $row['expected'];
      $received= $row['received'];
      $stamp_range= $row['stamp_range'];
      $scrutiny= $row['scrutiny'];
      $scanning= $row['scanning'];
      $courier= $row['courier'];

      $variance=$expected-$received;

      if ($variance==0 && $stamp_range != 'N' && $scrutiny == 'Y' && $scanning == 'Y' && $courier != 'N') {
        return 1;
      }else{
        return 0;
      }

    }

    public function getById($id){
      (int)$id;
      $sql="SELECT * FROM reverse_log_export_planning WHERE id=:id";
         $params = array(':id' => $id);
         $this->exec($sql, $params);
         $rows = $this->resultset();
         foreach ($rows as $row){
               $data[] = array(
                'id'=> $row['id'],
                'district_id'   =>$row['district_id'],
                'division_id'   =>$row['division_id'],
                'ttrb_qty'      =>$row['ttrb_qty'],
                'ttrb_received' =>$row['ttrb_received'],
                'ttrb_couriered' =>$row['ttrb_couriered']   
                       
                );
          }

          return $data;
    }
    //We are updating different Forms with different parameters
    //So we have 3 different update  forms ro cater for various form types

    //updates Form P and MT
    public function update(){
      // get the args into an array
      $arg_list = func_get_args();

        $sql="UPDATE $this->table_name SET
            ttrb_qty = :ttrb_qty,
            ttrb_received = :ttrb_received,
            ttrb_couriered = :ttrb_couriered     
            WHERE id    =:id ";

      
      $params = array(
        'id'      =>$arg_list[0],
        'ttrb_qty' => $arg_list[1],
        'ttrb_received' => $arg_list[2],
        'ttrb_couriered' => $arg_list[3] 
        
        );
      //execute the update
      $d=$this->exec($sql,$params);
      echo($params);

    }


    public function delete($id){
      $command="DELETE FROM $this->table_name WHERE id ='$id'";
      $this->exec($command);
    }

      public function getRolloutData(){

      //$sql = "SELECT actyvity_county, activity_venu, activity_division, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_venu IS NOT NULL AND activity_type='4' GROUP BY activity_venu";
      // $sql = "SELECT county_id, district_id FROM districts";  
      $sql = "SELECT district_id, division_id FROM divisions";          
      $this->exec($sql);
      $rows = $this->resultset();
      $null="N";
      $date="";
      $null_date="N";
      foreach ($rows as $row){  
        $district_id =$row['district_id'];
        $division_id =$row['division_id'];
        $sql5 ="INSERT  IGNORE INTO `reverse_log_export_training` (`district_id`, `division_id`)
        VALUES ('$district_id', '$division_id')";
        $this->exec($sql5); 
       
      
      } // end foreach
      //$this->updateDates();
    }

    public function getDis($dist_name){
      $sql="SELECT division_id  FROM schools WHERE division_id =:division_id ";
      $params = array(':division_id' => $dist_name);
      $this->exec($sql,$params);
      $name = $this->single();

      return $name['division_id'];
      }
  
  }// end class
 ?>
