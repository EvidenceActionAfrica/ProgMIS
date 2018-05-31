<?php
date_default_timezone_set("Africa/Nairobi");
 $disSelection=$_SESSION["district_selection"];//Extremely important:Do Not Touch
 if($disSelection !=null){
//require_once ('config.php');
$others=mysql_query("SELECT * FROM others_extras");
  while($extras=mysql_fetch_array($others))
  {
    //These Extras are used 
  $flip_charts=$extras['flip_charts'];
  $book_notes=$extras['book_notes'];
  $filled_forms=$extras['filled_forms'];
  $ex_boxes=$extras['ex_boxes'];
  $ex_attnr=$extras['ex_attnr'];
  $ex_attnt=$extras['ex_attnt'];
  $ex_attnc=$extras['ex_attnc'];
  $ex_formMT=$extras['ex_formMT'];
  $ex_formP=$extras['ex_formP'];
  $ex_formD=$extras['ex_formD'];
  $ex_formA=$extras['ex_formA'];
  $ex_formS=$extras['ex_formS'];
  $ex_formE=$extras['ex_formE'];
  $ex_formAP=$extras['ex_formAP'];
  $ex_formSP=$extras['ex_formSP'];
  $ex_formEP=$extras['ex_formEP'];
  $ex_formNP=$extras['ex_formNP'];
  $ex_disttrain_booklet=$extras['ex_disttrain_booklet'];
  $ex_teachtrain_booklet=$extras['ex_teachtrain_booklet'];
  $ex_scripttown_ann=$extras['ex_scripttown_ann'];
  $ex_commsens_sup=$extras['ex_commsens_sup'];
  $ex_boxes=$extras['ex_boxes'];
  $ex_commsens_sup=$extras['ex_commsens_sup'];




  $costperbox=$extras['costperbox'];
  $costperdist=$extras['costperdist'];
  $packing_labor=($ex_boxes*$costperbox)+($no_of_districts*$costperdist);
  }

  if(isset($_POST["savePrintOrder"])){

    $attnr=isset($_POST["attnr"])?$_POST["attnr"]:0;
    $attnt=isset($_POST["attnt"])?$_POST["attnt"]:0;
    $attnc=isset($_POST["attnc"])?$_POST["attnc"]:0;
    $formMt=isset($_POST["formMt"])?$_POST["formMt"]:0;
    $formP=isset($_POST["formP"])?$_POST["formP"]:0;
    $formA=isset($_POST["formA"])?$_POST["formA"]:0;
    $formS=isset($_POST["formS"])?$_POST["formS"]:0;
    $formE=isset($_POST["formE"])?$_POST["formE"]:0;
    $formN=isset($_POST["formN"])?$_POST["formN"]:0;
    $formAp=isset($_POST["formAp"])?$_POST["formAp"]:0;
    $formSp=isset($_POST["formSp"])?$_POST["formSp"]:0;
    $formEp=isset($_POST["formEp"])?$_POST["formEp"]:0;
    $formNp=isset($_POST["formNp"])?$_POST["formNp"]:0;
    $dtb=isset($_POST["dtb"])?$_POST["dtb"]:0;
    $ttb=isset($_POST["ttb"])?$_POST["ttb"]:0;
    $sta=isset($_POST["sta"])?$_POST["sta"]:0;
    $css=isset($_POST["css"])?$_POST["css"]:0;
    $gdlm=isset($_POST["gdlm"])?$_POST["gdlm"]:0;
    $ttk=isset($_POST["ttk"])?$_POST["ttk"]:0;
    $poster1=isset($_POST["poster1"])?$_POST["poster1"]:0;
    $poster2=isset($_POST["poster2"])?$_POST["poster2"]:0;
    $flipCharts=isset($_POST["flipCharts"])?$_POST["flipCharts"]:0;
    $bookNotes=isset($_POST["bookNotes"])?$_POST["bookNotes"]:0;
    $filledForm=isset($_POST["filledForm"])?$_POST["filledForm"]:0;
    $boxes=isset($_POST["boxes"])?$_POST["boxes"]:0;
    $packingLabor=isset($_POST["packingLabor"])?$_POST["packingLabor"]:0;
 
    $vendorId=isset($_POST["vendorId"])?mysql_real_escape_string($_POST["vendorId"]):"";
    $vendorName=isset($_POST["vendorName"])?mysql_real_escape_string($_POST["vendorName"]):"";
    $preparedBy=$_SESSION['staff_name'];
    $status=1;

   $handout=isset($_POST["handout"])?mysql_real_escape_string($_POST["handout"]):0;

   if(!is_numeric($handout)){
    $handout=0;
   }



$quantityArray=[$attnr,0,$formMt,0,0,$formP,$dtb,$css,$poster1,$poster2,$gdlm,$ttk,$handout,$ttb,$formA,$formAp,$formE,$formN,$formS
  ,$formEp,$formNp,$formSp,$attnt,$attnc,$sta,$flipCharts,$bookNotes
  ,$filledForm,$boxes,$packingLabor];


/*
echo $count;
echo "<pre>";
print_r($quantityArray);
echo "</pre>";
*/

//Set all other Records To inactive

$sql="select * from materials_printlist_history where status=1";
$resultU=mysql_query($sql);

    while($row=mysql_fetch_array($resultU)){
      $sql="Update materials_printlist_history set status=2 where id=".$row["id"];
  //    echo $sql."<br/>";
      mysql_query($sql) or die(mysql_error());
    }

//setting the data into printlist order history




            $sql="select * from materials_desc";
            $resultA=mysql_query($sql);
            $materialDesc=array();
            while($key=mysql_fetch_array($resultA)){
             $materialDesc[]=[$key["materials"],$key["packet"],$key["var1"],$key["var2"],$key["var3"],$key["var4"],$key["var5"],$key["extra"]];

            }
                  
$materialDescArray=serialize($materialDesc);
//$status=1;
$disSelection=serialize($disSelection);
$time_set=time();
$sql="INSERT INTO `materials_printlist_history`(`vendor_id`, `vendor_name`, `prepared_by`, `status`,`districts`,`time_set`,`assumptions`)";
$sql.=" VALUES ('$vendorId','$vendorName','$preparedBy',1,'$disSelection','$time_set','$materialDescArray')";
// echo $sql."<br/>";
$result=mysql_query($sql)or die(mysql_error());
if($result){
$updateResult.="<br/> &nbsp; This Printlist has been set as the Active Printlist.To Edit go to Printlist History";
}else{
  $updateResult.="<br/> &nbsp; This Printlist has not been set as the active Printlist. Contact Your System Administrator";
}

$sql="select * from materials_printlist_history where status=1";
$resultS=mysql_query($sql) or die(mysql_error());

while($row=mysql_fetch_array($resultS)){
  $printlistId=$row["id"];
}



//This will be used to place the items into the materials_printlist_history_data
$materialArray=["ATTNR","ATTNR- MoPHS","MT","Form D","Form DP","Form P","District Training Booklet with color cover",
"Community Sensitization Supplement","Poster 1","Poster 2","Guide for District Level Managers","Teacher_Training_Kit",
"Financial_Handout","Teacher_Training_Booklet","Form A","Form AP","Form E","Form N","Form S","Form EP",
"Form NP","Form SP","ATTNT","ATTNC","Script for Town Announcers"];
// echo "<pre>"; var_dump($materialArray); echo "</pre>";

// exit();
$append=0;
$count=sizeof($materialArray);


while($append<$count){

  $quantity=$quantityArray[$append];
 $materials=$materialArray[$append];

  
$sql="INSERT INTO `materials_printlist_history_data`(`material`, `print_order_quantity`, `printlist_id`)";
$sql.=" VALUES ('$materials',$quantity,'$printlistId')";
 //echo $sql."<br/>";
mysql_query($sql)or die(mysql_error());
++$append;
}



//Now that we have the printlist id we can update the quote table with the quantities and 
//printlist id for the respective printlist

$count=sizeof($quantityArray);
$append=0;
while($append<=$count){
  $quantity=$quantityArray[$append];
  $materials=$count;
++$append;
$sql="UPDATE `materials_vendor_quote` SET `print_order_quantity`='$quantity',";
$sql.="`print_order_unit_price`=0,`print_order_price`=0,updated_print_order_unit_price=0,updated_print_order_quantity=0,";
$sql.="updated_print_order_price=0 ,printlist_id='$printlistId' WHERE `id`='$append'";
//echo $sql."<br/>";
mysql_query($sql) or die(mysql_error());
  $updateResult="Print Order Created";

}

}    
?>
<form method="post">
  <h2 id="h2info"style="background:#bada66;"><?php echo $updateResult;$updateResult=""; ?></h2>
<table align="center" class="table table-bordered table-condensed table-striped table-hover">
   <tr>
    <td>Vendor Id: &nbsp; <input type="text" id="vendorId" name="vendorId" value="<?php echo $vendorId; ?>" /></td>
    <td>Vendor Name: &nbsp; <input type="text" id="vendorName" name="vendorName" value="<?php echo $vendorName; ?>" /></td>
   </tr>
   <tr>
    <th>Materials</th>
    <th>Quantity</th>
  </tr>
  <tr><td>ATTNR MOE: Day 1: &nbsp; <?php echo $total_attnrmoeday1; ?> &nbsp; Day 2: &nbsp; <?php echo $total_attnrmoeday2; ?></td></tr>
  <tr><td>ATTNR MOH: Day 1: &nbsp; <?php echo $total_attnrmohday1; ?> &nbsp; Day 2: &nbsp;  <?php echo $total_attnrmohday2; ?></td></tr>
  
  <tr>
    <td>ATTNR &nbsp; +extra &nbsp; <?php echo $ex_attnr; ?></td>
    <td><input readonly type="text" name="attnr" value="<?php echo ($total_attnrmoeday1+$total_attnrmoeday2+$total_attnrmohday1+$total_attnrmohday2+$ex_attnr) ?>" /></td>
  </tr>

  <tr>
    <td>ATTNT &nbsp; +extra &nbsp; <?php echo $ex_attnt; ?></td></td>
    <td><input readonly type="text" name="attnt" value="<?php echo $total_teachertb_attnt+$ex_attnt; ?>" /></td>
  </tr>
  <tr>
    <td>ATTNC: &nbsp; +extra &nbsp; <?php echo $ex_attnc; ?></td>
    <td><input readonly type="text" name="attnc" value="<?php echo $total_teachertb_attnc+$ex_attnc; ?> " /></td>
  </tr>
  <tr>
    <td>Form MT: &nbsp; +extra &nbsp; <?php echo $ex_formMT; ?></td>
    <td><input readonly type="text" name="formMt" value="<?php echo $total_formMT+$ex_formMT; ?>" /></td>
  </tr>
  <tr>
    <td>Form P: &nbsp; +extra &nbsp; <?php echo $ex_formP; ?></td>
    <td><input readonly type="text" name="formP" value="<?php echo $total_formP_slist+$ex_formP;  ?>" /></td>
  </tr>
  <tr>
    <td>Form D:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Form A: &nbsp; +extra &nbsp; <?php echo $ex_formA; ?></td>
    <td><input readonly type="text" name="formA" value="<?php echo $total_rtb_forma+$ex_formA; ?>" /></td>
  </tr>
  <tr>
    <td>Form S: &nbsp; +extra &nbsp; <?php echo $ex_formS; ?></td>
    <td><input readonly type="text" name="formS" value="<?php echo $total_formS_perdist+$ex_formS;  ?>" /></td>
  </tr>
  <tr>
    <td>Form E: &nbsp; +extra &nbsp; <?php echo $ex_formE; ?></td>
    <td><input readonly type="text" name="formE" value=" <?php echo $total_formE_perdist+$ex_formE; ?>" /></td>
  </tr>
  <tr>
    <td>Form N: &nbsp; +extra &nbsp; <?php echo $ex_formN; ?></td>
    <td><input readonly type="text" name="formN" value=" <?php echo $total_formN_perdist+$ex_formN; ?>" /></td>
  </tr>
  <tr>
    <td>Form DP :</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Form AP: &nbsp; +extra &nbsp; <?php echo $ex_formAP; ?></td>
    <td><input readonly type="text" name="formAp" value="<?php echo $total_rtb_formAP+$ex_formAP; ?>" /></td>
  </tr>
  <tr>
    <td>Form SP: &nbsp; +extra &nbsp; <?php echo $ex_formSP; ?></td>
    <td><input readonly type="text" name="formSp" value=" <?php echo $total_formSP_perdist+$ex_formSP; ?>" /></td>
  </tr>
  <tr>
    <td>Form EP: &nbsp; +extra &nbsp; <?php echo $ex_formEP; ?></td>
    <td><input readonly type="text" name="formEp" value="<?php echo $total_formEP_perdist+$ex_formEP; ?>" /></td>
  </tr>
  <tr>
    <td>Form NP: &nbsp; +extra &nbsp; <?php echo $ex_formNP; ?></td>
    <td><input readonly type="text" name="formNp" value="<?php echo $total_formNP_perdist+$ex_formNP; ?>" /></td>
  </tr>
  <tr>
    <td>District Training Booklet: &nbsp; +extra &nbsp; <?php echo $ex_disttrain_booklet; ?></td>
    <td><input readonly type="text" name="dtb" value=" <?php echo $total_dtb_perdist+$ex_disttrain_booklet; ?>" /></td>
  </tr>
  <tr>
    <td>Teacher Training Booklet: &nbsp; +extra &nbsp; <?php echo $ex_teachtrain_booklet; ?></td>
    <td><input readonly type="text" name="ttb" value="<?php echo $total_ttboxes_ttbooklets+$ex_teachtrain_booklet; ?>" /></td>
  </tr>
  <tr>
    <td>Script for Town Announcers: &nbsp; +extra &nbsp; <?php echo $ex_scripttown_ann; ?></td>
    <td><input readonly type="text" name="sta" value="<?php echo $total_rtb_staperdiv+$ex_scripttown_ann; ?>" /></td>
  </tr>
  <tr>
    <td>Community Sensitization Supplement: &nbsp; +extra &nbsp; <?php echo $ex_commsens_sup; ?></td>
    <td><input readonly type="text" name="css" value="<?php echo $total_css_perdiv+$ex_commsens_sup; ?>" /></td>
  </tr>
  <tr>
    <td>Guide for District Level Manager:</td>
    <td><input readonly type="text" name="gdlm" value=" <?php echo $total_rtb_gdlm ?>" /></td>
  </tr>
  <tr>
    <td>Teacher Training Kit: </td>
    <td><input readonly type="text" name="ttk" value="<?php echo $total_rtb_ttk ?>" /></td>
  </tr>
  <tr>
    <td>Poster 1:</td>
    <td><input readonly type="text" name="poster1" value="<?php echo $total_rtb_poster1 ?>" /></td>
  </tr>
  <tr>
    <td>Poster 2:</td>
    <td><input readonly type="text" name="poster2" value="<?php echo $total_rtb_poster2 ?>" /></td>
  </tr>
  <tr>
    <td>Flip Charts: &nbsp; +extra &nbsp; <?php echo $flip_charts; ?></td>
    <td><input readonly type="text" name="flipCharts" value="<?php echo $flip_charts ?>" /></td>
  </tr>
  <tr>
    <td>Book of Notes: &nbsp; +extra &nbsp; <?php echo $book_notes; ?></td>
    <td><input readonly type="text" name="bookNotes" value="<?php echo $book_notes; ?>" /></td>
  </tr>
  <tr>
    <td>Set of Filled Forms: &nbsp; +extra &nbsp; <?php echo $filled_forms; ?></td>
    <td><input readonly type="text" name="filledForm" value="<?php echo $filled_forms; ?>" /></td>
  </tr>
  <tr>
    <td>Financial Overview:</td>
    <td><input  type="text" name="handout" value="<?php echo $handout; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Boxes: &nbsp; +extra &nbsp; <?php echo $ex_boxes; ?></td>
    <td><input  type="text" name="boxes" value="<?php echo $ex_boxes; ?>" readonly/></td>
  </tr>
  <tr>
    <td>Packing Labor: </td>
    <td><input readonly type="text" name="packingLabor" value="<?php echo $packing_labor; ?>" /></td>
  </tr>
</table>
<input type="submit" style="margin-left:40%;" id="savePrintOrder" name="savePrintOrder" class="btn btn-info" value="Confirm Print Order" />
</form>
<script>
function prepareEventHandler(){
var vendorId=document.getElementById("vendorId");
var vendorId=document.getElementById("vendorName");
var savePrintOrder=document.getElementById("savePrintOrder");
var h3Error=document.createTextNode("Your Vendor Information is Incorrect.");
var h2info=document.getElementById("h2info");

//Prevents submit of page if validation does not pass
savePrintOrder.onsubmit=function(){
    
    if(vendorId.value==="" || vendorName.value==="" ){
        console.log("Validation Empty");
            return false;
    }else{
          if(!isNaN(vendorId.value) && isNaN(vendorName.value)){
             console.log("Validation Pass");
            return true;
          }else{
            console.log("Failed Validation");
            h2info.appendChild(h3Error);
            return false;
          }
       }
};
}
window.onload=function(){
prepareEventHandler();
 console.log("Validation script Works");
};
</script>
<?php
}else{

  echo "<h1 style='font-weight:bolder;'>Please Select the districts to generate the data From in the districts Selection.</h1>";
}
?>