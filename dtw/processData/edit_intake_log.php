<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
//Update Page Form
$tabActive="tab1";
if(isset($_POST['Submit']))
{
//If no Errors Submit Form
   $id=mysql_real_escape_string($_POST["idc"]);
       
 $district_name = $_POST['district_name'];
$date_of_receipt = $_POST['date_of_receipt'];
$submited_to = $_POST['submited_to'];
$how_received = $_POST['how_received'];
$otherSpecify=$_POST['otherSpecify'];
   
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
        $workticket=mysql_real_escape_string($_POST["workticketcheck"])=="YES"?mysql_real_escape_string($_POST["workticket"]):"";
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
         
        
  //     echo "This is".$_POST['otherSpecify']."</br>"; 
        
//$sql="UPDATE document_intake_log SET district_name='$district_name',date_of_receipt='$date_of_receipt',submited_to='$submited_to',how_received='$how_received',description='$description' WHERE id='{$_POST['id']}'";

$sql="UPDATE `document_intake_log` SET `district_name`='$district_name',`date_of_receipt`='$date_of_receipt',`submited_to`='$submited_to',";
$sql.="`how_received`='$how_received',`description`='$otherSpecify',`cd_report`='$cdreport',`frf`='$frf',`fin9`='$fin9',`fin5ahs`='$fin5ahs',";
$sql.="`fin6ths`='$fin6ths',`fin3lhs`='$fin3lhs',`fin7`='$fin7',`fin8`='$fin8',`fin8ii`='$fin8ii',`fin9d`='$fin9d',";
$sql.="`fin9e`='$fin9e',`fin6`='$fin6',`fin6c`='$fin6c',`fin6t`='$fin6t',`fin5`='$fin5',`fin5c`='$fin5c',`fin5cii`='$fin5cii',`fin3`='$fin3',";
$sql.="`fin3c`='$fin3c',`fin3cii`='$fin3cii',`fin3d`='$fin3d',`fin3th`='$fin3th',`fin3a`='$fin3a',`fin10c`='$fin10c',`fin15h`='$fin15h',";
$sql.="`ireport`='$ireport',`formssp`='$formssp',`formaap`='$formaap',`formddp`='$formaap',`workticket`='$workticket',`attnt`='$attnt',";
$sql.="`attnc`='$attnc',`tabpickup`='$tabpickup',`tabreturn`='$tabreturn',`courier`='$courier',`pashire`='$pashire',`meals`='$meals',";
$sql.="`stationery`='$stationery',`projectorhire`='$projecthire',`taxihire`='$taxihire',`hallhire`='$hallhire',`photocopying`='$photocopying',`bankstmt`='$bankstmt',`fuel`='$fuel' WHERE id=".$id;




//echo $sql."<br/>";

$result = mysql_query($sql) or die(mysql_error());
$messageToUser="Record Updated Successfully.";
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
<script language="JavaScript" type="text/javascript">
function CloseAndRefresh()
{
opener.location.reload(true);
self.close();
}
</script>

  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
    
    </div>
 <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
     
      <div class="contentBody" >

    
         <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Content(Title of all documents)</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Content(Title of all documents)</a></li>
      
          </ul>
          <div class="tab-content" style="max-height:650px; overflow:scroll;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM document_intake_log WHERE id='$id'";
$result1 = mysql_query($sql);
while ($row1 = mysql_fetch_array($result1)) {
$id = $row1['id'];
$district_name = $row1['district_name'];
$date_of_receipt = $row1['date_of_receipt'];
$submited_to = $row1['submited_to'];
$how_received = $row1['how_received'];
$otherSpecify=$row1['description'];
   $cdreport=$row1["cd_report"];
        $frf=$row1["frf"];
        $fin9=$row1["fin9"];
         $fin5ahs=$row1["fin5ahs"];
        $fin6ths=$row1["fin6ths"];
        $fin3lhs=$row1["fin3lhs"];
        $fin7=$row1["fin7"];
        $fin8=$row1["fin8"];
        $fin8ii=$row1["fin8ii"];
        $fin9d=$row1["fin9d"];
        $fin9e=$row1["fin9e"];
        $fin6=$row1["fin6"];
        $fin6c=$row1["fin6c"];
        $fin6t=$row1["fin6t"];
        $fin5=$row1["fin5"];
        $fin5c=$row1["fin5c"];
        $fin5cii=$row1["fin5cii"];
        $fin3=$row1["fin3"];
        $fin3c=$row1["fin3c"];
        $fin3cii=$row1["fin3cii"];
        $fin3d=$row1["fin3d"];
        $fin3th=$row1["fin3th"];
        $fin3a=$row1["fin3a"];
        $fin10c=$row1["fin10c"];
        $fin15h=$row1["fin15h"];
        $ireport=$row1["ireport"];
        $formssp=$row1["formssp"];
        $formaap=$row1["formaap"];
        $formddp=$row1["formddp"];
        $workticket=$row1["workticket"];
        $attnt=$row1["attnt"];
        $attnc=$row1["attnc"];
        $tabpickup=$row1["tabpickup"];
        $tabreturn=$row1["tabreturn"];
        $courier=$row1["courier"];
        $pashire=$row1["pashire"];
        $meals=$row1["meals"];
        $stationery=$row1["stationery"];
        $projecthire=$row1["projectorhire"];
        $taxihire=$row1["taxihire"];
        $hallhire=$row1["hallhire"];
        $photocopying=$row1["photocopying"];
        $bankstmt=$row1["bankstmt"];
        $fuel=$row1["fuel"];
         

   $cdreportcheck=$row1["cd_report"]!=NULL?"YES":"NO";
        $frfcheck=$row1["frf"]!=NULL?"YES":"NO";
        $fin9check=$row1["fin9"]!=NULL?"YES":"NO";
         $fin5ahscheck=$row1["fin5ahs"]!=NULL?"YES":"NO";
        $fin6thscheck=$row1["fin6ths"]!=NULL?"YES":"NO";
        $fin3lhscheck=$row1["fin3lhs"]!=NULL?"YES":"NO";
        $fin7check=$row1["fin7"]!=NULL?"YES":"NO";
        $fin8check=$row1["fin8"]!=NULL?"YES":"NO";
        $fin8iicheck=$row1["fin8ii"]!=NULL?"YES":"NO";
        $fin9dcheck=$row1["fin9d"]!=NULL?"YES":"NO";
        $fin9echeck=$row1["fin9e"]!=NULL?"YES":"NO";
        $fin6check=$row1["fin6"]!=NULL?"YES":"NO";
        $fin6ccheck=$row1["fin6c"]!=NULL?"YES":"NO";
        $fin6tcheck=$row1["fin6t"]!=NULL?"YES":"NO";
        $fin5check=$row1["fin5"]!=NULL?"YES":"NO";
        $fin5ccheck=$row1["fin5c"]!=NULL?"YES":"NO";
        $fin5ciicheck=$row1["fin5cii"]!=NULL?"YES":"NO";
        $fin3check=$row1["fin3"]!=NULL?"YES":"NO";
        $fin3ccheck=$row1["fin3c"]!=NULL?"YES":"NO";
        $fin3ciicheck=$row1["fin3cii"]!=NULL?"YES":"NO";
        $fin3dcheck=$row1["fin3d"]!=NULL?"YES":"NO";
        $fin3thcheck=$row1["fin3th"]!=NULL?"YES":"NO";
        $fin3acheck=$row1["fin3a"]!=NULL?"YES":"NO";
        $fin10ccheck=$row1["fin10c"]!=NULL?"YES":"NO";
        $fin15hcheck=$row1["fin15h"]!=NULL?"YES":"NO";
        $ireportcheck=$row1["ireport"]!=NULL?"YES":"NO";
        $formsspcheck=$row1["formssp"]!=NO?"YES":"NO";
        $formaapcheck=$row1["formaap"]!=NO?"YES":"NO";
        $formddpcheck=$row1["formddp"]!=NO?"YES":"NO";
        $workticketcheck=$row1["workticket"]!=NULL?"YES":"NO";
        $attntcheck=$row1["attnt"]!=NULL?"YES":"NO";
        $attnccheck=$row1["attnc"]!=NULL?"YES":"NO";
        $tabpickupcheck=$row1["tabpickup"]!=NULL?"YES":"NO";
        $tabreturncheck=$row1["tabreturn"]!=NULL?"YES":"NO";
        $couriercheck=$row1["courier"]!=NULL?"YES":"NO";
        $pashirecheck=$row1["pashire"]!=NULL?"YES":"NO";
        $mealscheck=$row1["meals"]!=NULL?"YES":"NO";
        $stationerycheck=$row1["stationery"]!=NULL?"YES":"NO";
        $projecthirecheck=$row1["projectorhire"]!=NULL?"YES":"NO";
        $taxihirecheck=$row1["taxihire"]!=NULL?"YES":"NO";
        $hallhirecheck=$row1["hallhire"]!=NULL?"YES":"NO";
        $photocopyingcheck=$row1["photocopying"]!=NULL?"YES":"NO";
        $bankstmtcheck=$row1["bankstmt"]!=NULL?"YES":"NO";
        $fuelcheck=$row1["fuel"]!=NULL?"YES":"NO";
         







?>       
           <form action="" method="POST">
        <table width="50%" align="center">
  <tr>
    <th colspan="2">Document Intake Log</th>
  </tr>
  <tr>
  <td><b>District Name:</b></td>
  <td>
  <select name="district_name"  style="width: 250px;" required>
        <option value='<?php echo $district_name; ?>' selected="selected"><?php echo $district_name; ?></option>
        <?php
        $dist_sql = "SELECT * FROM districts ORDER BY district_name ASC";
        $result = mysql_query($dist_sql);
        while ($dist = mysql_fetch_array($result)) { //loop table rows
        ?>
        <option value="<?php echo $dist['district_name']; ?>"><?php echo $dist['district_name']; ?></option>
        <?php } ?>
  </select></td>
  </tr>
  <tr>
  <td><b>Date of Receipt: </b> </td><td><input type="text" class="datepicker" name="date_of_receipt" style="width: 250px;" value="<?php echo $date_of_receipt; ?>" required></td>
  </tr>
  <tr>
  <td><b>To:</b> </td><td><input type="text" name="submited_to" style="width: 250px;" value="<?php echo $submited_to; ?>" required></td>
  </tr>
  <tr>
  <td><b>How Received: </b> </td><td><input type="text" name="how_received" style="width: 250px;" value="<?php echo $how_received;  ?>" required></td>
  </tr>
        </table>   
     <table>
     
     <tr>
         <td>County/District Report</td><td><input id="cdreportcheck" name="cdreportcheck" type="checkbox" value="YES" onclick="onCheckers(cdreportcheck,cdreport)" <?php if($cdreportcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id='cdreport' name='cdreport' value="<?php echo $cdreport; ?>"/></td>
     </tr>
     <tr>
         <td>Financial Reconciliation Form</td><td><input type="checkbox" id="frfcheck" name="frfcheck" value="YES" onclick="onCheckers(frfcheck,frf)"<?php if($frfcheck=="YES"){echo "checked";} ?>  /></td><td><input type='text' id='frf' name='frf' value="<?php echo $frf; ?>" /></td>
     </tr>
     
     <tr>
         <td>Fin 9</td><td><input type="checkbox" id="fin9check" name="fin9check" value="YES" onclick="onCheckers(fin9check,fin9)"<?php if($fin9check=="YES"){echo "checked";} ?>/></td><td><input type='text' id='fin9' name='fin9' value="<?php echo $fin9; ?>" /></td>
         
         <td>Fin 5AHS</td><td><input type="checkbox" id="fin5ahscheck" name="fin5ahscheck" value="YES" onclick="onCheckers(fin5ahscheck,fin5ahs)"<?php if($fin5ahscheck=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin5ahs" name="fin5ahs" value="<?php echo $fin5ahs; ?>"/></td>
     </tr>
     
       <tr>
         <td>Fin 9D</td><td><input type="checkbox" id="fin9dcheck" name="fin9dcheck" value="YES" onclick="onCheckers(fin9dcheck,fin9d)" <?php if($fin9dcheck=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin9d" name="fin9d" value="<?php echo $fin9d; ?>"/></td>
         
         <td>Fin 6THS</td><td><input type="checkbox" id="fin6thscheck" name="fin6thscheck" value="YES" onclick="onCheckers(fin6thscheck,fin6ths)"<?php if($fin6thscheck=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin6ths" name="fin6ths" value="<?php echo $fin6ths; ?>"/></td>
     </tr>
       <tr>
         <td>Fin 9E</td><td><input type="checkbox" id="fin9echeck" name="fin9echeck" value="YES" onclick="onCheckers(fin9echeck,fin9e)" <?php if($fin9echeck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin9e" name="fin9e" value="<?php echo $fin9e; ?>"/></td>
         
         <td>Fin 3LHS</td><td><input type="checkbox" id="fin3lhscheck" name="fin3lhscheck" value="YES" onclick="onCheckers(fin3lhscheck,fin3lhs)"<?php if($fin3lhscheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin3lhs" name="fin3lhs" value="<?php echo $fin3lhs; ?>" /></td>
     </tr>
        <tr>
         <td>Fin 6</td><td><input type="checkbox" id="fin6check" name="fin6check" value="YES" onclick="onCheckers(fin6check,fin6)" <?php if($fin6check=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin6" name="fin6" value="<?php echo $fin6; ?>" /></td>
         
         <td>Fin 7</td><td><input type="checkbox" id="fin7check" name="fin7check" value="YES"onclick="onCheckers(fin7check,fin7)" <?php if($fin7check=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin7" name="fin7" value="<?php echo $fin7; ?>"/></td>
     </tr>
       
      <tr>
         <td>Fin 6C</td><td><input type="checkbox" id="fin6ccheck" name="fin6ccheck" value="YES" onclick="onCheckers(fin6ccheck,fin6c)"<?php if($fin6ccheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin6c" name="fin6c" value="<?php echo $fin6c; ?>"/></td>
         
         <td>Fin 8</td><td><input type="checkbox" id="fin8check" name="fin8check" value="YES" onclick="onCheckers(fin8check,fin8)"<?php if($fin8check=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin8" name="fin8" value="<?php echo $fin8; ?>"/></td>
     </tr>
     <tr>
         <td>Fin 6T</td><td><input type="checkbox" id="fin6tcheck" name="fin6tcheck" value="YES" onclick="onCheckers(fin6tcheck,fin6t)"<?php if($fin6tcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin6t" name="fin6t" value="<?php echo $fin6t; ?>"/></td>
         
         <td>Fin 8II</td><td><input type="checkbox" id="fin8iicheck" name="fin8iicheck" value="YES" onclick="onCheckers(fin8iicheck,fin8ii)"<?php if($fin8iicheck=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin8ii" name="fin8ii" value="<?php echo $fin8ii; ?>" /></td>
     </tr>
          <tr>
         <td>Fin 5</td><td><input type="checkbox" id="fin5check" name="fin5check" value="YES" onclick="onCheckers(fin5check,fin5)" <?php if($fin5check=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin5" name="fin5" value="<?php echo $fin5; ?>" /></td>
    </tr>
           <tr>
         <td>Fin 5C</td><td><input type="checkbox" id="fin5ccheck" name="fin5ccheck" value="YES" onclick="onCheckers(fin5ccheck,fin5c)" <?php if($fin5ccheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin5c" name="fin5c" value="<?php echo $fin5c; ?>" /></td>
    </tr>
          <tr>
         <td>Fin 5CII</td><td><input type="checkbox" id="fin5ciicheck" name="fin5ciicheck" value="YES" onclick="onCheckers(fin5ciicheck,fin5cii)"  <?php if($fin5ciicheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin5cii" name="fin5cii" value="<?php echo $fin5cii; ?>"/></td>
    </tr>
    <tr>
         <td>Fin 3</td><td><input type="checkbox" id="fin3check" name="fin3check" value="YES" onclick="onCheckers(fin3check,fin3)"<?php if($fin3check=="YES"){echo "checked";} ?> /></td><td><input type='text' id="fin3" name="fin3" value="<?php echo $fin3; ?>"/></td>
    </tr>
    <tr>
         <td>Fin 3C</td><td><input type="checkbox" id="fin3ccheck" name="fin3ccheck" value="YES" onclick="onCheckers(fin3ccheck,fin3c)" <?php if($fin3ccheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin3c" name="fin3c" value="<?php echo $fin3c; ?>" /></td>
    </tr>
            <tr>
         <td>Fin 3D</td><td><input type="checkbox" id="fin3dcheck" name="fin3dcheck" value="YES" onclick="onCheckers(fin3dcheck,fin3d)" <?php if($fin3dcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin3d" name="fin3d" value="<?php echo $fin3d; ?>"/></td>
    </tr>
            <tr>
         <td>Fin 3TH</td><td><input type="checkbox" id="fin3thcheck" name="fin3thcheck" value="YES" onclick="onCheckers(fin3thcheck,fin3th)"<?php if($fin3thcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin3th" name="fin3th" value="<?php echo $fin3th; ?>"/></td>
    </tr>
           <tr>
         <td>Fin 3.A</td><td><input type="checkbox" id="fin3acheck" name="fin3acheck" value="YES" onclick="onCheckers(fin3acheck,fin3a)"<?php if($fin3acheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin3a" name="fin3a" value="<?php echo $fin3a; ?>" /></td>
    </tr>
              <tr>
         <td>Fin 10C</td><td><input type="checkbox" id="fin10ccheck" name="fin10ccheck" value="YES" onclick="onCheckers(fin10ccheck,fin10c)" <?php if($fin10ccheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin10c" name="fin10c" value="<?php echo $fin10c; ?>" /></td>
    </tr>
            <tr>
         <td>Fin 15H</td><td><input type="checkbox" id="fin15hcheck" name="fin15hcheck" value="YES" onclick="onCheckers(fin15hcheck,fin15h)" <?php if($fin15hcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="fin15h" name="fin15h" value="<?php echo $fin15h; ?>"/></td>
    </tr>
   
     <tr>
         <td>Incident Report</td><td><input type="checkbox" id="ireportcheck" name="ireportcheck" value="YES" onclick="onCheckers(ireportcheck,ireportcheck)" <?php if($ireportcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="ireport" name="ireport" value="<?php echo $ireport; ?>"/></td>
    </tr>             
       <tr>
         <td>Form(s) S/S-SP</td><td><input type="checkbox" id="formsspcheck" name="formsspcheck" value="YES"  <?php if($formsspcheck=="YES"){echo "checked";}  ?>/></td><td>Form(s) A/A-AP</td><td><input type="checkbox" id="formaapcheck" name="formaapcheck" value="YES" <?php if($formaapcheck=="YES"){echo "checked";} ?>/></td><td>Form(s) D/D-DP</td><td><input type="checkbox" name="formddpcheck" value="YES" <?php if($formddpcheck=="YES"){echo "checked";} ?>/></td>
    </tr>
       <tr>
         <td>Work ticket</td><td><input type="checkbox" id="workticketcheck" name="workticketcheck" value="YES" onclick="onCheckers(workticketcheck,workticket)" <?php if($workticketcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="workticket" name="workticket"  value="<?php echo $workticket; ?>"/></td>
    </tr>
        <tr>
         <td>ATTNT</td><td><input type="checkbox" id="attntcheck" name="attntcheck" value="YES" onclick="onCheckers(attntcheck,attnt)" <?php if($attntcheck=="YES"){echo "checked";} ?> /></td><td><input type='text' id="attnt" name="attnt" value="<?php echo $attnt; ?>"/></td>
    </tr>
         <tr>
         <td>ATTNC</td><td><input type="checkbox" id="attnccheck" name="attnccheck" value="YES" onclick="onCheckers(attnccheck,attnc)" <?php if($attnccheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="attnc" name="attnc" value="<?php echo $attnc; ?>"/></td>
    </tr>
    <tr>
         <td>Tablet Pick Up</td><td><input type="checkbox" id="tabpickupcheck" name="tabpickupcheck" value="YES" onclick="onCheckers(tabpickupcheck,tabpickup)" <?php if($tabpickupcheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="tabpickup" name="tabpickup"  value="<?php echo $tabpickup; ?>"/></td>
    </tr>
     <tr>
         <td>Tablet Return</td><td><input type="checkbox" id="tabreturncheck" name="tabreturncheck" value="YES" onclick="onCheckers(tabreturncheck,tabreturn)" <?php if($tabreturncheck=="YES"){echo "checked";} ?>/></td><td><input type='text' id="tabreturn" name="tabreturn" value="<?php echo $tabreturn; ?>"/></td>
     </tr>   
       </table>
      
            </div>
              
  <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
           <table>
            <tr>
                <td><u>RECEIPTS</u></td>
    </tr>  
    <tr>
         <td>Courier</td><td><input type="checkbox" id="couriercheck" name="couriercheck" value="YES" onclick="onCheckers(couriercheck,courier)"<?php if($couriercheck=="YES"){echo "checked";} ?>/><input type='text' id="courier" name="courier" value="<?php echo $courier; ?> "/></td><td>P.A.S Hire</td><td><input type="checkbox" name="pashirecheck" value="YES" onclick="onCheckers(pashirecheck,pashire)"<?php if($pashirecheck=="YES"){echo "checked";} ?>/><input type='text' id="pashire" name="pashire" value="<?php echo $courier; ?> " /></td>
    </tr> 
   <tr>
         <td>Meals</td><td><input type="checkbox" id="mealscheck" name="mealscheck" value="YES" onclick="onCheckers(mealscheck,meals)" <?php if($mealscheck=="YES"){echo "checked";} ?>/><input type='text' id="meals" name="meals" value="<?php echo $meals; ?>"/></td><td>Stationery</td><td><input type="checkbox" id="stationerycheck" name="stationerycheck" value="YES" onclick="onCheckers(stationerycheck,stationery)"<?php if($stationerycheck=="YES"){echo "checked";} ?>/><input type='text' id="stationery" name="stationery" value="<?php echo $stationery; ?> "/></td>
    </tr> 
       <tr>
         <td>Project hire</td><td><input type="checkbox" id="projecthirecheck" name="projecthirecheck" value="YES" onclick="onCheckers(projecthirecheck,projecthire)" <?php if($projecthirecheck=="YES"){echo "checked";} ?>/><input type='text' id="projecthire" name="projecthire" value="<?php echo $projecthire; ?>"/></td><td>Taxi hire</td><td><input type="checkbox" id="taxihirecheck" name="taxihirecheck" value="YES" onclick="onCheckers(taxihirecheck,taxihire)"<?php if($taxihirecheck=="YES"){echo "checked";} ?>/><input type='text' id="taxihire" name="taxihire" value="<?php echo $taxihire; ?>"/></td>
    </tr> 
         <tr>
         <td>Hall hire</td><td><input type="checkbox" id="hallhirecheck" name="hallhirecheck" value="YES" onclick="onCheckers(hallhirecheck,hallhire)" <?php if($hallhirecheck=="YES"){echo "checked";} ?>/><input type='text' id="hallhire" name="hallhire" value="<?php echo $hallhire; ?>" /></td><td>Photocopying</td><td><input type="checkbox" id='photocopyingcheck' name='photocopyingcheck' value="YES" onclick="onCheckers(photocopyingcheck,photocopying)"<?php if($photocopyingcheck=="YES"){echo "checked";} ?>/><input type='text' id='photocopying' name='photocopying' value="<?php echo $photocopying; ?>"/></td>
    </tr> 
           <tr>
         <td>Bank Statement</td><td><input type="checkbox" id="bankstmtcheck" name="bankstmtcheck" value="YES" onclick="onCheckers(bankstmtcheck,bankstmt)" <?php if($bankstmtcheck=="YES"){echo "checked";} ?>/><input type='text' id="bankstmt" name="bankstmt" value="<?php echo $bankstmt; ?>" /></td><td>Fuel</td><td><input type="checkbox" id="fuelcheck" name="fuelcheck" value="YES" onclick="onCheckers(fuelcheck,fuel)" <?php if($fuelcheck=="YES"){echo "checked";} ?>><input type='text' id="fuel" name="fuel" value="<?php echo $fuel; ?>" /></td>
    </tr> 
    
       
  <tr>
    <td colspan="2">
  <b>Other(Specify):</b><br/>
  <textarea style="width: 620px; min-height: 350;" name="otherSpecify"><?php echo $otherSpecify; ?></textarea>
  </td>
  </tr>
     
  <tr><td colspan="2" align="center">
<?php if($priv_materials_edit>=3){ ?>
    <input class="btn-custom-small" type="submit" name="Submit" value="Update Details" />
   <?php } ?>
    <input class="btn-custom-small" type="button" value="Exit Window" onClick="CloseAndRefresh();"></td></tr>
<input type='hidden' name="idc" value="<?php echo $id; ?>" />
</table>
   </div>
       
 
  </form>
  <p>
   <?php
   }
   ?>         
 
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

</script>

