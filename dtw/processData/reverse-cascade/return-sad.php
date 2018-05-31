<?php

require_once ("../../includes/auth.php"); //use root

require_once ('../../includes/config.php'); //use root
require_once("../../includes/logTracker.php");
$M_module =6;
include "includes/class.return_SAD.php";



//instansiate class

$SADReturns = new SADReturns;

// get rollout data

$SADReturns->getRolloutData();

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

if (isset($_POST['update-log-submit'])) {



         echo $id=$_POST['id'];

         // do not update the id

         //  no reason to

         $data= $SADReturns->getAll();
         $errId=($id-1)>=0?0:1;
         if($errId==0){
           $newdistrict=$SADReturns->getDistName($data[$id-1]['district_id']);
         }else{
          $newdistrict='unknown';
         }
          
         $action="Forms : updated Forms";
         $description="The District ".$newdistrict." has been updated.The updates are: ";


         // if date is empty set is as 'N/A'

         if ($return_date=="" || empty($return_date)) {

           $return_date="N/A";
           $description.=' The return date has been set to '.$return_date.'.';

         }else{

             $return_date = $_POST['return_date'];
             $description.=' The return date has been set to '.$_POST['return_date'].'.';
         }



          //handle the checkboxes





          if (isset($_POST['form_p'])) {

            $form_p='Y';
            $description.='Form p has been set to Y.';
          }else{

            $form_p="N";
            $description.='Form p has been set to N.';
          }

          if (isset($_POST['form_mt'])) {

            $form_mt='Y';
            $description.='Form Mt has been set to Y.';
          }else{

            $form_mt="N";
            $description.='Form Mt has been set to N.';
          }

          if (isset($_POST['form_attnt'])) {

            $form_attnt='Y';
            $description.='Form Attnt has been set to Y.';
          }else{

            $form_attnt="N";
            $description.='Form Attnt has been set to N.';
          }

          if (isset($_POST['form_attnc'])) {

            $form_attnc='Y';
            $description.='Form Attnc has been set to Y.';
          }else{

            $form_attnc="N";
            $description.='Form Attnc has been set to N.';
          }

          if (isset($_POST['form_attnr'])) {

            $form_attnsc='Y';
            $description.='Form Attnr has been set to Y.';
          }else{

            $form_attnsc="N";
            $description.='Form Attnr has been set to N.';
          }

          if (isset($_POST['form_s'])) {

            $form_s='Y';
            $description.='Form S has been set to Y.';
          }else{

            $form_s="N";
            $description.='Form S has been set to N.';
          }

          if (isset($_POST['form_a'])) {

            $form_a='Y';
            $description.='Form A has been set to Y.';
          }else{

            $form_a="N";
            $description.='Form A has been set to N.';
          }

          if (isset($_POST['form_d'])) {

            $form_d='Y';
            $description.='Form D has been set to Y.';
          }else{

            $form_d="N";
            $description.='Form D has been set to N.';
          }



          //join all form the data



         $forms=$form_p.','. $form_mt.','. $form_attnsc.','. $form_attnc.','. $form_attnt.','. $form_s.','. $form_a.','. $form_d;







  $SADReturns->update(

                      $id,

                      $forms

                    );

         $ArrayData = array($M_module, $action, $description);
         quickFuncLog($ArrayData);

  header("Location:return-sad.php?saved=1&#close");



}





// privileges check.DO NOT TOUCH



$resPriv =$SADReturns->checkPrivilege();



foreach ($resPriv as $key => $value) {

	$priv_log_forms_analysed=$value['priv_log_forms_analysed'];	

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



        <div id="data-table-container">



                   <div id="data-table-manger">

                    

                    <div class="col-md-4">

                     <?php 

                      if (isset($_GET['saved'])) {

                        ?>

                        <div class="alert alert-success saved-info">

                          <a href="#" class="close" data-dismiss="alert">&times;</a>

                          <strong>Success!</strong> Data has been updated.

                        </div>  

                        <div class="vclear"></div>



                        <?php

                      }

                     ?>

                    </div>

                    <div class="small-heading col-md-3">FORMS</div>

                    <div> <span class="col-md-offset-2"><a class="pink-button" href="exportExcelSAD.php"> Export To Excel</a></span>  </div>

                   <div class="clearfix"></div>

                    <hr>

                    </div>





         <div class="panel-heading">Sub-County Return Records</div>

        <table id='data-table' class="return-sad row-border">

          <thead>

            <tr>

              <th rowspan="2">Sub-County Name</th>

              <th colspan="4">Planning</th>

              <th colspan="3">Training</th>

              <th colspan="3">Treatment</th>

                <?php if( $priv_log_forms_analysed>=3){?> 

              <th rowspan="2" >Flag  </th>

              <th rowspan="2" >Edit  </th>

               <?php }?> 

            </tr>

            <tr>

                <th>P</th>

                <th>MT</th>

                <th>ATTNSC</th>

                <th>Warning</th>

                <th>ATTNC</th>

                <th>ATTNT</th>

                <th>Warning</th>

                <th>S</th>

                <th>A</th>

                <th>D</th>

              </tr>

            </tr>

          </thead>

          <tbody>



          <?php 

          $i=1;

          if (sizeof($data) > 0) {

            foreach ($data as $key => $value) {

              # explode the form field

              $form=explode(",", $value['forms']);

              ?>

                  <tr id="tr-<?php echo $i;?>">

                    <td  id="district_id_td<?php echo $i;?>"> <?php echo $SADReturns->getDistName($value['district_id']) ?></td>

                    <td class="align-td" id="form_p_td<?php echo $i;?>"><?php echo $form[0] ?></td>

                    <td class="align-td" id="form_mt_td<?php echo $i;?>"><?php echo $form[1] ?></td>

                    <td class="align-td" id="form_attnt_td<?php echo $i;?>"><?php echo $form[2] ?></td>



                    <td class="align-td"><?php echo $SADReturns->getSADWarning($value['district_id'],$value['district_training_end_date'],4); ?></td>



                    <td class="align-td" id="form_attnc_td<?php echo $i;?>"><?php echo $form[3] ?></td>

                    <td class="align-td" id="form_attnr_td<?php echo $i;?>"><?php echo $form[4] ?></td>



                    <td class="align-td"><?php echo $SADReturns->getSADWarning($value['district_id'],$value['teacher_training_end_date'],5); ?></td>



                    <td class="align-td" id="form_s_td<?php echo $i;?>"><?php echo $form[5] ?></td>

                    <td class="align-td" id="form_a_td<?php echo $i;?>"><?php echo $form[6] ?></td>

                    <td class="align-td" id="form_d_td<?php echo $i;?>"><?php echo $form[7] ?></td>

                    <input type="hidden"  id="id-td<?php echo $i;?>" name="id" value="<?php echo $value['id'] ?>"/>



                    <!-- flag -->

                    <td class="align-td"><?php echo $SADReturns->getSADWarning($value['district_id'],$value['district_training_end_date'],6); ?></td>



                    <?php if( $priv_log_forms_analysed>=3){?> 

                      <td id="<?php echo $i;?>" title="edit" class="edit-sad-returns">

                        <a  href="#editsad"><img src="../../images/icons/edit2.png"></a>

                      </td>

                     <?php }?>                   



                  </tr>

              <?php

               $i++;

            }

          }

            

           ?>

         





          </tbody>



        </table>



    </div> <!-- end data table container -->





    <!--==== Modal EDIT ======-->

    <div id="editsad" class="modalDialog">

      <div>

         <div id="data-table-container">

            <a href="#close" title="Close" class="modalclose">X</a>

           <div id="data-table-manger">

            <div class="col-md-3">

              <!-- <button title="Add"class="btn btn-primary btn-xs" id="show-form">+</button> -->

            </div>

            <div class="small-heading col-md-6">TRACKING FORMS SUB-COUNTY RETURN STATUS</div>

           <div class="clearfix"></div>

            <hr>

            </div>





            <div id="hor-form2">

             <form action="" method="post" class="form-horizontal" role="form">

              <!-- GEOGRAPHY -->

                <div class="form-group">

                  <!-- <span class="col-md-2 control-label">Geography</span> -->

                  <label for="district_name" class="col-md-2 control-label">Sub-County</label>

                  <div class="col-md-2 update-select">

                      <input type="text" class="form-control input-sm" name="district_name" id="district_name_input" disabled>

                  </div>  



                </div>



                <!-- RETURN DATE -->



                <!-- FORMS -->

                 <div class="form-group">

                    <label class="col-md-2 control-label">Planning</label>



                    <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_p_checkbox" name="form_p" value=""> P

                      </label>

                    </div><div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_mt_checkbox" name="form_mt" value=""> MT

                      </label>

                    </div>

                      <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_attnr_checkbox" name="form_attnr" value=""> ATTNSC

                      </label>

                    </div>

                </div>



                <div class="form-group">

                    <label class="col-md-2 control-label">Traning</label>



                    <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_attnt_checkbox" name="form_attnt" value=""> ATTNT

                      </label>

                    </div><div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_attnc_checkbox" name="form_attnc" value=""> ATTNC

                      </label>

                    </div>

                  <!--   <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_attnr_checkbox" name="form_attnr" value=""> ATTNR

                      </label>

                    </div> -->

                </div>





                <div class="form-group">

                    <label class="col-md-2 control-label">Forms</label>



                    <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_s_checkbox" name="form_s" value=""> S

                      </label>

                    </div>

                    <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_a_checkbox" name="form_a" value=""> A

                      </label>

                    </div>

                    <div class="col-md-1">

                      <label class="checkbox-inline">

                        <input type="checkbox" id="form_d_checkbox" name="form_d" value=""> D

                      </label>

                    </div>

                </div>





                <!-- hidden id field -->

                <input type="hidden" name="id" id="form_id" >





                <!-- <button type="submit" name="update-log-submit" class="btn btn-default">Update</button> -->

  <?php if( $priv_log_forms_analysed>=2){?> 

                <div class="form-group">

                  <div class="col-md-1"></div>

                  <button type="submit" name="update-log-submit" class="btn btn-default update-log-submit">Save</button>

                </div>

  <?php } if( $priv_log_forms_analysed>=2){?>             

  <?php }?> 

            </form>

          </div>

      </div>

    </div> <!--end model edit-->









      </div> <!--end content body-->

        <div class="clearFix"></div>



    </div> <!--end content main-->

  </body>

</html>





<script type="text/javascript">

  $(document).ready(function() {

      $('#data-table').dataTable();

  } );

</script>











