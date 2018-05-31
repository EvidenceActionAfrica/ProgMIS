<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
//Update Page Form
if(isset($_POST['Submit']))
{
//If no Errors Submit Form
$form_name=mysql_prep($_POST['form_name']);
$per_pack=mysql_prep($_POST['per_pack']);
$children_per_sheet=mysql_prep($_POST['children_per_sheet']);

$sql="UPDATE packet_assumptions SET form_name='$form_name',per_pack='$per_pack',children_per_sheet='$children_per_sheet' WHERE id='{$_POST['id']}'";
$result = mysql_query($sql) or die(mysql_error());
$messageToUser="Record Updated Successfully.";
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
<?php
$id = $_GET['id'];
$sql = "SELECT * FROM packet_assumptions WHERE id='$id'";
$result1 = mysql_query($sql);
while ($row1 = mysql_fetch_array($result1)) {
$id = $row1['id'];
$form_name = $row1['form_name'];
$per_pack = $row1['per_pack'];
$children_per_sheet = $row1['children_per_sheet'];
?>
<script type="text/javascript" src="../nicEdit/nicEdit.js"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script language="JavaScript" type="text/javascript">
function CloseAndRefresh()
{
opener.location.reload(true);
self.close();
}
</script>
<form action="" method="POST">
        <table width="50%" align="center">
  <tr>
    <th colspan="2">Edit Packect Assumptions</th>
  </tr>
  <tr>
  <td><b>Form Name: </b> </td><td><input type="hidden" name="id" value="<?php echo $id; ?>" required readonly><input type="text" name="form_name" style="width: 250px;" value="<?php echo $form_name ?>" required></td>
  </tr>
   <tr>
  <td><b>Per Pack: </b> </td><td><input type="text" name="per_pack" style="width: 250px;" value="<?php echo $per_pack ?>" required></td>
  </tr>
   <tr>
  <td><b>Children Per Sheet: </b> </td><td><input type="text" name="children_per_sheet" style="width: 250px;" value="<?php echo $children_per_sheet ?>" required></td>
  </tr>
  <tr><td colspan="2" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Update Details" /><input class="btn-custom-small" type="button" value="Exit Window" onClick="CloseAndRefresh();"></td></tr>
</table>
	</form>
<?php } ?>
</body>
</html>