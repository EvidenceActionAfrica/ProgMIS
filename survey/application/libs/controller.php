<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller {

    /**
     * @var null Database Connection
     */
    public $db = null;
    
    /*
     * Active Privilege to Check
     */
    public $privCheck=null;

    public $helper_model;
    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct() {

        $this->openDatabaseConnection();

        if (!isset($_SESSION["email"]) ) {

            session_start();
        }
        if(isset($_GET['url'])){

          if (isset($_SESSION["email"]) && isset($_SESSION["countryName"]) ) {

        
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
       // echo $url[1];
       // if(strpos($url[1], "update") !== false){ echo "True";}else{echo "False";}
        //  exit();
       $this->helper_model = $this->loadModel('helpermodel');
        $privCheck=$this->helper_model->accessAssigner($url,strtolower($_SESSION["countryName"]));
        // echo $url[0];
        //  exit();
        //if(isset($_SESSION[$privCheck])){echo " set Privilege is ".$_SESSION[$privCheck];}
        $this->recheckCertainPrivileges();
       

        if (isset($url[1])) {

            switch ($url[1]) {
                case stripos($url[1], "add") !== false:
                    $this->helper_model->addAccess($_SESSION[$privCheck],$url);
                    break;
                case strpos($url[1], "update") !== false:
                    $this->helper_model->editAccess($_SESSION[$privCheck], $url);
                    break;
                case strpos($url[1], "delete") !== false:
                    $this->helper_model->deleteAccess($_SESSION[$privCheck],$url);
                    break;
                case strpos($url[1], "setPrivilege") !== false:
                    
                    $this->helper_model->editAccess($_SESSION[$privCheck],$url);
                    break;
                case strpos($url[1], "upload") !== false:
                    
                    $this->helper_model->deleteAccess($_SESSION[$privCheck],$url);
                    break;
                 case strpos($url[1], "import") !== false:
                    $this->helper_model->addAccess($_SESSION[$privCheck],$url);
                    break;
                
                
                default:
                //$this->helper_model->zeroAccess($_SESSION[$privCheck],$url);
                    // continue;
                    //    echo "Failed";
                    //   exit();
                    break;
            }
        } else if (!isset($url[1])) {
            // $url[1]="home";
            //   header("Location:".URL."home");
        } else {
            
        }
    }
    }
}
    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection() {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_LOCAL_INFILE => 1);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }

    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    public function loadModel($model_name) {
        require_once 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db);
    }

    private function recheckCertainPrivileges(){

        $_SESSION["issueNo"]=$this->helper_model->getPending();
        
    }

}
