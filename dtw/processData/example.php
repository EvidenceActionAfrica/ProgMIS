<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];


$district_name=isset($_POST["district_name"])? mysql_real_escape_string($_POST["district_name"]):"";
$dmoh=isset($_POST["dmoh"])? mysql_real_escape_string($_POST["dmoh"]):"";
$pickup=isset($_POST["pickup"])? mysql_real_escape_string($_POST["pickup"]):"";
$quantity_dispatched=isset($_POST["quantity_dispatched"])? mysql_real_escape_string($_POST["quantity_dispatched"]):"";
$batch=isset($_POST["batch"])?$_POST["batch"]:"";
$expiry_dates=isset($_POST["expiry_dates"])? trim($_POST["expiry_dates"]):"";
$division_name=isset($_POST["division_name"])? mysql_real_escape_string($_POST["division_name"]):"";
$currentDate=date("Y-m-d");
$receive_drugs=isset($_POST["receive_drugs"])? mysql_real_escape_string($_POST["receive_drugs"]):"";

$format_expiry_dates=mysql_real_escape_string($expiry_dates);
$format_batch=mysql_real_escape_string($batch);
if (isset($_POST['saveRecord'])) {

$sql="INSERT INTO `drugs_tablet_pickup_form`(`district_name`, `person_picking_drugs`, `person_receving_drugs`, `expiry_dates`, `batch_numbers`, `dmoh`, `division_name`, `date`,`quantity_dispatched`)";
$sql.=" VALUES ('$district_name','$pickup','$receive_drugs','$format_expiry_dates','$format_batch','$dmoh','$division_name','$currentDate','$quantity_dispatched')";

mysql_query($sql) or die(mysql_error());


}
if(isset($_GET["deleteId"])){
$deleteId=$_GET["deleteId"];
$sql="DELETE from drugs_tablet_pickup_form where form_id='$deleteId'";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
      <?php
      require_once ("../includes/meta-link-script.php");
      ?>
      <script src="../js/tabs.js"></script>
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
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >	  
        <div id="tabContainer">
          <div id="tabs">
            <ul>
              <li id="tabHeader_1">Add Tablet Pickup Form</li>
              <li id="tabHeader_2">View Tablet Pickup Form</li>
            </ul>
          </div>
          <div id="tabscontent">
            <div class="tabpage" id="tabpage_1">
      
	  
	   <div>
          <h2>Tablet Pickup Form</h2>
        </div>
        
        <form action="" method="post">
          <table style="width: 80%">
          <tr>
            <td>District</td>   <td>
                        <select name="district_name"  class="input_select_p compact">
                          <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                          <?php
                          $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <option value="<?php echo $rows['district_name']; ?>"<?php
                            if ($district_name == $rows['district_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['district_name']; ?></option>
                                  <?php } ?>
                        </select>
                      </td>
          </tr>
          <tr>
            <td>DMOH</td><td><input class="input_textbox" type="text" name="dmoh"  value="<?php echo $dmoh; ?>"/></td>
          </tr>
          <tr>
            <td>Person Picking Drugs</td><td><input class="input_textbox" type="text" name="pickup"  value="<?php echo $pickup; ?>"/></td>
           <td>Person Receiving Drugs</td><td><input class="input_textbox" type="text" name="receive_drugs" value="<?php echo $receive_drugs; ?>"/></td>
           
			</tr>
          <tr>
            <td>Division</td>
            
          	<td>
                        <select name="division_name"  class="input_select_p compact">
                          <option value=''<?php if ($division_name == '') echo 'selected'; ?> ></option>
                          <?php
                          $sql = "SELECT * FROM divisions ORDER BY division_name ASC";
                          $result = mysql_query($sql);
                          while ($rows = mysql_fetch_array($result)) { //loop table rows
                            ?>
                            <option value="<?php echo $rows['division_name']; ?>"<?php
                            if ($division_name == $rows['division_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['division_name']; ?></option>
                                  <?php } ?>
                        </select>
                      </td>
			 <td>
                <label>Quantity Of drugs dispached</label>
            </td>
			<td>
                <input class="input_textbox" type="text" name="quantity_dispatched"  value="<?php echo $quantity_dispatched; ?>">
				</td>
				</tr>
            <tr>
			<td>
                <label>Drug batch Numbers</label>
			</td>
				<td>
				<textarea style="width:300px;min-width:300px;max-width:300px;height:200px;min-height:200px;max-height:200px;" name="batch">
				<?php echo $batch; ?>
				</textarea>
				</td>
             <td>Drug Expiry Dates</td><td><textarea style="width:300px;min-width:300px;max-width:300px;height:200px;min-height:200px;max-height:200px;" class="input_textbox" type="text" name="expiry_dates"/><?php echo $expiry_dates; ?> </textarea></td>
              </tr>
                 </table >
            <input class="btn-custom-small"type="submit" name="saveRecord" value="Save Record" >
        

<!-- <input class="btn-custom-small"type="submit" name="name" value="value" > -->
        </form>
	  </div> <!--//end div !-->
            <div class="tabpage" id="tabpage_2">
     
	   <h2>View Tablet Pickup Form</h2>
          

              <table>
                <tr>
                  <td style="width: 40%;" width="30%">

                    <h1 style="text-align: center; margin-top: 0px; font-size: 20px">View Tablet Pickup Form</h1>

                    <form method="post" style="margin-left:70%;">
                      <input type="search" name="search" value="" placeholder="Type Client Name or note id"/>
                      <input type="submit" class=" btn btn-info" name="find" value="Search" />
                    </form>



                    <table style="width:100%; height:100px; overflow-x: visible; overflow-y: scroll; float: left"width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <thead>
                        <tr style="border: 1px solid #B4B5B0;">
                          <th align="Left" width="10px">PickUp Form Id</th>
                          <th align="Left" width="10px">District</th>
                          <th align="Left" width="10px">Division</th>
                          <th align="Left" width="30px">Person Picking Drugs<th>
                          <th align="Left" width="10px">Person Receiving Drugs</th>
                          <th align="Left" width="10px">Quantity</th>
                          <th align="Left" width="10px">Date Saved</th>
                          <th align="center" width="10px">View</th>
                          <th align="center" width="10px">Del</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $sql = "SELECT * FROM drugs_tablet_pickup_form";

                        if (isset($_POST["find"])) {
                          $search = filter_input(INPUT_POST, "search");

                          $sql.=" where form_id like '%$search%' or person_picking_drugs like '%$search%'";
                          $sql.=" or person_receving_drugs like '%$search%' or date like '%$search%' or district_name like '%$search%'";
                          $sql.=" or division_name like '%$search%' or batch_numbers like '%$search%'";

						  }


                        $sql.="  ORDER BY date DESC";
                        $result_set = mysql_query($sql);

                        while ($row = mysql_fetch_array($result_set)) {
                         
											 
					$district_name=$row["district_name"];
					$dmoh=$row["dmoh"];
					$pickup=$row["person_picking_drugs"];
					$quantity_dispatched=$row["quantity_dispatched"];
					$batch=$row["batch"];
					$expiry_dates=$row["expiry_dates"];
					$division_name=$row["division_name"];
					$currentDate=$row["date"];
					$receive_drugs=$row["person_receving_drugs"];
					$form_id=$row["form_id"];
						 
                          ?>

                          <tr style="border-bottom: 1px solid #B4B5B0;">
                            <td align="left" width="30px"> <?php echo $form_id; ?>  </td>
                            <td align="left" width="10px"> <?php echo $district_name; ?> </td>
							<td align="left" width="10px"> <?php echo $division_name; ?> </td>
							
                            <td align="left" width="10px"> <?php echo $pickup; ?> </td>
                            <td align="left" width="10px"> <?php echo $receive_drugs; ?> </td>
                            <td align="left" width="10px"> <?php echo $quantity_dispatched; ?> </td>
                            <td align="left" width="10px"> <?php echo $currentDate; ?> </td>
                            <td align="center" width="10px"><a href="tabPickupForm.php?form_id=<?php echo $form_id; ?> " ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <!--
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $form_id;     ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td> 
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $form_id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                            !-->
                            <td align="center" width="40px"><a href="deliveryNote.php?deleteId=<?php echo $form_id; ?> " ><img src="../images/icons/delete.png" height="20px"/></a></td>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>

                  </td>
                  <?php //include('addNew.php');     ?>
                </tr>
              </table>


	 
	 
	 
	 
            </div>

          </div>
        </div>
      </div>
    </div>

  </body>
</html>
