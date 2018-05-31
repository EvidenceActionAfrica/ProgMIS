<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
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
        require_once ("includes/menuLeftBar-ProcessData.php");
        ?>
      </div>
      <div class="contentBody">
	<p>
	<div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
                  <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                    <thead>
                      <tr style="border: 1px solid #B4B5B0;">

                        <th align="Left" width="10%">District</th>
                        <th align="Left" width="10%">Division</th>
                        <th align="Left" width="10%">Training Venue</th>
                        <th align="Left" width="20%">Date</th>
                        <th align="Left" width="15%">Trainer Name</th>
                        <th align="Left" width="10%">Position</th>
						<th align="Left" width="10%">Phone No</th>
                        <th align="Left" width="10%">School Name</th>
                        <th align="Left" width="10%">Teacher 1</th>
                        <th align="center" width="4%">Edit</th>
                        <th align="center" width="4%">Del</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $sql = "SELECT * FROM attnt_bysch,districts,divisions WHERE attnt_bysch.attnt_district_id=districts.district_id AND attnt_bysch.attnt_division_id=divisions.division_id LIMIT 100";
                      $result = mysql_query($sql);
                      while ($row = mysql_fetch_array($result)) {

                        $id = $row['id'];
                        $district_name = $row['district_name'];
                        $division_name = $row['division_name'];
                        $training_venue = $row['training_venue'];
                        $training_date = $row['training_date'];
                        $trainer_name = $row['trainer_name'];
                        $trainer_position = $row['trainer_position'];
						$trainer_phone_num = $row['trainer_phone_num'];
                        $attnt_school_name = $row['attnt_school_name'];
                        $t1_name = $row['t1_name'];
                        ?>
                        <tr style="border-bottom: 1px solid #B4B5B0;">

                          <td align="left" width="10%"> <?php echo $district_name; ?>  </td>
                          <td align="left" width="10%"> <?php echo $division_name; ?> </td>
                          <td align="left" width="10%"> <?php echo $training_venue; ?> </td>
                          <td align="left" width="20%"> <?php echo $training_date; ?> </td>
                          <td align="left" width="15%"> <?php echo $trainer_name; ?> </td>
                          <td align="left" width="10%"> <?php echo $trainer_position; ?>  </td>
						  <td align="left" width="10%"> <?php echo $trainer_phone_num; ?>  </td>
                          <td align="left" width="10%"> <?php echo $attnt_school_name; ?> </td>
                          <td align="left" width="10%"> <?php echo $t1_name; ?> </td>
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












