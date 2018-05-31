<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];	
$tabActive="tab1";
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
$description = $row1['description'];


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
        $workTicket=$row1["workTicket"];
        $attnt=$row1["attnt"];
        $attnc=$row1["attnc"];
        $tabpickup=$row1["tabpickup"];
        $tabreturn=$row1["tabreturn"];
        $courier=$row1["courier"];
        $pashire=$row1["pashire"];
        $meals=$row1["meals"];
        $stationery=$row1["stationery"];
        $projecthire=$row1["projecthire"];
        $taxihire=$row1["taxihire"];
        $hallhire=$row1["hallhire"];
        $photocopying=$row1["photocopying"];
        $bankstmt=$row1["bankstmt"];
        $fuel=$row1["fuel"];
         


?>
  <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Content(Title Of All Documents)</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Content(Title Of All Documents)</a></li>
            <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Content(Title Of All Documents)</a></li>
         
          </ul>
          <div class="tab-content" style="max-height:650px; overflow:scroll;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                    
          <script type="text/javascript" src="../nicEdit/nicEdit.js"></script>
          <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
          <form action="" method="POST">
                  <table width="50%" align="center" cellpadding="5">
            <tr>
              <th colspan="2">Document Intake Log</th>
            </tr>
            <tr>
            <td><b>District Name:</b></td>
            <td><?php echo $district_name ?></td>
            </tr>
            <tr>
            <td><b>Date of Receipt: </b> </td><td><?php echo $date_of_receipt ?></td>
            </tr>
            <tr>
            <td><b>To:</b> </td><td><?php echo $submited_to ?></td>
            </tr>
            <tr>
            <td><b>How Received: </b> </td><td><?php echo $how_received ?></td>
            </tr>
            <tr>
              <td colspan="2">
          	<b>Contents (title of all documents):</b><br>
          	<?php echo $description ?>
          	</td>
            </tr>
            <tr><td colspan="2" align="center"></td></tr>
          </table>
          	</form>
          <?php } ?>
              </div>


            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">

              <?php 

         echo "<b>County/District Report </b><input type='text' value='".$cdreport."' readonly /><br/>";
         echo "<b>Financial Reconciliation Form <input type='text' value='". $frf."' readonly /><br/>";
         echo "<b>Fin 9 <input type='text' value='".$fin9."' readonly /><br/>";
         echo "<b>Fin 5AHS <input type='text' value='".$fin5ahs."' readonly /><br/>";
         echo "<b>FIN 6THS <input type='text' value='".$fin6ths."' readonly /><br/>";
         echo "<b>FIN 3LHS <input type='text' value='".$fin3lhs."' readonly /><br/>";
         echo "<b>FIN 7 <input type='text' value='".$fin7."' readonly /><br/>";
         echo "<b>FIN 8 <input type='text' value='".$fin8."' readonly /><br/>";
         echo "<b>FIN 8II <input type='text' value='".$fin8ii."' readonly /><br/>";
         echo "<b>FIN 9D<input type='text' value='".$fin9d."' readonly /><br/>";
         echo "<b>FIN 9E<input type='text' value='".$fin9e."' readonly /><br/>";
         echo "<b>FIN 6 <input type='text' value='".$fin6."' readonly /><br/>";
         echo "<b>FIN 6C <input type='text' value='".$fin6c."' readonly /><br/>";
         echo "<b>FIN 6T <input type='text' value='".$fin6t."' readonly /><br/>";
         echo "<b>FIN 5 <input type='text' value='".$fin5."' readonly /><br/>";
         echo "<b>FIN 5 C <input type='text' value='".$fin5c."' readonly /><br/>";
         echo "<b>FIN 5CII <input type='text' value='".$fin5cii."' readonly /><br/>";
         echo "<b>FIN 3 <input type='text' value='" .$fin3."' readonly /><br/>";
         echo "<b>FIN 3C <input type='text' value='".$fin3c."' readonly /><br/>";
         echo "<b>FIN 3CII <input type='text' value='".$fin3cii."' readonly /><br/>";




              ?>
            </div>


            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">

              <?php 

        echo "<b>fin3d  ".$fin3d."</b></br>";
        echo "<b>fin3th  ".$fin3th."</b></br>";
        echo "<b>fin3a  ".$fin3a."</b></br>";
        echo "<b>fin10c  ".$fin10c."</b></br>";
        echo "<b>fin15h  ".$fin15h."</b></br>";
        echo "<b>ireport  ".$ireport."</b></br>";
        echo "<b>formssp  ".$formssp."</b></br>";
        echo "<b>formaap  ".$formaap."</b></br>";
        echo "<b>formddp  ".$formddp."</b></br>";
        echo "<b>workTicket  ".$workTicket."</b></br>";
        echo "<b>attnt  ".$attnt."</b></br>";
        echo "<b>attnc  ".$attnc."</b></br>";
        echo "<b>tabpickup  ".$tabpickup."</b></br>";
        echo "<b>tabreturn  ".$tabreturn."</b></br>";
        echo "<b>courier  ".$courier."</b></br>";
        echo "<b>pashire  ".$pashire."</b></br>";
        echo "<b>meals  ".$meals."</b></br>";
        echo "<b>stationery  ".$stationery."</b></br>";
        echo "<b>projecthire  ".$projecthire."</b></br>";
        echo "<b>taxihire  ".$taxihire."</b></br>";
        echo "<b>hallhire  ".$hallhire."</b></br>";
        echo "<b>photocopying  ".$photocopying."</b></br>";
        echo "<b>bankstmt  ".$bankstmt."</b></br>";
        echo "<b>fuel  ".$fuel."</b></br>";
        

              ?>
            </div>



             </div>
        </div>
   </div>
</div>



</body>
</html>