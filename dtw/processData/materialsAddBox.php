 
<?php

$updateResult = "";

if (isset($_POST["addNewBox"])) {

    $printlistId = $_GET["printlistId"];
    $countyName = $_GET["countyName"];
    $districtName = $_GET["districtName"];
    $box_id=isset($_POST['box_id'])?filter_input(INPUT_POST,'box_id'):"Undefined";
    $date=isset($_POST['date'])?filter_input(INPUT_POST,'date'):"Undefined";
    $packaged_by=isset($_POST['packaged_by'])?filter_input(INPUT_POST,'packaged_by'):"Undefined";
    $boxType=isset($_POST['boxType'])?filter_input(INPUT_POST,'boxType'):"Undefined";
    $contact=isset($_POST['contact'])?filter_input(INPUT_POST,'contact'):"Undefined";
    
    $append = 1;
    

    unset($_POST["addNewBox"]);   
    unset($_POST['box_id']);
    unset($_POST['date']);
    unset($_POST['contact']);
    
    unset($_POST['packaged_by']);
    unset($_POST['boxType']);
   
    $insertMaterial = mysql_real_escape_string(serialize($_POST));

    $sql = "INSERT INTO `materials_packaging_history_data`(`box_id`, `printlist_id`,`packaged_by`,`contact`,";
    $sql.="`county_name`, `district_name`, `material`,`date`,`box_type`)";
    $sql.=" VALUES ('$box_id','$printlistId','$packaged_by','$contact','$countyName','$districtName','$insertMaterial',";
    $sql.=" '$date','$boxType')";

    mysql_query($sql)or die(mysql_error());

    $updateResult = "A New Box Was Added";
    $action="A New Box Was Added";
      $description=" A new box ".$box_id." has been added for ".$districtName.".Its box type is ".$boxType;
      $ArrayData = array($M_module, $action, $description);
      quickFuncLog($ArrayData);
}

?>


<div id="addBox"  >
    <div >
        <div >
            <div>
                <h2 class="text-center">Add New Box</h2>
            </div>
            <form  method="post" role="form">
                <div >
                    <div id="message"><span style="background-color:#bada66;"><?php echo $updateResult; ?></span></div>
                    <br/>
                    <div class="row">
                        <div>
                              <div style="margin-left:10%;width:20%;float:left;">
                              
                                <label>Box Type</label>
                                <select name="boxType" required>
                                       <?php 
                                    $sqlboxType='Select * from training_box_categories';
                                    $boxTypeResult=mysql_query($sqlboxType);
                                   
                                    while($rowType=mysql_fetch_array($boxTypeResult)){
                                   echo '<option value="'.$rowType["acronymn"].'" >'.$rowType['name'].'</option>';

                                    }

                                ?>
                                </select>
                               
                           </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                                 
                               
                                    <label>Packaged By</label>
                                    <input type="text" name="packaged_by"/>
                                
                            </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                              
                                    <label>Contact</label>
                                <input type="text" name="contact"/>
                          
                            </div>
                           <div style="margin-left:10%;width:20%;float:left;">
                              
                                <label>Date</label>
                                <input type="text" class="datepicker" name="date" value="<?php echo date('d-m-y'); ?>" />
                            
                           </div>
                            <div style="margin-left:10%;width:20%;float:left;">
                               
                                    <label>Box Id</label>
                                    <input type="text" name="box_id" value="" required/>
                              
                           </div>
                        

                            <?php
                            $sql = "SELECT materials from materials_vendor_quote_history WHERE printlist_id=" . $printlistId;
                            $result = mysql_query($sql);
                            $materialArray = array();
                            $count = 0;
                            while ($row = mysql_fetch_array($result)) {
                                array_push($materialArray, $row["materials"]);
                                ++$count;
                            }
                            /* echo "<pre>";
                              print_r($materialArray);
                              echo "</pre>";
                              exit();            //$fields = mysql_query($resultA);
                             */
                            $count = 1;
                            foreach ($materialArray as $key => $value) {

                                $mat = substr($value, 0, 20);
                                if (strlen($value) > 20) {
                                    $mat.="..";
                                }
                                $material = ucwords(str_replace('_', ' ', $mat));
                                // $material=$value;

                                echo '                      <div style="margin-left:10%;width:20%;float:left;">
                                                      <label class="showTooltip " data-toggle="tooltip" data-placement="left" title="' . $value . '">' . $material . '</label>
                                                         <input type="text" class="num-only" name="'.$value.'" value=""/>
                                            </div>
                                   ';
                                ++$count;
                            }
                            ?>

                            <input type="submit" style="margin-left:20%;margin-top:5%;" class="btn-custom" name="addNewBox" value="Add Box" />
                        </div>
                    </div>
                </div>  
                         
            </form>
        </div>
    </div> 
</div>

<script type="text/javascript">
 
$(function() {
$( ".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
});
</script>

