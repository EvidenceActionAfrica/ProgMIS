<?php 

require "../includes/db_class.php";

/**
* 
*/
class WHOIntro extends connDB
{
	
	private $table_name = 'drugs_who_intro';
	function __construct(argument)
	{
		$this->connDB(); //make db connection
		$this->createTable();


	}



	public function sqlTable(){
		$command="CREATE TABLE ".$this->table_name."(
			id  INT NOT NULL AUTO_INCREMENT,
			country	 variant_cast(variant, type)HAR (30),
			year VARCHAR (30),
			lf VARCHAR (30),
			oncho VARCHAR (30),
			sth VARCHAR (30),
			shisto VARCHAR (30),
			admin_units VARCHAR (30),
			preschool VARCHAR (30),
			sac VARCHAR (30),
			adults_15_and_older	 VARCHAR (30),
			PRIMARY KEY (id)
		)";

		$this->exec($command);

	}

	public function createTable(){

		if ($this->checkIfTableExists() == 0) {
			$this->sqlTable();
		}
	}

	/**
	* Description : check if the assumption version table exists.
	*
	* @param string $end.
	* @return boolean
	*/
	
	public function checkIfTableExists($end){

		$command="SHOW TABLES LIKE $this->table_name";

		$this->exec($command);

		return $count = $this->rowCount();

	}




}// end class


country	
year
lf
oncho
sth
shisto
admin_units
preschool
sac
adults_15_and_older	


