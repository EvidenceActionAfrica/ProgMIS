<!doctype html>
<html class="no-js" lang="en">
<?php $lastUrl = $generaldata_model->getLastURL($_SERVER['REQUEST_URI']); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!-- Mirrored from uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2017 07:37:23 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Evidence Action - Survey Tracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/font-awesome.min.css">
    <!-- adminpro icon CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/adminpro-custon-icon.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/meanmenu.min.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/jquery.mCustomScrollbar.min.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/animate.css">
    <!-- data-table CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/data-table/bootstrap-editable.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/normalize.css">
    <!-- charts C3 CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/c3.min.css">
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/form/all-type-forms.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body class="materialdesign">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- Header top area start-->
    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <a href="#"><img src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/img/message/" alt="" />
                    </a>
                    <h3>Survey Tracker</h3>
                    <p></p>
                    <strong>AP+</strong>
                </div>
                <div class="left-custom-menu-adp-wrap">
                    <ul class="nav navbar-nav left-sidebar-menu-pro">
                        <li class="nav-item">
                            <a href="<?php echo URL; ?>Surveytracker/tracker" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"> <span class="mini-dn">Surveys</span> <span class="indicator-right-menu mini-dn"></span></a>
                           
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL; ?>Surveytracker/msexcel" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="mini-dn">Survey Types</span> <span class="indicator-right-menu mini-dn"></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                
                                <a href="<?php echo URL; ?>Surveytracker/msexcel" class="dropdown-item">Excel</a>
                                <a href="<?php echo URL; ?>Surveytracker/msword" class="dropdown-item">Word</a>
                                
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"> <span class="mini-dn">Category</span> <span class="indicator-right-menu mini-dn"></span></a>
                            <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                
                                <a href="<?php echo URL; ?>Surveytracker/dsw" class="dropdown-item">DSW</a>
                                <a href="<?php echo URL; ?>Surveytracker/dtw" class="dropdown-item">DTW</a>
                                <a href="<?php echo URL; ?>Surveytracker/beta" class="dropdown-item">BETA</a>
                                <a href="<?php echo URL; ?>Surveytracker/others" class="dropdown-item">OTHERS</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL; ?>Surveytracker/msword" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">Trash Bin</a>
                           
                        </li>
                        
                        
                    </ul>
                </div>
            </nav>
        </div>
        <div class="content-inner-all">
            <div class="header-top-area">
                <div class="fixed-header-top">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-1 col-md-6 col-sm-6 col-xs-12">
                                <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <div class="admin-logo logo-wrap-pro">
                                    <a href="#"><img src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/img/logo/log.png" alt="" />
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-1 col-sm-1 col-xs-12">
                                <div class="header-top-menu tabl-d-n">
                                    <ul class="nav navbar-nav mai-top-nav">
                                        <li class="nav-item"><a href="#" class="nav-link">Home</a>
                                        </li>
                                        <li class="nav-item"><a href="#" class="nav-link">Admin Data</a>
                                        </li>
                                        <li class="nav-item"><a href="#" class="nav-link">Performance Data</a>
                                        </li>
                                        
                                        <li class="nav-item"><a href="#" class="nav-link">Issue Tracker</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                <div class="header-right-info">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                        
                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                
                                                <span class="admin-name">My Account</span>
                                                <span class="author-project-icon adminpro-icon adminpro-down-arrow"></span>
                                            </a>
                                            <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated flipInX">
                                                <li><a href="#"><span class="adminpro-icon adminpro-home-admin author-log-ic"></span>My Account</a>
                                                </li>
                                                <li><a href="#"><span class="adminpro-icon adminpro-user-rounded author-log-ic"></span>My Profile</a>
                                                </li>
                                                <li><a href="#"><span class="adminpro-icon adminpro-settings author-log-ic"></span>Settings</a>
                                                </li>
                                                <li><a href="#"><span class="adminpro-icon adminpro-locked author-log-ic"></span>Log Out</a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header top area end-->
            <!-- Breadcome start-->
            <div class="breadcome-area mg-b-30 small-dn">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                                <div class="row">
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        
                                       <div class="btn-group pull-right">
                                        <div class="btn-group pad-top-15">
                                                 <button type="button" id="activateIssue" class="btn btn-default pink-button" data-toggle="modal" data-target="#myuploadModal">Upload New Survey</button>                     
                                        </div>
                                    </div>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcome End-->
            <!-- Mobile Menu start -->
           <!--  <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <li><a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                            <ul class="collapse dropdown-header-top">
                                                <li><a href="dashboard.html">Dashboard v.1</a>
                                                </li>
                                                <li><a href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/dashboard-2.html">Dashboard v.2</a>
                                                </li>
                                                <li><a href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/analytics.html">Analytics</a>
                                                </li>
                                                <li><a href="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/widgets.html">Widgets</a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                       
                                        
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Mobile Menu end -->
            <!-- Breadcome start-->
            <div class="breadcome-area des-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="breadcome-heading">
                                            <form role="search" class="">
												<input type="text" placeholder="Search..." class="form-control">
												<a href="#"><i class="fa fa-search"></i></a>
											</form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Dashboard</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcome End-->
            
            <!-- Data table area Start-->
            <div class="admin-dashone-data-table-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline8-list shadow-reset">
                                <div class="sparkline8-hd">
                                    <div class="main-sparkline8-hd">
                                        <h1>Uploaded Surveys</h1>
                                        <div class="sparkline8-outline-icon">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="sparkline8-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                      
                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                            <thead>
                                                <tr>
                                                   
                                                    <th data-field="state" data-checkbox="true"></th>
                                                    <th data-field="id">ID</th>
                                                    <th data-field="cntry">Country</th>
                                                    <th data-field="name" data-editable="true">Survey Name</th>
                                                    <th data-field="email" data-editable="true">Survey Type</th>
                                                    <th data-field="phone" data-editable="true">Survey Category</th>
                                                    <th data-field="" data-editable="true">Sub-Category</th>
                                                    <th data-field="company" data-editable="true">Owner</th>
                                                    <th data-field="date" data-editable="true">Upload Date</th>
                                                    <th></th>
                                                    <th></th>
                                                    
                                                    
                                                    <!-- <th data-field="action">Action</th> -->
                                                </tr>
                                            </thead>
                                           
                                            <tbody>
                                                <?php 
                                                   $n = 0;
                                                   foreach($data as $dd){ 

                                                    $n++; ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?=$n?></td>
                                                   <!-- Determining the Country of the survey  -->
                                                    <td><?php
                                                    $string = preg_replace('/^[^_]*_\s*/', '', $dd['filename']);
                                                    $char = substr($string, 0, 1);
                                                    if ($char == 'K') {
                                                        $cntry = 'Kenya';
                                                        echo "Kenya";
                                                    }
                                                    elseif ($char == 'U') {
                                                        $cntry = 'Uganda';
                                                        echo "Uganda";
                                                    }
                                                    elseif ($char == 'M') {
                                                        $cntry = 'Malawi';
                                                        echo "Malawi";
                                                    }
                                                    else {
                                                        $cntry = 'Other';
                                                        echo "Other";
                                                    } 

                                                    ?></td>

                                                    <td ><?=preg_replace('/^[^_]*_\s*/', '', $dd['filename']);?></td>
                                                    <td><?=$dd['filetype']?></td>
                                                    <td><?=$dd['category']?></td>
                                                    <td><?=$dd['subcategory']?></td>
                                                    <td><?=$dd['full_name']?></td>
                                                    <td><?=$dd['date_created']?></td>
                                                    <td ><a href="<?php echo URL?>surveytracker/download/<?php echo $dd['filename'];?>"><button>Download</button></td>
                                                    <td ><a href="<?php echo URL?>surveytracker/delete/<?php echo $dd['id'];?>"><button>Delete</button></td>
                                                    
                                                </tr>
                                                 <?php } ?>   
                                            

                                            </tbody>
                                        </table>

         
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Data table area End-->
        </div>
    </div>
    <!-- Footer Start-->
    <div class="footer-copyright-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copy-right">
                        <p>Copyright &#169; 2017 <a href="http://uttaraitpark.com/">uttaraitpark</a> All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
    

    <!-- Upload Survey Dialog
     -->
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

    <!-- jquery
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/bootstrap.min.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/jquery.meanmenu.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/jquery.scrollUp.min.js"></script>
    

    <!-- data table JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/bootstrap-table.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/tableExport.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/data-table-active.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/bootstrap-table-editable.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/bootstrap-editable.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/colResizable-1.5.source.js"></script>
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/data-table/bootstrap-table-export.js"></script>
    <!-- main JS
		============================================ -->
    <script src="http://uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/js/main.js"></script>

 
</body>


<!-- Mirrored from uttaraitpark.com/adminpro-preview/adminpro/material-design-leftsidebar-dark/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 03 Nov 2017 07:37:23 GMT -->
</html>
