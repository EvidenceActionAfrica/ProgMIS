<?php
$sql = "select * from materials_printlist_history where status=1";

$resultA = mysql_query($sql);
while ($row = mysql_fetch_array($resultA)) {

    $printlistId = $row["id"];
}

if (isset($_POST["savePackages"])) {
    //We must first clear all records related to the active printlist before the insert since the same data
    //will be reentered into the databse with the code below.
    $sql = "DELETE from materials_packaging_history where printlist_id=" . $printlistId;
    mysql_query($sql);
    $tabActive = 'tab2';
    //As long as there exists a district perform this loop.

    $count = 1;
    //echo $count;
    $sql = "INSERT INTO `materials_packaging_history`(`countyName`, `districtName`, `noBox`,`printlist_id`,`locked`) VALUES";
    while ($_POST["countyName" . $count] != null) {

        $districtName = isset($_POST["districtName" . $count]) ? mysql_real_escape_string($_POST["districtName" . $count]) : "";
        $countyName = isset($_POST["countyName" . $count]) ? mysql_real_escape_string($_POST["countyName" . $count]) : "";
        $boxNo = isset($_POST["boxNo" . $count]) ? mysql_real_escape_string($_POST["boxNo" . $count]) : 0;
        $boxIds = isset($_POST["boxIds" . $count]) ? mysql_real_escape_string($_POST["boxIds" . $count]) : "";
          $sql.=" ('$countyName','$districtName','$boxNo','$printlistId',0),";
   
        ++$count;
    }
    $sql = rtrim($sql, ",");
    mysql_query($sql)or die(mysql_error());
    //This will make the editing process of the active printlist's package inaccessible
    $sql = "update materials_printlist_history set packaged=1 where status=1";
    mysql_query($sql);
    //	echo $sql."<br/>";
    $tabActive = 'tab1';
    $action="General Packing Information";
    $description=" General Packing Information has been saved.General information will be unavailable";
    $ArrayData = array($M_module, $action, $description);
    quickFuncLog($ArrayData);
}

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_materials_edit = $row['priv_materials_edit'];
}


//We check if the active printlist has a confirmed quote and that it is locked.
//   If it does have a confirmed quote and lock the data below will not be displayed
$sql = "Select * from materials_printlist_history where status=1 AND packaged=1";
$results = mysql_query($sql);

$check = mysql_affected_rows();
if ($check < 1) {
    ?>

    <form method="POST" style="margin-left:2%;">
        <div style="margin-left:10%;">
            <img style="width:10%;" src="../images/gklogo.png"/>
            <b>Kenya National School-Based Deworming Programme</b>
            <img style="width:10%;" src="../images/kwaAfya.png"/>
            <hr style="font-weight:bolder;color:#EEEE;"/>
        </div>   
        <h4 style="margin-left:20%;">Number of boxes and their unique ID per Sub-County in each county</h4>
        <table class="table table-bordered table-condensed table-striped table-hover">
        <caption><a  href="#addDistrict" class="btn-custom-small" style="marign-left:45%;">Add/Remove Sub-County</a></caption>
            <tr>
                <th>Id</th> 
                <th>County</th>
                <th>Sub-County</th>
                <th>Number Of Boxes</th>
            </tr>
            <?php
            $sql = "Select * from materials_printlist_history where status=1";
            $results = mysql_query($sql);
            while ($row = mysql_fetch_array($results)) {
                $districts = $row["districts"];
            }
             $districts = unserialize($districts);
            $sql = "SELECT DiSTINCT a.county,a.district_name FROM districts as a,rollout_activity as r where a.district_name=r.activity_venu ";


            foreach ($districts as $key => $value) {

                if ($key == 0) {
                    $sql.="AND a.district_name='" . $value . "'";
                } else {
                    $sql.=" OR a.district_name='" . $value . "'";
                }
            }

            $sql.="GROUP BY a.district_name ORDER BY county,district_name ASC";

            //$result = mysql_query($sql);
            $resultB = mysql_query($sql);
            $id = 1;
            while ($row = mysql_fetch_array($resultB)) {
                $countyName = $row["county"];
                $districtName = $row["district_name"];
                $link = "materials_packing.php?id='$id'";
                ?>
                <tr rowspan="3" >
                    <td><?php echo $id; ?></td>
                    <td><input  class="num-only input-max uneditable-input" type="text" name="countyName<?php echo $id; ?>" value="<?php echo $countyName; ?>" read-only/></td>
                    <td><input  class="num-only input-max uneditable-input" type="text" name="districtName<?php echo $id; ?>" value="<?php echo $districtName; ?>" read-only/></td>
                    <td><input  class="num-only input-mini" type="text" name="boxNo<?php echo $id; ?>" value="" /></td>
                  
                </tr>
        <?php
        ++$id;
    }
    ?>
            <?php if ($priv_materials_edit >= 2 ||stristr($_SESSION['staff_role'],'Vendor') !=false) { ?>
                
                <tr><td ></td><td></td><td><input type="submit" name="savePackages" class="btn-custom-small" value="Save Details"/></td></tr>
            <?php } ?>
        </table>
    </form> 


    <?php
} else {
    ?>
    <div style='background:#bada66;'>
    <span id="h2info" style="font-size:1.3em;"> &nbsp; The Active Printlist's General Packing Information has already been set.<br/>Select Edit in the Next Tab to make changes or to Print to it.</span>
    </div>
    <?php
}
?>
