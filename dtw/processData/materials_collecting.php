<?php
date_default_timezone_set("Africa/Nairobi");
//The Materials Module need this because the number of queries performed are many, which may need more time to process
//than assigned by default in the server's config
ini_set('max_execution_time', 300); 
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('pdf/collection_form.php');
require_once("../includes/logTracker.php");
$tabActive = "tab1";
$M_module =2;
if(isset($_GET['tabActive'])){
  $tabActive=$_GET['tabActive'];
}
/*
*******************************
*   REQUIREMENTS              *
*                             *
*******************************                                   
*
*1. Ability to Filter a long list of packaged boxes following this order:county,subcounty & finally training boxes(Displays A summary count for each)
*2. The Ability to filter(in requirement 1.) should be proceeded by the ability to check which box has been collected.
*3. Repeat the same process as step 1 & 2 for dispatch to counties
*4. The ability to return a box back to storage/inventory(undo collecting process of step 1&2)
*5. Ability to save more than one person collecting the materials from hq
*******************************
*                             *
*   SOLUTION                  *
*                             *
*                             *
*******************************
*
*1. A Sequence of tables displayed showing(in this order) county,sub-county & training Boxes.
*2. They will go under 2 steps where step 1 you filter the respective counties & subcounties to have their materials collected
*   then the list of boxes for those counties,sub_counties.
*3. The same process as step 1 &2 for the tables for dispatch to counties
*4. Ability to Return the boxes individually or boxes for an entire district 
*5. Save array of people & their details for Dispatch process
*6. Save all the data entered
*/
  //1.SOLUTION IMPLEMENTATION
  //This is used to jump from step 1 to step 2
  if(isset($_POST['districtSelect'])){

    $districtArray=array();
    unset($_POST['districtSelect']);
    foreach ($_POST as $key => $value) {
      array_push($districtArray,$value);
    }

    
  }
  //Step 2:Setting boxes as collected from vendor
  if(isset($_POST['boxSelect'])){

    $boxArray=array();
    unset($_POST['boxSelect']);
    foreach ($_POST as $key => $value) {
      //array_push($boxArray,$value);
      $sql='UPDATE materials_packaging_history_data set dispatched=1 WHERE box_id="'.$value.'"';
      $dispatchResult=mysql_query($sql)or die(mysql_error());
      $action="Box with an id ".$value." set as dispatched";
      $description=" The box has been set as dispatched to county";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
    }
      

    $tabActive = "tab2";
  }

  if(isset($_POST['districtDispatch'])){

    $districtDispatch=array();
    unset($_POST['districtDispatch']);
    foreach ($_POST as $key => $value) {
      array_push($districtDispatch,$value);
    }
    $tabActive = "tab2";

  }
//End of Inventory Planning 

//Dispatch To Counties Planning

if(isset($_POST['boxDispatch'])){

      $BoxDispatchedArray=array();
    unset($_POST['boxDispatch']);
    foreach ($_POST as $key => $value) {
      array_push($BoxDispatchedArray,$value);
    }
  $tabActive='tab3';
  $_SESSION['boxDispatchArray']=$BoxDispatchedArray;
  $boxes=sizeof($BoxDispatchedArray);
  if(isset($_SESSION['peopleArray'])){ unset($_SESSION['peopleArray']);}
}




/* Solution 4*/
  if(isset($_GET['returnDistrictInventory'])){
  
    $sql='UPDATE materials_packaging_history_data set dispatched=0,collected=0 WHERE district_name="'.$_GET['returnDistrictInventory'].'" AND collected !=1';
    mysql_query($sql)or die(mysql_error());

    $tabActive = "tab2";   
      $action="Boxes from ".$_GET['returnDistrictInventory']." reset as not dispatched nor collected";
      $description=" The box has been reset as un-dispatched to county";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
  }
  if(isset($_GET['returnInventory'])){
  
    $sql='UPDATE materials_packaging_history_data set dispatched=0,collected=0 WHERE box_id="'.$_GET['returnInventory'].'"';
    mysql_query($sql)or die(mysql_error());

    $tabActive = "tab2";  
     $action="Box with an id ".$_GET['returnInventory']." reset as not dispatched nor colllected";
      $description=" The box has been reset as un dispatched to county";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData); 
  }
/*  End of Solution 4*/

/* Solution 5 */
//unset($_SESSION['peopleArray']);
$mainArray=array();
if(isset($_POST['peopleSubmit'])){

$peopleMiniArray=array(
  'identity'=>$_POST['identity'],
  'position'=>$_POST['position'],
  'mobile'=>$_POST['mobile'],
  'noBox'=>$_POST['noBox'],
  'noPoles'=>$_POST['noPoles']

  );

if(isset($_SESSION['peopleArray'])){
    $mainArray=$_SESSION['peopleArray'];
    array_push($mainArray,$peopleMiniArray);
    $_SESSION['peopleArray']=$mainArray;
}else{
   array_push($mainArray,$peopleMiniArray);
   
  $_SESSION['peopleArray']=$mainArray;  
}
//5
//Ease of Use 
$peopleArray=$_SESSION['peopleArray'];
$tabActive='tab3';

}

//Ability To Remove All People Entered into The Table

if(isset($_POST['peopleunsubmit'])){

  if(isset($_SESSION['peopleArray'])){ unset($_SESSION['peopleArray']);}
}



/*  End of Solution 5 */

// Solution 6

if(isset($_POST['Submit'])){

  //Capture any pperson who wasn't saved by add collector button

  if(isset($_POST['identity'])){


  $peopleMiniArray=array(
    'identity'=>$_POST['identity'],
    'position'=>$_POST['position'],
    'mobile'=>$_POST['mobile'],
    'noBox'=>$_POST['noBox'],
    'noPoles'=>$_POST['noPoles']

    );

  if(isset($_SESSION['peopleArray'])){
      $mainArray=$_SESSION['peopleArray'];
      array_push($mainArray,$peopleMiniArray);
      $_SESSION['peopleArray']=$mainArray;
    }else{
       array_push($mainArray,$peopleMiniArray);
       
      $_SESSION['peopleArray']=$mainArray;  
    }
  //5
  //Ease of Use 

  }
  $peopleArray=$_SESSION['peopleArray'];
  $uniqueId=uniqid();//This is the id that will link the collection forms to the boxes
  foreach ($peopleArray as $key => $value) {
    $collectionDate=isset($_POST['collectionDate'])?mysql_real_escape_string($_POST['collectionDate']):date('d-m-Y');
    $ministry=isset($_POST['ministry'])?$_POST['ministry']:'unknown';
    $purpose=isset($_POST['purpose'])?$_POST['purpose']:'unknown';
    $noBox=isset($value['noBox'])?intval($value['noBox']):0;
    $noPoles=isset($value['noPoles'])?intval($value['noPoles']):0;
    $person=$value['identity'];
    $position=$value['position'];
    $mobile=$value['mobile'];
    $staffName=$_SESSION['staff_name'];

    $sql='INSERT INTO `collect_training_materials`(`date`, `ministry`, `purpose`, `name`,';
    $sql.=' `title`, `phone_no`, `no_of_boxes`, `no_of_poles`, `pby_name`,`collection_id`) ';
    $sql.=" VALUES ('$collectionDate','$ministry','$purpose','$person','$position','$mobile','$noBox','$noPoles','$staffName',";
    $sql.="'$uniqueId')";
    mysql_query($sql);
      $action=$noBox." Boxes have been collected by ".$person;
      $description=" Boxes have been collected by the ministry".$ministry." The purpose is ".$purpose;
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData); 
  }
  $boxArray=$_SESSION['boxDispatchArray'];

  foreach ($boxArray as $key => $value) {
    $sql='UPDATE materials_packaging_history_data set collected=1,collector_id="'.$uniqueId.'" WHERE box_id="'.$value.'"'; 
    mysql_query($sql);
      $action="Of The ".$noBox." collected by ".$person." one of them was ".$value;
      $description=" The box has been collected by the ministry, ".$ministry.".The purpose is ".$purpose;
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData); 
  }

  unset($_SESSION['peopleArray']);
  unset($_SESSION['boxDispatchArray']);
  $tabActive = "tab3";  
}

/* End of solution 6*/

//Retract Opeeration of a training materials collection Form

if($_GET['deleteProcess']){

$sql='SELECT collection_id from collect_training_materials WHERE id='.$_GET['deleteProcess'];
$resultD=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($resultD)){
  $collectId=$row['collection_id'];
}

$sql='DELETE from collect_training_materials WHERE collection_id="'.$collectId.'"';
mysql_query($sql);

$sql='UPDATE materials_packaging_history_data  set collected=0 WHERE collector_id="'.$collectId.'"';
mysql_query($sql);
$action="Collection process reversed";
$description="One or more boxes has been returned to the dispatch stage";
$ArrayData = array($M_module, $action, $description);
quickFuncLog($ArrayData); 

}
//end Of Retract/Delete

//Print option

if(isset($_GET['pdfCollectionView'])){

$collectId=$_GET['pdfCollectionView'];

showFormSummary($collectId);
    $action="Print/Download Pdf";
      $description=" A Pdf containing the collection information of a certain collector";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);

}

//End Of Print Option


//The Code Below Turns a recorded Sms from unconfirmed to Confirmed

if(isset($_GET['Smsid'])){
  $sms=$_GET['Smsid'];

  $sql='UPDATE materials_collection_sms set confirmed=1 WHERE sms_id='.$sms;
  mysql_query($sql);
      $action="Sms reception confirmed";
      $description="The people given the box details have confirmed they received an sms";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
}


//$no_of_records = $_POST['no_of_records'];
$updateResult = "";
//This is simply an initialization of the notification variable. 
//Find the id of the current printlist for //1&2
$sql='SELECT * from materials_printlist_history WHERE status=1';
$resultActive=mysql_query($sql);
while($row=mysql_fetch_array($resultActive)){
  $printlistId=$row['id'];
}

//



// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit = $row['priv_materials_edit'];
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
    <link href="css/materials.css" rel="stylesheet" type="text/css"/>
  </head>


  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
        <div class="contentBody" >
              <h2 style="margin-left:20%;">Training Materials Collection</h2>
              <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

                Warning! &nbsp; This Form will only display data from the active Print Order And Packing Information.
              </div>

              <div class="tabbable" >
                <ul class="nav nav-tabs">

                  <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Inventory</a></li>
                  <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Dispatch To Counties</a></li>
                  <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Materials Collected</a></li>
                  <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Send Sms</a></li>
                  <li <?php if ($tabActive == 'tab5') echo "class='active'" ?>><a href="#tab5" data-toggle="tab">View Unconfirmed Sms History</a></li>
                <li <?php if ($tabActive == 'tab6') echo "class='active'" ?>><a href="#tab6" data-toggle="tab">View Confirmed Sms History</a></li>
               
                </ul>
              <div class="tab-content" style="max-height:650px; overflow:scroll;">

                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                        <a style=" appearance:hyperlink;margin-top:5%;" class="btn" onclick="checkAll();"/>CHECK ALL </a> &nbsp; <a  style='margin-top:5%;'class="btn" onclick="uncheckAll();">UNCHECK ALL</a><br/>
   
                       <?php
                       //1. Soln
                          if(!isset($districtArray)){
                            echo '<h2 style="text-align:left;background-color:#5C8AE6;color:#FFF;width:100px;">Step 1</h2>';
                      
                             $sql='SELECT county_name,district_name from  materials_packaging_history_data WHERE ';
                             $sql.=' printlist_id='.$printlistId.' AND collected=0 AND dispatched=0 GROUP BY(district_name)';
                             $resultFilter=mysql_query($sql) or die(mysql_error());
                             $numRows=mysql_affected_rows();
                          if($numRows>=1){
                          ?>

                          <form action='materials_collecting.php' method='POST' >
                          <table width='30%' class="table table-bordered table-condensed table-striped table-hover">
                            <tr>
                              <th>County</th>
                              <th>Sub-County</th>
                              <th width='30px'>Collected From Vendor</th>
                            </tr>

                          <?php
                          $counter=1;
                          while($row=mysql_fetch_array($resultFilter)){

                                  echo '<tr>';
                                  echo '<td>'.$row['county_name'].'</td>';
                                  echo '<td>'.$row['district_name'].'</td>';
                                  echo '<td><input class="checkers" type="checkbox" name="district'.$counter.'" value="'.$row['district_name'].'" checked/></td>';
                                  echo '</tr>';
                                   ++$counter;
                                }
                                echo '</table>';
                                echo '<input type="submit" style="margin-left:50%;" name="districtSelect" class="btn btn-info" value="Continue"/>';
                               echo '</form>'; 
                        }else{

                          echo '     <div style="background:#bada66;">
                                            <span id="h2info" style="margin-top:5%;font-size:1.3em;text-align:center;"> &nbsp;No Boxes Available For Dispatch from Vendor.</span>
                                     </div>';
                        
                        }

                          }else{

                             echo '<h2 style="text-align:left;background-color:#5C8AE6;color:#FFF;width:100px;">Step 2</h2>';
                          
                              ?>

                              <form action='materials_collecting.php' method='POST' >
                              <table width='30%' class="table table-bordered table-condensed table-striped table-hover">
                                <tr>
                                  <th>County</th>
                                  <th>Sub-County</th>
                                  <th>Box Id</th>
                                  <th>Box Type</th>
                                  <th width='30px'>Collected From Vendor</th>
                                </tr>

                              <?php
                              $counter=1;
                                  foreach ($districtArray as $key => $value) {
                              
                                 $sql='SELECT * from  materials_packaging_history_data WHERE ';
                                 $sql.=' printlist_id='.$printlistId.' AND district_name="'.$value.'" AND collected=0 AND dispatched=0';
                              
                                 $resultFilter=mysql_query($sql) or die(mysql_error());
                                 $numRows=mysql_affected_rows();
                             
                              while($row=mysql_fetch_array($resultFilter)){

                                      echo '<tr>';
                                      echo '<td>'.$row['county_name'].'</td>';
                                      echo '<td>'.$row['district_name'].'</td>';
                                      echo '<td>'.$row['box_id'].'</td>';
                                      echo '<td>'.$row['box_type'].'</td>';
                                      echo '<td><input class="checkers" type="checkbox" name="box'.$counter.'" value="'.$row['box_id'].'" checked/></td>';
                                      echo '</tr>';
                                       ++$counter;
                                    }
                                 }
                                    echo '</table>';
                                    echo '<input type="submit" style="margin-left:50%;" name="boxSelect" class="btn btn-info" value="Finish"/>';
                                   echo '</form>'; 
                            
                         }


                            ?>
                    </div>

                    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                        <a style=" appearance:hyperlink;margin-top:5%;" class="btn" onclick="checkAll();"/>CHECK ALL </a> &nbsp; <a  style='margin-top:5%;'class="btn" onclick="uncheckAll();">UNCHECK ALL</a><br/>

                         <?php
                         //1. Soln
                            if(!isset($districtDispatch)){
                              echo '<h2 style="text-align:left;background-color:#FF6600;color:#FFF;width:100px;">Step 1</h2>';
                        
                               $sql='SELECT county_name,district_name from  materials_packaging_history_data WHERE ';
                               $sql.=' printlist_id='.$printlistId.' AND collected=0 AND dispatched=1 GROUP BY(district_name)';
                               $resultFilter=mysql_query($sql) or die(mysql_error());
                               $numRows=mysql_affected_rows();
                            if($numRows>=1){
                            ?>

                            <form action='materials_collecting.php' method='POST' >
                             <table width='30%' class="table table-bordered table-condensed table-striped table-hover">
                              <tr>
                                <th>County</th>
                                <th>Sub-County</th>
                                <th width='30px'>Dispatch</th>
                                <th>Return To Inventory</th>
                              </tr>

                            <?php
                            $counter=1;
                            while($row=mysql_fetch_array($resultFilter)){

                                    echo '<tr>';
                                    echo '<td>'.$row['county_name'].'</td>';
                                    echo '<td>'.$row['district_name'].'</td>';
                                    echo '<td><input class="checkers" type="checkbox" name="district'.$counter.'" value="'.$row['district_name'].'" checked/></td>';
                                    echo '<td><a onclick="returnDistrictInventory(\''.$row['district_name'].'\')" ><img src="../images/icons/edit.png" height="20px;"/></a></td>';
                                
                                    echo '</tr>';
                                     ++$counter;
                                  }
                                  echo '</table>';
                                  echo '<input type="submit" style="margin-left:50%;" name="districtDispatch" class="btn btn-info" value="Continue"/>';
                                 echo '</form>'; 
                          }else{
                            echo '<div style="background:#bada66;">
                                            <span id="h2info" style="margin-top:5%;font-size:1.3em;text-align:center;"> &nbsp;No Boxes Available For Dispatch from Vendor.</span>
                                     </div>';

                            
                          }

                            }else{

                               echo '<h2 style="text-align:left;background-color:#FF6600;color:#FFF;width:100px;">Step 2</h2>';
                            
                                ?>

                                <form action='materials_collecting.php' method='POST' >
                                <table width='30%' class="table table-bordered table-condensed table-striped table-hover">
                                  <tr>
                                    <th>County</th>
                                    <th>Sub-County</th>
                                    <th>Box Id</th>
                                    <th>Box Type</th>
                                    <th width='30px'>Dispatch</th>
                                    <th>Return To Inventory</th>
                                  </tr>

                                <?php
                                $counter=1;
                                    foreach ($districtDispatch as $key => $value) {
                                
                                   $sql='SELECT * from  materials_packaging_history_data WHERE ';
                                   $sql.=' printlist_id='.$printlistId.' AND district_name="'.$value.'" AND collected=0 AND dispatched=1';
                                
                                   $resultFilter=mysql_query($sql) or die(mysql_error());
                                   $numRows=mysql_affected_rows();
                               
                                while($row=mysql_fetch_array($resultFilter)){

                                        echo '<tr>';
                                        echo '<td>'.$row['county_name'].'</td>';
                                        echo '<td>'.$row['district_name'].'</td>';
                                        echo '<td>'.$row['box_id'].'</td>';
                                        echo '<td>'.$row['box_type'].'</td>';
                                        echo '<td><input class="checkers" type="checkbox" name="box'.$counter.'" value="'.$row['box_id'].'" checked/></td>';
                                        echo '<td><a onclick="returnInventory(\''.$row['box_id'].'\')" ><img src="../images/icons/edit.png" height="20px;"/></a></td>';
                                        echo '</tr>';
                                         ++$counter;
                                      }
                                   }
                                      echo '</table>';
                                      echo '<input type="submit" style="margin-left:50%;" name="boxDispatch" class="btn btn-info" value="Finish"/>';
                                     echo '</form>'; 
                              
                           }


                              ?>
                    </div>
                    <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                      <?php if(isset($_SESSION['boxDispatchArray'])){ ?>

                      <?php
                      $boxCount=$_SESSION['boxDispatchArray'];
                      
                      ?>
                            <h2 style='text-align:center;'>Training Materials Collection Form</h2>
                            <h4>Total Number Of Boxes Being Collected: &nbsp; <?php echo count($boxCount);?></h4>
                            <form method='POST'>
                                      <span style='font-weight:bold;text-align:center;'>Person/People Collecting Materials</span>
                                    
                                          <table class='table table-bordered table-condensed table-striped table-hover'>
                                              <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Position/Title</th>
                                                <th>Mobile Phone Number</th>
                                                <th>Number of Boxes</th>
                                                <th>Number of Poles</th>
                                              </tr>

                                              
                                                <?php

                                                  if(isset($peopleArray)){
                                                    $counter=1;
                                                    foreach ($peopleArray as $key => $value) {
                                                     echo '<tr>';
                                                     echo '<td>'.$counter.'</td>';
                                                     echo '<td>'.$value['identity'].'</td>';
                                                     echo '<td>'.$value['position'].'</td>';
                                                     echo '<td>'.$value['mobile'].'</td>';
                                                     echo '<td>'.$value['noBox'].'</td>';
                                                     echo '<td>'.$value['noPoles'].'</td>';
                                                     echo '</tr>';


                                                     ++$counter;
                                                    }
                                                  }
                                                  ?>
                                                  <tr>
                                                    <td></td>
                                                    <td><input type="text" name='identity' /></td>
                                                    <td><select name='position' required>
                                                            <option value="Other">Other</option>
                                                            <option value="DEO">DEO</option>
                                                            <option value="AEO">AEO</option>
                                                            <option value="DMOH">DMOH</option>
                                                            <option value="DPHO">DPHO</option>
                                                            
                                                        </select>
                                                    </td>
                                                    <td><input name='mobile' type='text'/></td>
                                                    <td><input type='text' name='noBox' /></td>
                                                    <td><input type='text' name='noPoles' /></td>
                                                  </tr>
                                          </table>
                                             <input type='submit' name='peopleSubmit' class='btn-custom' value='Add Collector'/>
                                           <input type='submit' name='peopleunsubmit' class='btn-custom' value='Clear All Collectors'/>  
                             
                              <div style='margin-left:10%;margin-bottom:2%;'>
                                <label for='collectionDate'><b>Date Collected</b></label>
                                  <input type="text" class='datepicker' name='collectionDate' value='<?php echo date("Y-m-d"); ?>'/>
                              </div>
                              <div style='width:100%;float:left;margin-bottom:2%;margin-left:10%;'>
                                <b>Tick One Ministry</b> &nbsp;
                                <?php
                               // Dynamic Call of all ministries in the db
                                $sql='SELECT * from dropdown_ministry';
                                $ministryResult=mysql_query($sql) or die(mysql_error());
                                while($row=mysql_fetch_array($ministryResult)){

                                  echo '<input type="radio" name="ministry" value="'.$row['ministry'].'"checked required >'.$row['ministry'].' &nbsp; ';
                            
                                }
                                ?>
                              </div>
                              <div style='width:100%;float:left;margin-bottom:2%;margin-left:10%;'>
                                <b>Tick One Purpose</b> &nbsp;
                                  <input type="radio" name="purpose"  value='Collecting Training Materials' required/>Collecting Training Materials &nbsp;
                                  <input type="radio" name="purpose" value='Picking Master Trainers' required/>Picking Master Trainers &nbsp;
                                  <input type="radio" name="purpose" value='Other' checked required/>Other &nbsp;
                              </div>
                             <?php if ($priv_materials_edit >= 2) { ?>
                               <div style='width:100%;float:left;margin-left:10%;'>
                                  <input class="btn-custom" type="submit" name="Submit" value="Submit Details" />
                               </div>
                                          <?php
                                        }
                                        ?>
                            </form>
                      <?php } ?>
                      <?php
                        $sql='SELECT * from collect_training_materials';
                        $resultA=mysql_query($sql)or die(mysql_error());

                      ?>
                      <table class='table table-bordered table-condensed table-striped table-hover'>
                        <tr>
                          <th>Collector</th>
                          <th>Purpose</th>
                          <th>Ministry</th>
                          <th>Mobile</th>
                          <th>No.Of Boxes</th>
                          <th>No.Of Poles</th>
                          <th>Print</th>
                          <th>Retract</th>
                        </tr>
                        <?php
                          while($row=mysql_fetch_array($resultA)){

                              echo '<tr>';
                              echo '<td>'.$row['name'].'</td>';
                              echo '<td>'.$row['purpose'].'</td>';
                              echo '<td>'.$row['ministry'].'</td>';
                              echo '<td>'.$row['phone_no'].'</td>';
                              echo '<td>'.$row['no_of_boxes'].'</td>';
                              echo '<td>'.$row['no_of_poles'].'</td>';
                              echo '<td><a href="materials_collecting.php?pdfCollectionView='.$row['collection_id'].'"><img src="../images/icons/view.png" height="20px;"/></a></td>';
                              echo '<td><a onclick="deleteConfirm('.$row["id"].')"><img src="../images/icons/delete.png" height="20px;"/></a></td>';
                              echo '</tr>';
                                 
                          }
                          ?>
                      </table>


                      </div>

                      <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">

                              <?php
                              if (isset($_POST["sendSms"])) {
                                 $boxId = isset($_POST["boxId"]) ? mysql_real_escape_string($_POST["boxId"]) : "";
                               
                                $sms_body='A box With An Id '.$boxId.' will contain the Following: ';
                                $sender = isset($_POST["sender"]) ? mysql_real_escape_string($_POST["sender"]) : "";
                                $recepient = isset($_POST["recepient"]) ? mysql_real_escape_string($_POST["recepient"]) : "";
                                $recepient_number = isset($_POST["recepient_number"]) ? mysql_real_escape_string($_POST["recepient_number"]) : "";
                                $subject = isset($_POST["subject"]) ? mysql_real_escape_string($_POST["subject"]) : "";
                                $sms_body.= isset($_POST["content"]) ? mysql_real_escape_string($_POST["content"]) : "";
                                
                                $arrivalDate = isset($_POST["arrivalDate"]) ? mysql_real_escape_string($_POST["arrivalDate"]) : "";
                                $county = isset($_POST["county"]) ? mysql_real_escape_string($_POST["county"]) : "";
                                $district = isset($_POST["district"]) ? mysql_real_escape_string($_POST["district"]) : "";
                                $recepient_type = isset($_POST["recepient_type"]) ? mysql_real_escape_string($_POST["recepient_type"]) : "";
                                $sms_body.= ". The Box will arrive on " . $arrivalDate;
                                $send_type = isset($_GET["sendType"]) ? mysql_real_escape_string($_GET["sendType"]) : "";

                                require_once 'sms.php';

                                $sms = new sms();
                                $sms->sendSMS($recepient_number, $sms_body);



                                $sql = "INSERT INTO `materials_collection_sms`( `sender`, `recepient`,  `recepient_number`, `subject`, `sms_body`, `box_id`,";
                                $sql.="`send_date`, `county`, `district`, `box_type`,`recepient_type`)";
                                $sql.=" VALUES ('$sender','$recepient','$recepient_number','$subject','$sms_body','$boxId','$arrivalDate','$county','$district','$recepient_type','$send_type')";
                                
                                mysql_query($sql) or die(mysql_error());
                                   $action="Sms sent";
                                  $description=" An Sms was sent to ".$recepient.".His/her number is ".$recepient_number." with box details of box ".$boxId;
                                  $ArrayData = array($M_module, $action, $description);
                                  quickFuncLog($ArrayData);
                                //$sms_body.=$arrivalNotes;
                                //   $sms = new sms();
                                // $sms->sendSMS($recipient_number, $sms_body)or die("Error Sending Sms");
                              }
                              ?>
                              <form action="materials_collecting.php" method="POST">
                                  <?php
                                 

                                  $sql = "SELECT * from materials_packaging_history_data where printlist_id='$printlistId' AND collected=1";
                                  $resultB = mysql_query($sql);
                                  $count = 0;
                                  $numRows = mysql_affected_rows();
                                  if ($numRows >= 1) {
                                    ?>
                                    <table  class="table table-bordered table-condensed table-striped table-hover" >
                                    
                                      <tr>

                                        <th>Box Id</th>
                                        <th>County</th>
                                        <th>Sub-County</th>
                                      
                                        <th>Date Set</th>
                                        <?php if ($priv_materials_edit >= 3) { ?>
                                          <th>Sms Sent to<br/>County Representatives</th>
                                        <?php } ?>
                                        <?php if ($priv_materials_edit >= 3) { ?>
                                          <th>Sms Sent to<br/> District Education Officer</th>
                                        <?php } ?>
                                     

                                      </tr>
                                      <?php
                                      while ($row = mysql_fetch_array($resultB)) {
                                        echo '<tr>';

                                        echo '<td>'.$row['box_id'].'</td>';
                                        echo '<td>'.$row['county_name'].'</td>';
                                        echo '<td>'.$row['district_name'].'</td>';
                                        echo '<td>'.$row['date'].'</td>';
                                        if ($priv_materials_edit >= 3) {

                                        $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["district_name"] . "' AND box_id='" . $row["box_id"] . "' AND recepient_type='CR'";
                                        //echo $sql;
                                        $result = mysql_query($sql);
                                        $numSms = mysql_affected_rows() >= 1 ? "YES" : "NO";
                                         echo '<td><a href="materials_collecting.php?boxId='.$row["box_id"] .'&tabActive=tab4&district='.$row["district_name"] .'&county='. trim($row['county_name']) .'&sendType=CR #addSms">'.$numSms.'</a></td>';


                                        }

                                         if ($priv_materials_edit >= 3) { 
                                   
                                             $sql = "SELECT * from materials_collection_sms WHERE county='" . $row["county_name"] . "' AND district='" . $row["district_name"] . "' AND box_id='" . $row["box_id"] . "' AND recepient_type='DEO'";
                                              
                                                $result = mysql_query($sql);
                                                $numSms2 = mysql_affected_rows() >= 1 ? "YES" : "NO";
                                              
                                          echo '<td><a href="materials_collecting.php?boxId='.$row["box_id"] . '&tabActive=tab4&district='. $row["district_name"] .'&county='.trim($row['county_name']) .'&sendType=DEO #addSms">'. $numSms2.'</a></td>';
                                              
                                        } 
                                       
                                      
                                        echo '</tr>';
                                        } ?>
                                    </table>
                                    <?php
                                  } else {
                                      echo '<div style="background:#bada66;">
                                            <span id="h2info" style="margin-top:5%;font-size:1.3em;text-align:center;"> &nbsp;No Box Has Been Dispatched.</span>
                                     </div>';
                                 
                                  }
                                  ?>
                                  </form>
                      </div>

                      <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
                                   <table  class="table table-bordered table-condensed table-striped table-hover" >
                                        <thead>
                                          <tr>
                                            <th>Sender</th>
                                            <th>Receiver</th>
                                            <th>Subject</th>
                                            <th>Body</th>
                                            <th>Confirmed</th>
                                          </tr>
                                        </thead>
                                        <?php
                                        $sql = "SELECT * from materials_collection_sms WHERE confirmed !=1 ORDER BY sms_id DESC";
                                        $resultR = mysql_query($sql);
                                        while ($row = mysql_fetch_array($resultR)) {
                                          echo "<tr>";
                                          echo "<td>" . $row["sender"] . "</td>";
                                          echo "<td>" . $row["recepient"] . "</td>";
                                          echo "<td>" . $row["subject"] . "</td>";
                                          echo "<td>" . $row["sms_body"] . "</td>";
                                          echo "<td><a href=materials_collecting.php?Smsid=" . $row["sms_id"] . ">Confirm</a></td>";
                                          echo "</tr>";
                                        }
                                        ?>
                                    </table>
                      </div>
                      <div class="tab-pane <?php if ($tabActive == 'tab6') echo 'active'; ?>" id="tab6">
                                   <table  class="table table-bordered table-condensed table-striped table-hover" >
                                                                        <thead>
                                                                          <tr>
                                                                            <th>Sender</th>
                                                                            <th>Receiver</th>
                                                                            <th>Subject</th>
                                                                            <th>Body</th>
                                                                            
                                                                          </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $sql = "SELECT * from materials_collection_sms WHERE confirmed =1 ORDER BY sms_id DESC";
                                                                        $resultR = mysql_query($sql);
                                                                        while ($row = mysql_fetch_array($resultR)) {
                                                                          echo "<tr>";
                                                                          echo "<td>" . $row["sender"] . "</td>";
                                                                          echo "<td>" . $row["recepient"] . "</td>";
                                                                          echo "<td>" . $row["subject"] . "</td>";
                                                                          echo "<td>" . $row["sms_body"] . "</td>";
                                                                          echo "</tr>";
                                                                        }
                                                                        ?>
                                                                      </table>
                      </div>
                    </div>

        </div>
        
   </div>





          <div id="addSms" class="modalDialog" style="margin-left:0%; ">
            <div style="width: 500px">
              <form method="POST" >
                <a href="materials_collecting.php" title="Close" class="close">X</a>
                <!-- ================= -->
                <?php
                $boxId = $_GET["boxId"];
                $county = $_GET["county"];
                $district = $_GET["district"];
                //$recepient_type = $_GET["type"];
                $send_type = $_GET["sendType"];

                $sql='SELECT * from materials_packaging_history_data WHERE box_id="'.$boxId.'" AND county_name="'.$county.'"';
                $sql.=' AND district_name="'.$district.'" ';
                
                $resultA=mysql_query($sql);
                $material='';
                while($row=mysql_fetch_array($resultA)){

                  $material=unserialize($row['material']);
                  $recepient_type=$row['box_type'];
                }

                ?>

                <h3 style="margin-left:40%;">
                  Compose SMS
                </h3>

                <?php
                if (isset($_POST["sendSms"])) {
                   echo '<div style="background:#bada66;">
                                            <span id="h2info" style="color:#FFFF;margin-top:5%;font-size:1.3em;text-align:center;"> &nbsp;Message Sent.</span>
                                     </div>';
                 
                }
                ?>
                <table >
                  <tr>
                    <th>Sender</th><th><input type="text" name="sender" value="<?php echo $_SESSION["staff_name"]; ?>" readonly/></th>
                    <th>Recipient</th><th><input type="text" name="recepient" value="" required/></th>
                  </tr>
                  <th>Date Expected</th><th><input type="text" name="arrivalDate" class="datepicker" value="" required/></th>
                  <th>Recipient Number</th><th><input type="text" id="recepient_number" name="recepient_number" value="" placeholder="Replace the first 0 with 254" onclick="autoNum(recepient_number)" required/></th>
                  </tr>
                  <th></th><th><input type="hidden" name="boxId" value="<?php echo $boxId; ?>" readonly/></th>
                  <th>Subject</th><th><input type="text" name="subject" value="" required/></th>
                  </tr>
                </table>
                <h3 style="margin-left:40%"> Sms Content</h3><br/>
                <textarea style="width:70%;"name="content"><?php
                    
                      foreach ($material as $key => $value) {
                       echo str_replace('_',' ',$key).'='.$value.',';
                      }
                    ?></textarea>
                <br/><br/>
                <input type="submit" name="sendSms" class="btn-custom" value="Send Sms" style="margin-left:35%;"/>
                <input type="hidden" name="county"  value="<?php echo $county; ?>"/>
                <input type="hidden" name="district"  value="<?php echo $district; ?>"/>
                <input type="hidden" name="recepient_type" value="<?php echo $recepient_type; ?>"/>
              </form>
            </div>
          </div>
          <script>
          
        function autoNum(variableX){
            var aut=document.getElementById(variableX);
            aut.innerHTML="254";
            console.log("Working with"+aut.value);
        }
          
       
        function checkAll(){
            
             $(".checkers").prop("checked", true);
        }
        
        function uncheckAll(){
             $(".checkers").prop("checked", false);
        }


        $(document).find("input.num-only").keydown(function(e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                  // Allow: Ctrl+A
                          (e.keyCode == 65 && e.ctrlKey === true) ||
                          // Allow: home, end, left, right
                                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                  }
                  // Ensure that it is a number and stop the keypress
                  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                  }
                });

        $(function() {
         
           $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
        });


        function show_confirm() {
          if (confirm("Are you sure you want to delete?")) {
            return true;
          } else {
            return false;
          }
        }


        function returnInventory(boxId){

          if (confirm("Are you sure you want to Undo its Collecting Process from the Vendor?")) {
            location.replace('?returnInventory=' + boxId);
          } else {
            return false;
          }

        }
        function returnDistrictInventory(district){

          if (confirm("Are you sure you want to Undo this District's Collecting Process from the Vendor?")) {
            location.replace('?returnDistrictInventory=' + district);
          } else {
            return false;
          }

        }

           function deleteConfirm(processId) {
          if (confirm("Are you sure you want to delete the Entire Process?")) {
              location.replace('?deleteProcess=' + processId);
          } else {
            return false;
          }
        }

          </script>