<div class="col-md-9">

    <h3>Daily Expenditure per CSA</h3>

    <div class="table-responsive">

        <?php if (!empty($expenditure_details)) { ?>

            <form action="<?php echo URL; ?>cdelivery/expenditure/" method="post">

                <!-- <div class="btn-group">
                        <button type="submit" class="btn btn-default" name="edit-expenditure" <?php // if(isset($editable) && $editable==true) { echo 'disabled'; }  ?> >Edit</button>
                        <button type="submit" class="btn btn-default" name="save-expenditure" <?php // if(!isset($editable) || $editable==false) { echo 'disabled'; }  ?> >Save</button>
                </div> -->

                <br>
                <br>

                <table class="table table-striped table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th class="index"></th>
                            <?php
                            foreach ($expenditure_details[0] as $key => $value) {
                                if ($key != 'id') {
                                    echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                }
                            }
                            ?>
                            <th class="export-visible">Total Jerrycans Delivered</th>							
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Totals</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                    <tbody>
    <?php foreach ($expenditure_details as $key => $value) { ?>
                            <tr>
                                <td class="index"></td>
                        <input type="hidden" name="id[]" value="<?php echo $value['id']; ?>">
                        <?php foreach ($value as $key => $value_1) {

                            if ($key != 'id') {
                                ?>

                                <td class="export-visible">
                                    <?php
                                    if (in_array($key, array('csa', 'date', 'total_jerrycans_delivered'))) {

                                        echo $value_1;
                                    } else {

                                        if (isset($editable) && $editable == true) {
                                            if ($key == 'start_date') {
                                                echo '<input type="text" value="' . $value_1 . '" name="' . $key . '[]" class="datepicker"/>';
                                            } else {
                                                echo '<input type="text" value="' . $value_1 . '" name="' . $key . '[]" />';
                                            }
                                        } else {
                                            echo $value_1;
                                        }
                                    }
                                    ?>
                                </td>
                            <?php }
                        }
                        ?>
                        <td class="export-visible"><?php echo ($value['jerrycans_per_delivery'] * $value['total_deliveries_made'] ); ?></td>
                        </tr>

                    <?php
                    }

                    $total_money_received = '';
                    $total_deliveries_made = '';
                    $total_jerrycans_delivered = '';
                    foreach ($expenditure_details as $key => $value) {
                        $total_money_received += $value['total_money_received'];
                        $total_deliveries_made += $value['total_deliveries_made'];
                        $total_jerrycans_delivered += ($value['jerrycans_per_delivery'] * $value['total_deliveries_made']);
                    }
                    ?>


                    </tbody>

                </table>

            </form>

<?php } else { ?>

            <div class="alert alert-info" role="alert">
                No CSAs have been assigned to any waterpoint. <a href="<?php echo URL; ?>cdelivery/waterpoints/" class="alert-link">click Here</a> to assign CSAs
            </div>

<?php } ?>

    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {

        var visiblecols = [];
        $('#data-table thead th').each(function(e) {
            if ($(this).hasClass('export-visible')) {
                visiblecols.push($(this).index());
            }
        });
        //console.log(visiblecols.toString());
        var table = $('#data-table').DataTable({
            scrollY: "100%",
            scrollCollapse: false,
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export All",
                        mColumns: visiblecols
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Export Filtered",
                        oSelectorOpts: {filter: 'applied', order: 'current'},
                        mColumns: visiblecols
                    }
                ]
            },
            columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
            order: [[1, 'asc']],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                
                // Total over all pages column 4
//                total4 = api
//                        .column(4)
//                        .data()
//                        .reduce(function(a, b) {
//                    return intVal(a) + intVal(b);
//                });
                // Total over this page column 5
                pageTotal4 = api
                        .column(4, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Update footer 
                $(api.column(4).footer()).html(
                        pageTotal4 
//                        + ' (' + total4 + ')'
                        );                            
                
                // Total over this page column 5
                pageTotal5 = api
                        .column(5, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Update footer 
                $(api.column(5).footer()).html(
                        pageTotal5 
                        );
               
                // Total over this page column 6
                pageTotal6 = api
                        .column(6, {filter: 'applied', order: 'current'})
                        .data()
                        .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Update footer
                $(api.column(6).footer()).html(
                        pageTotal6 
                        );
            }
        });

    });
</script>