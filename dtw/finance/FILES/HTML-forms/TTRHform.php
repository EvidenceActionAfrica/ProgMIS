<?php




require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/function_convert_number_to_words.php");
$tabActive="tab1";
$updateResult="";//This variable is used to display update status.DO NOT Modify





$totalAmountAdvanced=isset($_POST["totalAmountAdvanced"])?mysql_real_escape_string($_POST["totalAmountAdvanced"]):"";
$totalAmountSpent=isset($_POST["totalAmountSpent"])?mysql_real_escape_string($_POST["totalAmountSpent"]):"";
$preparedBy=isset($_POST["preparedBy"])?mysql_real_escape_string($_POST["preparedBy"]):"";
$remarks=isset($_POST["remarks"])?mysql_real_escape_string($_POST["remarks"]):"";
$amountWords=isset($_POST["totalAmountSpent"])?strToUpper(convert_number_to_words($_POST["totalAmountSpent"]).' Shillings'):"";

$date=date("Y-m-d");

if($_POST["saveRecord"]){
$tabActive="tab2";

//echo $sql;
mysql_query($sql);
}
if(isset($_GET["deleteid"])){
	$tabActive="tab2";
$id=$_GET["deleteid"];
$sql="DELETE from fin_budget_ttrh where form_id='$id'";

mysql_query($sql);
}

if($_POST["updateRecord"]){
$tabActive="tab2";
$id=$_GET["id"];


mysql_query($sql);
$updateResult="Record Updated";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>  
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
      </div>
      <?php
$_POST["emily"]=1;
// The TTRH will generate all the data from the GET request values it receives
//Failure of GET request being present should cease anykind of loading 
if(!empty($_GET) || !empty($_POST)){


?>
      <div class="contentBody">

      

      
       <div class="tabbable" >
                  <ul class="nav nav-tabs">
                    <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Financial Reconciliation Return Form
</a></li>
                    <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Financial Reconciliation Return Form
</a></li>
                   
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>"  id="tab1">
                         
	   <h2>Financial Reconciliation Return Form</h2>
              <form method="POST">
                <table border="0"cellpadding="0" cellspacing="0">
                  <thead>
                    <tr>
						<td>Name</td><td><input type="text" id="receiver_name" name="receiver_name" value="<?php echo $name; ?>" /></td>
						<td>Date</td><td><input type="text" id="amount" name="amount" value="<?php echo date('Y-m-d'); ?>" readonly/></td>
                     </tr>
					 <tr>
					 <td></td>
					 </tr>
					 <tr>
					 <td>Amount(Words)</td><td><input type="text" name="amount" style="width:200%;font-weight:bolder;" value="<?php echo $amountWords; ?>" readonly/></td>
					 </tr>
					 </thead>
				</table>
				
				<table border="2" >
				<thead style="font-weight:bold;">
				<tr>
				<th>No.</th>
				<th>Unit Description</th>
				<th>Amount Advanced</th>
				<th>Amount Spent</th>
				<th>Variance</th>
				
				
				</tr>
				</thead>
        <thead>
				<tbody>
            <?php
    echo "<tr>";
       echo " <td>1</td><td>Fuel(30/= Per kilometer)</td><td><input type='text' id='fuelAdvanced' name='fuelAdvanced' value='<?php echo $fuelAdvanced; ?>' onKeyUp='isNumeric(this.id);'/><span id='fuelAdvancedSpan'/></span></td></td><td><input type='text' id='fuelSpent'  name='fuelSpent' value='<?php echo $fuelSpent; ?>' onKeyUp='isNumeric(this.id);'/><span id='fuelSpentSpan'/></span></td><td><input type='text' id='fuelVariance' name='fuelVariance' value='<?php echo $fuelVariance=abs($fuelAdvanced-$fuelSpent); ?>' onKeyUp='isNumeric(this.id);'/><span id='fuelVarianceSpan'/></span> </td>";
       echo "</tr>";
      
            ?>
        </tbody>
      </thead>
      </table>
    </div>


                <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>"  id="tab2">
    
                </div>


  </div>
</div>
<?php
}else{


  echo "<h1 style='margin-left:45%;margin-top:10%;'>Error:Page Not Found</h1>";
}
?>