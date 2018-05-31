<?php

class surveytracker extends Controller {

    public $model;

    public function index() {
        header('location: ' . URL . 'surveytracker/tracker');
    }

    /**
     * The survey Tracker Is Primarily used by the Promoter thus you see promoterId & message as the parameters.
     * With The other users these parameters are automatically null.
     * The Parameters are used to fill in 
     * @param type $created_by:The AAc/CSA/Staff Who is currently logged in
     * @param type $message:Their Remarks saved in the Call/Sms logs
     * @param type $activeDate:The Date Selected In the Call log/Sms Log
     * @param type $waterpoint:The Current Waterpoint With survey
     */


    public function tracker() {
        date_default_timezone_set("Africa/Nairobi");

        //require 'application/views/_templates/header.php';

        $table = "survey";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');

        $data = $generaldata_model->getSurvey();

        $fields = $generaldata_model->getFields($table, $fieldsArray2);
    

        #require 'application/views/surveytracker/sidebar.php';
        #require 'application/views/surveytracker/surveytracker.php';
        require 'application/views/surveytracker/surveytracker_gilb.php';
        #require 'application/views/_templates/footer.php';
        
    }

    public function msexcel() {
        date_default_timezone_set("Africa/Nairobi");


        // require 'application/views/_templates/header.php';

        $table = "survey";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');
        

        $data = $generaldata_model->getExcel();
        $fields = $generaldata_model->getFields($table, $fieldsArray2);
        
        $surveyState = "MS-Excel";
        require 'application/views/surveytracker/surveytracker_gilb.php';
        // require 'application/views/surveytracker/sidebar.php';
        // require 'application/views/surveytracker/surveytracker.php';
        // require 'application/views/_templates/footer.php';
    }

    public function msword() {
        date_default_timezone_set("Africa/Nairobi");

        // require 'application/views/_templates/header.php';

        $table = "survey";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');

        $data = $generaldata_model->getWord();
        $fields = $generaldata_model->getFields($table, $fieldsArray2);
    
        $surveyState = "MS-Word";
        require 'application/views/surveytracker/surveytracker_gilb.php';
        // require 'application/views/surveytracker/sidebar.php';
        // require 'application/views/surveytracker/surveytracker.php';
        // require 'application/views/_templates/footer.php';
    }

    public function mysurveys() {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        $table = "survey";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'subcategory', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');

        $data = $generaldata_model->getmysurveys();
        $fields = $generaldata_model->getFields($table, $fieldsArray2);
    
        $surveyState = "My Surveys";
        require 'application/views/surveytracker/sidebar.php';
        require 'application/views/surveytracker/surveytracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function uploadfile($table = "survey") {
        $generaldata_model = $this->loadModel('surveytrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        
        if (isset($_POST["submitfile"])) { 
            $logs_model = $this->loadModel('logsmodel');
            $target_path = "excelfiles/";
            $mimes = array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            //echo $_FILES['uploadedfile']['type'];

            if(in_array($_FILES['uploadedfile']['type'],$mimes)){
                $mimesE = array("application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                //$mimesW = array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.openxmlformats-officedocument.wordprocessingml.template");
                
                //Get simple file type
                if(in_array($_FILES['uploadedfile']['type'],$mimesE)){ $filetype = "MS-EXCEL"; }else{ $filetype = "MS-WORD"; }

                //Get File Category ie DTW,DSW,G_UNITED,OTHER      
                $mimeDTW =  array('TT', 'DD', 'PDC', 'SCT', 'PD', 'PRE', 'CIFF', 'LF'); 
                $mimeDSW =  array('S004', 'S003','S002', 'S005', 'UF006', 'UF00', 'KF00', 'GEDU'); 
                $mimeGUNITED = array('GUNITED');
                //$mimeBETA =  array('CIFF',);
                

                $find_letters = $mimeDTW;
                $string = $_FILES['uploadedfile']['name'];
                //$match = (str_replace($find_letters, '', $string) != $string);
                //echo $match;

                if(str_replace($mimeDSW, '', $string) != $string){
                    //echo 'at least one of the needles where found';
                    $category = "DSW";
                }
                elseif (str_replace($mimeDTW, '', $string) != $string) {
                    $category = "DTW";
                }
                elseif (str_replace($mimeGUNITED, '', $string) != $string) {
                    $category = "GUNITED";
                }
                
                else{
                    $category = "BETA";
                };

                //SubCategory Get File Subcategory e.g Carbon, hardware, Teacher Trainin, Spotchlo
                //Get File Category ie DTW,DSW,G_UNITED,OTHER      
                $mimett =  array('TT');
                $mimedd =  array('DD');
                $mimepdc =  array('PDC');
                $mimesct =  array('SCT');
                $mimepd =  array('PD','PDC');
                $mimepre =  array('PRE');
                $mimeciff =  array('CIFF');
                $carbon =  array('S004', 'S003','S002', 'carbon'); 
                $comm =  array('S005', 'comm'); 
                #$wqt =  array('S005', 'comm'); 
                $mimeGUNITED = array('GUNITED');
                $mimeBETA =  array('NEEP','GUNITED','Small Talk');
                $mimeLF =  array('LF'); 


                if(str_replace($carbon, '', $string) != $string){
                    //echo 'at least one of the needles where found';
                    $subcategory = "Carbon";
                }
                elseif (str_replace($comm, '', $string) != $string) {
                    $subcategory = "Community";
                }
                elseif (str_replace($mimett, '', $string) != $string) {
                    $subcategory = "Teacher Training";
                }
                elseif (str_replace($mimepd, '', $string) != $string) {
                    $subcategory = "Pre Deworming";
                }

                elseif (str_replace($mimesct, '', $string) != $string) {
                    $subcategory = "Sub-county Training";
                }
                elseif (str_replace($mimedd, '', $string) != $string) {
                    $subcategory = "Deworming Day";
                }
                elseif (str_replace($mimeciff, '', $string) != $string) {
                    $subcategory = "CIFF";
                }
                elseif (str_replace($mimeLF, '', $string) != $string) {
                    $subcategory = "LF";
                }
                else{
                    $subcategory = "UNCLASSIFIED";
                };


                // Sub-sub category survey belongs to


                //Country of the Survey



                if(in_array($_FILES['uploadedfile']['type'],$mimesE)){ $filetype = "MS-EXCEL"; }else{ $filetype = "MS-WORD"; }
                
                $filename = time()."_".$_FILES['uploadedfile']['name'];
                #$filename = $_FILES['uploadedfile']['name']."_".time();
                //move the file to folder
                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path.$filename)){
                    //then store in db
                    $data = array($filename, $filetype, $category, $subcategory, $target_path.$filename); 
                    //$logs_model->addSurvey($data);
        
                    //$data = $generaldata_model->runRawQuery($query);
                    $generaldata_model->addSurvey($data);
                    $message = 'Survey Succesfully Uploaded.';
                    //Log Insert Action in Database
                    $table = "survey";
                    $logs_model->insertLogSurveyTracker($table);
                    
                    header('location: ' . URL . 'surveytracker/tracker/?message=' . urlencode($message));         
                    
                    
                }else{
                    echo "file couldnt be uploaded";
                }
                
            }else{
                echo "not excel";
            }
             
            
        }
        // where to go after upload
        //header('location: ' . URL . 'surveytracker/tracker');
    }

    public function download($filename) {

        $path ='excelfiles/';
        $file = $path.$filename;
        if(!$file){ // file does not exist
            die('file not found');
        } else {
            $mimesE = array("xlsx","xls");
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            $name = preg_replace('/^[^_]*_\s*/', '', $filename);
            header("Content-Disposition: attachment; filename=$name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($file));
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');


            //Determine the file type and Download the file
            //Get the file extension
            //$ext = pathinfo($filename, PATHINFO_EXTENSION);
            //filename = preg_replace('/_[^_]*$/', '', $dd['filename']
            #$filename = preg_replace('/^[^,]*,\s*/', '', $filename);
            $ext = array_pop(explode('.',$filename));
            //print_r($ext);
            if(in_array($ext,$mimesE)){
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                // read the file from disk
                while (ob_get_level()) {
                    ob_end_clean();
                }
                readfile($file);       
            } else{ 
                // Read word
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');              
                while (ob_get_level()) {
                    ob_end_clean();
                }
                readfile($file);
            }
          
        }

        header('location: ' . URL . 'surveytracker/tracker');
    }
    public function delete($id) {
        
        $this->model = $this->loadModel('surveytrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        if (isset($id)) {
            $generaldata_model = $this->loadModel('surveytrackermodel');
            $query = 'DELETE  from survey WHERE id= '.$id.' ';
            // echo  $query;
            $data = $generaldata_model->runRawQuery($query);
            //Log Insert Action in Database
            $table = "survey";
            $logs_model->deleteLogSurveyTracker($table);

        }
        header('location: ' . URL . 'surveytracker/tracker');
    }

    public function category($category) {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        $table = "survey";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');

        $data = $generaldata_model->getcategory($category);
        $fields = $generaldata_model->getFields($table, $fieldsArray2);
    
        $surveyState = "My Surveys";
        require 'application/views/surveytracker/sidebar.php';
        require 'application/views/surveytracker/surveytracker.php';
        require 'application/views/_templates/footer.php';
    }

    // public function readexcel() {
    //     date_default_timezone_set("Africa/Nairobi");

    //     require 'application/views/_templates/header.php';

    //     $path ='excelfiles/';
    //     $file = $path.$filename;
        
    //     // open the file in a binary mode
    //     $fp = fopen($file, 'rb');

    //     // send the right headers
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header("Content-Disposition: attachment; filename=\"results.xlsx\"");
    //     header("Cache-Control: max-age=0");
    //     header("Content-Type: application/force-download");
    //     header("Content-Type: application/octet-stream");
    //     header("Content-Type: application/download");
    //     header("Content-Description: File Transfer");
    //     header("Content-Transfer-Encoding: Binary");
    //     header("Content-Length: " . filesize($file));

    //     // dump the picture and stop the script
    //     fpassthru($fp);
    //     exit;
    
    //     $surveyState = "My Surveys";
    //     require 'application/views/surveytracker/sidebar.php';
    //     require 'application/views/surveytracker/surveytracker.php';
    //     require 'application/views/_templates/footer.php';
    // }

    public function table() {
        date_default_timezone_set("Africa/Nairobi");

        //require 'application/views/_templates/header.php';

        $table = "surveys";

        $fieldsArray2 = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'date_created');
        $fieldsArray = array('id', 'country', 'full_name', 'filename', 'filetype', 'category', 'date_created');
        

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('surveytrackermodel');

        //$data = $generaldata_model->getCompleted("surveys", $fieldsgetSurvey()
        $data = $generaldata_model->getSurvey();

        $fields = $generaldata_model->getFields($table, $fieldsArray2);
        
        require 'application/views/surveytracker/tables.php';
        
    }
    //


    /**
     * This Method is used by Jquery Load method in DSW To Load data from the Db to a specific element
     * Without Loading Page
     * @param type $table Contains the data needed
     * @param type $field The column being referenced
     * @param type $criteria what column to filter the data
     * @param type $value the value that should be in that column filtering
     */
    public function ajax_call($table, $field, $criteria, $value) {

        $generaldata_model = $this->loadModel('surveytrackermodel');
        //echo $value;

        $value = isset($_GET['cat']) ? $_GET['cat'] : $value; //$_GET['cat'] contains variables with possible surveys and should be manually defined if such a possibility occurs

        $query = 'SELECT id,' . $field . ' from ' . $table . ' WHERE ' . $criteria . ' like "%' . $value . '%"';
        // echo  $query;
        $data = $generaldata_model->runRawQuery($query);
        if ($data == null && strlen($value) > 5) {

            // $value=substr($value,$counter,+($limit-$counter));
            $query = 'SELECT id,' . $field . ' from ' . $table . ' WHERE  trim(' . $criteria . ')= "' . $value . '"';
            //  echo $query;
            $data = $generaldata_model->runRawQuery($query);
        }
        echo $data = json_encode($data);
    }

                // function strposa($haystack, $needles=array(), $offset=0) {
                //     $chr = array();
                //     foreach($needles as $needle) {
                //             $res = strpos($haystack, $needle, $offset);
                //             if ($res !== false) $chr[$needle] = $res;
                //     }
                //     if(empty($chr)) return false;
                //     return min($chr);
                // }
                 
                // $str = $_FILES['uploadedfile']['name'];
                // if(strposa($str,$mimeDTW)){
                //     $category = "DTW";                   
                // }
                // elseif (strposa($str, $mimeDSW, 1)) {
                //     $category = "DSW";                    
                // }
                // elseif (strposa($str, $mimeGUNITED, 1)) {
                //     $category = "GUNITED";                 
                // }
                // else{ 
                //     $category = "BETA";                   
                // }
                //$mimesC = array("S004","S003");
}

?>