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

    public $table_name ="reverse_log_export_treatment";
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
              :moh_517c_received,
              :moh_517c_couriered,
              :moh_517d_received,
              :moh_517d_couriered,
              :moh_517e_received,
              :moh_517e_qty,
              :moh_517e_couriered)";

      $params = array(':id'=>$id,
              ':county_id'    => $arg_list[0],
              ':district_id'    => $arg_list[1],  
              ':moh_517c_received'   => $arg_list[2],
              ':moh_517c_couriered'   => $arg_list[3],
              ':moh_517d_received'   => $arg_list[4],
              ':moh_517d_couriered'   => $arg_list[5],
              ':moh_517e_received'   => $arg_list[6],
              ':moh_517e_qty'   => $arg_list[7],
              ':moh_517e_couriered'   => $arg_list[8] );


      //execute the insert
      $this->exec($sql,$params);

         $sql = "SELECT * FROM reverse_log_export_treatment";
         $this->exec($sql);
         $row = $this->single();

         // echo "<pre>";var_dump($row);echo "</pre>";

    }

    public function getWarning(){
      echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign glyphicon-ok-sign-blue warning"></span>';
      //echo '<span title="OK. All forms received" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';

    }


    public function getAll(){

      $sql = "SELECT * FROM reverse_log_export_treatment";
      $this->exec($sql);
      $rows = $this->resultset();

      $data = array();
      foreach ($rows as $row){
        $data[] = array(
                'id'      => $row['id'],
                'district_id'   =>$row['district_id'],
                'moh_517c_received' =>$row['moh_517c_received'],
                'moh_517c_couriered' =>$row['moh_517c_couriered'],
                'moh_517d_received' =>$row['moh_517d_received'],
                'moh_517d_couriered' =>$row['moh_517d_couriered'],
                'moh_517e_received' =>$row['moh_517e_received'],
                'moh_517e_qty' =>$row['moh_517e_qty'],
                'moh_517e_couriered'=>$row['moh_517e_couriered']                                    
                );  
      }

      return $data;
    }



    public function getById($id){
      (int)$id;
      $sql="SELECT * FROM reverse_log_export_treatment WHERE id=:id";
         $params = array(':id' => $id);
         $this->exec($sql, $params);
         $rows = $this->resultset();
         foreach ($rows as $row){
               $data[] = array(
                'id'=> $row['id'],
                'district_id'   =>$row['district_id'],
                'moh_517c_received' =>$row['moh_517c_received'],
                'moh_517c_couriered' =>$row['moh_517c_couriered'],
                'moh_517d_received' =>$row['moh_517d_received'],
                'moh_517d_couriered' =>$row['moh_517d_couriered'],
                'moh_517e_received' =>$row['moh_517e_received'],
                'moh_517e_qty' =>$row['moh_517e_qty'],
                'moh_517e_couriered'=>$row['moh_517e_couriered']         
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
            moh_517c_received   = :moh_517c_received,
            moh_517c_couriered = :moh_517c_couriered,
            moh_517d_received = :moh_517d_received,
            moh_517d_couriered = :moh_517d_couriered,
            moh_517e_received = :moh_517e_received ,
            moh_517e_qty = :moh_517e_qty,
            moh_517e_couriered = :moh_517e_couriered

            WHERE id    =:id ";

              
      $params = array(
        'id'      =>$arg_list[0],
        ':moh_517c_received'   =>$arg_list[1],
        ':moh_517c_couriered'   =>$arg_list[2],
        ':moh_517d_received'   =>$arg_list[3],
        ':moh_517d_couriered'   =>$arg_list[4],
        ':moh_517e_received'   =>$arg_list[5],
        ':moh_517e_qty'   =>$arg_list[6],
        ':moh_517e_couriered'   =>$arg_list[7]
        );
      //execute the update
      $d=$this->exec($sql,$params);
      var_dump($params);

      print_r($params);

    }

    public function delete($id){
      $command="DELETE FROM $this->table_name WHERE id ='$id'";
      $this->exec($command);
    }

      public function getRolloutData(){

      //$sql = "SELECT actyvity_county, activity_venu, activity_division, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_venu IS NOT NULL AND activity_type='4' GROUP BY activity_venu";
      // $sql = "SELECT county_id, district_id FROM districts";  
      $sql = "SELECT district_id FROM districts";          
      $this->exec($sql);
      $rows = $this->resultset();
      $null="N";
      $date="";
      $null_date="N";
      foreach ($rows as $row){  
        $district_id =$row['district_id'];

        $sql5 ="INSERT  IGNORE INTO `reverse_log_export_treatment` (`district_id`)
        VALUES ('$district_id')";
        $this->exec($sql5); 
       
      
      } // end foreach
      //$this->updateDates();
    }

    public function getDis($dist_name){
      $sql="SELECT district_id  FROM schools WHERE district_id =:district_id ";
      $params = array(':district_id' => $dist_name);
      $this->exec($sql,$params);
      $name = $this->single();

      return $name['district_id'];
      }
  
  }// end class
 ?>
