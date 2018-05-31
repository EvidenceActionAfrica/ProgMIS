<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive="tab1";
$level = $_SESSION['level'];
if(isset($_POST["savePrintOrder"])){
$tabActive="tab7";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
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
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
      <div class="contentBody" >

<?php
if(isset($_GET["id"])){
  $updateResult="";
  $id=$_GET["id"];

  if(isset($_POST["updateRecord"])){
               $materials=isset($_POST["materials"])?mysql_real_escape_string($_POST["materials"]):"";
              $formula_desc=isset($_POST["formula_desc"])?mysql_real_escape_string($_POST["formula_desc"]):"";
              $material_description=isset($_POST["material_description"])?mysql_real_escape_string($_POST["material_description"]):"";
              $material_cat=isset($_POST["material_cat"])?mysql_real_escape_string($_POST["material_cat"]):"";
            
              $packet=isset($_POST["packet"])?mysql_real_escape_string($_POST["packet"]):"";
    


              $sql="UPDATE materials_desc set materials='$materials',formula_desc='$formula_desc',";
              $sql.="material_description='$material_description',material_category='$material_cat',packet='$packet'";
              $sql.=" where id='$id'";
              $resultU=mysql_query($sql) or die(mysql_error());
             if($resultU){
              $updateResult="Material Updated";
             }else{
              $updateResult="Material Update Failed".$sql;
             }
           

  }
  if(isset($_POST["saveParam"])){
             $var1=isset($_POST["var1"])?mysql_real_escape_string($_POST["var1"]):0;
             $var2=isset($_POST["var2"])?mysql_real_escape_string($_POST["var2"]):0;
             $var3=isset($_POST["var3"])?mysql_real_escape_string($_POST["var3"]):0;
             $var4=isset($_POST["var4"])?mysql_real_escape_string($_POST["var4"]):0;
             $var5=isset($_POST["var5"])?mysql_real_escape_string($_POST["var5"]):0;
              $basic_unit=isset($_POST["basic_unit"])?mysql_real_escape_string($_POST["basic_unit"]):"";
             $basic_unit=str_replace("+"," ",$basic_unit);
             $formula_desc=$var1.$basic_unit;
              $sql="UPDATE materials_desc set var1='$var1',var2='$var2',var3='$var3',var4='$var4',var5='$var5',formula_desc='$formula_desc'";
              $sql.=" where id='$id'";
              $resultU=mysql_query($sql) or die(mysql_error());
             if($resultU){
              $updateResult="Material Updated";
             }else{
              $updateResult="Material Update Failed".$sql;
             }
         /*
           $count=0;
             while($count<=5){
             $pos=strpos($basic_unit,"+");
             if($pos===true){
              if($count==5){
              $basic_unit=str_replace("+",$var1."%",$basic_unit);

              }else{
            $basic_unit=str_replace("+",$var1,$basic_unit);
            
              }
             
             }
             echo ++$count;
             */  

  }
  $sql="select * from materials_desc where id='$id'";
  $resultU=mysql_query($sql);
  while($key=mysql_fetch_array($resultU)){
            $materials=$key["materials"];
              $formula_desc=$key["formula_desc"];
              $material_description=$key["material_description"];
              $material_cat=$key["material_category"];
             $packet=$key["packet"];
             $formula_id=$key["formula_id"];
             $var1=$key["var1"];
             $var2=$key["var2"];
            $var3=$key["var3"];
             $var4=$key["var4"];
             $var5=$key["var5"];
             $basic_unit=$key["basic_unit"];
                       
  }

  ?>

<div id="openModal" class="modalDialog">
  <div>
    <a href="materials_printlist.php" title="Close" class="close">X</a>
    <!-- ================= -->
    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
   <h2 class="text-center">Edit Material Details</h2>
    <form class="form" method="post">
      <table>
        <tr><td><label for="material">Material</label></td>
            <td><input type="text" name="materials" id="material" value="<?php echo $materials; ?>" /></td>
         </tr>

        <tr><td align="right"><label for="formula_desc">Formula Description</label></td>
            <td><input type="text" name="formula_desc" id="formula_desc" value="<?php echo $formula_desc; ?>" readonly/>
           <td><a href="materials_printlist.php?id=<?php echo $id; ?>#editFormula">Edit Parameters</a></td>
         </tr>

        <tr><td><label for="material_description">Material Description</label></td>
            <td><textarea colspan="4" class="form-control" name="material_description"><?php echo $material_description; ?></textarea></td>
         </tr>
        <tr><td><label for="packet">Packet</label></td>
             <td><input type="text" name="packet" id="packet" value="<?php echo $packet; ?>" /></td>
         </tr>
        <tr><td><label for="material">Category</label></td>
            <td colspan="4"><textarea class="form-control" name="material_cat"><?php echo $material_cat; ?></textarea>
            </td>
         </tr>

        <tr><td></td><td> <input type="submit" class="btn btn-info" name="updateRecord" value="Save" /></td>
          <td><input type="hidden" name="id"  value="<?php echo $id; ?>" readonly/></td>
        </tr>
    </table>
    </form>




</div>

  </div>
  <div id="editFormula" class="modalDialog">
  <div>
  <a href="materials_printlist.php" title="Close" class="close">X</a>

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>
   <h2 class="text-center" style="text-deocration:underline;"> Formula Description</h2>
      <form method="post">
        <table>
          <tr><td><h4>Material:</h4></td>
              <td><h4><?php echo $materials; ?></h4></td>
           </tr>
        
          <input type="hidden" name="basic_unit" value="<?php echo $basic_unit; ?>"/>
          <tr><td ><h4>Current Formula Description:</h4></td>
              <td><h4><?php echo $formula_desc; ?></h4></td>
          </tr>
          <tr><td><h4>New Parameter Description:</h4></td></tr>
          <tr>
               <td> <input type="text" name="var1" value="<?php echo $var1; ?>" /></td>
               <td> <input type="text" name="var2" value="<?php echo $var2; ?>" /></td>
               <td> <input type="text" name="var3" value="<?php echo $var3; ?>" /></td>
               <td> <input type="text" name="var4" value="<?php echo $var4; ?>" /> </td> 
          </tr>
          <tr><td><h4>Percentage Increase</h4></td><td>
                   <input type="text" name="var5" value="<?php echo $var5; ?>" />%

              </td>
              <td><input type="submit" class="btn btn-info" name="saveParam" value="Update Parameters" />
          </tr>
      

        </table>
      </form>

  </div>
</div>
  <?php
}else{


  ?>
           <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

				<h4 class="text-center">Warning!</h4>
				   This Form will only display data from the active printlist assumptions.
   		   </div>
      
        <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">PrintList Assumptions</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">District Selection</a></li>
            <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Master Trainers Packet</a></li>
             <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Regional Training Boxes</a></li>
             <li <?php if ($tabActive == 'tab5') echo "class='active'" ?>><a href="#tab5" data-toggle="tab">Teacher Training Boxes</a></li>
             <li <?php if ($tabActive == 'tab6') echo "class='active'" ?>><a href="#tab6" data-toggle="tab">Extra Materials</a></li>
             <li <?php if ($tabActive == 'tab7') echo "class='active'" ?>><a href="#tab7" data-toggle="tab">Print Order</a></li>
             <li <?php if ($tabActive == 'tab8') echo "class='active'" ?>><a href="#tab8" data-toggle="tab">Print Order History</a></li>
          
          </ul>
          <div class="tab-content" style="max-height:650px; overflow:scroll;">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
            	  <p><?php require_once("printlistAssumptionsList.php"); ?></p>
			 </div>

		    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
			   
			</div>
            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
					<p><?php require_once("materials_mt_packet.php"); ?></p>
             </div> 


            <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
				  <p><?php require_once("materials_rtraining_boxes.php"); ?></p>
            </div>

            <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
				  <p><?php require_once("materials_ttraining_boxes.php"); ?></p>
            </div>

            <div class="tab-pane <?php if ($tabActive == 'tab6') echo 'active'; ?>" id="tab6">
            	 <p><?php require_once("materials_extra.php"); ?></p>
            </div>

            <div class="tab-pane <?php if ($tabActive == 'tab7') echo 'active'; ?>" id="tab7">

            	<h2 style="text-align:center">Print Order</h2>
              <p><?php require_once("materials_printlist_order.php"); ?></p>
            </div>

            <div class="tab-pane <?php if ($tabActive == 'tab8') echo 'active'; ?>" id="tab8">


            </div>

            </div>
          </div>
        </div>
		
<?php
}
?>
  


