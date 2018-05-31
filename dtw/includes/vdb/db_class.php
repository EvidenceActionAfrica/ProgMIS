<?php


/**************************************************************************
 *
 * Title:         Class 'connDB' (class_db_pdo.inc.php)
 *
 * Version:       1.3
 *
 * Copyright:     (c) 2012 Volker Rubach - All rights reserved
 *
 * Description:   This class provide a connection handling via PDO to
 *                a MySQL database with execution of all SQL commands.
 *
 *************************************************************************/


class connDB 
    { // Beginn class


    //-------------------------------------------------------------------------
    // Constructor
    //-------------------------------------------------------------------------

    public function connDB()
       {

        $this->dbHost = "127.0.0.1";    // MySQL host name
        $this->dbName = "evidence_action";       // MySQL database name


        //-------------------------------------------------------------------------
        // MySQL account details
        //-------------------------------------------------------------------------

        $this->dbUser = "root";       // MySQL username
        $this->dbPass = "";   // MySQL password

       // Include 'Config File'
       // require_once( 'db_conf.php' );

       // Configure PDO attributes
       $this->confPDO = array(
                              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Causes an exception to be thrown
                              PDO::ATTR_PERSISTENT => false,                 // With TRUE persistent connection activated (connection not closed when script ends)
                              //PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true    // With TRUE the buffered versions of the MySQL API will be used
                             );

       // Establish connection
       try
         {
         $this->dbc = new PDO( "mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass, $this->confPDO );
         }

       // Error handling
       catch( PDOException $errMsg )
         {
         trigger_error( $errMsg->getMessage() . ",E_USER_ERROR" );
         //exit( 1 );
         return false;
         }

       }


    //-------------------------------------------------------------------------
    // Exec
    //-------------------------------------------------------------------------

    // @param   $sql      [String => SQL statement]
    // @param   $params   [Array  => Parameter and values]

    public function exec( $sql, array $params = array() )
       {

       // Check SQL
       try
         {
         // Prepares SQL
         $this->stmt = $this->dbc->prepare( $sql );
         // Bind (Function 'bind')
         if ( count( $params ) > 0 )
            {
            foreach ( $params as $k=>$v )
                    {
                    $this->bind($k, $v);
                    }
            }
         // Execute SQL
         return $this->stmt->execute();
         }

       // Error handling
       catch( PDOException $errMsg )
         {
         // Close connection
         $this->dbc = null;
         trigger_error( $errMsg->getMessage() . ";E_USER_ERROR" );
         //exit( 1 );
         return false;
         }

       }


    //-------------------------------------------------------------------------
    // Bind
    //-------------------------------------------------------------------------

    // @param   $param   [String => Parameter]
    // @param   $value   [Array  => Value]
    // @param   $type    [Array  => Type of the value]

    public function bind( $param, $value, $type = null )
       {
       if ( is_null( $type ) )
          {
          switch ( true )
                 {
                 // Boolen parameter
                 case is_bool( $value ):
                      $type = PDO::PARAM_BOOL;
                      break;
                 // Integer parameter
                 case is_int( $value ):
                      $type = PDO::PARAM_INT;
                      break;
                 // Null parameter
                 case is_null( $value ):
                      $type = PDO::PARAM_NULL;
                      break;
                 // String parameter
                 default:
                      $type = PDO::PARAM_STR;
                 }
          }
          $this->stmt->bindValue( $param, $value, $type );
       }


    //-------------------------------------------------------------------------
    // Single value / row [SELECT]
    //-------------------------------------------------------------------------

    // @return   $result   [Value or Row => Result of select statement]

    public function single()
       {
       // Return result
       return $this->stmt->fetch(PDO::FETCH_ASSOC);
       }


    //-------------------------------------------------------------------------
    // Result set [SELECT]
    //-------------------------------------------------------------------------

    // @return   $result   [Array => Result of select statement]

    public function resultset()
       {
       // Return result
       return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
       }


    //-------------------------------------------------------------------------
    // Row count
    //-------------------------------------------------------------------------

    // @return   $rows   [Integer => Number of rows in the result]

    public function rowCount()
       {
       // Return row count
       return $this->stmt->rowCount();
       }


    } // End class


?>