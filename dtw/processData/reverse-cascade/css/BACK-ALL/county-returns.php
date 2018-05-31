<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
include "includes/class.CountyReturn.php";

//instansiate class
$countyReturn = new countyReturn;

// get districts
$counties = $countyReturn->getCounties();

// get all county returns data
$data= $countyReturn->getAll();

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$countyReturn->getById($id);
}

// update
if (isset($_POST['county_return_update'])) {

          $id=$_POST['id'];
          $county_id = $_POST['county_id'];
          $wave = $_POST['wave'];
          

          //handle the checkboxes

          if (isset($_POST['moe_monitoring'])) {
            $moe_monitoring='Y';
          }else{
            $moe_monitoring="N";
          }
          if (isset($_POST['moe_meeting'])) {
            $moe_meeting='Y';
          }else{
            $moe_meeting="N";
          }
          if (isset($_POST['mophs_community'])) {
            $mophs_community='Y';
          }else{
            $mophs_community="N";
          }
          if (isset($_POST['mophs_monitoring'])) {
            $mophs_monitoring='Y';
          }else{
            $mophs_monitoring="N";
          }
          if (isset($_POST['mophs_meeting'])) {
            $mophs_meeting='Y';
          }else{
            $mophs_meeting="N";
          }


  $countyReturn->update(
                          $id,
                          $county_id,
                          $wave,
                          $moe_monitoring,
                          $moe_meeting,
                          $mophs_community,
                          $mophs_monitoring,
                          $mophs_meeting
                    );

  header("Location:county-returns.php");

}

//create
if (isset($_POST['county_return'])) {

          $county_id = $_POST['county_id'];
          $wave = $_POST['wave'];
          

          //handle the checkboxes

          if (isset($_POST['moe_monitoring'])) {
            $moe_monitoring='Y';
          }else{
            $moe_monitoring="N";
          }
          if (isset($_POST['moe_meeting'])) {
            $moe_meeting='Y';
          }else{
            $moe_meeting="N";
          }
          if (isset($_POST['mophs_community'])) {
            $mophs_community='Y';
          }else{
            $mophs_community="N";
          }
          if (isset($_POST['mophs_monitoring'])) {
            $mophs_monitoring='Y';
          }else{
            $mophs_monitoring="N";
          }
          if (isset($_POST['mophs_meeting'])) {
            $mophs_meeting='Y';
          }else{
            $mophs_meeting="N";
          }


          //insert the form data
          $countyReturn->create(
                $county_id,
                $wave,
                $moe_monitoring,
                $moe_meeting,
                $mophs_community,
                $mophs_monitoring,
                $mophs_meeting
          );

          //refresh the page
          header("Location:county-returns.php");
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
      <div style="float: left">  <img src="../images/logo.png" />  </div>
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
        <h1>COUNTY RETURN</h1>
        <form action="#">
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a> -->
          <a class="btn btn-primary" href="#addCounty">Add County Return</a>
        </form>

        <table id='hor-minimalist-b'>
          <thead>
            <tr>
              <th rowspan="2">County Name</th>
              <th>Wave</th>
              <th colspan="2">MOE</th>
              <th colspan="3">MoPHS</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td></td>
            <td></td>
            <td>Monitoring</td>
            <td>Meeting</td>
            <td>Community Sensitization</td>
            <td>Monitoring</td>
            <td>Meeting</td>
          </tr>

          <?php 
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              # code...
              ?>
                  <tr>
                    <td id="county_id-td"> <?php echo $value['county_id'] ?></td>
                    <td id="wave-td"> <?php echo $value['wave'] ?></td>
                    <td id="moe_monitoring-td"> <?php echo $value['moe_monitoring'] ?></td>
                    <td id="moe_meeting-td"> <?php echo $value['moe_meeting'] ?></td>
                    <td id="mophs_community-td"> <?php echo $value['mophs_community'] ?></td>
                    <td id="mophs_monitoring-td"> <?php echo $value['mophs_monitoring'] ?></td>
                    <td id="mophs_meeting-td"> <?php echo $value['mophs_meeting'] ?></td>

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
                <a href="county-returns.php" title="Close" class="close">X</a>
                 <form action="county-returns.php" method="post">
                  <div >
                    <h1>Create New County Return</h1>
                  </div>

                  <table border="0">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <tr>
                      <td><b>County Name</b> </td>
                      <td> 
                        <td>
                          <select class='input_select' name="county_id">
                            <?php 
                              foreach ($counties as $key => $value) {
                                echo '<option value="'.$value['county_id'].'"">'.$value['county'].'</option>';
                              }
                             ?>
                            
                          </select>
                      </td>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Wave</b></td>
                      <td> 
                        <input type="number" class="input_textbox" name="wave"  value="column_head">
                      </td>
                    </tr>
                    <tr>
                      <td><b>MOE</b></td>
                      <td>
                      <input type="checkbox" name="moe_monitoring" >Monitoring
                      </td>
                      <td>
                      <input type="checkbox" name="moe_meeting" >Meeting
                      </td>
                    </tr>

                    <tr>
                      <td><b>MoPHS</b></td>
                      <td>
                      <input type="checkbox" name="mophs_community" >Community Sensitization
                      </td>
                      <td>
                      <input type="checkbox" name="mophs_monitoring" >Monitoring
                      </td>
                      <td>
                      <input type="checkbox" name="mophs_meeting" >Meeting
                      </td>
                    </tr>
                    <tr>
                    <td>
                      <br/><br/>
                          <input type="submit" class="btn btn-primary" name="county_return"  value="Save"/>
                    </td>
                  </tr>
                   
                  </table>
                </form>
              </div>
            </div>
          </div> <!--End modal-->
         <!--==== Modal EDIT ======-->
            <div id="editCounty" class="modalDialog">
              <div>
                <a href="county-returns" title="Close" class="close">X</a>
                 <form action="county-returns.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $details[0]['id'] ?>">
                  <div >
                    <h1>Edit <?php echo $details[0]['county_id']; ?> Return</h1>
                  </div>
                  <table>
                   <tbody>
                     <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <tr>
                        <td><b>County Name</b> </td>
                        <td> 
                          <td>
                            <select class='input_select' name="county_id">
                              <?php 
                                foreach ($counties as $key => $value) {
                                  echo '<option value="'.$value['county_id'].'"">'.$value['county'].'</option>';
                                }
                               ?>
                              
                            </select>
                        </td>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Wave</b></td>
                        <td> 
                          <input type="number" class="input_textbox" name="wave"  value="<?php echo $details[0]['wave'] ?>">
                        </td>
                      </tr>
                      <tr>
                        <td><b>MOE</b></td>
                        <td>
                        <input type="checkbox" name="moe_monitoring" <?php if (isset($details[0]['moe_monitoring'])) { if ($details[0]['moe_monitoring']=='Y') {echo 'checked'; }} ?> >Monitoring
                        </td>
                        <td>
                        <input type="checkbox" name="moe_meeting" 

                        <?php if (isset($details[0]['moe_meeting'])) {if ($details[0]['moe_meeting']=='Y') {echo 'checked'; }}  ?>
                        >Meeting
                        </td>
                      </tr>

                      <tr>
                        <td><b>MoPHS</b></td>
                        <td>
                        <input type="checkbox" name="mophs_community" 
                        <?php if (isset($details[0]['mophs_community'])) {if ($details[0]['mophs_community']=='Y') {echo 'checked'; }} ?>
                        >Community Sensitization
                        </td>
                        <td>
                        <input type="checkbox" name="mophs_monitoring" 

                        <?php if (isset($details[0]['mophs_monitoring'])) {if ($details[0]['mophs_monitoring']=='Y') {echo 'checked'; }} ?>
                        >Monitoring
                        </td>
                        <td>
                        <input type="checkbox" name="mophs_meeting" 
                        <?php if (isset($details[0]['mophs_meeting'])) {if ($details[0]['mophs_meeting']=='Y') {echo 'checked'; }} ?>
                        >Meeting
                        </td>
                      </tr>
                      <tr>
                      <td>
                        <br/><br/>
                            <input type="submit" class="btn btn-primary" name="county_return_update"  value="Save"/>
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




