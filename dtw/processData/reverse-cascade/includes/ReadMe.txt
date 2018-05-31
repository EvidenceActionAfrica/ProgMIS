
/**************************************************************************
 *
 * Title:         Class 'connDB' (class_db_pdo.inc.php)
 *
 * Version:       1.3
 *
 * Copyright:     (c) 2012 Volker Rubach - All rights reserved
 *
 * Description:   This class provide a connection handling via PDO to
 *                a MySQL database and execution of all SQL commands.
 *
 *************************************************************************/
  

 Importend notes
 ---------------
 Save 'class_db_pdo.inc.php' and 'conf_db_pdo.inc.php' under 'CGI-BIN'
 in the root folder. This directory exists in most cases, is not acces-
 sible from outside, but locally executed PHP scripts can access this
 folder and can use the class.

 If the hosting package has not a protected 'CGI-BIN' directory, manual
 a secure directory should be set up, then the class and config stored
 there.

 These measures increase the security against unauthorized access to
 the database, because the credentials are not as freely available!!!


 Include config file in class
 ----------------------------
 The config file should be in the same folder with the class. Then
 it will work automatically. If the file saved in another, please
 change the path in the include statement.

 <code>
 	require_once( 'conf_db_pdo.inc.php' );
 </code>


 Declaration of variables
 ------------------------
 $this->dbHost    CONF: MySQL host name
 $this->dbName    CONF: MySQL database name
 $this->dbUser    CONF: MySQL username
 $this->dbPass    CONF: MySQL password
 $this->confPDO   PDO attributes
 $this->dbc       Database connection
 $errMsg          Error message
 $sql             SQL statement from PHP
 $params          Parameter from PHP [Array]
 $param           Single Parameter for bind
 $value           Value for bind
 $type            Type of the value [Boolen / Integer / Null / String]


 Error handling
 --------------
 trigger_error( $errMsg->getMessage() . ";E_USER_NOTICE" );
 trigger_error( $errMsg->getMessage() . ";E_USER_WARNING" );
 trigger_error( $errMsg->getMessage() . ";E_USER_ERROR" );


 Include class
 -------------
 <code>
   include( '../ <path> /class_db_pdo.inc.php' );
 </code>


 Create instance
 ---------------
 <code>
   $db = new connDB();
 </code>

 Usage: Row count
 ----------------
 To get the number of processed rows, in a SELECT, INSERT, UPDATE, or
 DELETE, you need to call 'rowCount' after the database function.

 <code>
   $count = $db->rowCount();
 </code>


 Usage: 'Single value / row [SELECT]'
 ------------------------------------
 Select that use 'Prepared Statement' and if needed 'Bind Parameter'.
 Returns a single value or an row, that can be directly accessed.

 <code>
   $sql = "SELECT < column > FROM < table >";
   $db->exec($sql, $params);
   $value = $db->single();
   echo $value['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table >";
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table > WHERE < column > = :valuename";
   $params = array(':valuename' => 'value', ...);
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table > WHERE < column_1 > = :valuename_1 AND < column_2 > = :valuename_2";
   $params = array(':valuename_1' => 'value', :valuename_2' => 'value', ...);
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table > WHERE < column_1 > = :valuename_1 OR < column_1 > = :valuename_2";
   $params = array(':valuename_1' => 'value', :valuename_2' => 'value', ...);
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table > WHERE < column > LIKE :valuename";
   $params = array(':valuename' => '%...$', ...);
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>

 <code>
   $sql = "SELECT * FROM < table_1 > a LEFT JOIN < table_2 > b ON a.< column > = b.< column > WHERE < column > = :valuename_1";
   $params = array(':valuename_1' => 'value', ...);
   $db->exec($sql, $params);
   $row = $db->single();
   echo $row['< column >'] . "\n";
 </code>


 Usage: Result set [SELECT]
 --------------------------
 Select query that use 'Prepared Statement' and if needed 'Bind Parameter'.
 Returns an associative array, that can be looped through with 'FOREACH'.

 <code>
   $sql = "SELECT * FROM < table >";
   $db->exec($sql, $params);
   $rows = $db->resultset();
   foreach ($rows as $row)
           {
           echo $row['< column >'] . "\n";
           }
 </code>

 <code>
   $sql = "SELECT * FROM < table > WHERE < column > = :valuename_1";
   $params = array(':valuename_1' => 'value', ...);
   $db->exec($sql, $params);
   $rows = $db->resultset();
   foreach ($rows as $row)
           {
           echo $row['< column >'] . "\n";
           }
  </code>

 <code>
   $sql = "SELECT < column >  FROM < table_1 > a LEFT JOIN < table_2 > b ON a.< column > = b.< column > WHERE < column > LIKE :valuename_1";
   $params = array(':valuename_1' => 'value', ...);
   $db->exec($sql, $params);
   $rows = $db->resultset();
   foreach ($rows as $row)
           {
           echo $row['< column >'] . "\n";
           }
 </code>


 Usage: Run query [INSERT / DELETE / UPDATE / REPLACE]
 -----------------------------------------------------

 <code>
   $sql = "INSERT INTO < table > (< column_1 >, < column_2 >, ... ) VALUES (:valuename_1, :valuename_2, ...)";
   $params = array(':valuename_1' => 'value', ':valuename_2' => 'value', ...);
   $db->exec($sql, $params);
 </code>

 <code>
   $sql = "DELETE FROM < table > WHERE < column_1 > = :valuename_1";
   $params = array(':valuename_1' => 'value');
   $db->exec($sql, $params);
 </code>

 <code>
   $sql = "REPLACE INTO < table > (< column_1 >, < column_2 >, ...) VALUES (:valuename_1, :valuename_2, ...)";
   $params = array(':valuename_1' => 'value', ':valuename_2' => 'value', ...);
   $db->exec($sql, $params);
 </code>

 <code>
   $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
   $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
   $db->exec($sql, $params);
 </code>
