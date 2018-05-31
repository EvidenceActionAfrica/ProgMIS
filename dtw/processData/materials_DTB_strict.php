<?php
/**
*SUMMARY
*This Tab's Purpose is to show all the boxes packed along the materials,quantity of materials collected
*This are the following things you will see in the code
*
*1.CRUD Operations--I will put them just below this comments. They will be triggered by post requests
*2.Display of basic info of the boxes. The materials & their respective quantities will be shown in a modal if selected
*
*
*DISPLAY BASIC INFO OF THE BOXES
*
*The table will get the data from the get Request. The Get request will have the following:
*(a)The county and Sub-county(district) information.
*(b)The Tab information--This is what determines which tab opens(DO NOT MODIFY UNLESS tab number changed)
*(c)The Printlist Id--This is to avoid a possible collision.I.e If someone else selected another printlist as you worked on this
*(d)Box Type--This is responsible for showing/filtering the box type to be viewed.
*
*******************************
*     Solution Logic          *
*                             *
*******************************
*
*1.Considering the county,District(sub-county) details are alreay available.They will be displayed as is.
* Any crucial Crud will be performed this to ensure correct data is displayed.
*2.The get request for box type will give us the acronymn of the box type and not full description.
* soln:query for the box_type description.
*3.Create the query for displaying the boxes(WHERE box_type='acronym')
*4.Contigency:If Any of the GET requests is missing the page will be redirected.
*GOOD LUCK!
*
*/

/**CRUD OPERATION */

if(isset($_GET['boxDelete'])){
$deleteId=filter_input(INPUT_GET,'boxDelete',FILTER_SANITIZE_NUMBER_INT);
$Boxsql='DELETE from materials_packaging_history_data WHERE package_id='.$deleteId;
$updateResult='A Box Has Been Deleted.';
mysql_query($Boxsql)or die(mysql_error().' : Unable to Delete Box & Its Contents');
}

/*
DISPLAY INFO IMPLEMENTATION
*/
//1.
$county=isset($_GET['countyName'])?filter_input(INPUT_GET, 'countyName',FILTER_SANITIZE_SPECIAL_CHARS):null;
$district=isset($_GET['districtName'])?filter_input(INPUT_GET, 'districtName',FILTER_SANITIZE_SPECIAL_CHARS):null;
$printlist_id=isset($_GET['printlistId'])?filter_input(INPUT_GET, 'printlistId',FILTER_SANITIZE_SPECIAL_CHARS):null;

//2.
$boxTypeAcronymn=isset($_GET['boxType'])?filter_input(INPUT_GET,'boxType',FILTER_SANITIZE_SPECIAL_CHARS):null;

$sqlAcronymn='SELECT name from training_box_categories WHERE acronymn="'.$boxTypeAcronymn.'"';
$resultAcronymn=mysql_query($sqlAcronymn)or die(mysql_error().' : Unable to Get the acronym\'s Full definition');
while($acronymnRow=mysql_fetch_array($resultAcronymn)){
    $boxtTypeName=$acronymnRow['name'];
}
//$boxtTypeName is the full name of the active acronymn box type.

//3.

$sqlTableDetails='SELECT package_id,box_id,materials_printlist_history.vendor_name as vendor_name,packaged_by,contact';
$sqlTableDetails.=',date from materials_packaging_history_data JOIN materials_printlist_history ON materials_packaging_history_data.printlist_Id=materials_printlist_history.id';
$sqlTableDetails.=' WHERE box_type="'.$boxTypeAcronymn.'" AND printlist_id="'.$printlist_id.'"';
$sqlTableDetails.=' AND county_name="'.$county.'" AND district_name="'.$district.'"';
//echo $sqlTableDetails;
$tableResult=mysql_query($sqlTableDetails)or die(mysql_error().' : Unable to Get the table data');
$tableData='';//Thisis the variable that will carry the table's information
$rowNo=mysql_affected_rows();
while($tableRow=mysql_fetch_array($tableResult)){

    $package_id=$tableRow['package_id'];
    $box_id=$tableRow['box_id'];
    $vendor_name=$tableRow['vendor_name'];
    $packaged_by=$tableRow['packaged_by'];
    $contact=$tableRow['contact'];
    $date=$tableRow['date'];
    $tableData.='<tr>';
    $tableData.='<td>'.$package_id.'</td>'.'<td>'.$box_id.'</td><td>'.$vendor_name.'</td><td>'.$packaged_by.'</td>';
    $tableData.='<td>'.$contact.'</td>'.'<td>'.$date.'</td>';
    $link='materials_packing_strict.php?package_id='.$package_id;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link.='&package_id='.$package_id;
       $tableData.='<td><a href="'.$actual_link.'&printPdf=box_summary"><img src="../images/icons/view2.png" height="20px"/></a></td>';
      
       $tableData.='<td><a style="text-decoration:none;"  href="'.$actual_link.'&tab=5"><img src="../images/icons/edit.png" height="20px"/></a></td>';
     
        $tableData.=' <td><a onclick="show_Box_confirm('.$package_id.')"><img src="../images/icons/delete.png" height="20px"/></a></td>';
       
   
    
    $tableData.='</tr>';
}


?>
<div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
<?php 

//4.

if($county !=null && $district !=null & $printlist_id !=null && $boxTypeAcronymn !=null && $_GET['tab']==3){
    ?>
    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>" . $updateResult . "</h3>"; ?>
    <form action="materials_packing_strict.php" method="post" >
        <div style="margin-left:20%;">
            <h2>Box Type:<?php echo $boxtTypeName; ?></h2>
           
            <div style="font-weight:bold;width:auto;">
                <label>County<?php echo ": " . $county; ?></label><label>District<?php echo ": " . $district; ?></label>
            </div>
        </div>
        <?php
            if($rowNo>=1){
        ?>
        <table class='table table-bordered table-condensed table-striped table-hover'>
        <thead>
            <tr>
                <th>Package Id</th>
                <th>Box Id</th>
                <th>Vendor Name</th>
                <th>Packaged By</th>
                <th>Contact</th>
                <th>Date</th>
                <th>Print</th>
                <th>Edit</th>
                <th>Delete</th>
                  
            </tr>
        </thead>
        <?php
         echo $tableData;
          ?>
        </table>
        <?php
        }else{
            echo "<h3><i>Quantities Not Set</i></h3>";
        }
        $county=urlencode($county);
        $district=urlencode($district);
        $boxTypeAcronymn=urlencode($boxTypeAcronymn);
        $printlist_id=urlencode($printlist_id);
              
        
        ?>
         
        

            <a class="btn-custom" style="text-decoration:none;"  href="<?php echo $actual_link; ?>&tab=4">New Box</a>
      

      </form>
      <?php

}else{
     
}

?>
</div>
<script>

 function show_Box_confirm(deleteid) {
  <?php   $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'&boxDelete='; ?>
      if (confirm("Are you sure you want to delete?")) {
        location.replace('<?php echo $actual_link;?>'+ deleteid);
      } else {
        return false;
      }
    }
</script>

