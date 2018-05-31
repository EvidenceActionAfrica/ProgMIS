 
<?php


$updateResult = "";

/***
**************************
*                        *
*SUMMARY                 *
*                        *
**************************
*   
*  Edit Content requires capturing some fields of the the record that will be used to query the entire record including the content 
*  of the boxes.he following operations will be done in this file
*   1. Display of The Box To be Edited
*   2. Update Operation
*
**************************
*                        *
*Solution Logic          *
*                        *
**************************
*1.Capture the Get Requests
*2.Query the Record to be edited with the sanitized GET variables
*3.For the Update operation i will simply delete part(s) of the one in the system then insert them back.
*4.Contigency 
*
*
**/

//Solution Implementation

//1.

$package_id=isset($_GET['package_id'])?filter_input(INPUT_GET,'package_id',FILTER_SANITIZE_SPECIAL_CHARS):null;

//3. The Update operation is wrapped around this if statement that checks if the post request has been made for this file.
//This implementation has to begin before the querying to allow the user to view the most update version of the box in question.

if(isset($_POST['update-Box'])){

    $box_id=isset($_POST['box_id'])?filter_input(INPUT_POST,'box_id',FILTER_SANITIZE_STRING):"Undefined";
    $date=isset($_POST['date'])?filter_input(INPUT_POST,'date'):"Undefined";
    $packaged_by=isset($_POST['packaged_by'])?filter_input(INPUT_POST,'packaged_by',FILTER_SANITIZE_STRING):"Undefined";
    $package_id=isset($_POST['package_id'])?filter_input(INPUT_POST,'package_id',FILTER_SANITIZE_STRING):"Undefined";
    
    $boxType=isset($_POST['boxType'])?filter_input(INPUT_POST,'boxType',FILTER_SANITIZE_STRING):"Undefined";
    $contact=isset($_POST['contact'])?filter_input(INPUT_POST,'contact',FILTER_SANITIZE_NUMBER_INT):"Undefined";
    

    unset($_POST["update-Box"]);   
    unset($_POST['box_id']);
    unset($_POST['date']);
    unset($_POST['contact']);
    
    unset($_POST['packaged_by']);
    unset($_POST['package_id']);
    unset($_POST['boxType']);
   
    $insertMaterial = mysql_real_escape_string(serialize($_POST));

    $sql="UPDATE `materials_packaging_history_data` SET `box_id`='$box_id',
    `packaged_by`='$packaged_by',`contact`='$contact',`material`='$insertMaterial',
    `box_type`='$boxType',`date`='$date' WHERE `package_id`='$package_id'";

    
    mysql_query($sql)or die(mysql_error());

    $updateResult = "Box Was Updated";
    $action="Box Was Updated";
      $description="Box Was Updated";
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
}



//4. 

if(isset($package_id)){



//2.

$sqlBoxContent='select * from materials_packaging_history_data WHERE package_id='.$package_id;
//echo $sqlBoxContent;
$boxResult=mysql_query($sqlBoxContent) or die(mysql_error().' Cannot Locate the Box');

while($boxRow=mysql_fetch_assoc($boxResult)){
    
    $materialArray=unserialize($boxRow['material']);
    $packaged_by=$boxRow['packaged_by'];
    $contact=$boxRow['contact'];
    $boxType=$boxRow['box_type'];
    $date=$boxRow['date'];
    $box_id=$boxRow['box_id'];
}



?>


<div id="editBox"  >
    <div >
        <div >
            <div>
                <h2 class="text-center">Edit Box Details & Content</h2>
            </div>
            <form  method="post" role="form">
                <div >
                    <div id="message"><span style="background-color:#bada66;"><?php echo $updateResult; ?></span></div>
                    <br/>
                    <div class="row">
                        <div>
                              <div style="margin-left:10%;width:20%;float:left;">
                               
                                <label>Box Type</label><br/>
                                <select name="boxType" required>
                                <?php 
                                    $sqlboxType='Select * from training_box_categories';
                                    $boxTypeResult=mysql_query($sqlboxType);
                                   
                                    while($rowType=mysql_fetch_array($boxTypeResult)){
                                   echo '<option value="'.$rowType["acronymn"].'" ';
                                        if($rowType['acronymn']==$boxType){
                                            echo 'selected ';
                                        }
                                        echo '>'.$rowType['name'].'</option>';

                                    }

                                ?>
                                   
                                </select>
                               
                           </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                                    <label>Packaged By</label><br/>
                                    <input type="hidden" name="package_id" value="<?php echo $package_id; ?>" readonly/>
                                    <input type="text" name="packaged_by" value="<?php echo $packaged_by; ?>"/>
                                
                            </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                                    <label>Contact</label><br/>
                                     <input type="text" name="contact" value="<?php echo $contact; ?>"/>
                            </div>
                           <div style="margin-left:10%;width:20%;float:left;">
                                <label>Date</label><br/>
                                <input type="text" class="datepicker" name="date" value="<?php echo $date; ?>" />
                           </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                                    <label>Box Id</label><br/>
                                    <input type="text" name="box_id" value="<?php echo $box_id; ?>" />
                           </div>
                        

                            <?php
                           
                            /* echo "<pre>";
                              print_r($materialArray);
                              echo "</pre>";
                              exit();            //$fields = mysql_query($resultA);
                             */
                            $count = 1;
                            foreach ($materialArray as $key => $value) {

                                $mat = substr($key, 0, 20);
                                if (strlen($value) > 20) {
                                    $mat.="..";
                                }
                                $material = ucwords(str_replace('_', ' ', $mat));
                                // $material=$value;

                                echo '                      <div style="margin-left:10%;width:20%;float:left;">
                                                
                                                      <label class="showTooltip" data-toggle="tooltip" data-placement="left" title="' . str_replace('_',' ',$key). '">' . $material . '</label><br>
                                                         <input type="text"  name="'.$material.'" value="'.$value.'"/>
                                               
                                            </div>
                                   ';
                                ++$count;
                            }
                            ?>

                            <input type="submit" style="margin-left:30%;margin-top:5%;" class="btn-custom" name="update-Box" value="Update Box" />
                        </div>
                    </div>
                </div>  
                         
            </form>
        </div>
    </div> 
</div>

<?php
}
ob_flush();
?>