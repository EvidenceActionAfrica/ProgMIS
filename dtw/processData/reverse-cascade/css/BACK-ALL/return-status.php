<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
include "reverseCascade.func.php";

//instansiate class
$reverseCascade = new reverseCascade;

// get districts
$districts = $reverseCascade->getDistricts();

// get all return status data
$data= $reverseCascade->getAllReturnStatus();

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$reverseCascade->get_return_status_byId($id);
}

// update
if (isset($_POST['updateReturnStatus'])) {
  $id=$_POST['id'];
  $district_name = $_POST['district_name'];
  $wave = $_POST['wave'];
  $regional_training_end = $_POST['regional_training_end'];
  $tts_end_mt = $_POST['tts_end_mt'];
  $district_deworming_day = $_POST['district_deworming_day'];
  // die();

   //handle the check
          if (isset($_POST['rt_moe_recieved'])) {
            $rt_moe_recieved = 'Y';
            
          }else{
            $rt_moe_recieved = 'N';
          }

          if (isset($_POST['rt_mophs_recieved'])) {
            $rt_mophs_recieved = 'Y';
            
          }else{
            $rt_mophs_recieved = 'N';
          }

          if (isset($_POST['dd_moe_recieved'])) {
            $dd_moe_recieved = 'Y';
            
          }else{
            $dd_moe_recieved = 'N';
          }

          if (isset($_POST['dd_mophs_recieved'])) {
            $dd_mophs_recieved = 'Y';
            
          }else{
            $dd_mophs_recieved = 'N';
          }

          if (isset($_POST['tts_moe_recieved'])) {
            $tts_moe_recieved = 'Y';
            
          }else{
            $tts_moe_recieved = 'N';
          }

          if (isset($_POST['tts_mophs_recieved'])) {
            $tts_mophs_recieved = 'Y';
            
          }else{
            $tts_mophs_recieved = 'N';
          }


  $reverseCascade->update_return_status(
                          $id,
                          $district_name,
                          $wave,
                          $regional_training_end,
                          $rt_moe_recieved,
                          $rt_mophs_recieved,
                          $tts_end_mt,
                          $tts_moe_recieved,
                          $tts_mophs_recieved,
                          $district_deworming_day,
                          $dd_moe_recieved
                    );

  header("Location:return-status.php");

}


if (isset($_POST['return_form'])) {

          $district_name = $_POST['district_name'];
          $wave = $_POST['wave'];
          $regional_training_end = $_POST['regional_training_end'];
          $tts_end_mt = $_POST['tts_end_mt'];
          $district_deworming_day = $_POST['district_deworming_day'];
          

          //handle the check
          if (isset($_POST['rt_moe_recieved'])) {
            $rt_moe_recieved = 'Y';
            
          }else{
            $rt_moe_recieved = 'N';
          }

          if (isset($_POST['rt_mophs_recieved'])) {
            $rt_mophs_recieved = 'Y';
            
          }else{
            $rt_mophs_recieved = 'N';
          }

          if (isset($_POST['dd_moe_recieved'])) {
            $dd_moe_recieved = 'Y';
            
          }else{
            $dd_moe_recieved = 'N';
          }

          if (isset($_POST['dd_mophs_recieved'])) {
            $dd_mophs_recieved = 'Y';
            
          }else{
            $dd_mophs_recieved = 'N';
          }

          if (isset($_POST['tts_moe_recieved'])) {
            $tts_moe_recieved = 'Y';
            
          }else{
            $tts_moe_recieved = 'N';
          }

          if (isset($_POST['tts_mophs_recieved'])) {
            $tts_mophs_recieved = 'Y';
            
          }else{
            $tts_mophs_recieved = 'N';
          }


          //insert the form data
          $reverseCascade->createReturnStatus(
                $district_name,
                $wave,
                $regional_training_end,
                $rt_moe_recieved,
                $rt_mophs_recieved,
                $tts_end_mt,
                $tts_moe_recieved,
                $tts_mophs_recieved,
                $district_deworming_day,
                $dd_moe_recieved,
                $dd_mophs_recieved
          );

          //refresh the page
          header("Location:return-status.php");
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Reverse.php"); ?>
      </div>
      <div class="contentBody">
        <h1>RETURN STATUS</h1>
        <form action="#">
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a> -->
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form>

        <table id='hor-minimalist-b'>
          <thead>
            <tr>
              <th rowspan="3">District Name</th>
            </tr>
            
            <th>Wave</th>
            <th>Regional Training End</th>
            <th colspan="2">RT Returns Received</th>
            <th>TTS End MT</th>
            <th colspan="2">TTS Returns Received</th>
            <th>District Deworming Day</th>
            <th colspan="2">DD Returns Received </th>
            <th>Edit</th>
          </thead>
          <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>MOE</td>
            <td>MoPHS</td>
            <td></td>
            <td>MOE</td>
            <td>MoPHS</td>
            <td></td>
            <td>MOE</td>
            <td>MoPHS</td>
          </tr>

          <?php 
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              # code...
              ?>
                  <tr>
                    <td id='district_name-td'><?php echo $value['district_name'] ?></td>
                    <td id='wave-td'><?php echo $value['wave'] ?></td>
                    <td id='regional_training_end-td'><?php echo $value['regional_training_end'] ?></td>
                    <td id='rt_moe_recieved-td'><?php echo $value['rt_moe_recieved'] ?></td>
                    <td id='rt_mophs_recieved-td'><?php echo $value['rt_mophs_recieved'] ?></td>
                    <td id='tts_end_mt-td'><?php echo $value['tts_end_mt'] ?></td>
                    <td id='tts_moe_recieved-td'><?php echo $value['tts_moe_recieved'] ?></td>
                    <td id='tts_mophs_recieved-td'><?php echo $value['tts_mophs_recieved'] ?></td>
                    <td id='district_deworming_day-td'><?php echo $value['district_deworming_day'] ?></td>
                    <td id='dd_moe_recieved-td'><?php echo $value['dd_moe_recieved'] ?></td>
                    <td id='dd_mophs_recieved-td'><?php echo $value['dd_mophs_recieved'] ?></td>
                    <form method="POST" action="#editCounty">
                      <input type="hidden" name="id" value="<?php echo $value['id'] ?>"/>
                      <td class="sharing-column4"><input type="submit" name="editDetails" value="" style="background: url(../../images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                      <!-- <td class="sharing-column4"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $value['id']; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td> -->
                    </form>
                  </tr>
              <?php
            }
          }
            
           ?>
         


          </tbody>

        </table>
        <!--==== Modal ADD ======-->

        <div id="addCounty" class="modalDialog">
              <div>
                <a href="#close" title="Close" class="close">X</a>
                 <form action="" method="post">
                  <div >
                    <h1>Create New Return</h1>
                  </div>
                  <table>
                   <tbody>
                    <tr>
                      <td>District Name</td>
                      <td>
                          <select class='input_select' name="district_name">
                            <?php 
                              foreach ($districts as $key => $value) {
                                echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                              }
                             ?>
                            
                          </select>
                      </td>
                    <!-- </tr>
                    <tr> -->
                      <td>wave</td>
                      <td>
                        <input type="number" class='input_textbox' name="wave" placeholder="wave" value="wave">
                      </td>
                    </tr>

                    <tr>
                      <td>Regional Training End</td>
                      <td>
                        <input type="date" class='input_textbox' name="regional_training_end" placeholder="regional_training_end" value="regional_training_end">
                      </td>
                    <!-- </tr>

                    <tr> -->
                      <td>MoE Recieved</td><br>
                      <td>
                        <input type="checkbox" class="input_textbox" name="rt_moe_recieved" placeholder="rt_moe_recieved" >
                      </td>
                    <!-- </tr>

                   <tr> -->
                       <td>MoPHs Recieved</td>
                      <td>
                        <input type="checkbox" name="rt_mophs_recieved" placeholder="rt_moe_recieved">
                      </td>
                   </tr>

                   <tr>
                      <td>TTS End MT</td>
                      <td>
                        <input type="date" class='input_textbox' name="tts_end_mt" placeholder="regional_training_end" value="regional_training_end">
                      </td>
                   <!-- </tr>

                   <tr> -->
                      <td>TTS MoE Recieved</td>
                      <td>
                        <input type="checkbox" name="tts_moe_recieved" placeholder="tts_moe_recieved" >
                      </td>
                  <!--  </tr>

                  <tr> -->
                      <td>TTS Mophs Recieved</td>
                      <td>
                        <input type="checkbox" name="tts_mophs_recieved" placeholder="tts_mophs_recieved" >
                      </td>
                  </tr>

                  <tr>
                       <td>District Deworming Day</td>
                        <td>
                          <input type="date" class='input_textbox' name="district_deworming_day" placeholder="district_deworming_day" value="district_deworming_day">
                        </td>
                  <!-- </tr>

                 <tr> -->
                    <td>DD MoE Recieved</td>
                    <td>
                      <input type="checkbox" name="dd_moe_recieved" placeholder="dd_moe_recieved" >
                    </td>
                 <!-- </tr>

                 <tr> -->
                    <td>DD Mophs  Recieved</td>
                    <td>
                      <input type="checkbox" name="dd_mophs_recieved" placeholder="dd_mophs_recieved" >
                    </td>
                 </tr>
                  <tr>
                    <td>
                      <br/><br/><br/><br/>
                          <input type="submit" class="btn btn-primary" name="return_form"  value="Save"/>
                    </td>
                  </tr>
                </form> 

                </tbody>

              </table>

              </div>
            </div>
          </div> <!--End modal-->
         <!--==== Modal EDIT ======-->
            <div id="editCounty" class="modalDialog">
              <div>
                <a href="#close" title="Close" class="close">X</a>
                 <form action="return-status.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $details[0]['id'] ?>">
                  <div >
                    <h1>Edit <?php echo $details[0]['district_name']; ?> Return</h1>
                  </div>
                  <table>
                   <tbody>
                    <tr>
                      <td>District Name</td>
                      <td>
                          <select class='input_select' name="district_name">
                            <?php 
                              foreach ($districts as $key => $value) {
                                echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                              }
                             ?>
                            
                          </select>
                      </td>
                    <!-- </tr>
                    <tr> -->
                      <td>wave</td>
                      <td>
                        <input type="number" class='input_textbox' name="wave" placeholder="wave" value="<?php echo $details[0]['wave'] ?>">
                      </td>
                    </tr>

                    <tr>
                      <td>Regional Training End</td>
                      <td>
                        <input type="date" class='input_textbox' name="regional_training_end" placeholder="Regional Training End" value="<?php echo $details[0]['regional_training_end'] ?>"  >

                      </td>
                    <!-- </tr>

                    <tr> -->
                      <td>MoE Recieved</td><br>
                      <td>
                        <input type="checkbox" class="input_textbox" name="rt_moe_recieved" <?php if ($details[0]['rt_moe_recieved'] == 'Y') {echo "checked"; } ?>>
                      </td>
                    <!-- </tr>

                   <tr> -->
                       <td>MoPHs Recieved</td>
                      <td>
                        <input type="checkbox" name="rt_mophs_recieved" <?php if ($details[0]['rt_mophs_recieved'] == 'Y') {echo "checked"; } ?>>
                      </td>
                   </tr>

                   <tr>
                      <td>TTS End MT</td>
                      <td>
                        <input type="date" class='input_textbox' name="tts_end_mt"  value="<?php echo $details[0]['tts_end_mt'] ?>">
                      </td>
                   <!-- </tr>

                   <tr> -->
                      <td>TTS MoE Recieved</td>
                      <td>
                        <input type="checkbox" name="tts_moe_recieved"   <?php if ($details[0]['tts_moe_recieved'] == 'Y') {echo "checked"; } ?>>
                      </td>
                  <!--  </tr>

                  <tr> -->
                      <td>TTS Mophs Recieved</td>
                      <td>
                        <input type="checkbox" name="tts_mophs_recieved"  <?php if ($details[0]['tts_mophs_recieved'] == 'Y') {echo "checked"; } ?>>
                      </td>
                  </tr>

                  <tr>
                       <td>District Deworming Day</td>
                        <td>
                          <input type="date" class='input_textbox' name="district_deworming_day" placeholder="District Deworming Day" value="<?php echo $details[0]['district_deworming_day'] ?>">
                        </td>
                  <!-- </tr>

                 <tr> -->
                    <td>DD MoE Recieved</td>
                    <td>
                      <input type="checkbox" name="dd_moe_recieved" <?php if ($details[0]['dd_moe_recieved'] == 'Y') {echo "checked"; } ?>>
                    </td>
                 <!-- </tr>

                 <tr> -->
                    <td>DD Mophs  Recieved</td>
                    <td>
                      <input type="checkbox" name="dd_mophs_recieved" <?php if ($details[0]['dd_mophs_recieved'] == 'Y') {echo "checked"; } ?> >
                    </td>
                 </tr>
                  <tr>
                    <td>
                      <br/><br/><br/><br/>
                          <input type="submit" class="btn btn-primary" name="updateReturnStatus"  value="Update"/>
                    </td>
                  </tr>
                </form> 

                </tbody>

              </table>

              </div>
            </div>
            </div> <!--End modal edit-->



      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>




