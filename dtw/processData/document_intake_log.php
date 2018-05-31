<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once ("includes/class.documentIntakeLog.php");

$intakeLog= new intakeLog;

$tabActive="tab1";
if(isset($_GET['tabActive'])){
  $tabActive=$_GET["tabActive"];
}
//Submit Document Intake Materials Form
if(isset($_POST['Submit']))
{
//Sel All Fields Populated
      	$district_name = $_POST['district_name'];
      	$date_of_receipt= $_POST['date_of_receipt'];
      	$submited_to= $_POST['submited_to'];
      	$how_received = $_POST['how_received'];
      	$description= mysql_real_escape_string($_POST['description']);
       
        $cdreport=mysql_real_escape_string($_POST["cdreport"]);
        $frf=mysql_real_escape_string($_POST["frf"]);
        $fin9=mysql_real_escape_string($_POST["fin9"]);
        $fin5ahs=mysql_real_escape_string($_POST["fin5ahs"]);
        $fin6ths=mysql_real_escape_string($_POST["fin6ths"]);
        $fin3lhs=mysql_real_escape_string($_POST["fin3lhs"]);
        $fin7=mysql_real_escape_string($_POST["fin7"]);
        $fin8=mysql_real_escape_string($_POST["fin8"]);
        $fin8ii=mysql_real_escape_string($_POST["fin8ii"]);
        $fin9d=mysql_real_escape_string($_POST["fin9d"]);
        $fin9e=mysql_real_escape_string($_POST["fin9e"]);
        $fin6=mysql_real_escape_string($_POST["fin6"]);
        $fin6c=mysql_real_escape_string($_POST["fin6c"]);
        $fin6t=mysql_real_escape_string($_POST["fin6t"]);
        $fin5=mysql_real_escape_string($_POST["fin5"]);
        $fin5c=mysql_real_escape_string($_POST["fin5c"]);
        $fin5cii=mysql_real_escape_string($_POST["fin5cii"]);
        $fin3=mysql_real_escape_string($_POST["fin3"]);
        $fin3c=mysql_real_escape_string($_POST["fin3c"]);
        $fin3cii=mysql_real_escape_string($_POST["fin3cii"]);
        $fin3d=mysql_real_escape_string($_POST["fin3d"]);
        $fin3th=mysql_real_escape_string($_POST["fin3th"]);
        $fin3a=mysql_real_escape_string($_POST["fin3a"]);
        $fin10c=mysql_real_escape_string($_POST["fin10c"]);
        $fin15h=mysql_real_escape_string($_POST["fin15h"]);
        $ireport=mysql_real_escape_string($_POST["ireport"]);
        $formssp=mysql_real_escape_string($_POST["formssp"]);
        $formaap=mysql_real_escape_string($_POST["formaap"]);
        $formddp=mysql_real_escape_string($_POST["formddp"]);
        $workTicket=mysql_real_escape_string($_POST["workTicket"]);
        $attnt=mysql_real_escape_string($_POST["attnt"]);
        $attnc=mysql_real_escape_string($_POST["attnc"]);
        $tabpickup=mysql_real_escape_string($_POST["tabpickup"]);
        $tabreturn=mysql_real_escape_string($_POST["tabreturn"]);
        $courier=mysql_real_escape_string($_POST["courier"]);
        $pashire=mysql_real_escape_string($_POST["pashire"]);
        $meals=mysql_real_escape_string($_POST["meals"]);
        $stationery=mysql_real_escape_string($_POST["stationery"]);
        $projecthire=mysql_real_escape_string($_POST["projecthire"]);
        $taxihire=mysql_real_escape_string($_POST["taxihire"]);
        $hallhire=mysql_real_escape_string($_POST["hallhire"]);
        $photocopying=mysql_real_escape_string($_POST["photocopying"]);
        $bankstmt=mysql_real_escape_string($_POST["bankstmt"]);
        $fuel=mysql_real_escape_string($_POST["fuel"]);
         
        
        $cdreport=mysql_real_escape_string($_POST["cdreportcheck"])=="YES"?mysql_real_escape_string($_POST["cdreport"]):"";
        $frf=mysql_real_escape_string($_POST["frfcheck"])=="YES"?mysql_real_escape_string($_POST["frf"]):"";
        $fin9=mysql_real_escape_string($_POST["fin9check"])=="YES"?mysql_real_escape_string($_POST["fin9"]):"";
         $fin5ahs=mysql_real_escape_string($_POST["fin5ahscheck"])=="YES"?mysql_real_escape_string($_POST["fin5ahs"]):"";
        $fin6ths=mysql_real_escape_string($_POST["fin6thscheck"])=="YES"?mysql_real_escape_string($_POST["fin6ths"]):"";
        $fin3lhs=mysql_real_escape_string($_POST["fin3lhscheck"])=="YES"?mysql_real_escape_string($_POST["fin3lhs"]):"";
        $fin7=mysql_real_escape_string($_POST["fin7check"])=="YES"?mysql_real_escape_string($_POST["fin7"]):"";
        $fin8=mysql_real_escape_string($_POST["fin8check"])=="YES"?mysql_real_escape_string($_POST["fin8"]):"";
        $fin8ii=mysql_real_escape_string($_POST["fin8iicheck"])=="YES"?mysql_real_escape_string($_POST["fin8ii"]):"";
        $fin9d=mysql_real_escape_string($_POST["fin9dcheck"])=="YES"?mysql_real_escape_string($_POST["fin9d"]):"";
        $fin9e=mysql_real_escape_string($_POST["fin9echeck"])=="YES"?mysql_real_escape_string($_POST["fin9e"]):"";
        $fin6=mysql_real_escape_string($_POST["fin6check"])=="YES"?mysql_real_escape_string($_POST["fin6"]):"";
        $fin6c=mysql_real_escape_string($_POST["fin6ccheck"])=="YES"?mysql_real_escape_string($_POST["fin6c"]):"";
        $fin6t=mysql_real_escape_string($_POST["fin6tcheck"])=="YES"?mysql_real_escape_string($_POST["fin6t"]):"";
        $fin5=mysql_real_escape_string($_POST["fin5check"])=="YES"?mysql_real_escape_string($_POST["fin5"]):"";
        $fin5c=mysql_real_escape_string($_POST["fin5ccheck"])=="YES"?mysql_real_escape_string($_POST["fin5c"]):"";
        $fin5cii=mysql_real_escape_string($_POST["fin5ciicheck"])=="YES"?mysql_real_escape_string($_POST["fin5cii"]):"";
        $fin3=mysql_real_escape_string($_POST["fin3check"])=="YES"?mysql_real_escape_string($_POST["fin3"]):"";
        $fin3c=mysql_real_escape_string($_POST["fin3ccheck"])=="YES"?mysql_real_escape_string($_POST["fin3c"]):"";
        $fin3cii=mysql_real_escape_string($_POST["fin3ccheck"])=="YES"?mysql_real_escape_string($_POST["fin3c"]):"";
        $fin3d=mysql_real_escape_string($_POST["fin3dcheck"])=="YES"?mysql_real_escape_string($_POST["fin3d"]):"";
        $fin3th=mysql_real_escape_string($_POST["fin3thcheck"])=="YES"?mysql_real_escape_string($_POST["fin3th"]):"";
        $fin3a=mysql_real_escape_string($_POST["fin3acheck"])=="YES"?mysql_real_escape_string($_POST["fin3a"]):"";
        $fin10c=mysql_real_escape_string($_POST["fin10ccheck"])=="YES"?mysql_real_escape_string($_POST["fin10c"]):"";
        $fin15h=mysql_real_escape_string($_POST["fin15hcheck"])=="YES"?mysql_real_escape_string($_POST["fin15h"]):"";
        $ireport=mysql_real_escape_string($_POST["ireportcheck"])=="YES"?mysql_real_escape_string($_POST["ireport"]):"";
        $formssp=mysql_real_escape_string($_POST["formsspcheck"])=="YES"?"YES":"NO";
        $formaap=mysql_real_escape_string($_POST["formaapcheck"])=="YES"?"YES":"NO";
        $formddp=mysql_real_escape_string($_POST["formddpcheck"])=="YES"?"YES":"NO";
        $workTicket=mysql_real_escape_string($_POST["workTicketcheck"])=="YES"?mysql_real_escape_string($_POST["workTicket"]):"";
        $attnt=mysql_real_escape_string($_POST["attntcheck"])=="YES"?mysql_real_escape_string($_POST["attnt"]):"";
        $attnc=mysql_real_escape_string($_POST["attnccheck"])=="YES"?mysql_real_escape_string($_POST["attnc"]):"";
        $tabpickup=mysql_real_escape_string($_POST["attnccheck"])=="YES"?mysql_real_escape_string($_POST["attnc"]):"";
        $tabreturn=mysql_real_escape_string($_POST["tabreturncheck"])=="YES"?mysql_real_escape_string($_POST["tabreturn"]):"";
        $courier=mysql_real_escape_string($_POST["couriercheck"])=="YES"?mysql_real_escape_string($_POST["courier"]):"";
        $pashire=mysql_real_escape_string($_POST["pashirecheck"])=="YES"?mysql_real_escape_string($_POST["pashire"]):"";
        $meals=mysql_real_escape_string($_POST["mealscheck"])=="YES"?mysql_real_escape_string($_POST["meals"]):"";
        $stationery=mysql_real_escape_string($_POST["stationerycheck"])=="YES"?mysql_real_escape_string($_POST["stationery"]):"";
        $projecthire=mysql_real_escape_string($_POST["projecthirecheck"])=="YES"?mysql_real_escape_string($_POST["projecthire"]):"";
        $taxihire=mysql_real_escape_string($_POST["taxihirecheck"])=="YES"?mysql_real_escape_string($_POST["taxihire"]):"";
        $hallhire=mysql_real_escape_string($_POST["hallhirecheck"])=="YES"?mysql_real_escape_string($_POST["hallhire"]):"";
        $photocopying=mysql_real_escape_string($_POST["photocopyingcheck"])=="YES"?mysql_real_escape_string($_POST["photocopying"]):"";
        $bankstmt=mysql_real_escape_string($_POST["bankstmtcheck"])=="YES"?mysql_real_escape_string($_POST["bankstmt"]):"";
        $fuel=mysql_real_escape_string($_POST["fuelcheck"])=="YES"?mysql_real_escape_string($_POST["fuel"]):"";
        $ministry=mysql_real_escape_string($_POST["ministry"]);
        $county=mysql_real_escape_string($_POST['county']);
        $county_cascade=mysql_real_escape_string($_POST['county_cascade']);
        $district_cascade=mysql_real_escape_string($_POST['district_cascade']);
        
       $query="INSERT INTO `document_intake_log`(`county`,`county_cascade`,`district_cascade`,`ministry`,`district_name`, `date_of_receipt`, `submited_to`, `how_received`, `description`,";
       $query.="`cd_report`, `frf`, `fin9`, `fin5ahs`, `fin6ths`, `fin3lhs`, `fin7`, `fin8`, `fin8ii`, `fin9d`, `fin9e`, `fin6`, `fin6c`, ";
       $query.="`fin6t`, `fin5`, `fin5c`, `fin5cii`, `fin3`, `fin3c`, `fin3cii`, `fin3d`, `fin3th`, `fin3a`, `fin10c`, `fin15h`, `ireport`,";
       $query.="`formssp`, `formaap`, `formddp`, `workticket`, `attnt`, `attnc`, `tabpickup`, `tabreturn`, `courier`, `pashire`, `meals`,";
       $query.="`stationery`, `projectorhire`, `taxihire`, `hallhire`, `photocopying`, `bankstmt`, `fuel`)";
       $query.="VALUES ('{$county}','{$county_cascade}','{$district_cascade}','{$ministry}','{$district_name}','{$date_of_receipt}','{$submited_to}','{$how_received}','{$description}','$cdreport','$frf','$fin9','$fin5ahs','$fin6ths',";
       $query.="'$fin3lhs','$fin7','$fin8','$fin8ii','$fin9d','$fin9e','$fin6','$fin6c','$fin6t','$fin5','$fin5c',";
       $query.="'$fin5cii','$fin3','$fin3c','$fin3cii','$fin3d','$fin3th','$fin3a','$fin10c','$fin15h','$ireport','$formssp',";
       $query.="'$formaap','$formddp','$workTicket','$attnt','$attnc','$tabpickup','$tabreturn','$courier','$pashire','$meals','$stationery',";
    $query.="'$projecthire','$taxihire','$hallhire','$photocopying','$bankstmt','$fuel')";
     
	   mysql_query($query) or die (mysql_error());
	//header("Location: document_intake_log.php");


  if ($_POST["formsspcheck"]=="YES") {
    $intakeLog->update($_POST['district_name'],'S');
  }
  if ($_POST["formddpcheck"]=="YES") {
    $intakeLog->update($_POST['district_name'],'D');
  }
  if ($_POST["formaapcheck"]=="YES") {
    $intakeLog->update($_POST['district_name'],'A');
  }
  if ($_POST["attntcheck"]=="YES") {
    $intakeLog->update($_POST['district_name'],'ATTNT');
  }
  if ($_POST["attnccheck"]=="YES") {
    $intakeLog->update($_POST['district_name'],'ATTNC');
  }
     
}


// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit= $row['priv_reconciliation_return'];
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
        <?php  require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
 <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
          require_once ("../finance/includes/menuLeftBar-Settings.php");
        ?>
      </div>
      <div class="contentBody" >

	  <script type="text/javascript" src="../nicEdit/nicEdit.js"></script>
	  <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
	  <img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
         <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Content(Title of all documents)</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Content(Title of all documents)</a></li>
            <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Section 3:Intake Log History</a></li>
       
          </ul>
          <div class="tab-content" style="max-height:650px; overflow:scroll;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                     
           <form action="document_intake_log.php" method="POST">
        <table width="50%" align="center">
  <tr>
    <th colspan="2">Document Intake Log</th>
  </tr>
  <tr>
  
    <td><b>County</b></td>
    <td><select name='county' onchange="get_district(this.value);" id="selectcounty" style="width: 250px;">
           <?php
        $dist_sql = "SELECT * FROM counties ORDER BY county ASC";
        $result = mysql_query($dist_sql);
        while ($dist = mysql_fetch_array($result)) { //loop table rows
        ?>
        <option value="<?php echo $dist['county']; ?>"><?php echo $dist['county']; ?></option>
        <?php } ?>
        </select>
    </td>
    <td><b>County cascade</b></td>
    <td>
      <select name='county_cascade'>
        <option value='County Meeting' >County Meeting</option>
        <option value='1-4 Sub-County Meeting' >1-4 Sub-County Meeting</option>
        <option value='County Monitoring' >County Monitoring</option>
        <option value='Stake Holder Forums' >Stake Holder Forums</option>
        <option value='Others(Radio,Drugs,Collection)' >Others(Radio,Drugs,Collection)</option>
        
      </select>
    </td>
  </tr>
  <tr>
  <td><b>Sub-County Name:</b></td>
  <td>
  <select name="district_name" id="selectdistrict" style="width: 250px;" required>
        <option value=''>Select Sub-County</option>
       
  </select></td>
   <td><b>Sub-County cascade</b></td>
    <td>
      <select name='district_cascade'>
        <option value='SC Training' >SC Training</option>
        <option value='Drugs Collection' >Drugs Collection</option>
        <option value='CHEW Forum' >CHEW Forum</option>
        <option value='Teacher Trainings' >Teacher Trainings</option>
        <option value='Deworming Days' >Deworming Days</option>
        
      </select>
    </td>
  </tr>
  <tr>
  <td><b>Date of Receipt: </b> </td><td><input type="text" class="datepicker" name="date_of_receipt" style="width: 250px;" value="" required></td>
  </tr>
  <tr>
  <td><b>To:</b> </td><td><input type="text" name="submited_to" style="width: 250px;" value="" required></td>
  </tr>
  <tr>
    <td><b>Ministry</b></td>
    <td>
      <select name='ministry' style="width: 250px;" required>
      <option value=''>Select Ministry</option>
        <?php
        $dist_sql = "SELECT * FROM dropdown_ministry ORDER BY ministry ASC";
        $result = mysql_query($dist_sql);
        while ($dist = mysql_fetch_array($result)) { //loop table rows
        ?>
        <option value="<?php echo $dist['ministry']; ?>"><?php echo $dist['ministry']; ?></option>
        <?php } ?>

      </select>
    </td>
  </tr>
  <tr>
  <td><b>How Received: </b> </td><td><input type="text" name="how_received" style="width: 250px;" value="" required></td>
  </tr>
        </table>   
     <table>
     
     <tr>
         <td>County/District Report</td><td><input id="cdreportcheck" name="cdreportcheck" type="checkbox" value="YES" onclick="onCheckers(cdreportcheck,cdreport)"/></td><td><input id="cdreport" type='text' name='cdreport' /></td>
     </tr>
     <tr>
         <td>Financial Reconciliation Form</td><td><input id="frfcheck" type="checkbox" name="frfcheck" value="YES" onclick="onCheckers(frfcheck,frf)"/></td><td><input type='text' id='frf' name='frf' /></td>
     </tr>
     
     <tr>
         <td>Fin 9</td><td><input type="checkbox" id="fin9check" name="fin9check" value="YES" onclick="onCheckers(fin9check,fin9)"/></td><td><input type='text' id='fin9' name='fin9' /></td>
         
         <td>Fin 5AHS</td><td><input type="checkbox" id="fin5ahscheck" name="fin5ahscheck" value="YES" onclick="onCheckers(fin5ahscheck,fin5ahs)" /></td><td><input type='text' id="fin5ahs" name="fin5ahs" /></td>
     </tr>
     
       <tr>
         <td>Fin 9D</td><td><input type="checkbox" id="fin9dcheck"  name="fin9dcheck" value="YES" onclick="onCheckers(fin9dcheck,fin9d)" /></td><td><input type='text' id="fin9d" name="fin9d" /></td>
         
         <td>Fin 6THS</td><td><input type="checkbox" id="fin6thscheck" name="fin6thscheck" value="YES" onclick="onCheckers(fin6thscheck,fin6ths)"/></td><td><input type='text' id="fin6ths" name="fin6ths" /></td>
     </tr>
       <tr>
         <td>Fin 9E</td><td><input type="checkbox" id="fin9echeck" name="fin9echeck" value="YES" onclick="onCheckers(fin9echeck,fin9e)" /></td><td><input type='text' name="fin9e" id="fin9e"/></td>
         
         <td>Fin 3LHS</td><td><input type="checkbox" id="fin3lhscheck" name="fin3lhscheck" value="YES" onclick="onCheckers(fin3lhscheck,fin3lhs)"/></td><td><input type='text' id="fin3lhs"  name="fin3lhs" /></td>
     </tr>
        <tr>
         <td>Fin 6</td><td><input type="checkbox" id="fin6check" name="fin6check" value="YES" onclick="onCheckers(fin6check,fin6)"/></td><td><input type='text' name="fin6" id="fin6" /></td>
         
         <td>Fin 7</td><td><input type="checkbox" name="fin7check" id="fin7check" value="YES" onclick="onCheckers(fin7check,fin7)"/></td><td><input type='text' name="fin7" id="fin7" /></td>
     </tr>
       
      <tr>
         <td>Fin 6C</td><td><input type="checkbox" name="fin6ccheck" value="YES" onclick="onCheckers(fin6ccheck,fin6c)" /></td><td><input type='text' id="fin6c"  name="fin6c" /></td>
         
         <td>Fin 8</td><td><input type="checkbox" name="fin8check" value="YES" onclick="onCheckers(fin8check,fin8)"  /></td><td><input type='text' id="fin8" name="fin8" /></td>
     </tr>
     <tr>
         <td>Fin 6T</td><td><input type="checkbox" id="fin6tcheck" name="fin6tcheck" value="YES" onclick="onCheckers(fin6tcheck,fin6t)"/></td><td><input type='text' id="fin6t" name="fin6t" /></td>
          
         <td>Fin 8II</td><td><input type="checkbox" id="fin8iicheck" name="fin8iicheck" value="YES" onclick="onCheckers(fin8iicheck,fin8ii)"/></td><td><input type='text' name="fin8ii"  id="fin8ii"/></td>
     </tr>
          <tr>
         <td>Fin 5</td><td><input type="checkbox" id="fin5check" name="fin5check" value="YES" onclick="onCheckers(fin5check,fin5)"/></td><td><input type='text' id="fin5" name="fin5" /></td>
    </tr>
           <tr>
         <td>Fin 5C</td><td><input type="checkbox" id="fin5ccheck" name="fin5ccheck" value="YES" onclick="onCheckers(fin5ccheck,fin5c)" /></td><td><input type='text' id="fin5c" name="fin5c" /></td>
    </tr>
          <tr>
         <td>Fin 5CII</td><td><input type="checkbox" id="fin5ciicheck" name="fin5ciicheck" value="YES" onclick="onCheckers(fin5ciicheck,fin5cii)"/></td><td><input type='text' name="fin5cii" id="fin5cii"/></td>
    </tr>
    <tr>
         <td>Fin 3</td><td><input type="checkbox" id="fin3check" name="fin3check" value="YES" onclick="onCheckers(fin3check,fin3)"/></td><td><input type='text' id="fin3" name="fin3" /></td>
    </tr>
    <tr>
         <td>Fin 3C</td><td><input type="checkbox" id="fin3ccheck" name="fin3ccheck" value="YES" onclick="onCheckers(fin3ccheck,fin3c)" /></td><td><input type='text' id="fin3c" name="fin3c" /></td>
    </tr>
            <tr>
         <td>Fin 3D</td><td><input type="checkbox" id="fin3dcheck" name="fin3dcheck" value="YES"  onclick="onCheckers(fin3dcheck,fin3d)"/></td><td><input type='text' id="fin3d" name="fin3d" /></td>
    </tr>
            <tr>
         <td>Fin 3TH</td><td><input type="checkbox" id="fin3thcheck" name="fin3thcheck" value="YES" onclick="onCheckers(fin3thcheck,fin3th)" /></td><td><input type='text' id="fin3th" name="fin3th"/></td>
    </tr>
           <tr>
         <td>Fin 3.A</td><td><input type="checkbox" id="fin3acheck" name="fin3acheck" value="YES" onclick="onCheckers(fin3acheck,fin3a)"/></td><td><input type='text' id="fin3a" name="fin3a"/></td>
    </tr>
              <tr>
         <td>Fin 10C</td><td><input type="checkbox" name="fin10ccheck" value="YES" onclick="onCheckers(fin10ccheck,fin10c)"/></td><td><input type='text' id="fin10c" name="fin10c" /></td>
    </tr>
            <tr>
         <td>Fin 15H</td><td><input type="checkbox" name="fin15hcheck" value="YES" onclick="onCheckers(fin15hcheck,fin15h)"/></td><td><input type='text' id="fin15h" name="fin15h" /></td>
    </tr>
   
     <tr>
         <td>Incident Report</td><td><input type="checkbox" id="ireportcheck" name="ireportcheck" value="YES" onclick="onCheckers(ireportcheck,ireport)"/></td><td><input type='text' name="ireport" id="ireport" /></td>
    </tr>             
       <tr>
         <td>Form(s) S/S-SP</td><td><input type="checkbox" name="formsspcheck" value="YES" /></td><td>Form(s) A/A-AP</td><td><input type="checkbox" name="formaapcheck" value="YES" /></td><td>Form(s) D/D-DP</td><td><input type="checkbox" id="formddpcheck" name="formddpcheck" value="YES" /></td>
    </tr>
       <tr>
         <td>Work Ticket</td><td><input type="checkbox" id="workTicketcheck" name="workTicketcheck" value="YES" onclick="onCheckers(workTicketcheck,workTicket)"/></td><td><input type='text' name="workTicket" id="workTicket" /></td>
    </tr>
        <tr>
         <td>ATTNT</td><td><input type="checkbox" id="attntcheck" name="attntcheck" value="YES" onclick="onCheckers(attntcheck,attnt)"/></td><td><input type='text' name="attnt" id="attnt" /></td>
    </tr>
         <tr>
         <td>ATTNC</td><td><input type="checkbox"  id="attnccheck" name="attnccheck" value="YES" onclick="onCheckers(attnccheck,attnc)"/></td><td><input type='text' name="attnc" id="attnc" /></td>
    </tr>
    <tr>
         <td>Tablet Pick Up</td><td><input type="checkbox" id="tabpickupcheck" name="tabpickupcheck" value="YES" onclick="onCheckers(tabpickupcheck,tabpickup)"/></td><td><input type='text' id="tabpickup" name="tabpickup" /></td>
    </tr>
     <tr>
         <td>Tablet Return</td><td><input type="checkbox" id="tabreturncheck" name="tabreturncheck" value="YES" onclick="onCheckers(tabreturncheck,tabreturn)"/></td><td><input type='text' id="tabreturn" name="tabreturn" /></td>
     </tr>   
       </table>
      
            </div>
              
  <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
           <table>
            <tr>
                <td><u>RECEIPTS</u></td>
    </tr>  
    <tr>
         <td>Courier</td><td><input type="checkbox" id="couriercheck" name="couriercheck" value="YES" onclick="onCheckers(couriercheck,courier)"/><input type='text' id="courier" name="courier" /></td><td>P.A.S Hire</td><td><input type="checkbox" id="pashirecheck" name="pashirecheck" value="YES" onclick="onCheckers(pashirecheck,pashire)" /><input type='text' id="pashire"  name="pashire"  /></td>
    </tr> 
   <tr>
         <td>Meals</td><td><input type="checkbox" id="mealscheck" name="mealscheck" value="YES" onclick="onCheckers(mealscheck,meals)" /><input type='text' name="meals" /></td><td>Stationery</td><td><input type="checkbox" id="stationerycheck" name="stationerycheck" value="YES" onclick="onCheckers(stationerycheck,stationery)"/><input type='text' name="stationery" id="stationery" /></td>
    </tr> 
       <tr>
         <td>Project hire</td><td><input type="checkbox" id="projecthirecheck" name="projecthirecheck" value="YES" onclick="onCheckers(projecthirecheck,projecthire)" /><input type='text' id="projecthire" name="projecthire" /></td><td>Taxi hire</td><td><input type="checkbox" id="taxihirecheck" name="taxihirecheck" value="YES" onclick="onCheckers(taxihirecheck,taxihire)" /><input type='text' id="taxihire" name="taxihire" /></td>
    </tr> 
         <tr>
         <td>Hall hire</td><td><input type="checkbox" id="hallhirecheck" name="hallhirecheck" value="YES" onclick="onCheckers(hallhirecheck,hallhire)"/><input type='text' id="hallhire" name="hallhire" /></td><td>Photocopying</td><td><input type="checkbox" id='photocopyingcheck' name='photocopyingcheck' value="YES" onclick="onCheckers(photocopyingcheck,photocopying)"/><input type='text' id='photocopying' name='photocopying' /></td>
    </tr> 
           <tr>
         <td>Bank Statement</td><td><input type="checkbox" id="bankstmtcheck" name="bankstmtcheck" value="YES" onclick="onCheckers(bankstmtcheck,bankstmt)"/><input type='text' id="bankstmt" name="bankstmt" /></td><td>Fuel</td><td><input type="checkbox" id="fuelcheck" name="fuelcheck" value="YES" onclick="onCheckers(fuelcheck,fuel)" /><input type='text' id="fuel" name="fuel"  /></td>
    </tr> 
    
       
  <tr>
    <td colspan="2">
	<b>Other(Specify):</b><br>
	<textarea style="width: 620px; min-height: 350;" name="description"><?php echo $description ?></textarea>
	</td>
  </tr>
    <?php if($priv_materials_edit>=2){ ?>
  <tr><td colspan="2" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Submit Details" /></td></tr>
  <?php } ?>
</table>
   </div>
       
 
	</form>
	<p>
            
  <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
	
                  <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                    <thead>
                      <tr style="border: 1px solid #B4B5B0;">

                        <th align="Left" width="10%">District Name</th>
                        <th align="Left" width="10%">Date of Receipt</th>
                        <th align="Left" width="10%">Submitted To</th>
                        <th align="Left" width="20%">How Received</th>
                        <th align="center" width="4%">View</th>
                     <?php if($priv_materials_edit>=3){ ?>
                      <th align="center" width="4%">Edit</th>
                       <?php }if($priv_materials_edit>=2){ ?>  
                        <th align="center" width="4%">Del</th>
                        <?php } ?>  
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $count = 0;
                      $sql = "SELECT * FROM document_intake_log ORDER BY id DESC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)) {

                        $id = $row['id'];
                        $district_name = $row['district_name'];
                        $date_of_receipt = $row['date_of_receipt'];
                        $submited_to = $row['submited_to'];
                        $how_received = $row['how_received'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">

                          <td align="left" width="10%"> <?php echo $district_name; ?>  </td>
                          <td align="left" width="10%"> <?php echo $date_of_receipt; ?> </td>
                          <td align="left" width="10%"> <?php echo $submited_to; ?> </td>
                          <td align="left" width="20%"> <?php echo $how_received; ?> </td>
                          <td align='left' width="4%"><a href="document_intake_log.php?view=YES&tabActive=tab4&id=<?php echo $id; ?>" ><img src="../images/icons/view.png" height="20px"/></a></td>
                     <?php if($priv_materials_edit>=3){ ?>
                          <td align="center" width="4%"><a href="edit_intake_log.php?id=<?php echo $id; ?>" onclick="javascript:void window.open('edit_intake_log.php?id=<?php echo $id; ?>', '1397210634467', 'width=700,height=500,status=1,scrollbars=1,resizable=1,left=350,top=0');
          return false;"><img src="../images/icons/edit2.png" height="20px"></a></td>
          <?php }if($priv_materials_edit>=2){ ?>
                          <td align="center" width="4%"><a href="delete_intake_log.php?id=<?php echo $id; ?>" onclick="return confirm('Are you Sure you want to Delete Record?');"><img src="../images/icons/delete.png" height="20px"></a></td>
        <?php } ?>
                        </tr>
                      </tbody>
                    <?php } ?>
                  </table>
                </div>
                <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                    <?php
                    if(isset($_GET['id']) && isset($_GET['view'])){
                      $documentId=$_GET["id"];
                      $sql='SELECT * from document_intake_log WHERE id='.$documentId;
                      $result=mysql_query($sql);
                      while($row=mysql_fetch_array($result)){

                      
                    ?>
                    <h2 style='text-align:center;'>Summary Of Document intake log</h2>
                    <table class="table table-bordered table-condensed table-striped table-hover" >
                    <tr style="font-weight:bolder;">
                    <?php 
                      echo '<td >';
                      echo 'County: '.$row['county'].'<br/>';
                      echo 'County Cascade: '.$row['county_cascade'].'<br/>';
                      echo 'Sub-County: '.$row['district_name'].'<br/>';
                      echo 'Sub-County Cascade: '.$row['district_cascade'].'<br/>';
                      echo '</td>';
                      echo '<td>';
                      echo 'Date Of Receipt: '.$row['date_of_receipt'].'<br/>';
                      echo 'Received By: '.$row['submited_to'].'<br/>';
                      echo 'Ministry: '.$row['ministry'].'<br/>';
                      echo '</td>';

                    ?>
                    </tr>
                        <tr>
                          <td><b>Form</b></td>
                          <td><b>Status</b></td>
                        </tr>
                        <tr><td>CD Report</td><td><?php echo $row['cd_report'];echo $row['cd_report']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>FRF</td><td><?php echo $row['frf'];echo $row['frf']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 9</td><td><?php echo $row['fin9'];echo $row['fin9']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 5AHS</td><td><?php echo $row['fin5ahs'];echo $row['fin5ahs']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 6THS</td><td><?php echo $row['fin6ths'];echo $row['fin6ths']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 3LHS</td><td><?php echo $row['fin3lhs'];echo $row['fin3lhs']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          
                          <tr><td>Fin 7</td><td><?php echo $row['fin7'];echo $row['fin7']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 8</td><td><?php echo $row['fin8'];echo $row['fin8']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 8ii</td><td><?php echo $row['fin8ii'];echo $row['fin8ii']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 9d</td><td><?php echo $row['fin9d'];echo $row['fin9d']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 9e</td><td><?php echo $row['fin9e'];echo $row['fin9e']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 6</td><td><?php echo $row['fin6']; echo $row['fin6']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 6C</td><td><?php echo $row['fin6C'];echo $row['fin6C']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 6T</td><td><?php echo $row['fin6T'];echo $row['fin6T']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 5</td><td><?php echo $row['fin5']; echo $row['fin5']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 5C</td><td><?php echo $row['fin5c'];echo $row['fin5c']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 5CII</td><td><?php echo $row['fin5cii'];echo $row['fin5cii']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 3</td><td><?php echo $row['fin3'] ; echo $row['fin3']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 3C</td><td><?php echo $row['fin3c'] ;echo $row['fin3c']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 3CII</td><td><?php echo $row['fin3cii'] ;echo $row['fin3cii']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 3d</td><td><?php echo $row['fin3d'] ; echo $row['fin3d']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 3th</td><td><?php echo $row['fin3th'] ;echo $row['fin3th']!=""?"<b> Received</b>":"<b> Pending</b>"; ?></td></tr>
                          <tr><td>Fin 3a</td><td><?php echo $row['fin3a'] ; echo $row['fin3a']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 10c</td><td><?php echo $row['fin10c'] ; echo $row['fin10c']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 15h</td><td><?php echo $row['fin15h'] ; echo $row['fin15h']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 3d</td><td><?php echo $row['fin3d'] ; echo $row['fin3d']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>Fin 3th</td><td><?php echo $row['fin3d'] ; echo $row['fin3d']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 3a</td><td><?php echo $row['fin3a'] ; echo $row['fin3a']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 10c</td><td><?php echo $row['fin10c'] ; echo $row['fin10c']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fin 15h</td><td><?php echo $row['fin15h'] ; echo $row['fin15h']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>I Report</td><td><?php echo $row['ireport'] ; echo $row['ireport']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Form SSP</td><td><?php  echo $row['formssp']=="YES"?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>Form AAP</td><td><?php  echo $row['formaap']!="YES"?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>Form DDP</td><td><?php  echo $row['formddp']!="YES"? "<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>Work Ticket</td><td><?php echo $row['workticket'] ; echo $row['workticket']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>ATTNT</td><td><?php echo $row['attnt'] ; echo $row['attnt']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                           <tr><td>ATTNC</td><td><?php echo $row['attnc'] ; echo $row['attnc']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Tab Pickup</td><td><?php echo $row['tabpickup'] ; echo $row['tabpickup']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Tab Return</td><td><?php echo $row['tabreturn'] ; echo $row['tabreturn']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Courier</td><td><?php echo $row['courier'] ; echo $row['courier']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>P.A.S Hire</td><td><?php echo $row['pashire'] ; echo $row['pashire']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Taxi Hire</td><td><?php echo $row['taxihire'] ; echo $row['taxihire']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Hall Hire</td><td><?php echo $row['hallhire'] ; echo $row['hallhire']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>PhotoCopying</td><td><?php echo $row['photocopying'] ; echo $row['photocopying']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Bank Statement</td><td><?php echo $row['bankstmt'] ; echo $row['bankstmt']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                          <tr><td>Fuel</td><td><?php echo $row['fuel'] ; echo $row['fuel']!=""?"<b> Received</b>":"<b> Pending</b>";?></td></tr>
                                    
                        </tr>
                        <?php
                        }
                          ?>
                      </table>
                  <?php
                    }
                    ?>
                </div>
        </div>
    </div>	
 </div>            </p>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

  </body>
</html>



<script>
   function submitForm() {
                            document.getElementById('imgLoading').style.visibility = "visible";
                            var selectButton = document.getElementById('btnSearchSubmit');
                            selectButton.click();
                        }
    $(function() {
      $(".datepicker").datepicker({ dateFormat: "dd-mm-yy" });
    });

    function onCheckers(b,c){

        if(b.checked){
            c.setAttribute("required","required");
        console.log("Required Set");
        }else{
            c.removeAttribute("required");
       console.log("Required Removed");
        }
        
    }
    $(function(){
      document.getElementById('imgLoading').style.visibility = 'hidden';
      console.log('should have worked');
    });
    function get_district(txt) {
      
        $.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
            $('#selectdistrict').html(data);//alert(data);
        });
        document.getElementById('imgLoading').style.visibility = "hidden";
    }
</script>









