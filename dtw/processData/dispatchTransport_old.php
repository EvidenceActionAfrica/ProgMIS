<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';

if (isset($_POST["saveRecord"])) {
 

  $listed_km = isset($_POST["listed_km"]) ? mysql_real_escape_string($_POST["listed_km"]) : "";
  $km_rate = isset($_POST["km_rate"]) ? mysql_real_escape_string($_POST["km_rate"]) : "";

  $totalAmount = isset($_POST["totalAmount"]) ? mysql_real_escape_string($_POST["totalAmount"]) : 0;

  $driverPerDiem = isset($_POST["driverPerDiem"]) ? mysql_real_escape_string($_POST["driverPerDiem"]) : "";
  $kemsaLoadersMombasa = isset($_POST["kemsaLoadersMombasa"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasa"]) : "";
  $kemsaLoadersNairobi = isset($_POST["kemsaLoadersNairobi"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobi"]) : "";
  $airTime = isset($_POST["airTime"]) ? $_POST["airTime"] : "";
  $MOPHS = isset($_POST["MOPHS"]) ? mysql_real_escape_string($_POST["MOPHS"]) : "";
  $fuelNeed = isset($_POST["fuel"]) ? $_POST["fuel"] : 0;
  $service = isset($_POST["service"]) ? mysql_real_escape_string($_POST["service"]) : "";
  $incidentals = isset($_POST["incidentals"]) ? mysql_real_escape_string($_POST["incidentals"]) : "";

  $incidentalsCashCollection = isset($_POST["incidentalsCashCollection"]) ? mysql_real_escape_string($_POST["incidentalsCashCollection"]) : "";
  $airTimeMOCashCol = isset($_POST["airTimeMOCashCol"]) ? mysql_real_escape_string($_POST["airTimeMOCashCol"]) : "";

  $MOPHSCashCollection = isset($_POST["MOPHSCashCollection"]) ? mysql_real_escape_string($_POST["MOPHSCashCollection"]) : "";
  $serviceCashCollection = isset($_POST["serviceCashCollection"]) ? mysql_real_escape_string($_POST["serviceCashCollection"]) : "";
  $kemsaLoadersNairobiCashCollection = isset($_POST["kemsaLoadersNairobiCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobiCashCollection"]) : "";
  $kemsaLoadersMombasaCashCollection = isset($_POST["kemsaLoadersMombasaCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasaCashCollection"]) : "";
  $driverPerDiemCashCollection = isset($_POST["driverPerDiemCashCollection"]) ? mysql_real_escape_string($_POST["driverPerDiemCashCollection"]) : "";

//echo "The value of fuel is ".$_POST["fuel"];

  $sql = "INSERT INTO `drugs_dispatch_transport`(`listed_km`, `km_rate`, `fuel_needed`, `mophs`, `mophs_cash_collection`, `service`, `service_cash_collection`, `incidentals`, `incidentals_cash_collection`, `airtime_mophs`, `airtime_mophs_cash_collection`, `kemsa_loaders_nairobi`, `kemsa_loaders_nairobi_cash_collection`, `kemsa_loaders_mombasa`, `kemsa_loaders_mombasa_cash_collection`, `driver_per_diem`, `driver_per_diem_cash_collection`, `total_amount`)";
  $sql.=" VALUES ('$listed_km','$km_rate','$fuelNeed','$MOPHS','$MOPHSCashCollection','$service','$serviceCashCollection','$incidentals','$incidentalsCashCollection'";
  $sql.=",'$airTime','$airTimeMOCashCol','$kemsaLoadersNairobi','$kemsaLoadersNairobiCashCollection','$kemsaLoadersMombasa','$kemsaLoadersMombasaCashCollection','$driverPerDiem','$driverPerDiemCashCollection','$totalAmount')";
  mysql_query($sql) or die("Cannot save This data" . mysql_error());
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
      <?php require_once ("../includes/meta-link-script.php"); ?>
      <script src="../js/tabs.js"></script>
  </head>
  <body >
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
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >	  
        <div id="tabContainer">
          <div id="tabs">
            <ul>
              <li id="tabHeader_1">Moh calculation Table</li>
              <li id="tabHeader_2">View Moh calculation Table History</li>
            </ul>
          </div>
          <div id="tabscontent">
            <div class="tabpage" id="tabpage_1">
              <center>
                <h2>Nairobi To Mombasa</h2>
                <h2>Moh calculation Table</h2>
                <h2>Description</h2>
              </center>
              <form action="dispatchTransport.php" method="post">
                <table>
                  <tr>
                    <td>
                      <label>Listed Km's to and from Nrb/Mba</label><input type="text" id="listed_km" name="listed_km" placeholder=""  value="" /><span id="spanListedKm" style="color:rgb(240,20,30);font-weight:bold;"></span>
                    </td>
                    <td>
                      <label>
                        Kilometer Rate (KES)</label><input type="text" name="km_rate" id="km_rate" placeholder="" value="">
                        <span id="spankmRate"  style="color:rgb(240,20,30);font-weight:bold;"></span>
                    </td>
                    <td><label>Fuel Needed</label>
                    </td>
                    <td>
                      <input type="text"  name="fuel" id="fuel">
                    </td> 

                  </tr>	
                  <tr>
                    <td><b>Factors</b></td><td>Cost</td>
                  </tr>			
                  <tr>
                    <td>
                      <label><b>MoPHS Rep Per Diem Per Day (2 Days)-Job Group N</b></label>
                    </td>
                    <td>
                      <input type="text" name="MOPHS" id="MOPHS" placeholder="" value="">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" name="MOPHSCashCollection" id="MOPHSCashCollection" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><b> Service/Maintenance Amount</b> </label>
                    </td>
                    <td>

                      <input type="text" name="service" id="service" placeholder="" value="">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td><td>
                      <input type="text" name="serviceCashCollection" id="serviceCashCollection" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><b>Incidentals (Refundable if vehicle does not breakdown)</b></label>
                    </td>
                    <td>

                      <input type="text" name="incidentals" id="incidentals" placeholder="" value="">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td>
                    <td>

                      <input type="text" name="incidentalsCashCollection" id="incidentalsCashCollection" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><b>Airtime for MoPHS Rep</b></label>
                    </td>
                    <td>
                      <input type="text" name="airTime" id="airTime" placeholder="" value="">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" name="airTimeMOCashCol" id="airTimeMOCashCol" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><b> KEMSA Loaders (Nairobi)</b></label>
                    </td>
                    <td>
                      <input type="text" name="kemsaLoadersNairobi" id="kemsaLoadersNairobi" placeholder="" value="">
                    </td>


                    <td>
                      <label> Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text"  id="kemsaLoadersNairobiCashCollection" name="kemsaLoadersNairobiCashCollection" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label><b>KEMSA Loaders (Mombasa)</b></label>
                    </td>
                    <td>
                      <input type="text" name="kemsaLoadersMombasa" id="kemsaLoadersMombasa" placeholder="" value="">
                    </td>

                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" id="kemsaLoadersMombasaCashCollection" name="kemsaLoadersMombasaCashCollection" placeholder="" value="">
                    </td>
                  </tr>

                  <tr>

                    <td><label><b> Driver's Per Diem Per Day (2 Days)-Job Group G</b></label>
                    </td>
                    <td>
                      <input type="text" name="driverPerDiem" id="driverPerDiem" placeholder="" value="">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td>
                    <td>
                      <input type="text"  id="driverPerDiemCashCollection" name="driverPerDiemCashCollection" placeholder="" value="">
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>

                    <td id="tdError">
                    </td>
                  </tr>
                  <label><b>TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE</b></label>

                  <input type="text" name="totalAmount" id="totalAmount" placeholder="" value="">
                </table>

                <input type="submit" name="saveRecord"  style="width:20%;margin-left:25%;margin-top:5%;" class="btn btn-success" value="Save Details" />
              </form>










            </div> <!--//end div !-->
            <div class="tabpage" id="tabpage_2" class="active">

					<?php require_once("dispatch_2.php"); ?>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php
    if (isset($_POST["updateRecord"])) {
      $viewId = $_GET["viewId"];


      $listed_km = isset($_POST["listed_km"]) ? mysql_real_escape_string($_POST["listed_km"]) : "";
      $km_rate = isset($_POST["km_rate"]) ? mysql_real_escape_string($_POST["km_rate"]) : "";

      $totalAmount = isset($_POST["totalAmount"]) ? mysql_real_escape_string($_POST["totalAmount"]) : 0;

      $driverPerDiem = isset($_POST["driverPerDiem"]) ? mysql_real_escape_string($_POST["driverPerDiem"]) : "";
      $kemsaLoadersMombasa = isset($_POST["kemsaLoadersMombasa"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasa"]) : "";
      $kemsaLoadersNairobi = isset($_POST["kemsaLoadersNairobi"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobi"]) : "";
      $airTime = isset($_POST["airTime"]) ? $_POST["airTime"] : "";
      $MOPHS = isset($_POST["MOPHS"]) ? mysql_real_escape_string($_POST["MOPHS"]) : "";
      $fuel = isset($_POST["fuel"]) ? $_POST["fuel"] : "";
      $service = isset($_POST["service"]) ? mysql_real_escape_string($_POST["service"]) : "";
      $incidentals = isset($_POST["incidentals"]) ? mysql_real_escape_string($_POST["incidentals"]) : "";
      $incidentalsCashCollection = isset($_POST["incidentalsCashCollection"]) ? mysql_real_escape_string($_POST["incidentalsCashCollection"]) : "";
      $airTimeMOCashCol = isset($_POST["airTimeMOCashCol"]) ? mysql_real_escape_string($_POST["airTimeMOCashCol"]) : "";
      $MOPHSCashCollection = isset($_POST["MOPHSCashCollection"]) ? mysql_real_escape_string($_POST["MOPHSCashCollection"]) : "";
      $serviceCashCollection = isset($_POST["serviceCashCollection"]) ? mysql_real_escape_string($_POST["serviceCashCollection"]) : "";
      $kemsaLoadersNairobiCashCollection = isset($_POST["kemsaLoadersNairobiCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobiCashCollection"]) : "";
      $kemsaLoadersMombasaCashCollection = isset($_POST["kemsaLoadersMombasaCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasaCashCollection"]) : "";
      $driverPerDiemCashCollection = isset($_POST["driverPerDiemCashCollection"]) ? mysql_real_escape_string($_POST["driverPerDiemCashCollection"]) : "";


      $query = "UPDATE `drugs_dispatch_transport` SET `listed_km`='$listed_km',`km_rate`='$km_rate',`fuel_needed`='$fuel',`mophs`='$MOPHS',`mophs_cash_collection`='$MOPHSCashCollection',`service`='$service',`service_cash_collection`='$serviceCashCollection',`incidentals`='$incidentals',`incidentals_cash_collection`='$incidentalsCashCollection',`airtime_mophs`='$airTime',`airtime_mophs_cash_collection`='$airTimeMoCashCol',`kemsa_loaders_nairobi`='$kemsaLoadersNairobi',`kemsa_loaders_nairobi_cash_collection`='$kemsaLoadersNairobiCashCollection ',`kemsa_loaders_mombasa`='$kemsaLoadersMombasa',`kemsa_loaders_mombasa_cash_collection`='$kemsaLoadersMombasaCashCollection',`driver_per_diem`='$driverPerDiem',`driver_per_diem_cash_collection`='$driverPerDiemCashCollection',`total_amount`='$totalAmount' WHERE moh_id='$viewId'";

      echo $query;
      $result = mysql_query($query) or die("<h1>Could not update</h1><br/>" . mysql_error());
    }
    if (isset($_GET["viewId"])) {
      $viewId = $_GET["viewId"];
      $query = "select * from drugs_dispatch_transport where moh_id='$viewId'";

      $result = mysql_query($query) or die("<h1>Could not find</h1><br/>" . mysql_error());
      while ($row = mysql_fetch_array($result)) {

        $moh_id = $row["moh_id"];
        $listed_km = $row["listed_km"];
        $km_rate = $row["km_rate"];
        $fuel = $row["fuel_needed"];
        $totalAmount = $row["total_amount"];
        $driverPerDiem = $row["driver_per_diem"];
        $kemsaLoadersMombasa = $row["kemsa_loaders_mombasa"];
        $kemsaLoadersNairobi = $row["kemsa_loaders_nairobi"];
        $airTime = $row["airtime_mophs"];
        $MOPHS = $row["mophs"];

        $service = $row["service"];
        $incidentals = $row["incidentals"];
        $incidentalsCashCollection = $row["incidentals_cash_collection"];
        $airTimeMoCashCol = $row["airtime_mophs_cash_collection"];
        $MOPHSCashCollection = $row["mophs_cash_collection"];
        $serviceCashCollection = $row["service_cash_collection"];
        $kemsaLoadersNairobiCashCollection = $row["kemsa_loaders_nairobi_cash_collection"];
        $kemsaLoadersMombasaCashCollection = $row["kemsa_loaders_mombasa_cash_collection"];
        $driverPerDiemCashCollection = $row["driver_per_diem_cash_collection"];
      }
      ?> 
      <div id="openModalTabReturn" class="modalDialog" >

        <div style="">  
          <a href="dispatchTransport.php" style="margin-left:100%;margin-top:-10%;" class="btn btn-danger">X</a>
          <h1 style="text-align: center; margin-top: 0px; font-size: 22px">Edit Dispatch Transport Form</h1>

          <center>
            <h2>Moh calculation Table</h2>
          </center>
          <form  method="post">
            <table>
              <tr>
                <td>
                  <label>Listed Km's to and from Nrb/Mba</label><input type="text" id="listed_km" name="listed_km"   value="<?php echo $listed_km; ?>" /><span id="spanListedKm" style="color:rgb(240,20,30);font-weight:bold;"></span>
                </td>
                <td>
                  <label>
                    Kilometer Rate (KES)</label><input type="text" name="km_rate" id="km_rate" placeholder="" value="<?php echo $km_rate; ?>">
                    <span id="spankmRate"  style="color:rgb(240,20,30);font-weight:bold;"></span>
                </td>
                <td><label>Fuel Needed</label>
                  <input type="text"  name="fuel" id="fuel" value="<?php echo $fuel; ?>">
                </td> 

              </tr>	

              <tr>
                <td>
                  <label><b>MoPHS Rep Per Diem Per Day (2 Days)-Job Group N</b></label>
                </td>
                <td>
                  <input type="text" name="MOPHS" id="MOPHS" placeholder="" value="<?php echo $MOPHS; ?>">
                </td>
                <td>
                  <label>Cash Collection from IPA Office</label>
                </td>
                <td>
                  <input type="text" name="MOPHSCashCollection" id="MOPHSCashCollection" placeholder="" value="<?php echo $MOPHSCashCollection; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label><b> Service/Maintenance Amount</b> </label>
                </td>
                <td>

                  <input type="text" name="service" id="service" placeholder="" value="<?php echo $service; ?>">
                </td>
                <td>
                  <label>Cash Collection from IPA Office </label>
                </td><td>
                  <input type="text" name="serviceCashCollection" id="serviceCashCollection" placeholder="" value="<?php echo $serviceCashCollection; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label><b>Incidentals (Refundable if vehicle does not breakdown)</b></label>
                </td>
                <td>

                  <input type="text" name="incidentals" id="incidentals" placeholder="" value="<?php echo $incidentals; ?>">
                </td>
                <td>
                  <label>Cash Collection from IPA Office </label>
                </td>
                <td>

                  <input type="text" name="incidentalsCashCollection" id="incidentalsCashCollection" placeholder="" value="<?php echo $incidentalsCashCollection; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label><b>Airtime for MoPHS Rep</b></label>
                </td>
                <td>
                  <input type="text" name="airTime" id="airTime" placeholder="" value="<?php echo $airTime; ?>">
                </td>
                <td>
                  <label>Cash Collection from IPA Office</label>
                </td>
                <td>
                  <input type="text" name="airTimeMoCashCol" id="airTimeMoCashCol" placeholder="" value="<?php echo $airTimeMoCashCol; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label><b> KEMSA Loaders (Nairobi)</b></label>
                </td>
                <td>
                  <input type="text" name="kemsaLoadersNairobi" id="kemsaLoadersNairobi" placeholder="" value="<?php echo $kemsaLoadersNairobi; ?>">
                </td>


                <td>
                  <label> Cash Collection from IPA Office</label>
                </td>
                <td>
                  <input type="text"  id="kemsaLoadersNairobiCashCollection" name="kemsaLoadersNairobiCashCollection" placeholder="" value="<?php echo $kemsaLoadersNairobiCashCollection; ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <label><b>KEMSA Loaders (Mombasa)</b></label>
                </td>
                <td>
                  <input type="text" name="kemsaLoadersMombasa" id="kemsaLoadersMombasa" placeholder="" value="<?php echo $kemsaLoadersMombasa; ?>">
                </td>

                <td>
                  <label>Cash Collection from IPA Office</label>
                </td>
                <td>
                  <input type="text" id="kemsaLoadersMombasaCashCollection" name="kemsaLoadersMombasaCashCollection" placeholder="" value="<?php echo $kemsaLoadersMombasaCashCollection; ?>">
                </td>
              </tr>

              <tr>

                <td><label><b> Driver's Per Diem Per Day (2 Days)-Job Group G</b></label>
                </td>
                <td>
                  <input type="text" name="driverPerDiem" id="driverPerDiem" placeholder="" value="<?php echo $driverPerDiem; ?>">
                </td>
                <td>
                  <label>Cash Collection from IPA Office </label>
                </td>
                <td>
                  <input type="text"  id="driverPerDiemCashCollection" name="driverPerDiemCashCollection" placeholder="" value="<?php echo $driverPerDiemCashCollection; ?>">
                </td>
              </tr>
              <tr>
                <td>
                </td>

                <td id="tdError">
                </td>
                <td>
                  <b>TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE</b>
                  <input type="text" name="totalAmount" id="totalAmount" placeholder="" value="<?php echo $totalAmount; ?>">
                </td>
              </tr>

            </table>

            <input type="submit" name="updateRecord"  style="width:20%;margin-left:25%;margin-top:5%;" class="btn btn-success" value="update Details" />
          </form>







        </div>  
      </div> 


      <?php
    }
    ?>

  </body>
</html>
<script>

  function () {
    var listed_km = document.getElementById("listed_km");
    var km_rate = document.getElementById("km_rate");
    var fuel = document.getElementById("fuel");
    var totalAmount = document.getElementById("totalAmount");
    var driverPerDiem = document.getElementById("driverPerDiem");
    var kemsaLoadersMombasa = document.getElementById("kemsaLoadersMombasa");
    var kemsaLoadersNairobi = document.getElementById("kemsaLoadersNairobi");
    var airTimeMOPHS = document.getElementById("airTimeMOPHS");
    var MOPHS = document.getElementById("MOPHS");
    var service = document.getElementById("service");
    var incidentals = document.getElementById("incidentals");
    var airTimeMOPHS = document.getElementById("airTimeMOPHS");

    //cASH cOLLECTIONS
    var incidentalsCashCollection = document.getElementById("incidentalsCashCollection");
    var airTimeMOCashCol = document.getElementById("airTimeMOCashCol");
    var MOPHSCashCollection = document.getElementById("MOPHSCashCollection");
    var serviceCashCollection = document.getElementById("serviceCashCollection");
    var kemsaLoadersNairobiCashCollection = document.getElementById("kemsaLoadersNairobiCashCollection");
    var kemsaLoadersMombasaCashCollection = document.getElementById("kemsaLoadersMombasaCashCollection");
    var driverPerDiemCashCollection = document.getElementById("driverPerDiemCashCollection");

var openModalTabReturn=document.getElementById("openModalTabReturn");



    listed_km.onkeyup = function() {
      console.log(listed_km.value);
      document.getElementById("spanListedKm").innerHTML = "";
      if (isNaN(listed_km.value)) {
        var sperror = document.createTextNode("Enter Numerical Value");
        document.getElementById("spanListedKm").appendChild(sperror);
        listed_km.value = "";
      } else {

        calculateFuel();

      }
    };
    km_rate.onkeyup = function() {
      console.log(km_rate.value);
      document.getElementById("spankmRate").innerHTML = "";
      if (isNaN(km_rate.value)) {
        var sperror = document.createTextNode("Enter Numerical Value");
        document.getElementById("spankmRate").appendChild(sperror);
        km_rate.value = "";
      } else {

        calculateFuel();
      }
    }
   function calculateFuel() {

      if (!isNaN(listed_km.value) && !isNaN(km_rate.value)) {
        fuel.value = km_rate.value * listed_km.value;

      }
    }
  window.addEventListener('input', function calculateTotalAmount() {
      
      document.getElementById("tdError").innerHTML = " Enter Numerical Values";
      if (!isNaN(driverPerDiemCashCollection.value) && !isNaN(kemsaLoadersMombasaCashCollection.value) && !isNaN(kemsaLoadersNairobiCashCollection.value) && !isNaN(serviceCashCollection.value) && !isNaN(MOPHSCashCollection.value) && !isNaN(airTimeMOCashCol.value) && !isNaN(incidentalsCashCollection.value)) {

        totalAmount.value = (serviceCashCollection.value * 1) + (driverPerDiemCashCollection.value * 1) + (kemsaLoadersMombasaCashCollection.value * 1) + (kemsaLoadersNairobiCashCollection.value * 1) + (MOPHSCashCollection.value * 1) + (airTimeMOCashCol.value * 1) + (incidentalsCashCollection.value * 1) + (fuel.value * 1);
      } else {
        console.log("Error me");
        document.getElementById("tdError").innerHTML = " Enter Numerical Values";


      }



    }, false);

 }
  window.onload = function() {
  alert("Hello");
		activateFxns();
 }
    


</script>
