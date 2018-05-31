<?php

class continuous extends Controller {

    public $model;

    public function index() {
    	$scheduleModel=$this->loadModel('schedulemodel');
    	$programDropDown=$scheduleModel->getProgramDropDown();
        require 'application/views/_templates/header.php';
        require 'application/views/process/continuous/index.php';
        require 'application/views/_templates/footer.php';
    }
 
    public function checkProgram(){


    $scheduleModel=$this->loadModel('schedulemodel');
    $surveryData=$scheduleModel->getSurveyData('surveyor_temp',$_POST['program']);
    $tabActive='tab2';
	 $programDropDown=$scheduleModel->getProgramDropDown();
    require 'application/views/_templates/header.php';
    require 'application/views/process/continuous/index.php';
    require 'application/views/_templates/footer.php';	


    }
    public function uploadSurveyorlist($table){
      if (isset($_POST['upload-verification'])) {
        if ($_FILES["file"]["error"] > 0) {
          $status='F';
         // header('Location:'.URL.'expansion/sVerificationUpload/?status='.$status);
        }else {
          $temp = $_FILES["file"]["tmp_name"];
          $filename = $this->upload_image($temp);
          //$this->insertFile($filename, $table);
          $this->setCsv($filename,$table);
          $status='U';
        }
        
       }
     
      header('Location:'.URL.'continuous/?status='.$status);
      
    }
    public function upload_image($image_temp){
        $album_name=substr(sha1(uniqid('moreentropyhere')),0,10);
        
        $image_file=$album_name.'.csv';
        $path=__DIR__.'/upload/'.$image_file;
       // $path=str_replace('\\','\\\\',$path);
        move_uploaded_file($image_temp, $path);
        return $path;
    }
  

 }

 ?>