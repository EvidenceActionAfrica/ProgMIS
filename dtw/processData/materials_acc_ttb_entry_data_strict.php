<?php
if ($_GET[tab] == "tab5") {


    $county = $_GET["county_name"];
    $district = $_GET["district_name"];
    $boxId = $_GET["boxId"];
    ?>

    <form method="post" >
        <div style="margin-left:25%;">

            <h2>Teacher Training Box</h2>
            <img style="width:10%;" src="../images/gklogo.png"/>
            <b>Kenya National School-Based Deworming Programme</b>
            <img style="width:10%;" src="../images/kwaAfya.png"/>
            <hr style="font-weight:bolder;color:#EEEE;"/>
        </div>






        <?php
        $sql = "select * from materials_acc_ttb WHERE county_name='$county' AND district_name='$district' ORDER BY county_name,district_name DESC";
        $resultA = mysql_query($sql)or die(mysql_error());

        $numRows = mysql_affected_rows();
        if ($numRows >= 1) {
            ?>

            <table class="table table-bordered table-condensed table-striped table-hover">

                <tr>
                    <th>Entry Id</th>
                    <th>County</th>
                    <th>District</th>
                    <th>Box Id</th>
                    <th>Teacher Training Booklet </th>
                    <th>Form E Packet (20 forms each)</th>
                    <th>Form N Packet (15 forms each)</th>
                    <th>Form S Packet (5 forms each) </th>
                    <th>Form E-P Packet (20 forms each)</th>
                    <th>Form N-P Packet (5 forms each)</th>
                    <th>Form S-P Packet (5 forms each)</th>
                    <th>ATTNT Packet (20 forms each)</th>
                    <th>Poster 1- Date</th>
                    <th>Poster 2- Behavior Change</th>
                    <th>Prepared By</th>
                    <th>Responsibility</th>
                    <th>Date Created</th>
                    <th>Edit</th>
                </tr>
                <?php
                while ($row = mysql_fetch_array($resultA)) {

                    $boxId = $row["box_id"];
                    $ttb = $row["ttb"];
                    $total_ttb+=$ttb;
                    $formE = $row["form_e"];
                    $total_formE+=$formE;
                    $formN = $row["form_n"];
                    $total_formN+=$formN;
                    $formS = $row["form_s"];
                    $total_formS+=$formS;
                    $formEp = $row["form_ep"];
                    $total_formEp+=$formEp;
                    $formNp = $row["form_np"];
                    $total_formNp+=$formNp;
                    $formSp = $row["form_sp"];
                    $total_formSp+=$formSp;
                    $attntPacket = $row["attnt_packet"];
                    $total_attntPacket+=$attntPacket;
                    $poster1 = $row["poster_1"];
                    $total_poster1+=$poster1;
                    $poster2 = $row["poster_2"];
                    $total_poster2+=$poster2;
                    $entryId = $row["entry_id"];

                    $preparedBy = $row["prepared_by"];
                    $responsible = $row["collected_by"];
                    $unixDate = $row["date"];
                    $year = date('Y', $unixDate);
                    $month = date('M', $unixDate);
                    $day = date('d', $unixDate);
                    $suffix = date('S', $unixDate);
                    $hour = date('g', $unixDate);
                    //   $min=date('i',$unixDate);
                    $setTime = date('A', $unixDate);
                    $dayWeek = date('l', $unixDate);


                    $date = $day . "<sup>" . $suffix . "</sup> " . $month . " " . $year . " -" . $hour . " " . $setTime . " " . $dayWeek;
                    // $date=$row["date"];

                    $link = "materials_tts_strict.php?entryId=" . $entryId;
                    ?>
                    <tr>
                        <td><?php echo $entryId; ?> </td>

                        <td><?php echo $county; ?> </td>

                        <td><?php echo $district; ?> </td>
                        <td><?php echo $boxId; ?></td>
                        <td><?php echo $ttb; ?></td>
                        <td><?php echo $formE; ?></td>
                        <td><?php echo $formN; ?></td>
                        <td><?php echo $formS; ?></td>
                        <td><?php echo $formEp; ?></td>
                        <td><?php echo $formNp; ?></td>
                        <td><?php echo $formSp; ?></td>
                        <td><?php echo $attntPacket; ?></td>
                        <td><?php echo $poster1; ?></td>
                        <td><?php echo $poster2; ?></td>
                        <td><?php echo $preparedBy; ?></td>
                        <td><?php echo $responsible; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><a href="<?php echo $link; ?>#editQuantity"><img src="../images/icons/edit.png" height="20px"/></a></td>
                    </tr>
            <?php
        }
        ?>
            </table>

        <?php
    } else {
        echo "<h3><i>No Box has Entry Information.</i></h3>";
    }
}
?>	
</form>

