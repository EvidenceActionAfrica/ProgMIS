
<div class="col-md-10">
  <?php if (isset($_GET['message'])) { ?>
    <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
      <?php echo $_GET['message']; ?>
      <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
    </div>
  <?php } ?>

  <div id="data-table-manger">

    <div class="clearfix">
      <h3 class="pull-left"><?php echo $tableName; ?></h3>

      <div class="btn-group pull-right">
        <div class="btn-group pad-top-15">
          <!-- <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add</button> -->

          <button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal">Import Details</button>

          <button type="button" class="btn btn-default pink-button" data-toggle="modal" data-target="#myModal">Add <?php echo $tableName; ?></button>


        </div>
      </div>
    </div>
    <hr>
  </div>

  <div class="table-responsive">
    <?php if (!empty($data)) { ?>

      <table id="data-table" class="table table-striped table-hover">
        <thead>
          <tr>
            <th></th>
            <?php
            foreach ($data[0] as $key => $value) {
              if ($key == 'position' && $table != "staff_category") {
                continue;
              }
              if (!in_array($key, $arrayName = array('id'))) {

                if ($key == "country" || $key == "Country") {
                  continue;
                } else {
                  echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                }
              }
            }
            ?>
            <?php if ($table != "staff_list") { ?>
              <th></th>
              <th></th>
            <?php } ?>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <?php
            foreach ($data[0] as $key => $value) {
              if ($key == 'position' && $table != "staff_category") {
                continue;
              }
              if (!in_array($key, $arrayName = array('id'))) {

                if ($key == "country" || $key == "Country") {
                  continue;
                } else {
                  echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                }
              }
            }
            ?>
            <?php if ($table != "staff_list") { ?>
              <th></th>
              <th></th>
            <?php } ?>
          </tr>
        </tfoot>
        <tbody>
          <?php
          $i = 0;
          // echo "<pre>";var_dump($data);echo "</pre>";
          foreach ($data as $key => $value) {
            ?>
            <tr>
              <td></td>
              <?php
              foreach ($value as $key => $value) {
                // echo "<pre>";var_dump($key);echo "</pre>";         
                if ($key == 'position' && $table != "staff_category") {
                  continue;
                }
                if ($i == 1) {
                  $generalId = $value;
                }
                if (!in_array($key, $arrayName = array('id'))) {

                  if ($key == "country" || $key == "Country") {
                    continue;
                  } else {
                    echo '<td>' . $value . '</td>';
                  }
                }
                // $i = 0;	
              }
              // $i = 1;
              ?>

              <td><a href="<?php echo URL ?>fleetclass/update/<?php echo $table . "/" . $data[$i]['id']; ?>"><button class="btn btn-success btn-xs">Edit</button></a></td> 
              <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->
              <!-- <td><a href="<?php echo URL ?>generalclass/delete/<?php echo $table . "/" . $data[$i]['id']; ?>" class="btn btn-default">Delete</a></td> -->
              <td><a onclick="show_confirm('<?php echo $table ?>', <?php echo $data[$i]['id']; ?>);"><button class="btn btn-danger btn-xs">Delete</button></a></td>    							

            </tr>
            <?php
            $i++;
          }
          ?>					
        </tbody>

      </table>

    <?php } else { ?>

      <p><b>No Record Found</b></p>

    <?php } ?>

  </div>

</div>
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

              var table = $('#data-table').DataTable({
                scrollY: false,
                scrollX: true,
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
                      oSelectorOpts: {
                        page: 'current'
                      },
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo "Add " . $tableName . ""; ?></h4>
      </div>
      <form  action="<?php echo URL; ?>fleetclass/add/<?php echo $table; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
        <div class="modal-body">
          <div id="message"></div>
          <div class="row">
            <div class="col-md-12">



          <div class="form-group">
             <label>Reg No</label><br>
              <select id="reg_no" name="reg_no" class="form-control input-sm" required >
             <?php
             foreach ($regNo as $key => $value) {
              echo '<option value="'.$value['id'].'">'.$value['reg_no'].'</option>';
             }
            
             ?>
           </select>
         
          </div>
          <div class="form-group">
             <label>Odometer Current Reading</label><br>
             <input type="text" id="odometer_current_reading" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Duration Start</label><br>
             <input type="text" id="Duration Start" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Fuel Quantity</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Odometer Previous Reading</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Date Refilled</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Fuel Cost</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Service Date</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Oil Lubricant Total Cost</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Oil Lubricant Quality</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Oil Lubricant Quality</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>
          <div class="form-group">
             <label>Oil Lubricant Quality</label><br>
             <input type="text" id="ee" name="ee" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id=""></span>
          </div>


 
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button  type="submit" class="btn btn-primary" name="add-fleet-data" id="add-fleet-data">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>  



<!-- Modal -->
<div class="modal fade" id="myImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
      </div>
      <form  action="<?php echo URL; ?>fleetclass/import/<?php echo $table . '/'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
        <div class="modal-body">
          <div id="message"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                Select File to upload:
                <input type="file" name="file" id="file" />
              </div>
              <div class="form-group">
                <input type="submit" value="Upload" name="update-verification"/>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button  type="submit" class="btn btn-primary" name="add-general-data" id="add-general-data">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>  


<script type="text/javascript">
  $('#myModal').on('show.bs.modal', function(e) {

    autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
    $('#message').html('');

  });

  function show_confirm(tables, deleteId) {
    if (confirm("Are you sure you want to delete?")) {
      location.replace('<?php echo URL ?>fleetclass/delete/' + tables + '/' + deleteId);

    } else {
      console.log('<?php echo URL ?>fleetclass/delete/' + tables + '/' + deleteId);
      return false;
    }
  }

  $('form').validate();

  // $('#myModal').on('click','#add-admin-data', function(event) {

  //     var $form = $('#myModal form');
  //     var $target = $($form.attr('data-target'));

  //     $.ajax({
  //         type: $form.attr('method'),
  //         url: $form.attr('action'),
  //         data: $form.serialize(),

  //         success: function(data, status) {
  //         	if ( status == 'success') {
  //             	$('#message').html('<p class="bg-success"><span class="glyphicon glyphicon-ok-circle" ></span> Data Successfully Added</p>');
  //             	$('#myModal form').get(0).reset();
  //         	} else {
  //             	$('#message').html('<p class="bg-danger"><span class="glyphicon glyphicon-remove-circle" ></span> Error Adding Data</p>');
  //         	}
  //         }
  //     });

  //     event.preventDefault();
  // });


</script>