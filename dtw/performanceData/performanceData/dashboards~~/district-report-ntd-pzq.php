<?php
// require_once ("../../includes/auth.php"); //use root
// require_once ('../../includes/config.php'); // use root
$placeholder = "N/A";
// include "kpiFunctionsCiff.php";
// include "includes/class.ntd.pzq.php";
// $ntdPZQ=new ntdPZQ;
// $data=$ntdPZQ->getAll();
// include "includes/class.ntd.php";
// $ntdPZQ=new ntd;
// $dataPZQ=$ntdPZQ->getAllPZQ();
// echo "<pre>"; var_dump($data); echo "</pre>";
// exit();
// echo $ntdPZQ->numDistinctFlexible('school_id','a_bysch','district_id',2012029) . "\n";
// echo $ntdPZQ->sumSTHUnder5();
?>
<!--================================================-->
<!-- <div id="dashboard">

        <div id="indicator">
-->
<div class="dashboard_menu ntd-data-table">
    <div class="dashboard_export">
<?php if ($priv_ntd >= 1) { ?>
            <a href="exportExcelDistrictPZQ.php" class="btn btn-primary btn-small pink-color">Export To Excel</a>
<?php } ?>
        <!-- <a href="" class="btn btn-primary btn-small" target="_blank">Export To PDF</a> -->

    </div>
    <div class="vclear"></div>
    <div class="dashboard_title">

        <h3>District SHISTO Report</h3>	

    </div>

    <!-- start table -->

    <table id="data-table" class="display">
        <thead>
        <th>County</th>
        <th>District Name</th>
        <th>Rounds</th>
        <th>Year</th>	
        <th>Month</th>
        <th>Schools Treated</th>
        <th>SAC Treated</th>
        <th>15+ Treated</th>
        <th>SAC Male Treated</th>
        <th>SAC Female Treated</th>
        <th>of 15+ Male Treated</th>
        <th>of 15+ Female Treated</th>
        <th>Adults Treated</th>
        <th>Target SAC</th>
        <th>Target Adult</th>
        </thead>
        <tbody>
<?php
foreach ($dataPZQ as $key => $value) {
    ?>
                <tr>
                    <td><?php echo $ntd->getDistrictCounty($value['district_id'], 'name'); ?></td>
                    <td><?php echo $ntd->getDistName($value['district_id']); ?></td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td><?php echo $ntd::notavailable($value['schools_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['sac_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['over_15_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['sac_male_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['sac_female_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['over_15_male_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['over_15_female_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['adults_treated']); ?></td>
                    <td><?php echo $ntd::notavailable($value['target_sac']); ?></td>
                    <td><?php echo $ntd::notavailable($value['target_adult']); ?></td>
                </tr>
    <?php
}
?>

        </tbody>

    </table>


    <!-- end table -->

</div>



<!-- 	</div>

</div>
-->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<!-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css"> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
    });
</script>




