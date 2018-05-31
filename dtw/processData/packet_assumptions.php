<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];

$rate = "SELECT * FROM rate_per_km LIMIT 1";
$result = mysql_query($rate);
while ($row = mysql_fetch_array($result)) {
$rate_per_km = $row['rate_per_km'];
}
//Submit Document Intake Materials Form
if(isset($_POST['Submit']))
{
//Sel All Fields Populated
	$id = $_POST['id'];
	$form_name= $_POST['form_name'];
	$per_pack= $_POST['per_pack'];
	$children_per_sheet = $_POST['children_per_sheet'];
 
	$query = "INSERT INTO packet_assumptions (form_name,per_pack,children_per_sheet) 
	VALUES('{$form_name}','{$per_pack}','{$children_per_sheet}')";
	mysql_query($query) or die ("Error in query: $query");
	header("Location: packet_assumptions.php");
}
?>
<!---
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
      <?php
     // require_once ("../includes/meta-link-script.php");
      ?>
  </head>
  <body>
 
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   //require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
   content body 
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        //require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
      <div class="contentBody">
        ------------------------>
	  <form action="" method="POST">
        <table width="50%" align="center">
  <tr>
    <th colspan="2">Packet Assumption Form</th>
  </tr>
  <tr>
  <td><b>Form Name: </b> </td><td><input type="text" name="form_name" style="width: 250px;" value="" required></td>
  </tr>
  <tr>
  <td><b>Per Pack:</b> </td><td><input type="text" name="per_pack" id="per_pack" style="width: 250px;" value="" required></td>
  </tr>
  <tr>
  <td><b>Children Per Sheet: </b> </td><td><input type="text" name="children_per_sheet" id="children_per_sheet" style="width: 250px;" value="" required></td>
  </tr>
  <tr><td colspan="2" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Submit Details" /></td></tr>
</table>
	</form>
	<p>
	<div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
                  <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                    <thead>
                      <tr style="border: 1px solid #B4B5B0;">
                        <th align="Left" width="10%">Form Name</th>
                        <th align="Left" width="10%">Per Pack</th>
                        <th align="Left" width="20%">Children Per Sheet</th>
                        <th align="center" width="4%">Edit</th>
                        <th align="center" width="4%">Del</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $sql = "SELECT * FROM packet_assumptions ORDER BY form_name ASC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)) {
                        $id = $row['id'];
						$form_name = $row['form_name'];
                        $per_pack = $row['per_pack'];
                        $children_per_sheet = $row['children_per_sheet'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">
                          <td align="left" width="10%"> <?php echo $form_name; ?> </td>
                          <td align="left" width="10%"> <?php echo $per_pack; ?> </td>
                          <td align="left" width="20%"> <?php echo $children_per_sheet; ?> </td>
                          <td align="center" width="4%"><a href="edit_packet_assumptions.php?id=<?php echo $id; ?>" onclick="javascript:void window.open('edit_packet_assumptions.php?id=<?php echo $id; ?>', '1397210634467', 'width=700,height=500,status=1,scrollbars=1,resizable=1,left=350,top=0');
          return false;"><img src="../images/icons/edit2.png" height="20px"></a></td>
                          <td align="center" width="4%"><a href="delete_packet_assumptions.php?id=<?php echo $id; ?>" onclick="return confirm('Are you Sure you want to Delete Record?');"><img src="../images/icons/delete.png" height="20px"></a></td>
                        </tr>
                      </tbody>
                    <?php } ?>
                  </table>
                </div>

				</p>
        <!--
      </div>
   
  </body>
</html>
================================================-->











