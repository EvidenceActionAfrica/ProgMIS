<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];

$rate = "SELECT * FROM rate_per_km LIMIT 1";
$result = mysql_query($rate);
while ($row = mysql_fetch_array($result)) {
  $rate_per_km = $row['rate_per_km'];
}

//Update Page Form
if (isset($_POST['Submit'])) {
//If no Errors Submit Form
  $wave_id = mysql_prep($_POST['wave_id']);
  $no_of_poles = mysql_prep($_POST['no_of_poles']);
  $kilometres = mysql_prep($_POST['kilometres']);
  $fuel_cost = mysql_prep($_POST['fuel_cost']);
  $driver_allowance = mysql_prep($_POST['driver_allowance']);
  $mvnt_cost = mysql_prep($_POST['mvnt_cost']);

  $sql = "UPDATE pole_movement SET wave_id='$wave_id',no_of_poles='$no_of_poles',kilometres='$kilometres',fuel_cost='$fuel_cost',driver_allowance='$driver_allowance',mvnt_cost='$mvnt_cost' WHERE pole_id='{$_POST['pole_id']}'";
  $result = mysql_query($sql) or die(mysql_error());
  $messageToUser = "Record Updated Successfully.";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("../includes/meta-link-script.php");
    ?>
  </head>
  <body>
    <script language="JavaScript" type="text/javascript">
      function CloseAndRefresh()
      {
        opener.location.reload(true);
        self.close();
      }
    </script>
    <script type="text/javascript">
      window.onload = function() {
        document.getElementById("kilometres").onkeyup = keyHandler;
        document.getElementById("rate").onkeyup = keyHandler;
        document.getElementById("fuel_cost").onkeyup = keyHandler;
        document.getElementById("driver_allowance").onkeyup = keyHandler;
      }

      function keyHandler()
      {
        var val1 = document.getElementById('kilometres').value;
        var val2 = document.getElementById('rate').value;
        var val3 = document.getElementById('fuel_cost').value;
        var val4 = document.getElementById('driver_allowance').value;

        val1 = convertToInt(val1);
        val2 = convertToInt(val2);
        val3 = convertToInt(val3);
        val4 = convertToInt(val4);

        var fuel_cost = Math.round(val1 * val2);
        document.getElementById('fuel_cost').value = fuel_cost;
        var mvnt_cost = Math.round(val3 + val4);
        document.getElementById('mvnt_cost').value = mvnt_cost;
      }

      function convertToInt(inNum) {
        if (isNaN(inNum))
          return inNum;
        return parseFloat(inNum);
      }
    </script>
    <?php
    $pole_id = $_GET['pole_id'];
    $sql = "SELECT * FROM pole_movement,waves WHERE waves.wave_id=pole_movement.wave_id AND pole_movement.pole_id='$pole_id'";
    $result1 = mysql_query($sql);
    while ($row1 = mysql_fetch_array($result1)) {
      $pole_id = $row1['pole_id'];
      $wave_id = $row1['wave_id'];
      $wave_title = $row1['wave_title'];
      $no_of_poles = $row1['no_of_poles'];
      $kilometres = $row1['kilometres'];
      $fuel_cost = $row1['fuel_cost'];
      $driver_allowance = $row1['driver_allowance'];
      $mvnt_cost = $row1['mvnt_cost'];
      ?>
      <form action="" method="POST">
        <?php include("includes/messageBox.php"); ?>
        <table width="50%" align="center">
          <tr>
            <th colspan="2">Edit Materials Pole Movement Cost</th>
          </tr>
          <tr>
            <td><b>Wave:</b></td>
            <td><input type="hidden" name="pole_id" value="<?php echo $pole_id; ?>" required readonly>
                <select name="wave_id"  style="width: 250px;" required>
                  <option value='<?php echo $wave_id; ?>'><?php echo $wave_title; ?></option>
                  <?php
                  $dist_sql = "SELECT * FROM waves ORDER BY wave_title ASC";
                  $result = mysql_query($dist_sql);
                  while ($dist = mysql_fetch_array($result)) { //loop table rows
                    ?>
                    <option value="<?php echo $dist['wave_id']; ?>"><?php echo $dist['wave_title']; ?></option>
                  <?php } ?>
                </select></td>
          </tr>
          <tr>
            <td><b>No Of Poles: </b> </td><td><input type="text" name="no_of_poles" style="width: 250px;" value="<?php echo $no_of_poles; ?>" required></td>
          </tr>
          <tr>
            <td><b>Kilometres:</b> </td><td><input type="text" name="kilometres" id="kilometres" style="width: 250px;" value="<?php echo $kilometres; ?>" required></td>
          </tr>
          <tr>
            <td><b>Fuel Cost:</b> </td><td><input type="text" name="rate" id="rate" value="<?php echo $rate_per_km; ?>" style="width: 48px;" required readonly><input type="text" name="fuel_cost" id="fuel_cost" style="width: 200px;" value="<?php echo $fuel_cost; ?>" required readonly></td>
                  </tr>
                  <tr>
                    <td><b>Driver Allowance: </b> </td><td><input type="text" name="driver_allowance" id="driver_allowance" style="width: 250px;" value="<?php echo $driver_allowance; ?>" required></td>
                  </tr>
                  <tr>
                    <td><b>Cost: </b> </td><td><input type="text" name="mvnt_cost" id="mvnt_cost" style="width: 250px;" value="<?php echo $mvnt_cost; ?>" required readonly></td>
                  </tr>
                  <tr><td colspan="2" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Update Record" /><input class="btn-custom-small" type="button" value="Exit Window" onClick="CloseAndRefresh();"></td></tr>
                  </table>
                  </form>
                <?php } ?>
                </body>
                </html>