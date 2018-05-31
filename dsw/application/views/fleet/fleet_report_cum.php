
<div class="col-md-10">
    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>

    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left"><?php echo $category; ?> Expenditure Summary</h3>
        </div>
        <hr>
    </div>
    <form method="$_GET" >
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-hover">

                <thead>         
                    <tr>
                        <th class="export-visible" colspan="4" style="border-radius: 5px 5px 0px 0px; ">
                            <label  style="font-size: 14px; float: left; padding-right: 20px;">Select Year </label>
                            <select class="form-control input-sm" style="width:110px; float: left;"  name="choose_year" id="choose_year">
                                <option value='all' <?php echo 'selected'; ?>>All</option>
                                <?php 
                                foreach ($dataOffYearLogMaint as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['Year']; ?>"<?php if ($year == $value['Year']) echo 'selected'; ?>>
                                        <?php echo $value['Year']; ?></option>
                                <?php } ?>
                            </select>
                            <input class="btn btn-default pink-button" style="height: 30px; margin-left: 5px;" type="submit" name="submit_year"  value="Submit">
                            <?php if ($year != 'all') { ?>
                                <?php if (!isset($_GET['alter_week']) && !isset($_GET['submit_week'])) { ?>
                                    <input class="btn btn-default pink-button" style="height: 30px; float: right;" type="submit" name="alter_week"  value="Change to WeeK">
                                <?php } else { ?>
                                    <input class="btn btn-default pink-button" style="height: 30px; float: right;" type="submit" name="alter_month"  value="Change to Month">
                                <?php } ?>
                            <?php } ?>
                        </th>
                    </tr>          
                    <?php if ($year != 'all') { ?>
                        <tr>
                            <th class="export-visible" colspan="4">
                                <?php if (!isset($_GET['alter_week']) && !isset($_GET['submit_week'])) { ?>
                                    <label  style="font-size: 14px; float: left;">Select Month &nbsp;</label> 
                                    <select class="form-control input-sm" style="width:110px; float: left;"  name="choose_month" id="choose_month">
                                        <option value='all' <?php echo 'selected'; ?>>None</option>
                                        <option value='1' <?php if ($month == '1') echo 'selected'; ?>>January</option>
                                        <option value='2' <?php if ($month == '2') echo 'selected'; ?>>February</option>
                                        <option value='3' <?php if ($month == '3') echo 'selected'; ?>>March</option>
                                        <option value='4' <?php if ($month == '4') echo 'selected'; ?>>April</option>
                                        <option value='5' <?php if ($month == '5') echo 'selected'; ?>>May</option>
                                        <option value='6' <?php if ($month == '6') echo 'selected'; ?>>June</option>
                                        <option value='7' <?php if ($month == '7') echo 'selected'; ?>>July</option>
                                        <option value='8' <?php if ($month == '8') echo 'selected'; ?>>August</option>
                                        <option value='9' <?php if ($month == '9') echo 'selected'; ?>>September</option>
                                        <option value='10' <?php if ($month == '10') echo 'selected'; ?>>October</option>
                                        <option value='11' <?php if ($month == '11') echo 'selected'; ?>>November</option>
                                        <option value='12' <?php if ($month == '12') echo 'selected'; ?>>December</option>                        
                                    </select>
                                    <?php if ($month != 'all') { ?>
                                        <label  style="font-size: 14px; float: left;">&nbsp Select Day &nbsp;</label>
                                        <select class="form-control input-sm" style="width:75px; float: left;"  name="choose_day" id="choose_day">
                                            <option value='all' <?php echo 'selected'; ?>>None</option>
                                            <?php
                                            foreach ($dataDayOffMaint as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['Day']; ?>"<?php if ($day == $value['Day']) echo 'selected'; ?>>
                                                    <?php echo $value['Day']; ?></option>
                                                <?php } ?>
                                        </select>
                                    <?php } ?>
                                    <input class="btn btn-default pink-button" style="height: 30px; margin-left: 5px;" type="submit" name="submit_month"  value="Submit">
                                <?php } else { ?>
                                    <label  style="font-size: 14px; float: left;">Select Week &nbsp;</label> 
                                    <select class="form-control input-sm" style="width:110px; float: left;"  name="choose_week" id="choose_week">
                                        <option value='all' <?php echo 'selected'; ?>>None</option> 
                                        <?php
                                            foreach ($dataWeekOffMaint as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['Week']; ?>"<?php if ($week == $value['Week']) echo 'selected'; ?>>
                                                    <?php echo $value['Week']; ?></option>
                                                <?php } ?>
                                    </select>
                                    <?php if ($week != 'all') { ?>
                                        <label  style="font-size: 14px; float: left;">&nbsp Select Day &nbsp;</label>
                                        <select class="form-control input-sm" style="width:75px; float: left;"  name="choose_day" id="choose_day">
                                            <option value='all' <?php echo 'selected'; ?>>None</option>
                                            <?php
                                            foreach ($dataDayOffMaint as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['Day']; ?>"<?php if ($day == $value['Day']) echo 'selected'; ?>>
                                                    <?php echo $value['Day']; ?></option>
                                                <?php } ?>
                                        </select>
                                    <?php } ?>
                                    <input class="btn btn-default pink-button" style="height: 30px; margin-left: 5px;" type="submit" name="submit_week"  value="Submit">

                                <?php } ?>
                            </th>
                        </tr>

                    <?php } ?>

                    <tr > 
                        <th class="export-visible">Office Name</th>
                        <th class="export-visible">Fuel Cost</th>
                        <th class="export-visible">Maintenance Cost</th>                        
                        <th class="export-visible">Total Cost</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    
                        foreach ($data as $key => $value) {
                            ?>
                            <tr>

                                <td><?php echo $office_loc = $value["office_location"]; ?></td>                                
                                <?php $data_log = $fleetlistmodel->getDataLogCum($dayComplex, $weekComplex, $monthComplex, $yearComplex, $value["office_location"]); ?>
                                <td><?php echo $val_fuel_cost = $data_log[0]['sum_fuel_cost']; ?></td>
                                <?php $data_maint = $fleetlistmodel->getDataMaintCum($dayComplex, $weekComplex, $monthComplex, $yearComplex, $value["office_location"]); ?>
                                <td><?php echo $val_maint_cost = $data_maint[0]['sum_maint_cost']; ?></td>                                
                                <td><?php echo $val_total_cost = $val_maint_cost + $val_fuel_cost; ?></td>

                            </tr>
                            <?php
                        }
                   
                    ?>  
                </tbody>
                <tfoot>
                    <tr > 
                        <th >Total</th>
                        <th ></th>
                        <th ></th>                        
                        <th ></th>
                    </tr>
                </tfoot>
            </table>

        </div>  
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {


        //console.log(visiblecols.toString());
        var table = $('#data-table').DataTable({
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export All"
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Export Filtered",
                        oSelectorOpts: {
                            filter: 'applied'
                        }
                    }
                ]
            },
             "footerCallback": function(row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                
                // Total over all pages column 1
                pageTotal1 = api
                        .column(1, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(1).footer()).html(
                        pageTotal1
                        );
                // Total over all pages column 2
                pageTotal2 = api
                        .column(2, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(2).footer()).html(
                        pageTotal2
                        );
                // Total over all pages column 3
                pageTotal3 = api
                        .column(3, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(3).footer()).html(
                        pageTotal3
                        );          
            }

        });


    });
</script>