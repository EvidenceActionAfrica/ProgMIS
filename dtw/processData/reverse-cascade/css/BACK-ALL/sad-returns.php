<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); //use root
include "includes/class.SADReturns.php";

//instansiate class
$SADReturns = new SADReturns;

// get districts
$districts = $SADReturns->getDistricts();

// get all county returns data
$data= $SADReturns->getAll();

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$SADReturns->getById($id);
}

// update
if (isset($_POST['sad_return_update'])) {

          $id=$_POST['id'];
          $district_name = $_POST['district_name'];
          $wave = $_POST['wave'];
          

          //handle the checkboxes

          if (isset($_POST['forms'])) {
            $forms='Y';
          }else{
            $forms="N";
          }


  $SADReturns->update(
                      $id,
                      $district_name,
                      $wave,
                      $forms
                    );

  header("Location:sad-returns.php");

}

//create
if (isset($_POST['sad_return'])) {

          $district_name = $_POST['district_name'];
          $wave = $_POST['wave'];
          

          //handle the checkboxes

          if (isset($_POST['forms'])) {
            $forms='Y';
          }else{
            $forms="N";
          }


          //insert the form data
          $SADReturns->create(
                      $district_name,
                      $wave,
                      $forms
          );

          //refresh the page
          header("Location:sad-returns.php");
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
        <h1>FORM S,A & D RETURN</h1>
        <form action="#">
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/districts.php">Export to Excel</a> -->
          <a class="btn btn-primary" href="#addCounty">Add County Return</a>
        </form>

        <table id='hor-minimalist-b'>
          <thead>
            <tr>
              <th rowspan="2">District Name</th>
              <th>Wave</th>
              <th>Form S'A'D</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>

          <?php 
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              # code...
              ?>
                  <tr>
                    <td id="district_name-td"> <?php echo $value['district_name'] ?></td>
                    <td id="wave-td"> <?php echo $value['wave'] ?></td>
                    <td id="moe_monitoring-td"> <?php echo $value['forms'] ?></td>

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
                 <form action="sad-returns.php" method="post">
                  <div >
                    <h1>Create New Form Return</h1>
                  </div>

                  <table border="0">
                    <tr>
                      <td><b>District Name</b> </td>
                      <td> 
                        <td>
                          <select class='input_select' name="district_name">
                            <?php 
                              foreach ($districts as $key => $value) {
                                echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
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
                      <td><b>Forms</b></td>
                      <td>
                      <input type="checkbox" name="forms" >Monitoring
                      </td>
                    </tr>
                     <td>
                      <br/><br/>
                          <input type="submit" class="btn btn-primary" name="sad_return"  value="Save"/>
                    </td>

                  </table>
                </form>
              </div>
            </div>
          </div> <!--End modal-->
         <!--==== Modal EDIT ======-->
            <div id="editCounty" class="modalDialog">
              <div>
                <a href="sad-returns.php" title="Close" class="close">X</a>
                 <form action="sad-returns.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $details[0]['id'] ?>">
                  <div >
                    <h1>Edit <?php echo $details[0]['district_name']; ?> Return</h1>
                  </div>
                  <table>
                   <tbody>
                     <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                      <tr>
                        <td><b>County Name</b> </td>
                        <td> 
                          <td>
                            <select class='input_select' name="district_name">
                              <?php 
                                foreach ($districts as $key => $value) {
                                  echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
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
                        <td><b>FORMS</b></td>
                        <td>
                        <input type="checkbox" name="forms" <?php if (isset($details[0]['forms'])) { if ($details[0]['forms']=='Y') {echo 'checked'; }} ?> >Monitoring
                        </td>
                      </tr>
                      <tr>
                      <td>
                        <br/><br/>
                            <input type="submit" class="btn btn-primary" name="sad_return_update"  value="Save"/>
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




