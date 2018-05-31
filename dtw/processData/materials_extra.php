<?php

require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$updateResult="";
$year = date("Y");
$month = date("m");
$today = date("Y-m-d");
//Extra Materials Form

if (isset($_GET['deleteExtra'])) {
$id=$_GET["deleteExtra"];
$sql="DELETE from others_extra where id=".$id;
mysql_query($sql);
$updateResult="An Extra Materials Record has been Deleted";
}


if (isset($_POST['Submit'])) {
//Check if not empty
  $query = "SELECT * FROM others_extras WHERE date = '$today' LIMIT 1";
  $check_record = mysql_query($query);
  $rows = mysql_num_rows($check_record);

  if ($rows == 0) {
//If no Errors Submit Form
    $flip_charts = mysql_prep($_POST['flip_charts']);
    $book_notes = mysql_prep($_POST['book_notes']);
    $filled_forms = mysql_prep($_POST['filled_forms']);
    $ex_attnr = mysql_prep($_POST['ex_attnr']);
    $ex_attnt = mysql_prep($_POST['ex_attnt']);
    $ex_attnc = mysql_prep($_POST['ex_attnc']);
    $ex_formMT = mysql_prep($_POST['ex_formMT']);
    $ex_formP = mysql_prep($_POST['ex_formP']);
    $ex_formD = mysql_prep($_POST['ex_formD']);
    $ex_formA = mysql_prep($_POST['ex_formA']);
    $ex_formS = mysql_prep($_POST['ex_formS']);
    $ex_formE = mysql_prep($_POST['ex_formE']);
    $ex_formN = mysql_prep($_POST['ex_formN']);
    $ex_formDP = mysql_prep($_POST['ex_formDP']);
    $ex_formAP = mysql_prep($_POST['ex_formAP']);
    $ex_formSP = mysql_prep($_POST['ex_formSP']);
    $ex_formEP = mysql_prep($_POST['ex_formEP']);
    $ex_formNP = mysql_prep($_POST['ex_formNP']);
    $ex_disttrain_booklet = mysql_prep($_POST['ex_disttrain_booklet']);
    $ex_teachtrain_booklet = mysql_prep($_POST['ex_teachtrain_booklet']);
    $ex_scripttown_ann = mysql_prep($_POST['ex_scripttown_ann']);
    $ex_commsens_sup = mysql_prep($_POST['ex_commsens_sup']);
    $ex_boxes = mysql_prep($_POST['ex_boxes']);
    $costperbox = mysql_prep($_POST['costperbox']);
    $costperdist = mysql_prep($_POST['costperdist']);

    $query = "INSERT INTO others_extras (date,flip_charts,book_notes,filled_forms,ex_attnr,ex_attnt,ex_attnc,ex_formMT,ex_formP,ex_formD,ex_formA,ex_formS,ex_formE,ex_formN,ex_formDP,ex_formAP,ex_formSP,ex_formEP,ex_formNP,ex_disttrain_booklet,ex_teachtrain_booklet,ex_scripttown_ann,ex_commsens_sup,ex_boxes,costperbox,costperdist) 
VALUES ('$today',
'{$flip_charts}',
'{$book_notes}',
'{$filled_forms}',
'{$ex_attnr}',
'{$ex_attnt}',
'{$ex_attnc}',
'{$ex_formMT}',
'{$ex_formP}',
'{$ex_formD}',
'{$ex_formA}',
'{$ex_formS}',
'{$ex_formE}',
'{$ex_formN}',
'{$ex_formDP}',
'{$ex_formAP}',
'{$ex_formSP}',
'{$ex_formEP}',
'{$ex_formNP}',
'{$ex_disttrain_booklet}',
'{$ex_teachtrain_booklet}',
'{$ex_scripttown_ann}',
'{$ex_commsens_sup}',
'{$ex_boxes}',
'{$costperbox}',
'{$costperdist}')";
    $dispense = get_result_set($query);
    $messageToUser = "Extra Materials Added Successfully.";
  } else {
    if ($rows == 1) {
      $error_message.="Similar Record Exists";
    }
  }
}
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit= $row['priv_materials_edit'];
}

?>
 <h4 align="center">Extra Materials Form</h4>
    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>";$updateResult=""; ?>
       
          <form method="POST" action="">
            <table border="1" align="center" class='table-hover'>
              <thead>
                <tr>
                  <th>Charts</th>
                  <th>Bk Notes</th>
                  <th>Fld Forms</th>
                  <th>ATTNR</th>
                  <th>ATTNT</th>
                  <th>ATTNC</th>
                  <th>Form MT</th>
                  <th>Form P</th>
                  <th>Form D</th>
                  <th>Form A</th>
                  <th>Form S</th>
                  <th>Form E </th>
                  <th>Form N </th>
                  <th>Form DP</th>
                  <th>Form AP</th>
                  <th>Form SP</th>
                  <th>Form EP</th>
                  <th>Form NP</th>
                  <th>DTB</th>
                  <th>TTB</th>
                  <th>STA</th>
                  <th>CSS</th>
                  <th>Boxes</th>
                  <th>Cost /Box</th>
                  <th>Cost /Dist</th>
                  
                </tr>
              </thead>
              <tr>
                <td><input name="flip_charts" type="text" id="flip_charts" size="5" required="required" /></td>
                <td><input name="book_notes" type="text" id="book_notes" size="5" required="required" /></td>
                <td><input name="filled_forms" type="text" id="filled_forms" size="5" required="required" /></td>
                <td><input name="ex_attnr" type="text" id="ex_attnr" size="5" /></td>
                <td><input name="ex_attnt" type="text" id="ex_attnt" size="5" /></td>
                <td><input name="ex_attnc" type="text" id="ex_attnc" size="5" /></td>
                <td><input name="ex_formMT" type="text" id="ex_formMT" size="5" /></td>
                <td><input name="ex_formP" type="text" id="ex_formP" size="5" /></td>
                <td><input name="ex_formD" type="text" id="ex_formD" size="5" /></td>
                <td><input name="ex_formA" type="text" id="ex_formA" size="5" /></td>
                <td><input name="ex_formS" type="text" id="ex_formS" size="5" /></td>
                <td><input name="ex_formE" type="text" id="ex_formE" size="5" /></td>
                <td><input name="ex_formN" type="text" id="ex_formN" size="5" /></td>
                <td><input name="ex_formDP" type="text" id="ex_formDP" size="5" /></td>
                <td><input name="ex_formAP" type="text" id="ex_formAP" size="5" /></td>
                <td><input name="ex_formSP" type="text" id="ex_formSP" size="5" /></td>
                <td><input name="ex_formEP" type="text" id="ex_formEP" size="5" /></td>
                <td><input name="ex_formNP" type="text" id="ex_formNP" size="5" /></td>
                <td><input name="ex_disttrain_booklet" type="text" id="ex_disttrain_booklet" size="5" /></td>
                <td><input name="ex_teachtrain_booklet" type="text" id="ex_teachtrain_booklet" size="5" /></td>
                <td><input name="ex_scripttown_ann" type="text" id="ex_scripttown_ann" size="5" /></td>
                <td><input name="ex_commsens_sup" type="text" id="ex_commsens_sup" size="5" /></td>
                <td><input name="ex_boxes" type="text" id="ex_boxes" size="5" /></td>
                <td><input name="costperbox" type="text" id="costperbox" placeholder="Per Box" size="5"/></td>
                <td><input name="costperdist" type="text" id="costperdist" placeholder="Per District" size="5"/></td>
              </tr>
            </table>
              <?php if($priv_materials_edit>=2){ ?>
            <td colspan="27" align="center"><input class="btn-custom-small" name="Submit" type="submit" value="Save Record" /></td>
       <?php } ?>
          </form>

           <table border="1" align="center" class='table-hover' >
             <thead>
              <tr>
                <th>Charts</th>
                <th>Bk Notes</th>
                <th>Fld Forms</th>
                <th>ATTNR</th>
                <th>ATTNT</th>
                <th>ATTNC</th>
                <th>Form MT</th>
                <th>Form P</th>
                <th>Form D</th>
                <th>Form A</th>
                <th>Form S</th>
                <th>Form E </th>
                <th>Form N </th>
                <th>Form DP</th>
                <th>Form AP</th>
                <th>Form SP</th>
                <th>Form EP</th>
                <th>Form NP</th>
                <th>DTB</th>
                <th>TTB</th>
                <th>STA</th>
                <th>CSS</th>
                <th>Boxes</th>
                <th>Cost /Box</th>
                <th>Cost /Dist</th>
                 <?php if($priv_materials_edit>=3){ ?>
                <th>Edit</th>
                 <?php }if($priv_materials_edit>=3){ ?>
                <th>Delete</th>
                 <?php } ?>
              </tr>
              </tr>
            </thead>

            <?php
            $sql = "SELECT * FROM others_extras ORDER BY id DESC LIMIT 1";
            $result = mysql_query($sql);
            while ($row = mysql_fetch_array($result)) {
              $flip_charts = $row['flip_charts'];
              $book_notes = $row['book_notes'];
              $filled_forms = $row['filled_forms'];
              $ex_attnr = $row['ex_attnr'];
              $ex_attnt = $row['ex_attnt'];
              $ex_attnc = $row['ex_attnc'];
              $ex_formMT = $row['ex_formMT'];
              $ex_formP = $row['ex_formP'];
              $ex_formD = $row['ex_formD'];
              $ex_formA = $row['ex_formA'];
              $ex_formS = $row['ex_formS'];
              $ex_formE = $row['ex_formE'];
              $ex_formN = $row['ex_formN'];
              $ex_formDP = $row['ex_formDP'];
              $ex_formAP = $row['ex_formAP'];
              $ex_formSP = $row['ex_formSP'];
              $ex_formEP = $row['ex_formEP'];
              $ex_formNP = $row['ex_formNP'];
              $ex_disttrain_booklet = $row['ex_disttrain_booklet'];
              $ex_teachtrain_booklet = $row['ex_teachtrain_booklet'];
              $ex_scripttown_ann = $row['ex_scripttown_ann'];
              $ex_commsens_sup = $row['ex_commsens_sup'];
              $ex_boxes = $row['ex_boxes'];
              $costperbox = $row['costperbox'];
              $costperdist = $row['costperdist'];
              $id=$row["id"];
              ?>  
              <tr>
                <td><?php echo $flip_charts; ?></td>
                <td><?php echo $book_notes; ?></td>
                <td><?php echo $filled_forms; ?></td>
                <td><?php echo $ex_attnr; ?></td>
                <td><?php echo $ex_attnt; ?></td>
                <td><?php echo $ex_attnc; ?></td>
                <td><?php echo $ex_formMT; ?></td>
                <td><?php echo $ex_formP ?></td>
                <td><?php echo $ex_formD; ?></td>
                <td><?php echo $ex_formA; ?></td>
                <td><?php echo $ex_formS; ?></td>
                <td><?php echo $ex_formE; ?></td>
                <td><?php echo $ex_formN; ?></td>
                <td><?php echo $ex_formDP; ?></td>
                <td><?php echo $ex_formAP; ?></td>
                <td><?php echo $ex_formSP; ?></td>
                <td><?php echo $ex_formEP; ?></td>
                <td><?php echo $ex_formNP; ?></td>
                <td><?php echo $ex_disttrain_booklet; ?></td>
                <td><?php echo $ex_teachtrain_booklet; ?></td>
                <td><?php echo $ex_scripttown_ann; ?></td>
                <td><?php echo $ex_commsens_sup; ?></td>
                <td><?php echo $ex_boxes; ?></td>
                <td><?php echo $costperbox; ?></td>
                <td><?php echo $costperdist; ?></td>
                  <?php if($priv_materials_edit>=3){ ?>
                <td align="center" width="4%"><a href="materials_printlist.php?id=<?php echo $id; ?>#editextra"><img src="../images/icons/edit2.png" height="20px"></a></td>
                <?php }if($priv_materials_edit>=4){ ?>
                <td align="center" width="4%"><a href="?deleteExtra=<?php echo $id; ?>" onclick="return confirm('Are you Sure you want to Delete Record?');"><img src="../images/icons/delete.png" height="20px"></a></td>
              <?php } ?>
              </tr>
            <?php } ?>
          </table>       
     
