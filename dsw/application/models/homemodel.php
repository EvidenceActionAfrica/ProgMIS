<?php

//require_once(INC.'application/libs/db.php');

class HomeModel extends Database {

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

    /*
     * The things we need so far when loading home page are
     * 1.The Country Set
     * 2.Issues Pending for the respective user
     */
    /*
      public function getAll() {

      $return = $this->selectDB(
      'staff_list',
      array('id','employee_id'),
      array('id'=>'1','position'=>'Associate Co-ordinator'),
      'OR',
      array('order' => 'GROUP BY','order_field'=>'position', 'order_type' => 'DESC'),
      '20'
      );




      return $return;

      }
     */

    public function getData() {

            $query = 'SELECT country from admin_countries'.' WHERE id='.$_SESSION["country"];
      $data = $this->selectDBraw($query);

      $countryName=$data[0]["country"];
        return $countryName;
       
    }

}
?>