<?php
if ($_GET[tab] == "tab6") {


    $county = $_GET["county_name"];
    $district = $_GET["district_name"];
    $boxId = $_GET["boxId"];
    ?>

    <form method="post" >
        <div style="margin-left:25%;">

            <h2>District Training Box</h2>
            <img style="width:10%;" src="../images/gklogo.png"/>
            <b>Kenya National School-Based Deworming Programme</b>
            <img style="width:10%;" src="../images/kwaAfya.png"/>
            <hr style="font-weight:bolder;color:#EEEE;"/>
        </div>






        <?php
        $sql = "select * from materials_acc_dtb WHERE county_name='$county' AND district_name='$district' ORDER BY county_name,district_name DESC";
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
                    <th>Master Trainers Packet</th>
                    <th>DC Packet</th>
                    <th>DPHO Packet</th>
                    <th>District Training Booklet</th>
                    <th>Teacher Training Booklet </th>
                    <th>Handout on Financial Disbursements</th>
                    <th>Guide for District Level Managers (old)</th>
                    <th>Teacher Training Kit (old)</th>
                    <th>Form A</th>
                    <th>Form AP</th>
                    <th>Poster 1- Date</th>
                    <th>Poster 2- Behavior Change</th>
                    <th>Prepared By</th>
                    <th>Responsibility</th>
                    <th>Date Created</th>
                    <th>Edit</th>
                </tr>
                <?php
                while ($row = mysql_fetch_array($resultA)) {
                   $entryId = $row["entry_id"];
                    $boxId = $row["box_id"];
                    $mtp = $row["mtp"];
                    $total_mtp+=$mtp;
                    $dc_packet = $row["dc_packet"];
                    $total_dc_packet+=$dc_packet;
                    $dpho_packet = $row["dpho_packet"];
                    $total_dpho_packet=$dpho_packet;
                    $dtb = $row["dtb"];
                    $total_dtb+=$dtb;
                    $ttb = $row["ttb"];
                    $total_ttb+=$ttb;
                    $hfd = $row["hfd"];
                    $total_hfd+=$hfd;
                    $gdlm = $row["gdlm"];
                    $total_gdlm+=$gdlm;
                    $ttk = $row["ttk"];
                    $total_ttk+=$ttk;
                    $formA = $row["form_a"];
                    $total_formA+=$formA;
                    $formAp = $row["form_ap"];
                    $total_formAp+=$formAp;
                    $poster1 = $row["poster_1"];
                    $total_poster1+=$poster1;
                    $poster2 = $row["poster_2"];
                    $total_poster2+=$poster2;

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

                    $link = "materials_tts_dtb_strict.php?entryId=" . $entryId;
                    ?>
                    <tr>
                        <td><?php echo $entryId; ?> </td>

                        <td><?php echo $county; ?> </td>

                        <td><?php echo $district; ?> </td>
                        <td><?php echo $boxId; ?></td>
                        <td><?php echo $mtp; ?></td>
                        <td><?php echo $dc_packet; ?></td>
                        <td><?php echo $dpho_packet; ?></td>
                        <td><?php echo $dtb; ?></td>
                        <td><?php echo $ttb; ?></td>
                        <td><?php echo $hfd; ?></td>
                        <td><?php echo $gdlm; ?></td>
                        <td><?php echo $ttk; ?></td>
                        <td><?php echo $formA; ?></td>
                        <td><?php echo $formAp; ?></td>
                       <td><?php echo $poster1; ?></td>
                        <td><?php echo $poster2; ?></td>
                        <td><?php echo $preparedBy; ?></td>
                        <td><?php echo $responsible; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><a href="<?php echo $link; ?>#editDTBQuantity"><img src="../images/icons/edit.png" height="20px"/></a></td>
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

