<div class="col-md-9">

    <h3>Archive</h3> 
    <div class="row">
        <form method="POST" action="<?php echo URL . 'cdelivery/archive/'; ?> ">
            <div class="form-group col-md-6" >

                <label> Select An Archive</label>
                <select name="name" class=" input-sm" style="width: 260px" required>
                    <option value=''>None Selected</option>
                    <?php
                    foreach ($archive_table_name as $key => $value) {
                        if (isset($_POST['name']) && $_POST['name'] == $value['name']) {
                            echo '<option value="' . $value['name'] . '" selected>' . str_replace('_', ' ', $value['name']) . '</option>';
                            $table_title = $value['name'];
                        } else {
                            echo '<option value="' . $value['name'] . '">' . str_replace('_', ' ', $value['name']) . '</option>';
                        }
                    }
                    ?>
                </select>

                <input type="submit" class="btn btn-default" name="save" value="Confirm"/>
            </div>
        </form>
    </div>
    <?php if (!empty($data)) { ?>
        <div class="btn-group pull-left">
            <h3><?php echo str_replace('_', ' ', $table_title); ?></h3>
        </div>
        <div class="btn-group pull-right">                
            <a href="<?php echo URL; ?>cdelivery/truncatearchive/<?php echo $table_title; ?>" class="btn btn-default pink-button" >Delete this table</a>
        </div><br><br>
        <table class="table table-striped table-hover" id="data-table">
            <thead>
                <tr>
                    <th class="index"></th>
                    <?php foreach ($data[0] as $key => $value) { ?>
                        <th class="export-visible"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="index"></th>
                    <?php foreach ($data[0] as $key => $value) { ?>
                        <th class="export-visible"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                    <?php } ?>
                </tr>
            </tfoot>
            <tbody>				
                <?php foreach ($data as $key => $value) { ?>
                    <tr>
                        <td class="index"></td>
                        <?php
                        foreach ($value as $key => $value_1) {
                            echo '<td class="export-visible">' . $value_1 . '</td>';
                        }
                        ?>
                    </tr>
                <?php } ?>
            </tbody>		

        </table>

    <?php } else { ?>

        <div class="alert alert-info" role="alert">
            No Achieve has been Selected
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