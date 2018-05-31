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
  $date = mysql_prep($_POST['date']);
  $ministry = mysql_prep($_POST['ministry']);
  $purpose = mysql_prep($_POST['purpose']);
  $name = mysql_prep($_POST['name']);
  $personal_no = mysql_prep($_POST['personal_no']);
  $title = mysql_prep($_POST['title']);
  $phone_no = mysql_prep($_POST['phone_no']);
  $no_of_boxes = mysql_prep($_POST['no_of_boxes']);
  $no_of_poles = mysql_prep($_POST['no_of_poles']);
  $pby_name = mysql_prep($_POST['pby_name']);
  $pby_position = mysql_prep($_POST['pby_position']);
  $pby_contact = mysql_prep($_POST['pby_contact']);
  $pby_date = mysql_prep($_POST['pby_date']);

  $sql = "UPDATE collect_training_materials SET date='$date',ministry='$ministry',purpose='$purpose',name='$name',personal_no='$personal_no',title='$title',phone_no='$phone_no',no_of_boxes='$no_of_boxes',no_of_poles='$no_of_poles',pby_name='$pby_name',pby_position='$pby_position',pby_contact='$pby_contact',pby_date='$pby_date' WHERE id='{$_POST['id']}'";
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
      
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <?php
    $id = $_GET['id'];
    $sql = "SELECT * FROM collect_training_materials WHERE id='$id'";
    $result1 = mysql_query($sql);
    while ($row1 = mysql_fetch_array($result1)) {
      $date = $row1['date'];
      $ministry = $row1['ministry'];
      $purpose = $row1['purpose'];
      $name = $row1['name'];
      $personal_no = $row1['personal_no'];
      $title = $row1['title'];
      $phone_no = $row1['phone_no'];
      $no_of_boxes = $row1['no_of_boxes'];
      $no_of_poles = $row1['no_of_poles'];
      $pby_name = $row1['pby_name'];
      $pby_position = $row1['pby_position'];
      $pby_contact = $row1['pby_contact'];
      $pby_date = $row1['pby_date'];
      ?>
      <form action="" method="POST">
        <?php include("includes/messageBox.php"); ?>
        <table width="80%" align="center">
          <tr>
            <th colspan="7">Collecting Training Material Form</th>
          </tr>
          <form action="" method="POST">
            <tr>
              <td><b><input name="id" type="hidden" value="<?php echo $id; ?>">
                    Date:</b></td><td colspan="2"><input name="date" type="date" class="datepicker" value="<?php echo $date; ?>" required></td>
              <td>&nbsp;</td>
              <td colspan="3"><b>Tick One: </b>
              <!-- <?php echo'---'. $ministry ?> -->
                <input type="radio" name="ministry" value="MoE"   <?php if ($ministry == 'MoE') echo 'checked'; ?> />MoE 
                <input type="radio" name="ministry" value="MoPHS" <?php if ($ministry == 'MoPHS') echo 'checked'; ?> />MoPHS
              </td>
            </tr>
            <tr>
              <td colspan="7" align="center"><b>Purpose (tick one): </b>
                <input type="radio" name="purpose" value="Collecting Training Materials" <?php if ($purpose == 'Collecting Training Materials') echo 'checked'; ?> required/>
                Collecting Training Materials
                <input type="radio" name="purpose" value="Picking Master trainers" <?php if ($purpose == 'Picking Master trainers') echo 'checked'; ?> />
                Picking Master trainers
                <input type="radio" name="purpose" value="Other"  <?php if ($purpose == 'Other') echo 'checked'; ?>  />
                Other
              </td>
            </tr>
            <tr>
              <th>Id.</th>
              <th>Name</th>
              <th>Personal Number (P/No)</th>
              <th>Position/Title</th>
              <th>Mobile Phone Number</th>
              <th>Number of Boxes</th>
              <th>Number of Poles</th>
            </tr>
            <tr>
              <td>1</td>
              <td><input name="name" type="text" id="name" value="<?php echo $name; ?>"></td>
              <td><input name="personal_no" type="text" id="personal_no" value="<?php echo $personal_no; ?>"></td>
              <td><select name="title" id="title">
                  <option value="<?php echo $title; ?>"><?php echo $title; ?></option>
                  <option value="DEO">DEO</option>
                  <option value="AEO">AEO</option>
                  <option value="DMOH">DMOH</option>
                  <option value="DPHO">DPHO</option>
                </select>    </td>
              <td><input name="phone_no" type="text" id="phone_no" value="<?php echo $phone_no; ?>"></td>
              <td><input name="no_of_boxes" type="text" id="no_of_boxes" value="<?php echo $no_of_boxes; ?>"></td>
              <td><input name="no_of_poles" type="text" id="no_of_poles" value="<?php echo $no_of_poles; ?>"></td>
            </tr> 
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><b>Prepared By:</b></td>
              <td>
               <select name="pby_name"  id="pby_name">
        
        
        <?php
        
        echo "<option selected='selected' value=".$_SESSION["staff_name"].">".$pby_name."</option>";
       
        
       $sql="SELECT * from staff";
       $result=mysql_query($sql);
       while($row=mysql_fetch_array($result)){
        
       
        echo "<option value=".$row["staff_name"].">".$row["staff_name"]."</option>";
       
      
       }
       ?>
  
            </select>
              
              </td>
              <td>
                <select name="pby_position" id="pby_position" required>
                  <option value="<?php echo $pby_position; ?>"><?php echo $pby_position; ?></option>
                  <option value="DEO">DEO</option>
                  <option value="AEO">AEO</option>
                  <option value="DMOH">DMOH</option>
                  <option value="DPHO">DPHO</option>
                </select>
              </td>
              <td><input name="pby_contact" type="text" id="pby_contact" placeholder="Contact" value="<?php echo $pby_contact; ?>" required/></td>
              
              <td><input name="pby_date" type="date" id="pby_date" class="datepicker" placeholder="Date" value="<?php echo $pby_date; ?>" required/></td>
            </tr>
            <tr><td colspan="4" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Update Record" /><input class="btn-custom-small" type="button" value="Exit Window" onClick="CloseAndRefresh();"></td></tr>
          </form>
        </table>
      </form>
    <?php } ?>
  </body>
     <script>
$(function() {
$( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
});
</script>




</html>