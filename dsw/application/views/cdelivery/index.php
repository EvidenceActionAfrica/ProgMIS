<div class="col-md-9">
    <?php if ($track != 'track') { ?>
        <h3>Delivery Details</h3>
    <?php } else { ?>
        <h3>Tracking</h3> 
    <?php } ?>

    <?php if (!empty($programs)) { ?>

        <table class="table table-striped table-hover" id="data-table">
            <thead>
                <tr>
                    <th class="index"></th>
                    <?php foreach ($programs[0] as $key => $value) { ?>
                        <th class="export-visible"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                    <?php } ?>
                    <th class="buttons"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="index"></th>
                    <?php foreach ($programs[0] as $key => $value) { ?>
                        <th class="export-visible"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                    <?php } ?>
                    <th class="buttons"></th>
                </tr>
            </tfoot>
            <tbody>				
                <?php foreach ($programs as $key => $value) { ?>
                    <tr>
                        <td class="index"></td>
                        <?php
                        foreach ($value as $key => $value_1) {
                            echo '<td class="export-visible">' . $value_1 . '</td>';
                        }
                        ?>
                        <?php if ($track != 'track') { ?>
                            <td class="buttons"><a href="<?php echo URL; ?>cdelivery/editdelivery/<?php echo $value['program']; ?>" class="btn btn-default btn-sm">Edit</a></td>
                        <?php } else { ?>
                            <td class="buttons"><a href="<?php echo URL; ?>cdelivery/waterpoints/<?php echo $value['program']; ?>" class="btn btn-default btn-sm">Track</a></td>
                        <?php } ?>

                    </tr>
                <?php } ?>
            </tbody>		

        </table>

    <?php } else { ?>

        <div class="alert alert-info" role="alert">
            No Programs have been found in the database
        </div>

    <?php } ?>

    <script type="text/javascript">
        $(document).ready(function() {

            // Setup - add a text input to each footer cell
            $('#data-table tfoot th').each(function() {
                var title = $('#data-table thead th').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });


            var visiblecols = [];
            $('#data-table thead th').each(function(e) {
                if ($(this).hasClass('export-visible')) {
                    visiblecols.push($(this).index());
                }
            });
            //console.log(visiblecols.toString());
            var table = $('#data-table').DataTable({
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
                order: [[1, 'asc']]
            });

            // Apply the search
            table.columns().eq(0).each(function(colIdx) {
                $('input', table.column(colIdx).footer()).on('keyup change', function() {
                    table
                            .column(colIdx)
                            .search(this.value)
                            .draw();
                });
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

        });
    </script>

</div>