<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
require_once("../../csv_upload/upload_csv/class.image.php");
require_once("../../csv_upload/upload_csv/class.insert.php");
require_once("../../includes/logTracker.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$image= new image;
$insertFile = new UploadFIle;
$tabActive="tab2";

//GET THE MAXIMUM NUMBER OF RECORDS ON THE TABLE
  $sqlMax = "Select * from a_bysch";
$resultMax = mysql_query($sqlMax);
$max = mysql_affected_rows();
//echo "Max Records are ".$max;
//CHECKING IF A PAGE NUMBER WAS SET 

   if (isset($_POST["btnSubmitPage"])) {       
        $pageOffset =isset($_POST["page"]) ? $_POST["page"] : 1;
        $offset=($pageOffset - 1) * 50;
        $tabActive="tab2";
    }else{
       $pageOffset=1; 
       $offset=0;
    }



if (isset($_POST['SUBMIT'])) {
        $table="a_bysch";
	if ($_FILES["file"]["error"] > 0) {
  	//echo "Error: " . $_FILES["file"]["error"] . "<br>";
        $description="A Csv Sheet called ".$_FILES["file"]['name'].' Failed To Upload'; 
	} else {
    $temp=$_FILES["file"]["tmp_name"];
    $filename=$image->upload_image($temp);
    $description="A Csv Sheet called ".$_FILES["file"]['name'].' Was Uploaded Successully';   
    $description=$insertFile->insertFile($filename,$table);

	}


$action=" Uploading a Form in a_bysch Called ".$_FILES["file"]["name"];
$M_module=6;
$ArrayData = array($M_module, $action, $description);

quickFuncLog($ArrayData);
	
}
  $pages = ceil($max/50);
//echo "There are ".$pages." Available";
                  $count = isset($_POST["Page"]) ? $_POST["Page"] : 1;
                  if ($count > $pages) {
                    $count = 1;
                  }
                  if ($count > 1) {
                    $countMin = $count - 1;
                  } else {
                    $countMin = 1;
                  }$countPlus = $count + 1;
                  $countMax = $count + 5;
                  while ($countMax > $pages) {
                    --$countMax;
                  }

//newMax
                  $newMax = 1;

 

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_login_forms_reverse = $row['priv_login_forms_reverse'];
}                 
                  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script-pablo.php"); ?>
 
  </head>


  <body  onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
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
        <?php
        require_once ("includes/menuLeftBar-Reverse.php");
        ?>
      </div>
      <div class="contentBody" >
         <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Upload/Export Data</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">View Data</a></li>
         
          </ul>
          <div class="tab-content">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
        
                 <?php
                  if (isset($_POST['SUBMIT']) && $_FILES["file"]["error"]==0) {
                      echo "<h2 style='background:#bada66;text-align:center;'>Upload done Successfully.</h2><br/><br/>";
                  }else if(isset($_POST['SUBMIT']) && $_FILES["file"]["error"]>0){
                       echo "<h2 style='background:#bada66;text-align:center;'>Upload Failed.</h2><br/><br/>";
                  }
                  ?>
                <div class="revrese-upload-panel">
                  <center class="padding-5">      
                    <h1 class="h3">Form A</h1>
                    <?php if ($priv_login_forms_reverse >= 1) { ?>
                      <a href="../../PHPExcel/csv_export.php?file_name=FormA&table_name=a_bysch" class="btn-custom-small">Export To Excel</a>
                    <?php }?>
                  </center>
                  <div class="vclear"></div>
                  <div class='alert alert-block'>
                      <p>
                      Please note. <br>Once data is uploaded, the online data will be overwriten.
                      <br>
                      Use the button to right to export the current data in the system, and update it.
                      <br>Only upload updated content
                      </p>
                  </div>

                   <img src="../../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
                   <form action="" method="post"
                    enctype="multipart/form-data">
                    <label for="file">Filename:</label>
                    <input type="file" name="file" id="file" />
                           <?php if ($priv_login_forms_reverse >= 2) { ?>
                    <input type="submit" id='btnSubmit' name="SUBMIT" value="Upload" class="btn-custom-small-normal" onclick='submitForm();'/>
                           <?php }

                           ?>
                   </form>
                 </div><!--End reverse-upload-panel-->
            </div>


            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" style="max-height:450px; overflow:scroll;">
                                     <form method="post" >
                    <b> Page </b>
                    <select name='page' onchange='submitPage();' style='width:70px'>
                      <?php
                      
                      if ($newMax == $pageOffset) {
                        $newMax = 2;
                      }
                      ?>
                      <option value="<?php echo $pageOffset ?>"><?php echo $pageOffset ?></option>
                        <?php
                        while ($newMax <= $pages) {
                          echo "<option value=$newMax> $newMax</option>";
                          ++$newMax;
                        }
                        ?>
                    </select> 
                    <b>of</b>  <?php echo $pages; ?> <b>Form A Pages</b>
                    <input  type="submit" value="submitPage" name='btnSubmitPage' id='btnSubmitPage' style="visibility: hidden"/>
                  </form>
            <table  class="table table-bordered table-condensed table-striped table-hover">
             <tr>
                 <div style="position:fixed;">
               <th>id</th>
              <th>county_id</th>
              <th>county_name</th>
              <th>district_id</th>
              <th>district_name</th> 
              <th>division_id</th> 
              <th>division_name</th>
              <th>school_id</th>
              <th>a_school_name</th>
              <th>a_prog_id1</th>
              <th>a_prog_id2</th>
              <th>a_prog_id3</th> 
              <th>a_form_s_returned</th> 
              <th>a_ecd_m</th> 
              <th>a_ecd_f</th> 
              <th>a_ecd_a</th> 
              <th>a_reg_total</th> 
              <th>a_trt_m</th> 
              <th>a_trt_f</th> 
              <th>a_treated_b</th>
              <th>a_2_m</th> 
              <th>a_2_f</th>
              <th>a_6_m</th> 
              <th>a_6_f</th> 
              <th>a_11_m</th>
              <th>a_11_f</th> 
              <th>a_15_m</th> 
              <th>a_15_f</th> 
              <th>a_total_c</th> 
              <th>a_ecd_total</th>
              <th>a_trt_total</th>
              <th>a_2_total</th>
              <th>a_6_total</th> 
              <th>a_11_total</th>
              <th>a_15_total</th> 
              <th>a_6_18_m</th> 
              <th>a_6_18_f</th> 
              <th>a_6_18_total</th> 
              <th>a_6_14_m</th> 
              <th>a_6_14_f</th> 
              <th>a_6_14_total</th> 
              <th>a_2_14_m</th>
              <th>a_2_14_f</th> 
              <th>a_2_14_total</th> 
              <th>a_2_18_m</th>
              <th>a_2_18_f</th> 
              <th>a_2_18_total</th>
              <th>a_u5_m</th> 
              <th>a_u5_f</th> 
              <th>a_u5_total</th>
              <th>a_total_child</th>
              <th>a_total_m</th> 
              <th>a_total_f</th>
              <th>ap_district_id</th>
              <th>ap_district_name</th> 
              <th>ap_division_id</th>
              <th>ap_division_name</th> 
              <th>ap_attached</th>
              <th>ap_school_name</th>
              <th>ap_prog_id1</th>
              <th>ap_prog_id2</th>
              <th>ap_prog_id3</th>
              <th>ap_form_s_returned</th> 
              <th>ap_ecd_m</th> 
              <th>ap_ecd_f</th>
              <th>ap_ecd_a</th>
              <th>ap_reg_total</th> 
              <th>ap_trt_m</th> 
              <th>ap_trt_f</th>
              <th>ap_treated_b</th>
              <th>ap_6_m</th>
              <th>ap_6_f</th>
              <th>ap_11_m</th>
              <th>ap_11_f</th>
              <th>ap_15_m</th> 
              <th>ap_15_f</th> 
              <th>ap_total_c</th>
              <th>ap_ecd_total</th> 
              <th>ap_trt_total</th>
              <th>ap_6_total</th>
              <th>ap_11_total</th> 
              <th>ap_15_total</th> 
              <th>ap_6_18_m</th> 
              <th>ap_6_18_f</th> 
              <th>ap_6_18_total</th>
              <th>ap_6_14_m</th>
              <th>ap_6_14_f</th> 
              <th>ap_6_14_total</th> 
              <th>ap_total_child</th> 
              <th>ap_total_m</th> 
              <th>ap_total_f</th> 
              <th>survey_id</th> 
              <th>aeo_name</th> 
              <th>aeo_phone_07</th>
              <th>aeo_phone</th> 
              <th>a</th>
              <th>ap</th>
              <th>Deworming Date</th>
              </div>
                 
             </tr>
       
                <?php
                
                $sql="SELECT * from a_bysch";
             $sql.=" LIMIT 50";
            if (isset($_POST["page"])) {
           $pageOffset = isset($_POST["page"]) ? $_POST["page"] : 1;

               $offset = ($pageOffset - 1) * 50;
               $sql.=" OFFSET " . $offset;
            }
                                              
               // echo $sql;                            
                $resultA=mysql_query($sql);
                while($row=  mysql_fetch_array($resultA)){
              echo "<tr><td>".$row["id"]."</td>";
              echo "<td>".$row["county_id"]."</td>";
              echo "<td>".$row["county_name"]."</td>";
              echo "<td>".$row["district_id"]."</td>";
              echo "<td>".$row["district_name"]."</td>"; 
              echo "<td>".$row["division_id"]."</td>"; 
              echo "<td>".$row["division_name"]."</td>";
              echo "<td>".$row["school_id"]."</td>";
              echo "<td>".$row["a_school_name"]."</td>";
              echo "<td>".$row["a_prog_id1"]."</td>";
              echo "<td>".$row["a_prog_id2"]."</td>";
              echo "<td>".$row["a_prog_id3"]."</td>"; 
              echo "<td>".$row["a_form_s_returned"]."</td>"; 
              echo "<td>".$row["a_ecd_m"]."</td>"; 
              echo "<td>".$row["a_ecd_f"]."</td>"; 
              echo "<td>".$row["a_ecd_a"]."</td>"; 
              echo "<td>".$row["a_reg_total"]."</td>"; 
              echo "<td>".$row["a_trt_m"]."</td>"; 
              echo "<td>".$row["a_trt_f"]."</td>"; 
              echo "<td>".$row["a_treated_b"]."</td>";
              echo "<td>".$row["a_2_m"]."</td>"; 
              echo "<td>".$row["a_2_f"]."</td>";
              echo "<td>".$row["a_6_m"]."</td>"; 
              echo "<td>".$row["a_6_f"]."</td>"; 
              echo "<td>".$row["a_11_m"]."</td>";
              echo "<td>".$row["a_11_f"]."</td>"; 
              echo "<td>".$row["a_15_m"]."</td>"; 
              echo "<td>".$row["a_15_f"]."</td>"; 
              echo "<td>".$row["a_total_c"]."</td>"; 
              echo "<td>".$row["a_ecd_total"]."</td>";
              echo "<td>".$row["a_trt_total"]."</td>";
              echo "<td>".$row["a_2_total"]."</td>";
              echo "<td>".$row["a_6_total"]."</td>"; 
              echo "<td>".$row["a_11_total"]."</td>";
              echo "<td>".$row["a_15_total"]."</td>"; 
              echo "<td>".$row["a_6_18_m"]."</td>"; 
              echo "<td>".$row["a_6_18_f"]."</td>"; 
              echo "<td>".$row["a_6_18_total"]."</td>"; 
              echo "<td>".$row["a_6_14_m"]."</td>"; 
              echo "<td>".$row["a_6_14_f"]."</td>"; 
              echo "<td>".$row["a_6_14_total"]."</td>"; 
              echo "<td>".$row["a_2_14_m"]."</td>";
              echo "<td>".$row["a_2_14_f"]."</td>"; 
              echo "<td>".$row["a_2_14_total"]."</td>"; 
              echo "<td>".$row["a_2_18_m"]."</td>";
              echo "<td>".$row["a_2_18_f"]."</td>"; 
              echo "<td>".$row["a_2_18_total"]."</td>";
              echo "<td>".$row["a_u5_m"]."</td>"; 
              echo "<td>".$row["a_u5_f"]."</td>"; 
              echo "<td>".$row["a_u5_total"]."</td>";
              echo "<td>".$row["a_total_child"]."</td>";
              echo "<td>".$row["a_total_m"]."</td>"; 
              echo "<td>".$row["a_total_f"]."</td>";
              echo "<td>".$row["ap_district_id"]."</td>";
              echo "<td>".$row["ap_district_name"]."</td>"; 
              echo "<td>".$row["ap_division_id"]."</td>";
              echo "<td>".$row["ap_division_name"]."</td>"; 
              echo "<td>".$row["ap_attached"]."</td>";
              echo "<td>".$row["ap_school_name"]."</td>";
              echo "<td>".$row["ap_prog_id1"]."</td>";
              echo "<td>".$row["ap_prog_id2"]."</td>";
              echo "<td>".$row["ap_prog_id3"]."</td>";
              echo "<td>".$row["ap_form_s_returned"]."</td>"; 
              echo "<td>".$row["ap_ecd_m"]."</td>"; 
              echo "<td>".$row["ap_ecd_f"]."</td>";
              echo "<td>".$row["ap_ecd_a"]."</td>";
              echo "<td>".$row["ap_reg_total"]."</td>"; 
              echo "<td>".$row["ap_trt_m"]."</td>"; 
              echo "<td>".$row["ap_trt_f"]."</td>";
              echo "<td>".$row["ap_treated_b"]."</td>";
              echo "<td>".$row["ap_6_m"]."</td>";
              echo "<td>".$row["ap_6_f"]."</td>";
              echo "<td>".$row["ap_11_m"]."</td>";
              echo "<td>".$row["ap_11_f"]."</td>";
              echo "<td>".$row["ap_15_m"]."</td>"; 
              echo "<td>".$row["ap_15_f"]."</td>"; 
              echo "<td>".$row["ap_total_c"]."</td>";
              echo "<td>".$row["ap_ecd_total"]."</td>"; 
              echo "<td>".$row["ap_trt_total"]."</td>";
              echo "<td>".$row["ap_6_total"]."</td>";
              echo "<td>".$row["ap_11_total"]."</td>"; 
              echo "<td>".$row["ap_15_total"]."</td>"; 
              echo "<td>".$row["ap_6_18_m"]."</td>"; 
              echo "<td>".$row["ap_6_18_f"]."</td>"; 
              echo "<td>".$row["ap_6_18_total"]."</td>";
              echo "<td>".$row["ap_6_14_m"]."</td>";
              echo "<td>".$row["ap_6_14_f"]."</td>"; 
              echo "<td>".$row["ap_6_14_total"]."</td>"; 
              echo "<td>".$row["ap_total_child"]."</td>"; 
              echo "<td>".$row["ap_total_m"]."</td>"; 
              echo "<td>".$row["ap_total_f"]."</td>"; 
              echo "<td>".$row["survey_id"]."</td>"; 
              echo "<td>".$row["aeo_name"]."</td>"; 
              echo "<td>".$row["aeo_phone_07"]."</td>";
              echo "<td>".$row["aeo_phone"]."</td>"; 
              echo "<td>".$row["a"]."</td>";
              echo "<td>".$row["ap"]."</td>";
              echo "<td>".$row["deworming_date"]."</td></tr>";
                }
                
                ?>


                    </table>
            </div>
        </div>
  </div>
</div>
   </div>
 <script type="text/javascript">
    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      //var selectButton = document.getElementById('btnSubmit');
      //selectButton.click();
    }
   function submitPage() {
     var selectButton = document.getElementById('btnSubmitPage');
     selectButton.click();
   }
    </script>

</body>
</html>