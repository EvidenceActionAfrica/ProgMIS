<?php

class workshop extends Controller {

	public function index($list) {

		$table = $this->getDbTable($list);

	    require 'application/views/_templates/header.php'; //Because of the country session to filter data

		$index_model = $this->loadModel('workshopmodel');
		$fields = $index_model->getFields($table);        
	    $data = $index_model->getAllData($table = $table);

		require 'application/views/dispenserparts/sidebar.php';
		require 'application/views/dispenserparts/workshop/index.php';
	    require 'application/views/_templates/footer.php';

	}

	public function add($list) {

		$table = $this->getDbTable($list);

		if (isset($_POST['add-dispenser-data'])) {

			unset($_POST['add-dispenser-data']);

			$data = array();
			foreach ($_POST as $key => $value) {
				if (is_array($value)) {
					$value = serialize($value);
					$data[$key]= $value;
				} else {
					$data[$key]= $value;				
				}
			}

			$add_model = $this->loadModel('workshopmodel');
			$add_model->addData($table, $data); 	

			$this->index($list);

		} else {

			$this->index($list);

		}		

	}

	public function edit($list,$id) {

		$table = $this->getDbTable($list);

		require 'application/views/_templates/header.php'; //Because of the country session to filter data

		$edit_model = $this->loadModel('workshopmodel');

		if (isset($_POST['update-dispenser-data'])) {

			unset($_POST['update-dispenser-data']);

			$data = array();
			foreach ($_POST as $key => $value) {
				if (is_array($value)) {
					$value = serialize($value);
					$data[$key]= $value;
				} else {
					$data[$key]= $value;				
				}
			}

			$edit_model->editData($table,$data,$params = array('id' => $id ) );

		}

		$fields = $edit_model->getFields($table);        
	    $record = $edit_model->getSingleRecord($table, $id)[0];

		require 'application/views/dispenserparts/sidebar.php';
		require 'application/views/dispenserparts/workshop/edit.php';
	    require 'application/views/_templates/footer.php';	

	}

	public function delete($list,$id,$confirm=null) {
		
		$delete_model = $this->loadModel('workshopmodel');

		if ($confirm==null) {

			require 'application/views/_templates/header.php'; //Because of the country session to filter data
			require 'application/views/dispenserparts/sidebar.php';
			require 'application/views/dispenserparts/workshop/delete.php';
		    require 'application/views/_templates/footer.php';	

		} else {

			$table = $this->getDbTable($list);
		    $delete_model->deleteData($table,$params = array('id'=>$id) );

			$this->index($list=$list);

		}

	}

	public function getDbTable($list) {

		switch ($list) {
			case 'products':
				return $table = 'dispenserparts_productlist';
				break;
			case 'customers':
				return $table = 'dispenserparts_customerlist';
				break;
			case 'suppliers':
				return $table = 'dispenserparts_supplierlist';
				break;			
			default:
				return $table = 'dispenserparts_customerlist';
				break;
		}

	}



}

?>