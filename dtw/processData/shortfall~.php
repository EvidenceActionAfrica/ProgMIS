<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('includes/db_functions.php');
$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];
$tabActive="tab1";

// LOAD PREVIOUS RECORD
$result_display = mysql_query("SELECT * FROM assumptions  ORDER BY id DESC LIMIT 1");
while ($row = mysql_fetch_array($result_display)) {
  $id = $row['id'];
  $dateSaved = $row['dateSaved'];
  $aChildrenTreatedPerAdult = $row['aChildrenTreatedPerAdult'];
  $pChildrenTreatedPerAdult = $row['pChildrenTreatedPerAdult'];
  $aNonEnrolledPerSchool = $row['aNonEnrolledPerSchool'];
  $pNonEnrolledPerSchool = $row['pNonEnrolledPerSchool'];
  $aUnderFivesTreated = $row['aUnderFivesTreated'];
  $pUnderFivesTreated = $row['pUnderFivesTreated'];
  $aPopulationGrowthAnnual = $row['aPopulationGrowthAnnual'];
  $pPopulationGrowthAnnual = $row['pPopulationGrowthAnnual'];
  $aSpoilage = $row['aSpoilage'];
  $pSpoilage = $row['pSpoilage'];
  $aTinSize = $row['aTinSize'];
  $pTinSize = $row['pTinSize'];
  $aAverageChildDose = $row['aAverageChildDose'];
  $pAverageChildDose = $row['pAverageChildDose'];
  $aAdultDose = $row['aAdultDose'];
  $pAdultDose = $row['pAdultDose'];
  $aMaxDrugShortagePermittedKids = $row['aMaxDrugShortagePermittedKids'];
  $pMaxDrugShortagePermittedKids = $row['pMaxDrugShortagePermittedKids'];
  $aExtraSchoolsPerDistrict = $row['aExtraSchoolsPerDistrict'];
  $pExtraSchoolsPerDistrict = $row['pExtraSchoolsPerDistrict'];
  $aAssumedSchoolSize = $row['aAssumedSchoolSize'];
  $pAssumedSchoolSize = $row['pAssumedSchoolSize'];
  $aMaxDrugShortagePermittedDrugs = $row['aMaxDrugShortagePermittedDrugs'];
  $pMaxDrugShortagePermittedDrugs = $row['pMaxDrugShortagePermittedDrugs'];
  $aAverageDrugNeed = $row['aAverageDrugNeed'];
  $pAverageDrugNeed = $row['pAverageDrugNeed'];
  $aAverageTinsNeededPerSchools = $row['aAverageTinsNeededPerSchools'];
  $pAverageTinsNeededPerSchools = $row['pAverageTinsNeededPerSchools'];
  $aCalcDrugsPerSchool = $row['aCalcDrugsPerSchool'];
  $pCalcDrugsPerSchool = $row['pCalcDrugsPerSchool'];
  $aTreatYear = $row['aTreatYear'];
  $pTreatYear = $row['pTreatYear'];
  $areaAssumptions = $row['areaAssumptions'];
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_tab_pickup= $row['priv_tab_pickup'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
      <?php
      require_once ("includes/meta-link-script.php");
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
		<!--tab skeleton-->
          <div class="tabbable" >
                  <ul class="nav nav-tabs">
                    <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Get KEMSA</a></li>
                    <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">Get from Another District</a></li>
                    <li class="<?php if ($tabActive == 'tab3') echo 'active'; ?>"><a href="#tab3" data-toggle="tab">Get from District Store</a></li>
					
					 <li>
					<!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
               
              </form>
			  </a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                       <!--============ get kemsa ==========================-->
       
          <!--<div align="right"><a id="close1" href="#" title="Click This Button">Close</a></div>-->
          <h1 style="text-align: center; margin-top: 0px; font-size: 20px; ">Get KEMSA </h1>

          <?php
          //Delete
          if (isset($_GET['deleteid_kemsa'])) {
		  $tabActive="tab1";
            $deleteid = $_GET['deleteid'];
            $query = "DELETE FROM shortfall_kemsa WHERE id='$deleteid'";
            $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          }
          ?>
          <table width="100%" >
		  
            <tr>
			 
				    <thead>
              <td id="addKemsa" style="border-right: 1px solid grey" style="width: 45%">
                <!--====  ADD kemsa ======-->
                
                  <?php
                  if (isset($_POST['submitAdd'])) {
				  $tabActive="tab1";
                    $dateSaved = date('Y-m-d');
                    $district = $_POST['district'];
                    $albendazoleNeeded = $_POST['albendazoleNeeded'];
                    $praziquantelNeeded = $_POST['praziquantelNeeded'];

                    $query = ( "INSERT INTO shortfall_kemsa (dateSaved,district,albendazoleNeeded,praziquantelNeeded) VALUES (
                                      '$dateSaved',
                                      '$district',
                                      '$albendazoleNeeded',
                                      '$praziquantelNeeded')" );
                    mysql_query($query) or die(mysql_error("Could not enter"));
                    echo " <div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                           <table align='center'>
                             <tr>
                               <td><img src='../images/icons/success.png' height='50px'/></td>
                               <td><b style='font-size: 15px;'>KEMSA shortfall saved</b></td>
                             </tr>
                           </table>
                         </div><br/> ";
                  }
                  ?>
                  <form action="" method="post">
                    <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Add shortfall</h1>
                    
                  
                        
                          <table border="0" style="padding: 5px;">
                         <thead>  
                            <tr>
                              <td>Date  </td>
                              <td><input type="text" class="input_textbox" value="<?php echo date('d-m-Y'); ?>" readonly style="width: 100px"/></td>
                            </tr>
                            <tr>
                              <td>District Name *  </td>
                              <td>
                                <select name="district"  class="input_select" style="width: 250px">
                                  <option value=''></option>
                                  <?php
                                  $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                                  $result = mysql_query($sql);
                                  while ($rows = mysql_fetch_array($result)) { //loop table rows
                                    ?>
                                    <option value="<?php echo $rows['district_name']; ?>" ><?php echo $rows['district_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>Albendazole drugs needed </td>
                              <td><input type="text" name="albendazoleNeeded" id="albendazoleNeeded" class="input_textbox"onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="albendazoleNeededSpan"/></td>
                            </tr>
                            <tr>
                              <td>Praziquantel drugs needed </td>
                              <td><input type="text" name="praziquantelNeeded" id="praziquantelNeeded" class="input_textbox" onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="praziquantelNeededSpan"/></td>
                            </tr>

                          </thead>
                          </table>
                       
                      
                              <?php if($priv_tab_pickup>=2){ ?>
                        <input type="submit" class="btn-custom" name="submitAdd"  value="Save"/>
                              <?php } ?>
                  </form>
                 
              </td>
			 
              <td style="margin-left: 10%;width: 100%;">
                
                  <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous requests</h1>
                  
                    <form method="post" style=" margin-right: 20px">
                      <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="center" width="10%">ID</th>
                            <th align="Left" width="20%">Date<br/>Requested</th>
                            <th align="Left" width="20%">District</th>
                            <th align="Left" width="20%">Albendazole</th>
                            <th align="Left" width="20%">Praziquantel</th>
      <?php if($priv_tab_pickup>=4){ ?>
                            <!--<th align="center" width="40px">View</th>-->
                            <th align="center" width="10%">Del</th>
      <?php } ?>
                          </tr>
                        </thead>
                      </table>
                    </form>
             

               
                    <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left" width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <tbody>

                        <?php
                        $result_set = mysql_query("SELECT * FROM shortfall_kemsa  ORDER BY id DESC");
                        while ($row = mysql_fetch_array($result_set)) {
                          $id = $row['id'];
                          $district = $row['district'];
                          $dateSaved = $row['dateSaved'];
                          $albendazoleNeeded = $row['albendazoleNeeded'];
                          $praziquantelNeeded = $row['praziquantelNeeded'];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">

                            <td align="center" width="10%"> <?php echo $id; ?>  </td>
                            <td align="left" width="20%"> <?php echo $dateSaved; ?>  </td>
                            <td align="left" width="20%"> <?php echo $district; ?>  </td>
                            <td align="center" width="20%"> <?php echo $albendazoleNeeded; ?>  </td>
                            <td align="center" width="20%"> <?php echo $praziquantelNeeded; ?>  </td>
      <?php if($priv_tab_pickup>=4){ ?>
                               <!--<td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecord('load',<?php echo $id; ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                            <td align="center" width="10%"><a href="javascript:void(0)" onclick='show_confirm_kemsa(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
      <?php } ?>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                  
              </td>
                </thead>
            </tr>
          </table>


       

                    </div>
                    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                    
					
					 <h1 style="text-align: center; margin-top: 0px; font-size: 20px; ">Get from nearby District </h1>
          <?php
          //Delete
          if (isset($_GET['deleteid_nearby'])) {
            $deleteid = $_GET['deleteid'];
            $query = "DELETE FROM shortfall_nearby_district WHERE id='$deleteid'";
            $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
			$tabActive="tab2";
          }
          ?>
          <table width="100%" >
            <thead>
            <tr>
              <td id="addKemsa" style="border-right: 1px solid grey;width: 45%">
                <!--====  ADD nearby ======-->
                
                  <?php
                  if (isset($_POST['submitAdd_nearby'])) {
				  $tabActive="tab2";
                    $dateSaved = date('Y-m-d');
                    $district_from = $_POST['district_from'];
                    $district_to = $_POST['district_to'];
                    $albendazoleNeeded = $_POST['albendazoleNeeded'];
                    $praziquantelNeeded = $_POST['praziquantelNeeded'];

                    $query = ( "INSERT INTO shortfall_nearby_district (dateSaved,district_from,district_to,albendazoleNeeded,praziquantelNeeded) VALUES (
                                      '$dateSaved',
                                      '$district_from',
                                      '$district_to',
                                      '$albendazoleNeeded',
                                      '$praziquantelNeeded')" );
                    mysql_query($query) or die(mysql_error("Could not enter"));
                    echo " <div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                           <table align='center'>
                             <tr>
                               <td><img src='../images/icons/success.png' height='50px'/></td>
                               <td><b style='font-size: 15px;'>Saved</b></td>
                             </tr>
                           </table>
                         </div><br/> ";
                  }
                  ?>
                  <form action="" method="post">
                    <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Add shortfall</h1>
                    
                          <table style="padding: 5px;" border="0">
                                 <thead>
                            <tr>
                              <td>Date  </td>
                              <td><input type="text" class="input_textbox" value="<?php echo date('d-m-Y'); ?>" readonly style="width: 100px"/></td>
                            </tr>
                            <tr>
                              <td>District From *  </td>
                              <td>
                                <select name="district_from"  class="input_select" style="width: 250px">
                                  <option value=''></option>
                                  <?php
                                  $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                                  $result = mysql_query($sql);
                                  while ($rows = mysql_fetch_array($result)) { //loop table rows
                                    ?>
                                    <option value="<?php echo $rows['district_name']; ?>" ><?php echo $rows['district_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>District To *  </td>
                              <td>
                                <select name="district_to"  class="input_select" style="width: 250px">
                                  <option value=''></option>
                                  <?php
                                  $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                                  $result = mysql_query($sql);
                                  while ($rows = mysql_fetch_array($result)) { //loop table rows
                                    ?>
                                    <option value="<?php echo $rows['district_name']; ?>" ><?php echo $rows['district_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>Albendazole drugs needed </td>
                              <td><input type="text" name="albendazoleNeeded" id="albendazoleNeeded1" class="input_textbox"onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="albendazoleNeeded1Span"/></td>
                            </tr>
                            <tr>
                              <td>Praziquantel drugs needed </td>
                              <td><input type="text" name="praziquantelNeeded" id="praziquantelNeeded1" class="input_textbox" onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="praziquantelNeeded1Span"/></td>
                            </tr>
                                 </thead>
                          </table>
                             <?php if($priv_tab_pickup>=2){ ?>
                        <input type="submit" class="btn-custom" name="submitAdd_nearby"  value="Save"/>
                             <?php } ?>
                  </form>
                 
              </td>
              <td style="width: 100%;margin-left: 10%">
                
                  <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous transfers</h1>

               
                    <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <tbody>
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="center" width="5%">ID</th>
                            <th align="Left" width="15%">Date<br/>Requested</th>
                            <th align="Left" width="15%">District<br/>From</th>
                            <th align="Left" width="10%">District<br/>To</th>
                            <th align="center" width="5%">ALB</th>
                            <th align="center" width="5%">PZQ</th>
      <?php if($priv_tab_pickup>=4){ ?>
                            <!--<th align="center" width="40px">View</th>-->
                            <th align="center" width="5%">Del</th>
      <?php } ?>
                          </tr>
                        </thead>
                        <?php
                        $result_set = mysql_query("SELECT * FROM shortfall_nearby_district ORDER BY id DESC");
                        while ($row = mysql_fetch_array($result_set)) {
                          $id = $row['id'];
                          $district_from = $row['district_from'];
                          $district_to = $row['district_to'];
                          $dateSaved = $row['dateSaved'];
                          $albendazoleNeeded = $row['albendazoleNeeded'];
                          $praziquantelNeeded = $row['praziquantelNeeded'];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">

                            <td align="center" width="5%"> <?php echo $id; ?>  </td>
                            <td align="left" width="15%"> <?php echo $dateSaved; ?>  </td>
                            <td align="left" width="15%"> <?php echo $district_from; ?>  </td>
                            <td align="left" width="15%"> <?php echo $district_to; ?>  </td>
                            <td align="center" width="5%"> <?php echo $albendazoleNeeded; ?>  </td>
                            <td align="center" width="5%"> <?php echo $praziquantelNeeded; ?>  </td>
      <?php if($priv_tab_pickup>=4){ ?>
                               <!--<td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecord('load',<?php echo $id; ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                            <td align="center" width="5%"><a href="javascript:void(0)" onclick='show_confirm_nearby(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
      <?php } ?>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                 
              </td>

            </tr>
          </thead>
          </table>
                    </div>
                    <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                     	
			      <!--<div align="right"><a id="close1" href="#" title="Click This Button">Close</a></div>-->
          <h1 style="text-align: center; margin-top: 0px; font-size: 20px; ">Get from District Store </h1>

          <?php
          //Delete
          if (isset($_GET['deleteid_store'])) {
            $deleteid = $_GET['deleteid'];
            $query = "DELETE FROM shortfall_store WHERE id='$deleteid'";
            $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
			$tabActive = 'tab3';
          }
          ?>
          <table width="100%" >
		    <thead>
            <tr>
              <td style="width: 45%;border-right: 1px solid grey">
                <!--====  ADD store ======-->
               
                  <?php
                  if (isset($_POST['submitAdd_store'])) {
				  $tabActive ='tab3';
                    $dateSaved = date('Y-m-d');
                    $district = $_POST['district'];
                    $hospital = $_POST['hospital'];
                    $albendazoleNeeded = $_POST['albendazoleNeeded'];
                    $praziquantelNeeded = $_POST['praziquantelNeeded'];

                    $query = ( "INSERT INTO shortfall_store (dateSaved,district,hospital,albendazoleNeeded,praziquantelNeeded) VALUES (
                                      '$dateSaved',
                                      '$district',
                                      '$hospital',
                                      '$albendazoleNeeded',
                                      '$praziquantelNeeded')" );
                    mysql_query($query) or die(mysql_error("Could not enter"));
                    echo " <div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                           <table align='center'>
                             <tr>
                               <td><img src='../images/icons/success.png' height='50px'/></td>
                               <td><b style='font-size: 15px;'>Shortfall saved</b></td>
                             </tr>
                               </thead>
                           </table>
                         </div><br/> ";
                  }
                  ?>
                  <form style="padding: 5px;"action="" method="post">
                    <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Add shortfall</h1>
                    
                      
                          <table border="0">
                              <thead>
                            <tr>
                              <td>Date  </td>
                              <td><input type="text" class="input_textbox" value="<?php echo date('d-m-Y'); ?>" readonly style="width: 100px"/></td>
                            </tr>
                            <tr>
                              <td>District Name *  </td>
                              <td>
                                <select name="district"  class="input_select" style="width: 250px">
                                  <option value=''></option>
                                  <?php
                                  $sql = "SELECT * FROM districts ORDER BY district_name ASC";
                                  $result = mysql_query($sql);
                                  while ($rows = mysql_fetch_array($result)) { //loop table rows
                                    ?>
                                    <option value="<?php echo $rows['district_name']; ?>" ><?php echo $rows['district_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>Hospital</td>
                              <td><input type="text" name="hospital" id="hospital" class="input_textbox"onkeyup="isBlank(this.id);" style="width: 250px"/><span id="hospitalSpan"/></td>
                            </tr>
                            <tr>
                              <td>Albendazole drugs needed </td>
                              <td><input type="text" name="albendazoleNeeded" id="albendazoleNeeded2" class="input_textbox"onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="albendazoleNeeded2Span"/></td>
                            </tr>
                            <tr>
                              <td>Praziquantel drugs needed </td>
                              <td><input type="text" name="praziquantelNeeded" id="praziquantelNeeded2" class="input_textbox" onkeyup="isNumeric(this.id);" style="width: 50px"/><span id="praziquantelNeeded2Span"/></td>
                            </tr>
                              </thead>
                          </table>
                           <?php if($priv_tab_pickup>=2){ ?>
                        <input type="submit" class="btn-custom" name="submitAdd_store"  value="Save"/>
                           <?php } ?>
                  </form>
                 
              </td>
              <td style="margin-left: 10%;width: 100%;">
               
                  <h1 style="text-align: center; margin-top: 0px; font-size: 20px">Previous requests</h1>
                 
                    <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left" width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <tbody>
                        <thead>
                          <tr style="border: 1px solid #B4B5B0;">
                            <th align="center" width="5%">ID</th>
                            <th align="Left" width="10%">Date<br/>Requested</th>
                            <th align="Left" width="15%">District</th>
                            <th align="Left" width="15%">Hospital</th>
                            <th align="center" width="5%">ALB</th>
                            <th align="center" width="5%">PZQ</th>
      <?php if($priv_tab_pickup>=4){ ?>
                            <!--<th align="center" width="40px">View</th>-->
                            <th align="center" width="5%">Del</th>
      <?php }?>
                          </tr>
                        </thead>
                        <?php
                        $result_set = mysql_query("SELECT * FROM shortfall_store ORDER BY id DESC");
                        while ($row = mysql_fetch_array($result_set)) {
                          $id = $row['id'];
                          $district = $row['district'];
                          $hospital = $row['hospital'];
                          $dateSaved = $row['dateSaved'];
                          $albendazoleNeeded = $row['albendazoleNeeded'];
                          $praziquantelNeeded = $row['praziquantelNeeded'];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">
                            <td align="center" width="5%"> <?php echo $id; ?>  </td>
                            <td align="left" width="15%"> <?php echo $dateSaved; ?>  </td>
                            <td align="left" width="15%"> <?php echo $district; ?>  </td>
                            <td align="left" width="15%"> <?php echo $hospital; ?>  </td>
                            <td align="center" width="5%"> <?php echo $albendazoleNeeded; ?>  </td>
                            <td align="center" width="5%"> <?php echo $praziquantelNeeded; ?>  </td>
  <?php if($priv_tab_pickup>=4){ ?>
                               <!--<td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecord('load',<?php echo $id; ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>-->
                            <td align="center" width="10%"><a href="javascript:void(0)" onclick='show_confirm_kemsa(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
  <?php } ?>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                  
              </td>

            </tr>
          </table>       
			
			
                    </div>
                  </div>
                </div>  
         
       
        </div>
      </div>
    </div>
  <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->

        <!--Delete dialog-->
        <script>
          function show_confirm_kemsa(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid_kemsa=' + deleteid);
            } else {
              return false;
            }
          }
          function show_confirm_other_district(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid_other_district=' + deleteid);
            } else {
              return false;
            }
          }
          function show_confirm_store(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid_store=' + deleteid);
            } else {
              return false;
            }
          }


          //show previous records
          function loadRecord(req, val) {
            if (req == "") {
              document.getElementById("divShowContent").innerHTML = "";
              return;
            }
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("divDisplayAssumption").innerHTML = xmlhttp.responseText;
              }
            }
            xmlhttp.open("GET", "ajax_files/assumptions.php?req=" + req + "&val=" + val, true);
            xmlhttp.send();
          }
        </script>
        </body>
        </html>

<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
  $(function() {
    $('input#id_search').quicksearch('table tbody tr');
  });
</script>
<script >
   document.onkeypress = function(e)  {
    e = e || window.event;
    if (typeof e != 'undefined') {
      var tgt = e.target || e.srcElement;
      if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
        return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
    }
  }
console.log("enter Block workin...");
</script>

