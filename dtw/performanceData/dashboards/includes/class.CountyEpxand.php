<?php 

/**
* 
*/
// require "../../includes/class.evidenceAction.php";
require "../../includes/db_class.php";

/**
* 
*/
class CountyExpand extends connDB
{
	
	function __construct()
	{
		$this->connDB(); //make db connection
	}


	public STATIC function PERCENT($number){
		return number_format($number)."%";
	}

	public function sum_simple($field,$table,$county_field,$county_value){
		$command="SELECT sum($field) AS sum_simple FROM $table WHERE $county_field = '$county_value' ";
		$this->exec($command);
		$row = $this->single();
		
		
		return $row['sum_simple'];
	}


	public function getCounties(){
		$sql="SELECT county_id,county FROM counties";

		$this->exec($sql);
		$rows = $this->resultset();

		$data=array();
		foreach ($rows as $row){
			$data[]=array(
				'county_id'=>$row['county_id'],
				'county'=>$row['county']
			);
		}

		return $data;

	}

	public function sumPlain($field,$county_id){
		$command="SELECT sum($field) AS sumPlain FROM a_bysch WHERE county_id = '$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['sumPlain'];
	}

	public function numPlain($field,$county_id){
		$command="SELECT COUNT($field) AS sumPlain FROM a_bysch WHERE county_id = '$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['sumPlain'];
	}


	public function sumPlainShisto($field,$county_id){
		$command="SELECT sum($field) AS sumPlain FROM a_bysch WHERE county_id = '$county_id' AND ap_attached='Yes'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['sumPlain'];
	}

	public function numPlainShisto($field,$county_id){
		$command="SELECT COUNT($field) AS sumPlain FROM a_bysch WHERE county_id = '$county_id' AND ap_attached='Yes'";
		$this->exec($command);
		$row = $this->single();
		
		$num = $row ['sumPlain'];                
                 return number_format($num);
               
	}
        
        	
	public function percentageSum($numerator,$denominator,$county_id){
		$numerator=$this->sumPlain($numerator,$county_id);
		$denominator=$this->sumPlain($denominator,$county_id);

		if ($denominator == 0) {
			return 0;
		}else{
			$average = ($numerator / $denominator) * 100;	

			return $average;
		}

	}

	public function percentageSimple($numerator,$denominator){

		if ($denominator == 0) {
			return 0;
		}else{
			$average = ($numerator / $denominator) * 100;

			return $average;
		}

	}

	/**
		* treatment : none
		* table : attnt_bysch
		* no. of parameters : none
		* parameter values : none(count if attnt_total_drugs==1 & attnt_total_poles==1 & attnt_total_forms==1 & attnt_sch_treatment==1) | count if attnt_drugs==1 & attnt_forms==1 & attnt_sch_treatment==0 
		*/
	public function attntWithCriticalMaterials($countyid){
		
		$row37=$this->numAttntFlex4($countyid,'attnt_total_drugs','1','attnt_total_poles','1','attnt_total_forms','1','attnt_sch_treatment','1');
		$row44=$this->numAttntFlex3($countyid,'attnt_total_drugs','1','attnt_total_forms','1','attnt_sch_treatment','0');

		$withCriticalMaterials=$this->remove_comma($row37)+$this->remove_comma($row44);

		return $withCriticalMaterials;


	}	
        public function attntWithCriticalMaterials1($field,$county_id){
		$command="SELECT COUNT($field) AS valueC FROM attnt_bysch WHERE countyid = '$county_id' AND attnt_total_drugs = '1' AND attnt_total_poles = '1' AND attnt_total_forms = '1' AND attnt_sch_treatment = '1'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['valueC'];
	}
        
        public function attntWithCriticalMaterials2($field,$county_id){
		$command="SELECT COUNT($field) AS valueC FROM attnt_bysch WHERE countyid = '$county_id' AND attnt_total_drugs = '1' AND attnt_total_forms = '1' AND attnt_sch_treatment = '0'";
                $total=  $command;
                $this->exec($total);
		$row = $this->single();
		
		return $row ['valueC'];
	}        

	function remove_comma($string){
		$clean_string = str_replace(',', '', $string);
		return $clean_string;
	}
	function numAttntFlex3($by,$field1,$value1,$field2,$value2,$field3,$value3){
		$command="SELECT DISTINCT('$by') AS attnt FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['attnt'];
	}

	function numAttntFlex4($by,$field1,$value1,$field2,$value2,$field3,$value3,$field4,$value4){
		$command="SELECT DISTINCT('$by') AS attnt FROM attnt_bysch WHERE $field1 = $value1 AND $field2 = $value2 AND $field3 = $value3 AND $field4 = '$value4'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['attnt'];
	}

	/**
* treatment : none
* table : any table
* no. of parameters : many
* parameter values : get the values and add them. 
*                    first parameter is the table, 
*					 Second paremeter is the donor. 
*/
public function sumArgsByCountyP(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$county=array_shift($args); // get and remove the donor
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	for ($i=0; $i < $size; $i++) { 
		$total+=$this->sumPlainP($args[$i],$table,$county);
	}

	return $total;
}


public function sumArgsByCountyPShisto(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$county=array_shift($args); // get and remove the donor
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	for ($i=0; $i < $size; $i++) { 
		$total+=$this->sumPlainPShisto($args[$i],$table,$county);
	}

	return $total;
}

public function sumArgsByCounty(){
	
	$args=func_get_args(); // get the args

	$table=array_shift($args); // get and remove the table

	$county_id=array_shift($args); // get and remove the donor

	$county_field=array_shift($args); 
	
	$size=sizeof($args); // get number of items in array
	$total=0;
	for ($i=0; $i < $size; $i++) { 
		$total+=$this->sumPlainByCounty($args[$i],$table,$county_field,$county_id);
	}

	return $total;
}

/**
* treatment : sth and shisto
* table : any tanle
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
public function sumPlainP($field,$table,$county){
	$command="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE county_id = '$county'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['dewormed'];
}

public function sumPlainPShisto($field,$table,$county){
	$command="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE county_id = '$county' AND p_sch_bilharzia = 'Y'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['dewormed'];
}


public function countPlainP($field,$table,$county){
	$command="SELECT count($field) AS dewormed 
			FROM $table
			WHERE county_id = '$county'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['dewormed'];
}

/**
* treatment : sth and shisto
* table : any tanle
* no. of parameters : 2
* parameter values : e.g a_6_m , a_bysch
*/
public function sumPlainByCounty($field,$table,$county_field,$county){
	$command="SELECT SUM($field) AS dewormed 
			FROM $table
			WHERE $county_field = '$county'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['dewormed'];
}

public function numPlainByCounty($field,$table,$county_field,$county){
	$command="SELECT COUNT($field) AS dewormed 
			FROM $table
			WHERE $county_field = '$county'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['dewormed'];
}



	public function query_long(){



		$this->exec($command);
		$row = $this->single();
		
		return $row [''];
	}

} // end class








?>