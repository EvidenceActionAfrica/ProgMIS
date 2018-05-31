<!doctype html>
<html lang="en">
<head>
	<?php    
            ob_start();
            
            if(!isset($_SESSION["email"])){
                
                session_start();
            }
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
                // last request was more than 30 minutes ago
                session_unset();     // unset $_SESSION variable for the run-time 
                session_destroy();   // destroy session data in storage
            }
            // echo $_SESSION['email'];
            if (!isset($_SESSION['email'])) {
                header("Location:" . URL . "LoginForm");
                exit();
            }

            $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php
            //The code below is a redirect when after a crud operation  and this variable has been initialised after
        if(isset($redirectURL)=='100'){
            echo '<meta http-equiv="refresh" content="3; url='.$redirectURL.'" />';
        }
        ?>
	<title>Survey Tracker</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo URL; ?>public/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo URL; ?>public/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo URL; ?>public/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo URL; ?>public/assets/css/main.css">
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>public/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo URL; ?>public/assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">

		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="index.html" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="elements.html" class=""><i class="lnr lnr-code"></i> <span>Elements</span></a></li>
						<li><a href="charts.html" class=""><i class="lnr lnr-chart-bars"></i> <span>Charts</span></a></li>
						<li><a href="panels.html" class=""><i class="lnr lnr-cog"></i> <span>Panels</span></a></li>
						<li><a href="notifications.html" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a href="page-profile.html" class="">Profile</a></li>
									<li><a href="page-login.html" class="">Login</a></li>
									<li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
								</ul>
							</div>
						</li>
						<li><a href="tables.html" class="active"><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
						<li><a href="typography.html" class=""><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
						<li><a href="icons.html" class=""><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<?php $lastUrl = $generaldata_model->getLastURL($_SERVER['REQUEST_URI']); ?>
<div class="col-md-10">
    <h3 class=" text-center"><?php echo $tableName;
    if(isset($surveyState)){echo ' - '.$surveyState;} ?></h3>
        <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
                    <?php 
                        echo  $_GET['message'];
                    ?>
                    <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </div>
                <?php } ?>
    <div id="data-table-manger">

        <div class="clearfix">

            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                         <button type="button" id="activateIssue" class="btn btn-default pink-button" data-toggle="modal" data-target="#myuploadModal">Upload <?php echo $tableName; ?></button>                     
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="table-responsive">
        <?php if (!empty($data)) { 
        //print_r($data);
            ?>
   

            <table  id="data-table" class="table table-bordered table-striped table-hover">
                <thead class="index">
                    <tr>
                    <th class="index" >#</th> 
                    <th class="index">Date Added</th>     
                    <th class="index">Survey Name</th>
                    <th class="index">Survey Type</th>
                    <th class="index">Created by</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                   <?php 
                   $n = 0;
                   foreach($data as $dd){ 
                    $n++; ?>
                   <tr style="margin-bottom:10px;">
                    <td class="index"><?=$n?></td>
                    <td class="index"><?=$dd['date_created']?></td>
                    <td class="index"><?=$dd['filename']?></td>
                    <td class="index"><?=$dd['filetype']?></td>
                    <td class="index"><?=$dd['full_name']?></td>
                    <td class="index"><a href="<?php echo URL?>surveytracker/download/<?php echo $dd['filename'];?>"><button>Download</button></td>
                    <td class="index"><a href="<?php echo URL?>surveytracker/delete/<?php echo $dd['id'];?>"><button>Delete</button></td>

                   </tr>
                    <?php } ?>   
                </tbody>    
            </table>

        <?php } else { ?>

            <p><b>No Record Found</b></p>

        <?php } ?>

    </div>
 <<!-- img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>
 -->
</div>

<script type="text/javascript">

function show_confirm(deleteId) {
           console.log("Delete Operation activated");
             if (confirm("Are you sure you want to delete?")) {
                    location.replace('<?php echo URL?>surveytracker/delete/' + deleteId);
                          
              } else {
                 return false;
              }
        }
  <?php if (!empty($data)) { ?>
    $(document).ready(function() {

        

        var table = $('#data-table').DataTable( {
            scrollX: "100%",              
            scrollCollapse: false,           
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export All",
                        mColumns: [1,2,3,4,5,6,7,8,9,10,11]
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Export Filtered",
                        oSelectorOpts: { filter: 'applied', order: 'current' },
                        mColumns: [1,2,3,4,5,6,7,8,9,10,11]
                    }
                ]
            },
            columnDefs: [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            order: [[ 1, 'asc' ]]
        } );

        // Apply the search
        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
            } );
        } );
     
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    });
<?php }?>
</script>


<!-- Modal Upload Survey -->
<div class="modal fade" id="myuploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload a new Survey</h4>
            </div>

            <form enctype="multipart/form-data" action="<?php echo URL; ?>surveytracker/uploadfile/<?php echo $table; ?>"  data-async data-target="myuploadModal" method="post">
                <!-- action="<?php echo URL; ?>issuetracker/add/<?php echo $table; ?>" -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">           
                            <div class="form-group">
                                <label>Upload Survey</label><br/>
                                <input name="uploadedfile" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, .docx , .xlx, ." />
                            </div>                                                                                  
                        </div>
                
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" name="submitfile" class="btn btn-primary" value="Upload File" id="add-sendSms-data">Upload</button>
                                
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

    $('#myuploadModal').on('show.bs.modal', function(e) {

        autoColumn(3, '#myuploadModal .modal-body .row', 'div', 'col-md-2');
        $('#message').html('');

    });
    
    
     function assignId(surveyId){
        var assignedIssue=document.getElementById('assignedIssue');
        assignedIssue.value=surveyId;
        console.log("Survey Id is"+assignedIssue.value);
        }
   $('#disapproval').on('show.bs.modal', function(e) {

        autoColumn(3, '#disapproval .modal-body .row', 'div', 'col-md-4');
        $('#message').html('');
     
    });

   );
    <?php
    if(isset($created_by)){
        echo "window.onload=function(){ var btn=document.getElementById('activateIssue');"
        . "btn.click();"
        . "console.log('Button Called');};";
    }  
    
    
    ?>
  
       function show_confirm(table,deleteId) {
           console.log("Delete Operation activated");
             if (confirm("Are you sure you want to delete?")) {
                    location.replace('<?php echo URL?>surveytracker/delete/'+ table+'/' + deleteId);
                          
              } else {
                 return false;
              }
        }

      
          $("#country").change(function() {
          $.ajax({
        url: "<?php echo URL ?>surveytracker/ajax_call/field_office/office_location/country/"+$("#country").find(":selected").val(),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
        var counter=1;
        
        $("#filename").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#filename").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["filename"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["filename"]);
        if(counter<data.length){
        counter+=1;
    }
    })         
 
        /*
        $(data).each(function(){
        console.log(data[counter-1]["office_location"]);
        counter+=1;
        });
        */
        });
        
           $.ajax({
        url: "<?php echo URL ?>surveytracker/ajax_call/staff_list/full_name/country/"+$("#country").find(":selected").val(),
        beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
        }
        })
        .done(function( data ) {
           data=jQuery.parseJSON(data);
        if ( console && console.log ) {
            
        console.log( "Sample of data:", data.slice( 0, 100 ) );
        }
        var counter=1;
        
        $("#full_name").empty();
        //$("#raised_by").empty();
        
            
            $(data).each(function(){
                
              //We Need To Loop Through the select tag searching for any value matching the json values
           $("#full_name").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["full_name"]+"</option>");    
           //$("#raised_by").append("<option value='"+data[counter-1]["id"]+"'>"+data[counter-1]["full_name"]+"</option>");    
            
            console.log("passed thru");
            console.log(data[counter-1]["full_name"]);
        if(counter<data.length){
        counter+=1;
    }
    })
         
 
        /*
        $(data).each(function(){
        console.log(data[counter-1]["office_location"]);
        counter+=1;
        });
        */
        });     
        
        
        
    });
 
        /*

        });
             
 function fixedEncodeURIComponent (str) {
  return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->

	<script src="<?php echo URL; ?>public/assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo URL; ?>public/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo URL; ?>public/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo URL; ?>public/assets/scripts/klorofil-common.js"></script>
</body>

</html>
