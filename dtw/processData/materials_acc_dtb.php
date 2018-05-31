<form method="post" >
    <div style="margin-left:25%;">

        <h2>Sub-County Training Box</h2>
        <img style="width:10%;" src="../images/gklogo.png"/>
        <b>Kenya National School-Based Deworming Programme</b>
        <img style="width:10%;" src="../images/kwaAfya.png"/>
        <hr style="font-weight:bolder;color:#EEEE;"/>
    </div>






    <?php
    $sql = "select * from materials_packaging_history_data  WHERE collected=1";
    $resultA = mysql_query($sql)or die(mysql_error());
    $sql = "Select count(package_id) as Number from materials_packaging_history_data WHERE collected=1 ";
//echo $sql;
    $result = mysql_query($sql)or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        $numRows = $row["Number"];
    }
    if ($numRows >= 1) {
        ?>

        <table class="table table-bordered table-condensed table-striped table-hover">

            <tr>
                <th>County</th>
                <th>District</th>
                <th>Box Id</th>
               
               <th></th>
            </tr>
            <?php
            while ($row = mysql_fetch_array($resultA)) {

                $county = $row["county_name"];
                $district = $row["district_name"];
                $boxId = $row["box_id"];
             

                $link = "materials_tts.php?county_name=$county&district_name=" . $district . "&boxId=" . $boxId;
                ?>
                <tr>
                    <td><?php echo $county; ?> </td>

                    <td><?php echo $district; ?> </td>
                    <td><?php echo $boxId; ?></td>
                    
        <?php if ($priv_materials_edit >= 2) { ?>
                        <td><a class="btn btn-info" style="text-decoration:none;margin-top:5%;" href="<?php echo $link; ?>#addDTBQuantity">Add Quantities</a></td>
                    <?php } ?>				 

                </tr>
                    <?php
                }
                ?>
        </table>
            <?php
        } else {
            echo "<h3 style='margin-left:25%;'><i>No Boxes have Been Sent.</i></h3>";
        }
        ?>	
</form>

