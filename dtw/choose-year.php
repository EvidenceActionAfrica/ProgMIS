<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
// $level = $_SESSION['level'];
 
 if (isset($_GET['year'])) {
      
    if ($_GET['year']!='choose') {
      // unset the previous session
      unset ($_SESSION['database']);
      // create a new session
     $_SESSION['database']=$_GET['year'];
      
      // header("Location:choose-year.php");
    }
    
  }


//READ FROM EXCEL AND POPULATE THE DROPDOWN

  if(file_exists($_SERVER['DOCUMENT_ROOT'].'/PROGMIS/includes/ea-databases.xml')) {
  // if(file_exists('write.xml')) {
    // echo $_SERVER['DOCUMENT_ROOT'];
    // echo "<br/>";
    $data=array();

    if( ! $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/PROGMIS/includes/ea-databases.xml') ) {
      echo 'unable to load XML file'; 
    } 
    else { 
      foreach( $xml as $user ){
        // $chosendb=$user->year; 
        $data[]=$dbname=$user->year; 
      } 
    } 


  }else{
    echo "file does not exist"; echo "<br>";
    echo $_SERVER['DOCUMENT_ROOT'];

  }




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta name="description" content="Description" />
    <meta name="keywords" content="Keywords" />

    <!-- CSS includes -->
    <link rel="stylesheet" href="css/style.css"  type="text/css" media="screen" />
    <link rel="stylesheet" href="css/vstyle.css" type="text/css" >

    <!-- javascript includes -->
    <script src="js/jquery.min.js"  type="text/javascript" ></script>

    <!-- Bootstrap includes -->
    <!-- <link href="css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/> -->
    <link rel="stylesheet" type="text/css" href="processData/reverse-cascade/css/bootstrap-3.1.1/css/bootstrap.css">


    <?php
    // require_once ("includes/meta-link-script.php");
    ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        require_once ("includes/loginInfo.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-AdminData.php");
        ?>
      </div>
      <div class="contentBody">

        <!-- <h1 style="text-align: center; margin-top: 0px">Administrative Data</h1> -->

        <center>
          <h3>Welcome to the Evidence Action Management Information System</h3>
          <div >
            <div class="alert alert-info">
              <a href="#" class="alert-link">...
              <?php echo "You are now using Year  ".getYearEnd() ?>
            </a>
            </div>
        
          <form style="width:300px" action="" method="get">
          <select name="year" class="form-control">
            <option value="choose">Choose Year</option>
            <option value="evidence_action">year 22</option>
            <option value="evidence_action_year3">year 33</option>
            <!-- 
            <?php 
                foreach ($data as $key => $value) {
                  ?>
                  <option value=<?php echo $value ?> >Year <?php echo $key+2 ?></option>
                  <?php
                }

             ?> -->
          </select>
          
          <br>
          <input class=" btn btn-primary"type="submit" name="name" value="Choose" >

            <!-- <input type="text" name="addyear"  class="form-control" placeholder="addyear" value="Add"> -->

          </form>

          </div>

        <div class="dashboardMenu1">
        
        </div>
      
      </center>

        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
 
  </body>
</html>





 
  
  
  
  
  
  
  