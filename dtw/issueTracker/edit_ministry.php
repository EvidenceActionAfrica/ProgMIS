<?php
require_once('includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
$id = $_GET[id];

//Update Page Form
if(isset($_POST['Submit']))
{
//If no Errors Submit Form
$ministry=mysql_prep($_POST['ministry']);
$content=mysql_real_escape_string($_POST['content']);

$sql="UPDATE dropdown_ministry SET ministry='$ministry' WHERE id='$id'";
$result = mysql_query($sql) or die(mysql_error());
$messageToUser="Ministry Updated Successfully.";
}
?>
<link rel="stylesheet" href="styles/style.css" type="text/css" />
<script type="text/javascript" src="nicEdit/nicEdit.js"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script language="JavaScript" type="text/javascript">
function CloseAndRefresh()
{
opener.location.reload(true);
self.close();
}
</script>
<table style="min-width:250px;" align="center">
<?php
{
	$result_set=mysql_query("SELECT * FROM dropdown_ministry WHERE id='$id'");
	while($row=mysql_fetch_array($result_set))
	{
	$id=$row['id'];
	$ministry=$row['ministry'];
?>
<tr>
	<td>
	<form action='' method='POST'>
	<?php include("includes/messageBox.php");?>
	<h2 align="center">Edit Ministry</h2>
     <p><input type="text" name="ministry" style="width: 250px;" value="<?php echo $ministry ?>" required> </p>
     <p align="center"><input type="submit" name="Submit" id="Submit" value="Update Ministry"/><input type="button" value="Exit Window" onClick="CloseAndRefresh();"></p>
	</form>
	</td>
</tr>
<?php
	}
}
?>
</table>