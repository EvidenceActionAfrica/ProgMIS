<?php

//The Materials Module need this because the number of queries performed are many, which may need more time to process
//than assigned by default in the server's config
ini_set('max_execution_time', 300); 
/*
*********************************
*      REQUIREMENTS             *
*********************************
*
*1.This file is required for setting up the default settings of the entire materials_module
*2. The Settings needed are for the following:
* - Officials.
* - Materials.
* -Printlist Structure(How The data Will displayed as well as which data to display)
* -Packet And Training Boxes Definitions.
* *******************************
*      SOLUTION                 *
*                               *
*********************************
*
*1. The First Tab (official assumptions)
*  - The admin module normally produces the no of officials who will participate in the distribution and use of the materials but
*    some officials are not accessible and hence this portion was created. There are two buttons on top of the officials tab
*    [set all from admin]- This one automatically sets all the sub-counties to have materials sent the no of officials collected in the admin module
*    [set default for all]-This one opens a module that lets you set the default number of officials for all sub-counties to have materials set
*    There are also such buttons for each record as icons
*2. The Second Tab(Printlist Assumptions)
* -This one displays all the materials to be used throughout
* - 
*
*3. The Third (Printlist Structure)
*-This controls how you wish to view and use the data.
*-It is here that you can choose whether to include or exclude packages/training boxes.
*
*4. Packet/Training Box definitions
*This is where you can add/edit/delete a packet/training box categories.
*
*5. Materials & Assumptions
*
*
*
*/
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("class.mathMaterials.php");
require_once("../includes/logTracker.php");
$tabActive = "tab2";
$M_module =2;

if(isset($_GET['tabActive'])){
  $tabActive='tab'.$_GET['tabActive'];
}

//Printlist Structure Crud
if(isset($_GET['editCategory'])){
  $tabActive = "tab3";
}
if(isset($_POST['submitCategory'])){
  $tabActive='tab4';
}
if(isset($_GET['deleteCategory'])){

$catId=isset($_GET['deleteCategory'])?$_GET['deleteCategory']:0;
$sql1='SELECT * from materials_cat_organizer WHERE id='.$catId;
$result=mysqli_query($db_mysqli_connection,$sql1);

$sql='DELETE from materials_cat_organizer WHERE id='.$catId;

mysqli_query($db_mysqli_connection,$sql);

$tabActive = "tab3";
$action=" Deleting a Category";
$description="Unknown";
while($row=mysqli_fetch_assoc($result)){
  $description='A Category called '.$row['category'].' was deleted';
}
mysqli_free_result($result);
$ArrayData = array($M_module, $action, $description);
quickFuncLog($ArrayData);
}

//Create A Category

if(isset($_POST['printCat'])){

  $category=isset($_POST['category'])?$_POST['category']:'undefined';
  $tab=isset($_POST['tab'])?intval($_POST['tab']):0;
  $printlist=isset($_POST['printlist'])?intval($_POST['printlist']):0;
  $sql='SELECT * from materials_cat_organizer WHERE category="'.$category.'"';
  $result=mysqli_query($db_mysqli_connection,$sql);
  $numRow=mysqli_affected_rows($db_mysqli_connection);
  mysqli_free_result($result);
   $action=' Adding A Category';
    if($numRow<=0){
        $sql='INSERT INTO `materials_cat_organizer`(`category`, `tab_appearance`, `printlist_appearance`)';
        $sql.=" VALUES ('$category','$tab','$printlist')";
        mysqli_query($db_mysqli_connection,$sql);
        $description="Category ".$_POST['category']." Added.";
    }else{
      $updateResult='Sorry! The Category Already Exists.';
      $description="Category ".$_POST['category']." Not Added.";

    }

  $tabActive = "tab3";

  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);

}

//Update A Category

if(isset($_POST['UpdateCat'])){
  $action="Updating a category";
  $category=isset($_POST['category'])?$_POST['category']:'undefined';
  $tab=isset($_POST['tab'])?intval($_POST['tab']):0;
  $printlist=isset($_POST['printlist'])?intval($_POST['printlist']):0;
  $catId=isset($_POST['id'])?intval($_POST['id']):0;
  $sql='SELECT * from materials_cat_organizer WHERE category="'.$category.'" AND id !='.$catId;
   $result=mysqli_query($db_mysqli_connection,$sql);
  $numRow=mysqli_affected_rows($db_mysqli_connection);
  mysqli_free_result($result);
  if($numRow<=0){
    $sql='UPDATE materials_cat_organizer set category="'.$category.'",tab_appearance='.$tab.',printlist_appearance='.$printlist;
    $sql.=' WHERE id='.$catId;
    mysqli_query($db_mysqli_connection,$sql);
      $description="Category ".$_POST['category']." Updated.";
  }else{
    $updateResult='Sorry! The Category Already Exists.';
    $description="Category ".$_POST['category']." Not Added.";
  }
  $tabActive = "tab2";


  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
}

//End of Printlist Structure Crud

//4

if($_GET['deleteCategoryDef']){

    $tabActive = "tab4";
    $catId=intval($_GET['deleteCategoryDef']);
    $table=mysqli_real_escape_string($db_mysqli_connection,$_GET['table']);

    $sql='DELETE from '.$table.' WHERE id='.$catId;

    mysqli_query($db_mysqli_connection,$sql);
    if($table=="packet_category"){
       $updateResult='Packet Deleted';
       $action="Deleting a Packet";
      $description="Packet Deleted";
  }else{
     $updateResult='Category Deleted';
    $action="Deleting a category";
    $description="Category Deleted";
  }
   
    
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}
//


//5. CRUD
//Deleting a material
if(isset($_GET['deleteMaterialId'])){
  $materialId=intval($_GET['deleteMaterialId']);
    $sql='SELECT * from materials_desc WHERE id ='.$materialId;
    $result=mysqli_query($db_mysqli_connection,$sql);

    while($row=mysqli_fetch_assoc($result)){
    $description="Deleting a material called ".$row['materials'];
    }
    $action=" Deleting a Material";
    mysqli_free_result($result);

    $materialId=intval($_GET['deleteMaterialId']);
    $sql='DELETE from materials_desc WHERE id='.$materialId;
    mysqli_query($db_mysqli_connection,$sql);
    $tabActive = "tab2";
    $materialResult='Material Deleted From Assumptions';
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}

//Material Creation

if(isset($_POST['createMaterial'])){
$tabActive = "tab5";
}
if(isset($_GET['edit_material'])){
$tabActive = "tab6";
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysqli_query($db_mysqli_connection,"SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysqli_fetch_assoc($resPriv)) {
    $priv_materials_assumptions = $row['priv_materials_assumptions'];
}
mysqli_free_result($resPriv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
        <?php require_once ("includes/meta-link-script.php"); ?>
        <script src="../js/tabs.js"></script>
        <link href="css/materials.css" rel="stylesheet" type="text/css"/>
 
    </head>


    <body>
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
                require_once ("includes/menuLeftBar-Materials.php");
                ?>
            </div>
            <div class="contentBody" >

                <div class="tabbable" >
                    <ul class="nav nav-tabs">

                        <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Officials Assumptions</a></li>
                        <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Training Box/Packet Definition</a></li>
                        <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">Printlist Structure</a></li>
                        <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Printlist Assumptions</a></li>
                    
                    </ul>
                    <div class="tab-content" >

                        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                            <p><?php require_once 'materials_officials_Assumptions.php'; ?></p>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                            <p><?php require_once 'printlistAssumptionsList.php'; ?></p>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                            <p><?php require_once 'materials_cat_organizer.php'; ?></p>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                            <p><?php require 'materials_tbox_categories.php'; ?></p>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
                            <p><?php require_once 'materials_create.php'; ?></p>
                        </div>
                        <div class="tab-pane <?php if ($tabActive == 'tab6') echo 'active'; ?>" id="tab6">
                            <p><?php require_once 'materials_edit.php'; ?></p>
                        </div>





                    </div>
                </div>
            </div>
    </body>
</html>
<?php
if (isset($_GET["Identity"])) {
    $id =intval($_GET["Identity"]);
    
    if(isset($_POST["updateOfficials"])){

       $county = isset($_POST["county"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["county"]):"";
        $district = $_POST["district"];
        $district_health_contacts = isset($_POST["district_health_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["district_health_contacts"]):0;
        $district_education_contacts =isset($_POST["district_education_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["district_education_contacts"]):0;
        $division_health_contacts = isset($_POST["division_health_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["division_health_contacts"]):0;
        $division_education_contacts =isset($_POST["division_education_contacts"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["division_education_contacts"]):0;
        $master_trainers = isset($_POST["master_trainers"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["master_trainers"]):0;
        $id=isset($_POST["id"])?mysqli_real_escape_string($db_mysqli_connection,$_POST["id"]):$_GET["Identity"];
        $sql="UPDATE `materials_officials_assumptions` SET `district_health_contacts`='$district_health_contacts',`division_health_contacts`='$division_health_contacts',";
        $sql.="`division_education_contacts`='$division_education_contacts',`district_education_contacts`='$district_education_contacts',`master_trainers`='$master_trainers' WHERE `id`='$id'";
       // $updateResult= $sql;
        mysqli_query($db_mysqli_connection,$sql);
        $updateResult="Assumptions Updated";
        $action="Updated the Officials from a sub-county ".$district;
        $ArrayData = array($M_module, $action, $updateResult);
        quickFuncLog($ArrayData);
    }
    
    
    
    
    
    $sql = "SELECT * from materials_officials_assumptions WHERE id=" . $id;
    $resultU = mysqli_query($sql);
    while ($row = mysqli_fetch_assoc($resultU)) {
        $county = $row["county"];
        $district = $row["district_name"];
        $district_health_contacts = $row["district_health_contacts"];
        $district_education_contacts = $row["district_education_contacts"];
        $division_health_contacts = $row["division_health_contacts"];
        $division_education_contacts = $row["division_education_contacts"];
        $master_trainers = $row["master_trainers"];
    }
    mysqli_free_result($resultU);


    ?>
    <div id="openModal" class="modalDialog">
        <div  style="width:350px" >
            <a href="materials_general_assumptions.php" title="Close" class="close">X</a>
            <!-- ================= -->
            <?php 
              if(isset($_POST["updateOfficials"])){
                echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>Assumptions Updated</h3>";
               }
            ?>
            <h2 style="margin-left:35%;">Edit Details</h2>
            <form class="form" method="post"  >
                <table>
                    <tr><td>County</td><td><input type="text" name="county" value="<?php echo $county; ?>" readonly/></td></tr>
                    <tr><td>Sub-County</td><td><input type="text" name="district" value="<?php echo $district; ?>" readonly/></td></tr>
                    <tr><td>Sub-County Health Contacts</td><td><input class="num-only" type="text" name="district_health_contacts" value="<?php echo $district_health_contacts; ?>" /></td></tr>
                    <tr><td>Division Health Contacts</td><td><input class="num-only" type="text" name="division_health_contacts" value="<?php echo $division_health_contacts; ?>" /></td></tr>
                 <tr><td>Sub-County Education Contacts</td><td><input class="num-only" type="text" name="district_education_contacts" value="<?php echo $district_education_contacts; ?>" /></td></tr>
                <tr><td>Division Education Contacts</td><td><input class="num-only" type="text" name="division_education_contacts" value="<?php echo $division_education_contacts; ?>" /></td></tr>
                
                 <tr><td>Master Trainers</td><td><input class="num-only" type="text" name="master_trainers" value="<?php echo $master_trainers; ?>" /></td></tr>
                    <tr rowspan="2"></tr>
                    <tr><td></td><td> <input type="submit" class="btn-custom" name="updateOfficials" value="Save" /></td>
                        <td><input type="hidden" name="id"  value="<?php echo $id; ?>" readonly/></td>
                    </tr>
                </table>
            </form>


        </div>

        </div>
    <div id="openDefaults" class="modalDialog">
        <div  style="width:350px" >
            <a href="materials_general_assumptions.php" title="Close" class="close">X</a>
            <!-- ================= -->
            <?php 
            if(isset($_POST["setOfficials"])){
             echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;text-align:center;'>Assumptions Updated</h3>"; 
            }
            ?>
            <h2 style="margin-left:35%;">Set Default Values</h2>
            <form class="form" method="post" style="">
                <table>
                  <tr><td>Sub-County Health Contacts</td><td><input class="num-only" type="text" name="district_health_contacts" value="" /></td></tr>
                  <tr><td>Division Health Contacts</td><td><input class="num-only" type="text" name="division_health_contacts" value="" /></td></tr>
                  <tr><td>Sub-County Education Contacts</td><td><input class="num-only" type="text" name="district_education_contacts" value="" /></td></tr>
                  <tr><td>Division Education Contacts</td><td><input class="num-only" type="text" name="division_education_contacts" value="" /></td></tr>
                  <tr><td>Master Trainers</td><td><input class="num-only" type="text" name="master_trainers" value="" /></td></tr>
                  <tr rowspan="2"></tr>
                  <tr><td></td><td> <input type="submit" class="btn-custom" name="setOfficials" value="Save" /></td></tr>
                </table>
            </form>


        </div>

        </div>

    <?php
}

?>
<script type="text/javascript">
        $(document).find("input.num-only").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        console.log("Workin..");
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        console.log("Workin.. for letters");
                        e.preventDefault();
                    }
                });
        $(document).ready(function() {
           
            
            $('.data-table').dataTable();
        
        });
</script>
<?php
mysqli_close($db_mysqli_connection);
?>