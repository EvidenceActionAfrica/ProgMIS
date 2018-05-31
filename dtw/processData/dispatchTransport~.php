<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';
if (isset($_POST["saveRecord"])) {

  $tabActive = 'tab1';
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
if (isset($_POST["updateRecord"])) {
  $tabActive = 'tab2';
}
if (isset($_GET['deleteid'])) {
  $tabActive = 'tab2';
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_dispatch = $row['priv_dispatch'];
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>

    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>
  <body >
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
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >


        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Moh calculation Table</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Moh calculation Table History</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">

              <center>
                <span style="font-weight:bold">Nairobi To Mombasa<br/><br/>Moh calculation Table<br/>Description</span>
              </center>
              <form action="dispatchTransport.php" method="post">
                <table>
                  <thead>
                    <tr>
                      <td>
                        <label>Distance</label><input type="text" id="listed_km" name="listed_km" placeholder=""  value="" /><span id="spanListedKm" style="color:rgb(240,20,30);font-weight:bold;"></span>
                      </td>
                      <td>
                        <label>
                          Kilometer Rate (KES)</label><input type="text" name="km_rate" id="km_rate" placeholder="" value="">
                          <span id="spankmRate"  style="color:rgb(240,20,30);font-weight:bold;"></span>
                      </td>
                      <td><label>Fuel Needed</label>
                      </td>
                      <td>
                        <input type="text"  name="fuel" id="fuel" onkeyup='isNumeric(this.id)'/><span id='fuelSpan'></span>
                      </td> 

                    </tr>	
                    <tr>
                      <td><b>Factors</b></td><td></td><td></td><td><b>Cost</b></td>
                    </tr>			
                    <tr>
                      <td>
                        MoPHS Rep Per Diem Per Day (2 Days)-Job Group N</label>
                      </td>
                      <td>
                        <input type="text" name="MOPHS" id="MOPHS" placeholder="" value="">
                      </td>
                      <td>
                        <label>Cash Collection from IPA Office</label>
                      </td>
                      <td>
                        <input type="text" name="MOPHSCashCollection" id="MOPHSCashCollection" placeholder="" value=""onkeyup='isNumeric(this.id)'/><span id='MOPHSCashCollectionSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Service/Maintenance Amount</label>
                      </td>
                      <td>

                        <input type="text" name="service" id="service" placeholder="" value="">
                      </td>
                      <td>
                        <label>Cash Collection from IPA Office </label>
                      </td><td>
                        <input type="text" name="serviceCashCollection" id="serviceCashCollection" placeholder="" value=""onkeyup='isNumeric(this.id)'/><span id='serviceCashCollectionSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Incidentals (Refundable if vehicle does not breakdown)</label>
                      </td>
                      <td>
                        <input type="text" name="incidentals" id="incidentals" placeholder="" value="">
                      </td>
                      <td>
                        <label>Cash Collection from IPA Office </label>
                      </td>
                      <td>
                        <input type="text" name="incidentalsCashCollection" id="incidentalsCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)'/><span id='incidentalsCashCollectionSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Airtime for MoPHS Rep</b></label>
                      </td>
                      <td>
                        <input type="text" name="airTime" id="airTime" placeholder="" value="">
                      </td>
                      <td>
                        <label>Cash Collection from IPA Office</label>
                      </td>
                      <td>
                        <input type="text" name="airTimeMOCashCol" id="airTimeMOCashCol" placeholder="" value=""onkeyup='isNumeric(this.id)'/><span id='airTimeMOCashColSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        KEMSA Loaders (Nairobi)</label>
                      </td>
                      <td>
                        <input type="text" name="kemsaLoadersNairobi" id="kemsaLoadersNairobi" placeholder="" value="">
                      </td>
                      <td>
                        <label> Cash Collection from IPA Office</label>
                      </td>
                      <td>
                        <input type="text"  id="kemsaLoadersNairobiCashCollection" name="kemsaLoadersNairobiCashCollection" placeholder="" value=""  onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersNairobiCashCollectionSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        KEMSA Loaders (Mombasa)</b></label>
                      </td>
                      <td>
                        <input type="text" name="kemsaLoadersMombasa" id="kemsaLoadersMombasa" placeholder="" value="">
                      </td>

                      <td>
                        <label>Cash Collection from IPA Office</label>
                      </td>
                      <td>
                        <input type="text" id="kemsaLoadersMombasaCashCollection" name="kemsaLoadersMombasaCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersMombasaCashCollectionSpan'></span>
                      </td>
                    </tr>

                    <tr>

                      <td><label> Driver's Per Diem Per Day (2 Days)-Job Group G</label>
                      </td>
                      <td>
                        <input type="text" name="driverPerDiem" id="driverPerDiem" placeholder="" value=""><span id='driverPerDiemSpan'></span>
                      </td>
                      <td>
                        <label>Cash Collection from IPA Office </label>
                      </td>
                      <td>
                        <input type="text"  id="driverPerDiemCashCollection" name="driverPerDiemCashCollection" placeholder="" value="" onkeyup='isNumeric(this.id)'/><span id='driverPerDiemCashCollectionSpan'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      </td>

                      <td id="tdError">
                      </td>
                    </tr>
                </table>
                <table>

                  <tr>
                    <td>
                    </td>
                    <td style="width:400px;">
                      <b><label>TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE</label></b>

                      <input type="text" name="totalAmount" id="totalAmount" placeholder="" value="" disable>
                    </td>

  <?php if( $priv_dispatch>=2){ ?>
                    <td style="width:500px;">
                      <input type="submit" name="saveRecord"  style="width:20%;margin-left:25%;margin-top:5%;" class="btn btn-success" value="Save Details" />
                    </td>
  <?php } ?>
                  </tr>
                  </thead>
                </table>
              </form>



            </div>
            <!--tab 2 - view delivery note-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <br/><br/>
              <!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                <b style="margin-left:20%;width: 100px; font-size:1.5em;">View Moh calculation Table History</b>
              </form>
              <br/><br/>


              <!--================================================-->
              <!--   OTHER RECORDS           -->
              <!--================================================-->
              <?php
              //Delete
              if (isset($_GET['deleteid'])) {
                $tabActive = 'tab2';
                $deleteid = $_GET['deleteid'];
                $query = "DELETE FROM drugs_dispatch_transport WHERE moh_id='$deleteid'";
                $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
              }
              ?>
              <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left"  border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                <thead>
                  <th align="Left" width="10px">ID</th>
                  <th align="Left" width="10px">Listed Km</th>
                  <th align="center" width="5px">Km Rate</th>
                  <th align="center" width="10px">Fuel Needed</th>
                  <th align="center" width="10px">Incidentals</th>
                  <th align="center" width="10px">Service</th>
                  <th align="center" width="20px">Total Amount</th>
                    <?php if( $priv_dispatch>=1){ ?>
                  <th align="center" width="15px">View</th>
                    <?php }if( $priv_dispatch>=2){ ?>
                  <th align="center" width="10px">Del</th>
                    <?php }?>
                </thead>
                <tbody>

                  <?php
                  $result_set = mysql_query("SELECT * FROM drugs_dispatch_transport  ORDER BY moh_id");
                  while ($row = mysql_fetch_array($result_set)) {
                    $moh_id = $row["moh_id"];
                    $listed_km = $row["listed_km"];
                    $km_rate = $row["km_rate"];
                    $fuelNeed = $row["fuel_needed"];
                    $totalAmount = $row["total_amount"];
                    $driverPerDiem = $row["driver_per_diem"];
                    $kemsaLoadersMombasa = $row["kemsa_loaders_mombasa"];
                    $kemsaLoadersNairobi = $row["kemsaLoadersNairobi"];
                    $airTime = $row["airtime_mophs"];
                    $MOPHS = $row["mophs"];

                    $service = $row["service"];
                    $incidentals = $row["incidentals"];
                    $incidentalsCashCollection = $row["incidentals_cash_collection"];
                    $airTimeMOCashCol = $row["airtime_mophs_cash_collection"];
                    $MOPHSCashCollection = $row["mophs_cash_collection"];
                    $serviceCashCollection = $row["service_cash_collection"];
                    $kemsaLoadersNairobiCashCollection = $row["kemsa_loaders_nairobi_cash_collection"];
                    $kemsaLoadersMombasaCashCollection = $row["kemsa_loaders_mombasa_cash_collection"];
                    $driverPerDiemCashCollection = $row["driver_per_diem_cash_collection"];
                    ?>
                    <tr style="border-bottom: 1px solid #B4B5B0;">
                      <td align="left" width="10px"> <?php echo $moh_id; ?>  </td>
                      <td align="left" width="10px"> <?php echo $listed_km; ?>  </td>
                      <td align="left" width="5px"> <?php echo $km_rate; ?>  </td>
                      <td align="left" width="10px"> <?php echo $fuelNeed; ?>  </td>
                      <td align="left" width="10px"> <?php echo $incidentals; ?>  </td>
                      <td align="left" width="10px"> <?php echo $service; ?>  </td>
                      <td align="left" width="20px"> <?php echo $totalAmount; ?>  </td>

                        <?php if( $priv_dispatch>=1){ ?>
                      <td align="center" width="10px"><a href="dispatchTransport.php?viewId=<?php echo $moh_id; ?> #openModalTabReturn" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                        <?php }if( $priv_dispatch>=2){ ?>
                      <td align="center" width="10px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $moh_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                       <?php } ?>
                    </tr>
                  </tbody>
                <?php } ?>
              </table>

              <!--Delete dialog-->
              <script>
                          function show_confirm(deleteid) {
                            if (confirm("Are you sure you want to delete?")) {
                              location.replace('?deleteid=' + deleteid);
                            } else {
                              return false;
                            }
                          }
              </script>


            </div>
          </div>
        </div>




        <?php
        if (isset($_POST["updateRecord"])) {
          $viewId = $_GET["viewId"];
//echo "The amount is ".$_POST["total"];
          $tabActive = 'tab2';
          $listed_km = isset($_POST["listed_km"]) ? mysql_real_escape_string($_POST["listed_km"]) : "";
          $km_rate = isset($_POST["km_rate"]) ? mysql_real_escape_string($_POST["km_rate"]) : "";

          $total = isset($_POST["total"]) ? mysql_real_escape_string($_POST["total"]) : 0;

          $driverPerDiem = isset($_POST["driverPerDiem"]) ? mysql_real_escape_string($_POST["driverPerDiem"]) : "";
          $kemsaLoadersMombasa = isset($_POST["kemsaLoadersMombasa"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasa"]) : "";
          $kemsaLoadersNairobi = isset($_POST["kemsaLoadersNairobi"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobi"]) : "";
          $airTime = isset($_POST["airTime"]) ? $_POST["airTime"] : "";
          $MOPHS = isset($_POST["MOPHS"]) ? mysql_real_escape_string($_POST["MOPHS"]) : "";
          $fuel = isset($_POST["fuel"]) ? $_POST["fuel"] : "";
          $service = isset($_POST["service"]) ? mysql_real_escape_string($_POST["service"]) : "";
          $incidentals = isset($_POST["incidentals"]) ? mysql_real_escape_string($_POST["incidentals"]) : "";
          $incidentalsCashCollection = isset($_POST["incidentalsCashCollection"]) ? mysql_real_escape_string($_POST["incidentalsCashCollection"]) : "";
          $airTimeMoCashCol = isset($_POST["airTimeMoCashCol"]) ? mysql_real_escape_string($_POST["airTimeMoCashCol"]) : "";
          $MOPHSCashCollection = isset($_POST["MOPHSCashCollection"]) ? mysql_real_escape_string($_POST["MOPHSCashCollection"]) : "";
          $serviceCashCollection = isset($_POST["serviceCashCollection"]) ? mysql_real_escape_string($_POST["serviceCashCollection"]) : "";
          $kemsaLoadersNairobiCashCollection = isset($_POST["kemsaLoadersNairobiCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersNairobiCashCollection"]) : "";
          $kemsaLoadersMombasaCashCollection = isset($_POST["kemsaLoadersMombasaCashCollection"]) ? mysql_real_escape_string($_POST["kemsaLoadersMombasaCashCollection"]) : "";
          $driverPerDiemCashCollection = isset($_POST["driverPerDiemCashCollection"]) ? mysql_real_escape_string($_POST["driverPerDiemCashCollection"]) : "";


          $query = "UPDATE `drugs_dispatch_transport` SET `listed_km`='$listed_km',`km_rate`='$km_rate',`fuel_needed`='$fuel',`mophs`='$MOPHS',`mophs_cash_collection`='$MOPHSCashCollection',`service`='$service',`service_cash_collection`='$serviceCashCollection',`incidentals`='$incidentals',`incidentals_cash_collection`='$incidentalsCashCollection',`airtime_mophs`='$airTime',`airtime_mophs_cash_collection`='$airTimeMoCashCol',`kemsa_loaders_nairobi`='$kemsaLoadersNairobi',`kemsa_loaders_nairobi_cash_collection`='$kemsaLoadersNairobiCashCollection ',`kemsa_loaders_mombasa`='$kemsaLoadersMombasa',`kemsa_loaders_mombasa_cash_collection`='$kemsaLoadersMombasaCashCollection',`driver_per_diem`='$driverPerDiem',`driver_per_diem_cash_collection`='$driverPerDiemCashCollection',`total_amount`='$total' WHERE moh_id='$viewId'";

          //  echo $query;
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
            $total = $row["total_amount"];
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

            <div >  
              <a href="#close" style="margin-left:94%;position:absolute;margin-top:-4.9%;" class="btn btn-danger">X</a>
              <h1 style="text-align: center; margin-top: 0px; font-size: 22px">Edit Dispatch Transport Form</h1>

              <center>
                <h2>Moh calculation Table</h2>
              </center>
              <form  method="post">
                <table>
                  <style>
                    td{

                      width:200px;
                    }
                  </style>
                  <tr>
                    <td>
                      <label>Listed Km's to and from Nrb/Mba</label><input type="text" name="listed_km"   id="listed_km2"  value="<?php echo $listed_km; ?>" onkeyup='isNumeric(this.id)'/><span id='listed_km2Span'></span>
                    </td>
                    <td>
                      <label>
                        Kilometer Rate (KES)</label><input type="text" name="km_rate" id="km_rate2"  value="<?php echo $km_rate; ?>" onkeyup='isNumeric(this.id)'/><span id='km_rate2Span'></span>
                    </td>
                    <td><label>Fuel Needed</label>
                      <input type="text"  name="fuel" id="fuel2" value="<?php echo $fuel; ?>" onkeyup='isNumeric(this.id)'/><span id='fuel2Span'></span>
                    </td> 

                  </tr>	

                  <tr>
                    <td>
                      MoPHS Rep Per Diem Per Day (2 Days)-Job Group N</label>
                    </td>
                    <td>
                      <input type="text" name="MOPHS" id="MOPHS2" placeholder="" value="<?php echo $MOPHS; ?>">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" name="MOPHSCashCollection" id="MOPHSCashCollection2" placeholder="" value="<?php echo $MOPHSCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='MOPHSCashCollection2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Service/Maintenance Amount </label>
                    </td>
                    <td>

                      <input type="text" name="service" id="service2" placeholder="" value="<?php echo $service; ?>">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td><td>
                      <input type="text" name="serviceCashCollection" id="serviceCashCollection2" placeholder="" value="<?php echo $serviceCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='serviceCashCollection2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Incidentals (Refundable if vehicle does not breakdown)</label>
                    </td>
                    <td>

                      <input type="text" name="incidentals" id="incidentals2" placeholder="" value="<?php echo $incidentals; ?>">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td>
                    <td>

                      <input type="text" name="incidentalsCashCollection" id="incidentalsCashCollection2" placeholder="" value="<?php echo $incidentalsCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='incidentalsCashCollection2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Airtime for MoPHS Rep</label>
                    </td>
                    <td>
                      <input type="text" name="airTime" id="airTime2" placeholder="" value="<?php echo $airTime; ?>">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" name="airTimeMoCashCol" id="airTimeMoCashCol2" placeholder="" value="<?php echo $airTimeMoCashCol; ?>" onkeyup='isNumeric(this.id)'/><span id='airTimeMoCashCol2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      KEMSA Loaders (Nairobi)</label>
                    </td>
                    <td>
                      <input type="text" name="kemsaLoadersNairobi" id="kemsaLoadersNairobi2" placeholder="" value="<?php echo $kemsaLoadersNairobi; ?>">
                    </td>


                    <td>
                      <label> Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text"  id="kemsaLoadersNairobiCashCollection2" name="kemsaLoadersNairobiCashCollection" placeholder="" value="<?php echo $kemsaLoadersNairobiCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersNairobiCashCollection2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      KEMSA Loaders (Mombasa)</label>
                    </td>
                    <td>
                      <input type="text" name="kemsaLoadersMombasa" id="kemsaLoadersMombasa2" placeholder="" value="<?php echo $kemsaLoadersMombasa; ?>">
                    </td>

                    <td>
                      <label>Cash Collection from IPA Office</label>
                    </td>
                    <td>
                      <input type="text" id="kemsaLoadersMombasaCashCollection2" name="kemsaLoadersMombasaCashCollection" placeholder="" value="<?php echo $kemsaLoadersMombasaCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='kemsaLoadersMombasaCashCollection2Span'></span>
                    </td>
                  </tr>

                  <tr>

                    <td> Driver's Per Diem Per Day (2 Days)-Job Group G</label>
                    </td>
                    <td>
                      <input type="text" name="driverPerDiem" id="driverPerDiem2" placeholder="" value="<?php echo $driverPerDiem; ?>">
                    </td>
                    <td>
                      <label>Cash Collection from IPA Office </label>
                    </td>
                    <td>
                      <input type="text"  id="driverPerDiemCashCollection2" name="driverPerDiemCashCollection" placeholder="" value="<?php echo $driverPerDiemCashCollection; ?>" onkeyup='isNumeric(this.id)'/><span id='driverPerDiemCashCollection2Span'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    </td>

                    <td id="tdError">
                    </td>
                  </tr>
                </table>
                <table>
                  <tr>
                    <td style="width:600px;"><b>
                        TOTAL IMPREST AMOUNT TO BE PAID ON DEPARTURE
                      </b><input type="text"   id="totalAmount2" placeholder="" name="total" value="<?php echo $total; ?>" disable/>
                    </td>
                  </tr>

                </table>
                    <?php if( $priv_dispatch>=2){ ?>
                <input type="submit" name="updateRecord"  style="width:20%;margin-left:25%;margin-top:5%;" class="btn btn-success" value="update Details" />
                    <?php } ?>
              </form>

            </div>  
          </div> 
        <?php } ?>
      </div>
    </div>

  </body>
</html>

<script>

                          function prepareEventHandler() {
                            var listed_km = document.getElementById("listed_km");
                            var km_rate = document.getElementById("km_rate");
                            var fuel = document.getElementById("fuel");
                            var totalAmount = document.getElementById("totalAmount");
                            var driverPerDiem = document.getElementById("driverPerDiem");
                            var kemsaLoadersMombasa = document.getElementById("kemsaLoadersMombasa");
                            var kemsaLoadersNairobi = document.getElementById("kemsaLoadersNairobi");
                            var airTime = document.getElementById("airTime");
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

                            var openModalTabReturn = document.getElementById("openModalTabReturn");



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
                              if (!isNaN(driverPerDiemCashCollection.value) && !isNaN(kemsaLoadersMombasaCashCollection.value) && !isNaN(kemsaLoadersNairobiCashCollection.value) && !isNaN(serviceCashCollection.value) && !isNaN(MOPHSCashCollection.value) && !isNaN(airTimeMOCashCol.value) && !isNaN(incidentalsCashCollection.value)) {
                                totalAmount.value = (serviceCashCollection.value * 1) + (driverPerDiemCashCollection.value * 1) + (kemsaLoadersMombasaCashCollection.value * 1) + (kemsaLoadersNairobiCashCollection.value * 1) + (MOPHSCashCollection.value * 1) + (airTimeMOCashCol.value * 1) + (incidentalsCashCollection.value * 1) + (fuel.value * 1);
                              } else {
                                console.log("Enter Numerical data");
                              }
                            }, false);
                          }



                          function prepareEventHandler2() {
                            var listed_km2 = document.getElementById("listed_km2");
                            var km_rate2 = document.getElementById("km_rate2");
                            var fuel2 = document.getElementById("fuel2");
                            var totalAmount2 = document.getElementById("totalAmount2");
                            var driverPerDiem2 = document.getElementById("driverPerDiem2");
                            var kemsaLoadersMombasa2 = document.getElementById("kemsaLoadersMombasa2");
                            var kemsaLoadersNairobi2 = document.getElementById("kemsaLoadersNairobi2");
                            var airTime2 = document.getElementById("airTime2");
                            var MOPHS2 = document.getElementById("MOPHS2");
                            var service2 = document.getElementById("service2");
                            var incidentals2 = document.getElementById("incidentals2");
                            var airTimeMOPHS2 = document.getElementById("airTimeMOPHS2");

                            //cASH cOLLECTIONS
                            var incidentalsCashCollection2 = document.getElementById("incidentalsCashCollection2");
                            var airTimeMOCashCol2 = document.getElementById("airTimeMoCashCol2");
                            var MOPHSCashCollection2 = document.getElementById("MOPHSCashCollection2");
                            var serviceCashCollection2 = document.getElementById("serviceCashCollection2");
                            var kemsaLoadersNairobiCashCollection2 = document.getElementById("kemsaLoadersNairobiCashCollection2");
                            var kemsaLoadersMombasaCashCollection2 = document.getElementById("kemsaLoadersMombasaCashCollection2");
                            var driverPerDiemCashCollection2 = document.getElementById("driverPerDiemCashCollection2");

                            var openModalTabReturn = document.getElementById("openModalTabReturn");



                            listed_km2.onblur = function() {
                              console.log(listed_km2.value);

                              calculateFuel2();
                              runTotal();

                            };
                            km_rate2.onblur = function() {
                              console.log(km_rate2.value);

                              calculateFuel2();
                              runTotal();

                            }
                            function calculateFuel2() {

                              if (!isNaN(listed_km2.value) && !isNaN(km_rate2.value)) {
                                fuel2.value = km_rate2.value * listed_km2.value;

                              }
                            }
                            fuel2.onchange = function() {
                              if (!isNaN(driverPerDiemCashCollection2.value) && !isNaN(kemsaLoadersMombasaCashCollection2.value) && !isNaN(kemsaLoadersNairobiCashCollection2.value) && !isNaN(serviceCashCollection2.value) && !isNaN(MOPHSCashCollection2.value) && !isNaN(airTimeMOCashCol2.value) && !isNaN(incidentalsCashCollection2.value)) {
                                totalAmount2.value = (serviceCashCollection2.value * 1) + (driverPerDiemCashCollection2.value * 1) + (kemsaLoadersMombasaCashCollection2.value * 1) + (kemsaLoadersNairobiCashCollection2.value * 1) + (MOPHSCashCollection2.value * 1) + (airTimeMOCashCol2.value * 1) + (incidentalsCashCollection2.value * 1) + (fuel2.value * 1);
                              } else {
                                console.log("Enter Numerical data");
                              }



                            };
                            function runTotal() {
                              if (!isNaN(driverPerDiemCashCollection2.value) && !isNaN(kemsaLoadersMombasaCashCollection2.value) && !isNaN(kemsaLoadersNairobiCashCollection2.value) && !isNaN(serviceCashCollection2.value) && !isNaN(MOPHSCashCollection2.value) && !isNaN(airTimeMOCashCol2.value) && !isNaN(incidentalsCashCollection2.value)) {
                                totalAmount2.value = (serviceCashCollection2.value * 1) + (driverPerDiemCashCollection2.value * 1) + (kemsaLoadersMombasaCashCollection2.value * 1) + (kemsaLoadersNairobiCashCollection2.value * 1) + (MOPHSCashCollection2.value * 1) + (airTimeMOCashCol2.value * 1) + (incidentalsCashCollection2.value * 1) + (fuel2.value * 1);
                              } else {
                                console.log("Enter Numerical data");
                              }



                            }
                            window.addEventListener('input', function calculateTotalAmount2() {
                              if (!isNaN(driverPerDiemCashCollection2.value) && !isNaN(kemsaLoadersMombasaCashCollection2.value) && !isNaN(kemsaLoadersNairobiCashCollection2.value) && !isNaN(serviceCashCollection2.value) && !isNaN(MOPHSCashCollection2.value) && !isNaN(airTimeMOCashCol2.value) && !isNaN(incidentalsCashCollection2.value)) {
                                totalAmount2.value = (serviceCashCollection2.value * 1) + (driverPerDiemCashCollection2.value * 1) + (kemsaLoadersMombasaCashCollection2.value * 1) + (kemsaLoadersNairobiCashCollection2.value * 1) + (MOPHSCashCollection2.value * 1) + (airTimeMOCashCol2.value * 1) + (incidentalsCashCollection2.value * 1) + (fuel2.value * 1);
                              } else {
                                console.log("Enter Numerical data");
                              }
                            }, false);
                          }
                          window.onload = function() {
                            prepareEventHandler();
                            prepareEventHandler2();
                          }



</script>

<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
  $(function() {
    $('input#id_search').quicksearch('table tbody tr');
  });
</script> 

<script src="../js/keydown_event"></script>

