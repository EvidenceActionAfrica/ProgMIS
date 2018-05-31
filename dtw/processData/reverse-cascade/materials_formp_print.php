<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive="tab1";
$tableCount=isset($_POST["tableCount"])?$_POST["tableCount"]:10;

if(isset($_GET["editFormPId"])){
$tabActive="tab3";
    
}

    $division_name=isset($_POST["division_name"])?mysql_real_escape_string($_POST["division_name"]):"";
    $total_number=isset($_POST["total_number"])?mysql_real_escape_string($_POST["total_number"]):"";
    $total_enrolled_primary=isset($_POST["total_enrolled_primary"])?mysql_real_escape_string($_POST["total_enrolled_primary"]):"";
    $total_enrolled_ecd=isset($_POST["total_enrolled_ecd"])?mysql_real_escape_string($_POST["total_enrolled_ecd"]):"";
    $total_number_stand_alone=isset($_POST["total_number_stand_alone"])?mysql_real_escape_string($_POST["total_number_stand_alone"]):"";
    $total_enrolled_stand_alone=isset($_POST["total_enrolled_stand_alone"])?mysql_real_escape_string($_POST["total_enrolled_stand_alone"]):"";
    $number_alb_tablets=isset($_POST["number_alb_tablets"])?mysql_real_escape_string($_POST["number_alb_tablets"]):"";
    $number_bilharzia_schools=isset($_POST["number_bilharzia_schools"])?mysql_real_escape_string($_POST["number_bilharzia_schools"]):"";
    $number_pzq_tablets=isset($_POST["number_pzq_tablets"])?mysql_real_escape_string($_POST["number_pzq_tablets"]):"";
    $agreed_deworming_date=isset($_POST["agreed_deworming_date"])?mysql_real_escape_string($_POST["agreed_deworming_date"]):"";
    $agreed_return_form_s=isset($_POST["agreed_return_form_s"])?mysql_real_escape_string($_POST["agreed_return_form_s"]):"";
    $agreed_aeo_return_form_s_a=isset($_POST["agreed_aeo_return_form_s_a"])?mysql_real_escape_string($_POST["agreed_aeo_return_form_s_a"]):"";
    $agreed_deo_return_form_s_a_d=isset($_POST["agreed_deo_return_form_s_a_d"])?mysql_real_escape_string($_POST["agreed_deo_return_form_s_a_d"]):"";
    $prepared_by=isset($_SESSION["staff_name"])?mysql_real_escape_string($_SESSION["staff_name"]):"";
if(isset($_POST["formPSubmit"])){
    $date=time();
    
    $sql="INSERT INTO `materials_form_p_division_summary`(`division_name`, `total_number`, ";
    $sql.="`total_enrolled_primary`, `total_enrolled_ecd`, `total_number_stand_alone`, `total_enrolled_stand_alone`,";
    $sql.="`number_alb_tablets`, `number_bilharzia_schools`, `number_pzq_tablets`, `agreed_deworming_date`, ";
    $sql.="`agreed_return_form_s`, `agreed_aeo_return_form_s_a`, `agreed_deo_return_form_s_a_d`, `prepared_by`, `date`)";
    $sql.="VALUES ('$division_name','$total_number','$total_enrolled_primary','$total_enrolled_ecd','$total_number_stand_alone','$total_enrolled_stand_alone','$number_alb_tablets','$number_bilharzia_schools',";
    $sql.="'$number_pzq_tablets','$agreed_deworming_date','$agreed_return_form_s','$agreed_aeo_return_form_s_a','$agreed_deo_return_form_s_a_d', '$prepared_by','$date')";
    mysql_query($sql) or die(mysql_error());
    
    $sql="SELECT * from materials_form_p_division_summary order by form_p_id DESC LIMIT 1";
    $resultA=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_array($resultA)){
        $formP=$row["form_p_id"];
        $formPDate=$row["date"];
    }
    $count=1;
    while(isset($_POST["training_venue".$count])){
    $training_venue=isset($_POST["training_venue".$count])?$_POST["training_venue".$count]:"";
    $training_date=isset($_POST["training_date".$count])?$_POST["training_date".$count]:"";
    
    $officer_name=isset($_POST["officer_name".$count])?$_POST["officer_name".$count]:"";
    $officer_phone=isset($_POST["officer_phone".$count])?$_POST["officer_phone".$count]:"";
    $non_bilharzia=isset($_POST["non_bilharzia".$count])?$_POST["non_bilharzia".$count]:"";
    $bilharzia=isset($_POST["bilharzia".$count])?$_POST["bilharzia".$count]:"";
    $total_ab=isset($_POST["total_ab".$count])?$_POST["total_ab".$count]:"";
    
    $sql="INSERT INTO `materials_form_p_division_schedule`(`form_p_id`, `training_venue`, `training_date`,";
    $sql.="`officer_name`, `officer_phone`, `non_bilharzia`, `bilharzia`, `total_ab`)";
    $sql.="VALUES ('$formP','$training_venue','$training_date','$officer_name','$officer_phone','$non_bilharzia',";
    $sql.="'$bilharzia','$total_ab')";
    mysql_query($sql) or die(mysql_error());
    ++$count;
    
    }
      $updateResult="A FormP Was Created";
      $tabActive="tab2";
    
}
if(isset($_POST["FormPUpdate"])){
    $form_p_id=$_GET["editFormPId"];
    
    $sql="UPDATE `materials_form_p_division_summary` SET `division_name`='$division_name',";
    $sql.="`total_number`='$total_number',`total_enrolled_primary`='$total_enrolled_primary',`total_enrolled_ecd`='$total_enrolled_ecd',";
    $sql.="`total_number_stand_alone`='$total_number_stand_alone',`total_enrolled_stand_alone`='$total_enrolled_stand_alone',`number_alb_tablets`='$number_alb_tablets',";
    $sql.="`number_bilharzia_schools`='$number_bilharzia_schools',`number_pzq_tablets`='$number_pzq_tablets',`agreed_deworming_date`='$agreed_deworming_date',";
    $sql.="`agreed_return_form_s`='$agreed_return_form_s',`agreed_aeo_return_form_s_a`='$agreed_aeo_return_form_s_a',";
    $sql.="`agreed_deo_return_form_s_a_d`='$agreed_deo_return_form_s_a_d' WHERE form_p_id='$form_p_id'";
  // echo $sql;
    mysql_query($sql)or die(mysql_error());
    
    $updateResult="Form P updated";
    
    $sql="Select id from materials_form_p_division_schedule WHERE form_p_id=".$form_p_id;
     $resultA=mysql_query($sql) or die(mysql_error());
    $idArray=array();
     while($row=mysql_fetch_array($resultA)){
         array_push($idArray,$row["id"]);
    }
    
     $count=1;
    while(isset($_POST["training_venue".$count])){
    $training_venue=isset($_POST["training_venue".$count])?$_POST["training_venue".$count]:"";
    $training_date=isset($_POST["training_date".$count])?$_POST["training_date".$count]:"";
    
    $officer_name=isset($_POST["officer_name".$count])?$_POST["officer_name".$count]:"";
    $officer_phone=isset($_POST["officer_phone".$count])?$_POST["officer_phone".$count]:"";
    $non_bilharzia=isset($_POST["non_bilharzia".$count])?$_POST["non_bilharzia".$count]:"";
    $bilharzia=isset($_POST["bilharzia".$count])?$_POST["bilharzia".$count]:"";
    $total_ab=isset($_POST["total_ab".$count])?$_POST["total_ab".$count]:"";
    
    $sql="UPDATE `materials_form_p_division_schedule` SET`training_venue`='$training_venue',`training_date`='$training_date',"
            . "`officer_name`='$officer_name',`officer_phone`='$officer_phone',`non_bilharzia`='$non_bilharzia',`bilharzia`='$bilharzia',"
            . "`total_ab`='$total_ab' WHERE `form_p_id`='$form_p_id' AND id=".$idArray[$count-1];
    mysql_query($sql) or die(mysql_error());
    ++$count;
    
    }
    
    
    
    
}
if(isset($_GET["deleteformPId"])){
    $form_p_id=$_GET["deleteformPId"];

    $sql="DELETE from materials_form_p_division_summary where form_p_id=".$form_p_id;
    mysql_query($sql)or die(mysql_error());
    
    $sql="DELETE from materials_form_p_division_schedule where form_p_id=".$form_p_id;
    mysql_query($sql)or die(mysql_error());
    $updateResult="A FormP Was Deleted";
      $tabActive="tab2";
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit= $row['priv_materials_edit'];
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>


  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php   require_once ("includes/menuNav.php");  ?>
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
       <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
      <div class="contentBody" >


      <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Form P Generation</a></li>
    
              <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Form P History</a></li>
          </ul>
     

      <div class="tab-content" style="max-height:650px; overflow:scroll;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                
                
                   <table border=1 style="background-color:#FFFFFF;margin-top:5%;">
           <td rowspan="2"> Do Not Write in this Space</td>
           
          </table>
                
               <img src="../images/kwaAfya.png" style="margin-left:15%;width:5%;background-color:#FFFFFF;"/>
          <div style="margin-left:45%;width:30%;align:center">
           <h1>FORM P:DIVISON</h1>
          <h2>Planning</h2>
          <h3>(Program Activities)</h3>
        </div>
                <br/><br/>
                
                
                
                
                
              <table border=1 style="background-color:#FFFFFF;">
           <td> Do Not Write in this Space</td>
          </table>
          <div style="margin-left:45%;width:30%;align:center">
           
          <img src="../images/kwaAfya.png" style="width:15%;background-color:#FFFFFF;"/><h1>FORM P:DIVISON</h1>
          <h2>Planning</h2>
          <h3>(Program Activities)</h3>
        </div>

        <div class="divcontent" style="align:center;background-color:#FFFFFF;">
          <h3 style="align:center">Using Form P (school list) please complete the planning exercise below for your division.</h3>
          <form method="POST" action="materials_formp.php">
       
            <table class="table table-bordered table-condensed table-striped table-hover">

              <tr>
                <td colspan="9"><b>1. Division Summary: Please add up all Form P sheet totals to give a summary for this division</b></td>
              </tr>
              <tr>
                <th>Division Name</th>
                <th>Total Number</th>
                <th colspan="2">Enrollment In Schools</th>
                <th>Total Number Of stand-alone</th>
                <th>Total Enrollment in stand-alone</th>
                <th>No. Of ALB Tablets</th>
                <th>No. Of Bilhazia Schools</th>
                <th>No. Of Pzq Tablets</th>
 
              </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Primary</th>
                  <th>ECD</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
                 <tr>
                  <td>
                      <select name="division_name">
                          <option selected="selected" value="none">--Choose Division--</option>
                          <?php
                          $sql="select division_name from divisions";
                          $results=mysql_query($sql);
                          while($row=mysql_fetch_array($results)){
                              echo "<option value=".$row["division_name"].">".$row["division_name"]."</option>";
                          }
                          ?>
                      </select>
                  
                  </td>
                  <td><input type="text" class="input-mini num-only" name="total_number" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_primary" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_ecd" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_number_stand_alone" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_stand_alone" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_alb_tablets" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_bilharzia_schools" value="" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_pzq_tablets" value="" /></td>
                </tr>



            </table>
            <br/><br/><b>
            <br/><br/>
            2. Number of Training Sessions:<br/>
Based on the programme in your division last year the total number of teacher training sessions allocated to your division this year is

This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session. Please speak with a Master Trainer if you think the number of teacher training sessions should be revised.
</b><br/><br/>
 <table class="table table-bordered table-condensed table-striped table-hover">

              <tr>
                <td colspan="8"><b>3. Plan scheduling and select venues for teacher training</b></td>
              </tr>

              <tr>
                <td colspan="8"><b>As a division plan the teacher training sessions according to the number needed Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</b>
              </tr>
              <tr>
                <th></th>
                 <th>Training Venue</th>
                 <th>Estimated Training Date</th>
                 <th colspan="2" align="center">Assigned Responsible Officer MoE or MoH</th>
                 <th colspan="3" align="center">No. Of Schools Attending</th>
              </tr>
              <tr>
                <th>No.</th>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Non-Bilharzia(A)</th>
                <th>Bilharzia(B)</th>
                <th>Total(A+B)</th>
              </tr>

              <?php
              $append=1;
              while($tableCount>0){

                $number="number".$append;
                $training_venue="training_venue".$append;
                $training_date="training_date".$append;
                $officer_name="officer_name".$append;
                $officer_phone="officer_phone".$append;
                $non_bilharzia="non_bilharzia".$append;
                $bilharzia="bilharzia".$append;
                $total_ab="total_ab".$append;
                echo "<tr>";
                echo "<td>$append</td>";
                echo "<td><input type='text'  name='".$training_venue."' value='' /></td>";
                echo "<td><input type='text' class='datepicker' name='".$training_date."' value='' /></td>";
                echo "<td><input type='text'  name='".$officer_name."' value='' /></td>";
                echo "<td><input type='text'  name='".$officer_phone."' value='' /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='".$non_bilharzia."'id='".$non_bilharzia."' value='' onkeyup='calculateTotal($non_bilharzia,$bilharzia,$total_ab)' /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='".$bilharzia."'id='".$bilharzia."' value='' onkeyup='calculateTotal($non_bilharzia,$bilharzia,$total_ab)' /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='".$total_ab."''id='".$total_ab."' value='' onkeyup='calculateTotal($non_bilharzia,$bilharzia,$total_ab)'  /></td>";
                            
             echo "</tr>";

              ++$append;
              --$tableCount;


                }
              ?>




   </table>
   Add Rows
   <select name="tableCount" onchange="tableChange()">
      
      <?php
      $counter=1;
      while($counter<=20){
        if($counter==5){
       echo "<option selected=\"selected\" value=5>5</option>";
        }else{
      echo "<option value=".$counter."> ".$counter."</option>";
     
    }
     ++$counter;
  }
    ?>
   </select>

<input type="submit" style="display:none;" id="tableCheck" name="tableCheck" value="Generate" />
<br/><br/>
<table class="table table-bordered table-condensed table-striped table-hover">
  <tr><td colspan="3"><b>4. As a district please agree on and record the following dates:</b>
      </td>
  </tr>


  <tr><td>Event</td><td>Guidance On Date<i>(As agreed by County)</i></td><td>Agreed Date<br/><i>(DD/MM/YY)</i></td>
  </tr>
    <tr><td>Deworming Day</td><td><i>About 1 week after teacher training</i></td><td><input type="text" name="agreed_deworming_date" class="datepicker" /></td>
    </tr>
  <tr><td>Return Form S to AEO</td><td><i>About 1 week after teacher training</i></td><td><input type="text" name="agreed_return_form_s" class="datepicker" /></td>
    </tr>
  <tr><td>AEO Returns Form S and A to DEO</td><td><i>About 2 weeks after deworming day</i></td><td><input type="text" name="agreed_aeo_return_form_s_a" class="datepicker" /></td>
    </tr>
  <tr><td>DEO returns S,A, and D to national team</td><td><i>About 3 weeks after deworming day</i></td><td><input type="text" name="agreed_deo_return_form_s_a_d" class="datepicker" /></td>
    </tr>



</table>
<b>
Thank You Division Officers. Please make sure the AEO, DEO, MT and all people conducting a TT session have a copy<br/>
of correctly filled Form P including School List. Please give the original to a master trainer. Please use Form P to prefill Form A and AP with school names and IDs for each division.
</b>


<br/><br/>
 <?php   if($priv_materials_edit>=2){ ?>
<input type="submit" class="btn-custom" style="margin-left:30%;" name="formPSubmit" value="Submit Form" /><br/>
<?php }?>

          </form>
        </div>









         </div>
          
          <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              
   <h2 style="background-color:#bada66;align:center;"><?php echo $updateResult;$updateResult="";?></h2>
        <?php
        $sql="SELECT * from materials_form_p_division_summary";
        $resultS=  mysql_query($sql);
        $numRows=mysql_affected_rows();
        if($numRows>=1){
        ?>
              <table class="table table-bordered table-condensed table-striped table-hover">
                  <caption>
                      <h2>Captured Form P's</h2>
                  </caption>
                  <tr>
                      <th>Division</th>
                      <th>Agreed Deworming Date</th>
                      <th>Return Form S to AEO</th>
                      <th>AEO Returns Form S <br/>and A to DEO</th>
                      <th>DEO returns S,A, and <br/>D to national team</th>
                      <th>Prepared By</th>
                       <?php if($priv_materials_edit>=1){ ?>
                      <th>View</th>
                      <?php } if($priv_materials_edit>=3){ ?>
                      <th>Edit</th>
                      <?php }if($priv_materials_edit>=4){ ?>
                      <th>Delete</th>
                      <?php } ?>
                  </tr>
              
        <?php
        while($row=mysql_fetch_array($resultS)){
          $formPId= $row["form_p_id"];
            echo "<tr><td>".$row["division_name"].
            "</td><td>".$row["agreed_deworming_date"].
            "</td><td>".$row["agreed_return_form_s"].
            "</td><td>".$row["agreed_aeo_return_form_s_a"].
            "</td><td>".$row["agreed_deo_return_form_s_a_d"].
            "</td><td>".$row["prepared_by"]."</td>";
     if($priv_materials_edit>=1){ 
           echo  "<td><a href='materials_formp.php?formPId=".$row["form_p_id"]."'target='blank' ><img src='../images/icons/view2.png' height='20px'/></a></td>";
     }if($priv_materials_edit>=3){ 
    echo "<td><a href='javascript:void(0)' onclick='setFormP($formPId)'><img src='../images/icons/edit.png' height='20px'/></a></td>";
     }if($priv_materials_edit>=4){ 
echo "<td><a href='javascript:void(0)' onclick='showConfirm($formPId)'><img src='../images/icons/delete.png' height='20px'/></a>
</td></tr>";
       }      	   
        }
        ?>
              
              
        </table>
              
             <?php
        }else{
            echo "<h2 style='background-color:#bada66;'>No Records Found</h2>";
        }
        ?>
          </div>

          <div style="" class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3" >
          <?php
          if(isset($_GET["editFormPId"])){
          $form_p_id=$_GET["editFormPId"];
          ?>
              <h2 style="background-color:#bada66;align:center;"><?php echo $updateResult;$updateResult="";?></h2>
          <div style="background-color:#FFFFFF;">
                    <table border=1 style="background-color:#FFFFFF;">
           <td> Do Not Write in this Space</td>
          </table>
          <div style="margin-left:45%;width:30%;align:center;background-color:#FFFFFF;">
           
          <img src="../images/kwaAfya.png" style="width:15%;background-color:#FFFFFF;"/><h1>FORM P:DIVISON</h1>
          <h2>Planning</h2>
          <h3>(Program Activities)</h3>
        </div>
              
        <div class="divcontent"style="align:center;background-color:#FFFFFF;">
          <h3 style="align:center">Using Form P (school list) please complete the planning exercise below for your division.</h3>
          <form method="POST">
       
            <table class="table table-bordered table-condensed table-striped table-hover">

              <tr>
                <td colspan="9"><b>1. Division Summary: Please add up all Form P sheet totals to give a summary for this division</b></td>
              </tr>
              <tr>
                <th>Division Name</th>
                <th>Total Number</th>
                <th colspan="2">Enrollment In Schools</th>
                <th>Total Number Of stand-alone</th>
                <th>Total Enrollment in stand-alone</th>
                <th>No. Of ALB Tablets</th>
                <th>No. Of Bilhazia Schools</th>
                <th>No. Of Pzq Tablets</th>
 
              </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Primary</th>
                  <th>ECD</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
                 <tr>
                  <td>
                      <?php
                      $sql="SELECT * from materials_form_p_division_summary WHERE form_p_id=".$form_p_id;
                      $resultA=mysql_query($sql)or die(mysql_error());
                      while($row=mysql_fetch_array($resultA)){
                       
                          $division_name=$row["division_name"];
                         $total_number=$row["total_number"];
                            $total_enrolled_primary=$row["total_enrolled_primary"];
                            $total_enrolled_ecd=$row["total_enrolled_ecd"];
                            $total_number_stand_alone=$row["total_number_stand_alone"];
                            $total_enrolled_stand_alone=$row["total_enrolled_stand_alone"];
                            $number_alb_tablets=$row["number_alb_tablets"];
                            $number_bilharzia_schools=$row["number_bilharzia_schools"];
                            $number_pzq_tablets=$row["number_pzq_tablets"];
                            $agreed_deworming_date=$row["agreed_deworming_date"];
                            $agreed_return_form_s=$row["agreed_return_form_s"];
                            $agreed_aeo_return_form_s_a=$row["agreed_aeo_return_form_s_a"];
                            $agreed_deo_return_form_s_a_d=$row["agreed_deo_return_form_s_a_d"];
                          
                      }
                      
                      
                      
                      
                      
                      
                      ?>
                      
                      <select name="division_name">
                          <option selected="selected" value="<?php echo $division_name ; ?>"><?php echo $division_name ; ?></option>
                          <?php
                          $sql="select division_name from divisions";
                          $results=mysql_query($sql);
                          while($row=mysql_fetch_array($results)){
                              echo "<option value=".$row["division_name"].">".$row["division_name"]."</option>";
                          }
                          ?>
                      </select>
                  
                  </td>
                     <td><input type="text" class="input-mini num-only" name="total_number" value="<?php echo $total_number; ?>"/></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_primary" value="<?php echo $total_enrolled_primary; ?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_ecd" value="<?php echo $total_enrolled_ecd; ?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_number_stand_alone" value="<?php echo $total_number_stand_alone; ?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="total_enrolled_stand_alone" value="<?php echo $total_enrolled_stand_alone; ?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_alb_tablets" value="<?php echo $number_alb_tablets; ?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_bilharzia_schools" value="<?php echo $number_bilharzia_schools;?>" /></td>
                  <td><input type="text" class="input-mini num-only" name="number_pzq_tablets" value="<?php echo $number_pzq_tablets; ?>" /></td>
                </tr>



            </table>
            <br/><br/><b>
            <br/><br/>
            2. Number of Training Sessions:<br/>
Based on the programme in your division last year the total number of teacher training sessions allocated to your division this year is

This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session. Please speak with a Master Trainer if you think the number of teacher training sessions should be revised.
</b><br/><br/>
 <table class="table table-bordered table-condensed table-striped table-hover">

              <tr>
                <td colspan="8"><b>3. Plan scheduling and select venues for teacher training</b></td>
              </tr>

              <tr>
                <td colspan="8"><b>As a division plan the teacher training sessions according to the number needed Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</b>
              </tr>
              <tr>
                <th></th>
                 <th>Training Venue</th>
                 <th>Estimated Training Date</th>
                 <th colspan="2" align="center">Assigned Responsible Officer MoE or MoH</th>
                 <th colspan="3" align="center">No. Of Schools Attending</th>
              </tr>
              <tr>
                <th>No.</th>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Non-Bilharzia(A)</th>
                <th>Bilharzia(B)</th>
                <th>Total(A+B)</th>
              </tr>

              <?php
              $append=1;
              
              $sql="SELECT * from materials_form_p_division_schedule WHERE form_p_id=".$form_p_id;
              $resultsS=mysql_query($sql)or die(mysql_error());
              
              while($row=mysql_fetch_array($resultsS)){

                  $training_venue=$row["training_venue"];
                  $training_date=$row["training_date"];
                  $officer_name=$row["officer_name"];
                  $officer_phone=$row["officer_phone"];
                  $non_bilharzia=$row["non_bilharzia"];
                  $bilharzia=$row["bilharzia"];
                  $total_ab=$row["total_ab"];
                  $jsnon_bilharzia="non_bilharzia".$append;
                  $jsbilharzia="bilharzia".$append;
                  $jstotal_ab="total_ab".$append;
                echo "<tr>";
                echo "<td>$append</td>";
                echo "<td><input type='text'  name='training_venue".$append."' value=".$training_venue." /></td>";
                echo "<td><input type='text' class='datepicker' name='training_date".$append."' value=".$training_date." /></td>";
                echo "<td><input type='text'  name='officer_name".$append."' value=".$officer_name." /></td>";
                echo "<td><input type='text'  name='officer_phone".$append."' value=".$officer_phone." /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='non_bilharzia".$append."'id='non_bilharzia".$append."' value=".$non_bilharzia." onkeyup='calculateTotal($jsnon_bilharzia,$jsbilharzia,$jstotal_ab)' /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='bilharzia".$append."'id='bilharzia".$append."' value=".$bilharzia." onkeyup='calculateTotal($jsnon_bilharzia,$jsbilharzia,$jstotal_ab)' /></td>";
                echo "<td><input type='text' class='input-mini num-only' name='total_ab".$append."''id='total_ab".$append."' value=".$total_ab." onkeyup='calculateTotal($jsnon_bilharzia,$jsbilharzia,$jstotal_ab)'  /></td>";
                            
             echo "</tr>";

              ++$append;
              


                }
         
                
              ?>




   </table>

<br/><br/>
<table class="table table-bordered table-condensed table-striped table-hover">
  <tr><td colspan="3"><b>4. As a district please agree on and record the following dates:</b>
      </td>
  </tr>


  <tr><td>Event</td><td>Guidance On Date<i>(As agreed by County)</i></td><td>Agreed Date<br/><i>(DD/MM/YY)</i></td>
  </tr>
    <tr><td>Deworming Day</td><td><i>About 1 week after teacher training</i></td><td><input type="text" name="agreed_deworming_date" class="datepicker" value="<?php echo $agreed_deworming_date; ?>"/></td>
    </tr>
  <tr><td>Return Form S to AEO</td><td><i>About 1 week after teacher training</i></td><td><input type="text" name="agreed_return_form_s" class="datepicker" value="<?php echo $agreed_return_form_s ?>"/></td>
    </tr>
  <tr><td>AEO Returns Form S and A to DEO</td><td><i>About 2 weeks after deworming day</i></td><td><input type="text" name="agreed_aeo_return_form_s_a" class="datepicker" value="<?php echo $agreed_aeo_return_form_s_a; ?>"/></td>
    </tr>
  <tr><td>DEO returns S,A, and D to national team</td><td><i>About 3 weeks after deworming day</i></td><td><input type="text" name="agreed_deo_return_form_s_a_d" class="datepicker" value="<?php echo $agreed_deo_return_form_s_a_d; ?>"/></td>
    </tr>



</table>
<b>
Thank You Division Officers. Please make sure the AEO, DEO, MT and all people conducting a TT session have a copy<br/>
of correctly filled Form P including School List. Please give the original to a master trainer. Please use Form P to prefill Form A and AP with school names and IDs for each division.
</b>


<br/><br/>
<input type="submit" class="btn-custom" style="margin-left:30%;" name="FormPUpdate" value="Update Form" /><br/>


          </form>
        </div>
</div>


<?php
          }else{
           //   header("Location:materials_formp.php");
             // exit();
          }
?>




          
          </div>   
          
          
          
          
      </div>
  </div>
   </div>












        </div>
		
 
<script>

    $(function() {
      $(".datepicker").datepicker({ dateFormat: "dd-mm-yy"});
    });
      $(document).find("input.num-only").keydown(function (e) {
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
      function calculateTotal(a,b,c){

        c.value=(a.value *1)+(b.value *1);
        document.getElementById(c).innerHTML=c.value;

      }
      function tableChange(){
        var selectButton=document.getElementById("tableCheck");
        selectButton.click();
      }
      function setFormP(formPId){
            if (confirm("Are you sure you want to Edit?")) {
        location.replace('?editFormPId=' + formPId);
      } else {
        return false;
      }
      }
       function showConfirm(deleteformPId){
            if (confirm("Are you sure you want to Delete This Record?")) {
        location.replace('?deleteformPId=' + deleteformPId);
      } else {
        return false;
      }
      }
</script>

<?php
if(isset($_GET["formPId"])){
    $form_p_id=$_GET["formPId"];
    $sql="SELECT * from materials_form_p_division_summary as mp WHERE mp.form_p_id=".$form_p_id;
   // echo $sql;
    $resultA=mysql_query($sql) or die(mysql_error());
    while($row=mysql_fetch_array($resultA)){
        
          $division_name=$row["division_name"];
    $total_number=$row["total_number"];
    $total_enrolled_primary=$row["total_enrolled_primary"];
    $total_enrolled_ecd=$row["total_enrolled_ecd"];
    $total_number_stand_alone=$row["total_number_stand_alone"];
    $total_enrolled_stand_alone=$row["total_enrolled_stand_alone"];
    $number_alb_tablets=$row["number_alb_tablets"];
    $number_bilharzia_schools=$row["number_bilharzia_schools"];
    $number_pzq_tablets=$row["number_pzq_tablets"];
    $agreed_deworming_date=$row["agreed_deworming_date"];
    $agreed_return_form_s=$row["agreed_return_form_s"];
    $agreed_aeo_return_form_s_a=$row["agreed_aeo_return_form_s_a"];
    $agreed_deo_return_form_s_a_d=$row["agreed_deo_return_form_s_a_d"];
   }
    
    
    
    
   /* 
 $data="    <table>
           <td> Do Not Write in this Space</td>
          </table>
          <div>
           
          <img src'../images/kwaAfya.png' style='width:15%;' /><h1>FORM P:DIVISON</h1>
          <h2>Planning</h2>
          <h3>(Program Activities)</h3>
        </div>
";
 */
 $data="
        
          <h3>Using Form P (school list) please complete the planning exercise below for your division.</h3>
         
       
            <table>

              <tr>
                <td colspan=\"9\"><b>1. Division Summary: Please add up all Form P sheet totals to give a summary for this division</b></td>
              </tr>
              <tr>
                <th>Division<br/> Name</th>
                <th>Total Number</th>
                <th colspan=\"2\">Enrollment<br/> In Schools</th>
                <th>Total Number<br/> Of stand-alone</th>
                <th>Total Enrollment<br/> in stand-alone</th>
                <th>No. Of<br/> ALB Tablets</th>
                <th>No. Of<br/> Bilhazia Schools</th>
                <th>No. Of<br/> Pzq Tablets</th>
 
              </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Primary</th>
                  <th>ECD</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
            
       ";
$data.="        <tr>   <td>$division_name</td>
                  <td>$total_number</td>
                  <td>$total_enrolled_primary</td>
                  <td>$total_enrolled_ecd</td>
                  <td>$total_number_stand_alone</td>
                  <td>$total_enrolled_stand_alone</td>
                  <td>$number_alb_tablets</td>
                  <td>$number_bilharzia_schools</td>
                  <td>$number_pzq_tablets</td>
                </tr>
                 </table>
";
$data.="
           
            <br/><br/><b>
            
            2. Number of Training Sessions:<br/>
Based on the programme in your division last year the total number of teacher training sessions allocated to your division this year is

This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session. Please speak with a Master Trainer if you think the number of teacher training sessions should be revised.
</b><br/><br/>
 <table>

              <tr>
                <td colspan=\"8\"><b>3. Plan scheduling and select venues for teacher training</b></td>
              </tr>

              <tr>
                <td colspan=\"8\"><b>As a division plan the teacher training sessions according to the number needed Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</b></td>
              </tr>
              <tr>
                <th>No</th>
                 <th>Training Venue</th>
                 <th>Estimated<br/> Training<br/> Date</th>
                 <th colspan=\"2\">Assigned Responsible<br/> Officer<br/> MoE or MoH</th>
                 <th colspan=\"3\">No. Of Schools<br/> Attending</th>
              </tr>
               <tr>
                <th>No.</th>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Non-Bilharzia(A)</th>
                <th>Bilharzia(B)</th>
                <th>Total(A+B)</th>
              </tr>
";
$sql="SELECT * from materials_form_p_division_schedule where form_p_id=".$form_p_id;
$resultB=mysql_query($sql) or die(mysql_error());
$append=1;
while($row=mysql_fetch_array($resultB)){
    
               
                $training_venue=$row["training_venue"];
                $training_date=$row["training_date"];
                $officer_name=$row["officer_name"];
                $officer_phone=$row["officer_phone"];
                $non_bilharzia=$row["non_bilharzia"];
                $bilharzia=$row["bilharzia"];
                $total_ab=$row["total_ab"];


            
  $data.="              <tr>
                <td>$append</td>
                <td>$training_venue</td>
               <td>$training_date</td>
                <td>$officer_name</td>
                <td>$officer_phone</td>
                <td>$non_bilharzia</td>
                <td>$bilharzia</td>
                <td>$total_ab</td>
           </tr> 
  ";
  
  ++$append;
}
 $data.=" </table>
     <br/><br/>
<table>
  <tr><td><b>4. As a district please agree on and record the following dates:</b>
      </td>
  </tr>
 </table>
               <table>

  <tr><th>Event</th><th>Guidance On Date<i>(As agreed by County)</i></th><th>Agreed Date<br/><i>(DD/MM/YY)</i></th>
  </tr>
    <tr><td>Deworming Day</td><td><i>About 1 week after teacher training</i></td><td>$agreed_deworming_date</td>
    </tr>
  <tr><td>Return Form S to AEO</td><td><i>About 1 week after teacher training</i></td><td>$agreed_return_form_s</td>
    </tr>
  <tr><td>AEO Returns Form S and A to DEO</td><td><i>About 2 weeks after deworming day</i></td><td>$agreed_aeo_return_form_s_a</td>
    </tr>
  <tr><td>DEO returns S,A, and D to national team</td><td><i>About 3 weeks after deworming day</i></td><td>$agreed_deo_return_form_s_a_d</td>
    </tr>



</table>
 <br/>
<b>
Thank You Division Officers. Please make sure the AEO, DEO, MT and all people conducting a TT session have a copy
of correctly filled Form P including School List. Please give the original to a master trainer. Please use Form P to prefill Form A and AP with school names and IDs for each division.
</b>


<br/><br/>


";
 
 
 
 
 
 
    
    
    
    
    
    
    
    
//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
// $_SESSION["tableData"]="Hello";
 header("Location:../tcpdf/examples/materials_form_p.php");
exit();
echo "<pre>";
var_dump($data);
echo "</pre>";




    
    
}

?>