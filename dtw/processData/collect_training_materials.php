<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$no_of_records = $_POST['no_of_records'];

//Submit Collect Training Materials Form
if(isset($_POST['Submit']))
{
//Sel All Fields Populated
$size = $no_of_records;
$records = 0;
while ($records < $size) {	
	$date = $_POST['date'];
	$ministry= $_POST['ministry'];
	$purpose= $_POST['purpose'];
	$name = $_POST['name'][$records];
	$personal_no= $_POST['personal_no'][$records];
	$title= $_POST['title'][$records];
	$phone_no= $_POST['phone_no'][$records];
	$no_of_boxes= $_POST['no_of_boxes'][$records];
	$no_of_poles= $_POST['no_of_poles'][$records];
	$pby_name= $_POST['pby_name'];
	$pby_position= $_POST['pby_position'];
	$pby_contact= $_POST['pby_contact'];
	$pby_date= $_POST['pby_date'];
 
	$query = "INSERT INTO collect_training_materials (date,ministry,purpose,name,personal_no,title,phone_no,no_of_boxes,no_of_poles,pby_name,pby_position,pby_contact,pby_date) 
	VALUES('{$date}','{$ministry}','{$purpose}','{$name}','{$personal_no}','{$title}','{$phone_no}','{$no_of_boxes}','{$no_of_poles}','{$pby_name}','{$pby_position}','{$pby_contact}','{$pby_date}')";
	mysql_query($query) or die ("Error in query: $query");
	++$records;
	header("Location: collect_training_materials.php");
}
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
    
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <body>
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
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
        
      <div class="contentBody">
<table width="80%" align="center">
  <tr>
    <th colspan="7">Collecting Training Material Form</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<form action="" method="POST">
    <td colspan="2"><b>No of Records to Post:</b> 
	<select name="no_of_records" id="no_of_records" style="width:50px;">
		<option value="<?php echo $no_of_records; ?>"></option>
		<?php for ($count = 1; $count <= 60; $count++) : ?>
		<option value="<?php echo $count; ?>"><?php echo $count; ?></option>
		<?php endfor; ?>
	</select><input type="submit" name="Get_Records" value="Go" />
	</td>
	</form>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<form action="" method="POST">
    <?php
    if($no_of_records>0){
    ?>
  <tr>
    <td><b><input name="no_of_records" type="hidden" value="<?php echo $no_of_records; ?>">Date:</b></td>
    <td colspan="2"><input name="date" type="date" class="datepicker" required></td>
	<td>&nbsp;</td>
    <td colspan="3"><b>Tick One: </b><input type="radio" name="ministry" value="MoE" required>MoE <input type="radio" name="ministry" value="MoPHS" required>MoPHS</td>
  </tr>
  <tr>
    <td colspan="7" align="center"><b>Purpose (tick one): </b>
	<input type="radio" name="purpose" value="Collecting Training Materials" required>
        Collecting Training Materials
    <input type="radio" name="purpose" value="Picking Master trainers">
        Picking Master trainers
	<input type="radio" name="purpose" value="Other">
        Other
	</td>
  </tr>
  <tr>
    <th>No.</th>
    <th>Name</th>
    <th>Personal Number (P/No)</th>
    <th>Position/Title</th>
    <th>Mobile Phone Number</th>
    <th>Number of Boxes</th>
    <th>Number of Poles</th>
  </tr>
  <?php
	for ($i=1; $i<=$no_of_records; $i++){
  ?>
  <tr>
    <td><?php echo $i ?></td>
    <td><input name="name[]" type="text" id="name"></td>
    <td><input name="personal_no[]" type="text" id="personal_no"></td>
    <td><select name="title[]" id="title">
      <option value="">Position/Title</option>
      <option value="DEO">DEO</option>
      <option value="AEO">AEO</option>
      <option value="DMOH">DMOH</option>
      <option value="DPHO">DPHO</option>
    </select>    </td>
    <td><input name="phone_no[]" type="text" id="phone_no"></td>
    <td><input name="no_of_boxes[]" type="text" id="no_of_boxes"></td>
    <td><input name="no_of_poles[]" type="text" id="no_of_poles"></td>
  <?php
	}
  ?>
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
    <td>  <select name="pby_name"  id="pby_name">
        
        
        <?php
        echo "<option selected='selected' value=".$_SESSION["staff_name"].">".$_SESSION["staff_name"]."</option>";
       
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
      <option value="">Position/Title</option>
      <option value="DEO">DEO</option>
      <option value="AEO">AEO</option>
      <option value="DMOH">DMOH</option>
      <option value="DPHO">DPHO</option>
    </select>
	</td>
    <td><input name="pby_contact" type="text" id="pby_contact" placeholder="Contact" required/></td>
    <td>&nbsp;</td>
    <td><input name="pby_date" type="date" id="pby_date" class="datepicker" placeholder="Date" required/></td>
  </tr>
  <tr><td colspan="7" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Submit Details" /></td></tr>
<?php
    }
    ?>
</form>
</table>
	<p>
	<div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
                  <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                    <thead>
                      <tr style="border: 1px solid #B4B5B0;">

                        <th align="Left" width="10%">Date</th>
                        <th align="Left" width="10%">Ministry</th>
                        <th align="Left" width="10%">Purpose</th>
                        <th align="Left" width="20%">Name</th>
                        <th align="Left" width="15%">Personal No</th>
                        <th align="Left" width="10%">Title</th>
						<th align="Left" width="10%">Phone No</th>
                        <th align="Left" width="10%">No of Boxes</th>
                        <th align="Left" width="10%">No of Poles</th>
                        <th align="center" width="4%">Edit</th>
                        <th align="center" width="4%">Del</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $count = 0;
                      $sql = "SELECT * FROM collect_training_materials ORDER BY date DESC";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)) {

                        $id = $row['id'];
                        $date = $row['date'];
                        $ministry = $row['ministry'];
                        $purpose = $row['purpose'];
                        $name = $row['name'];
                        $personal_no = $row['personal_no'];
                        $title = $row['title'];
						$phone_no = $row['phone_no'];
                        $no_of_boxes = $row['no_of_boxes'];
                        $no_of_poles = $row['no_of_poles'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">

                          <td align="left" width="10%"> <?php echo $date; ?>  </td>
                          <td align="left" width="10%"> <?php echo $ministry; ?> </td>
                          <td align="left" width="10%"> <?php echo $purpose; ?> </td>
                          <td align="left" width="20%"> <?php echo $name; ?> </td>
                          <td align="left" width="15%"> <?php echo $personal_no; ?> </td>
                          <td align="left" width="10%"> <?php echo $title; ?>  </td>
						  <td align="left" width="10%"> <?php echo $phone_no; ?>  </td>
                          <td align="left" width="10%"> <?php echo $no_of_boxes; ?> </td>
                          <td align="left" width="10%"> <?php echo $no_of_poles; ?> </td>
                          <td align="center" width="4%"><a href="edit_collect_training_materials.php?id=<?php echo $id; ?>" onclick="javascript:void window.open('edit_collect_training_materials.php?id=<?php echo $id; ?>', '1397210634467', 'width=1050,height=500,status=1,scrollbars=1,resizable=1,left=150,top=0'); 
						  return false;"><img src="../images/icons/edit2.png" height="20px"></a></td>
                          <td align="center" width="4%"><a href="delete_collect_training_materials.php?id=<?php echo $id; ?>" onclick="return confirm('Are you Sure you want to Delete Record?');"><img src="../images/icons/delete.png" height="20px"></a></td>
                        </tr>
                      </tbody>
                    <?php } ?>
                  </table>
                </div>
				</p>
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
$( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
});
</script>











