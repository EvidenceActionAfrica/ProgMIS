<?php
class EvidenceAction {
	//insert
	function insert($tablename, $fields){
		//echo "INSERT INTO ".$tablename." SET ".$fields;
		mysql_query("INSERT INTO ".$tablename." SET ".$fields);
		$lastinsertid = mysql_insert_id();
		return $lastinsertid;
	}
	//selectarray for list
	function selectarray($tablename, $fields, $where){
		//echo "SELECT ".$fields." FROM ".$tablename." WHERE ".$where;
		$selectarray = mysql_fetch_array(mysql_query("SELECT ".$fields." FROM ".$tablename." WHERE ".$where));
		return $selectarray;
	}
	//selectarray for all
	function mysql_fetch_all($tablename, $fields, $where, $kind = '') {
		$query = "SELECT ".$fields." FROM ".$tablename." WHERE ".$where." ".$kind;
		//echo $query;
		$result = mysql_query($query);
		$resultc = array();
		if(mysql_num_rows($result)>0)
		{
		 while($row = mysql_fetch_array($result)){
		 	 	array_push($resultc, $row);
			}
		}
		return $resultc;
	}
	//selectrow
	function selectrow($tablename, $fields, $where){
		//echo "SELECT ".$fields." FROM ".$tablename." WHERE ".$where;
		$selectrow = mysql_fetch_array(mysql_query("SELECT ".$fields." FROM ".$tablename." WHERE ".$where));
		return $selectrow;
	}
	//update
	function update($tablename, $fields, $where){
		//echo "UPDATE ".$tablename." SET ".$fields." WHERE ".$where;
		mysql_query("UPDATE ".$tablename." SET ".$fields." WHERE ".$where);
	}
	//createtable
	function createtable($tablename){
		mysql_query("CREATE TABLE IF NOT EXISTS ".$tablename." (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	}
	//addfieldtotable
	function addfieldtotable($tablename, $fieldname){
		//echo "ALTER TABLE ".$tablename."  ".$fieldname;
		mysql_query("ALTER TABLE ".$tablename."  ".$fieldname);
	}
	//check session
	function checksession(){
		if(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']) && isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])){
			
		}else{
			header('Location:index.php');
    		exit();
		}
	}
	//not check session
	function notchecksession(){
		if(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']) && isset($_SESSION['admin_name']) && !empty($_SESSION['admin_name'])){
			header('Location:dashboard.php');
    		exit();
		}else{
			
		}
	}
	
}
?>