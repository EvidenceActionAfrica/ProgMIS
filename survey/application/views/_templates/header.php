<!DOCTYPE html>
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
        <title>Evidence Action:DSW</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->    
        <link href="<?php echo URL; ?>public/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/css/bootstrap-responsive.min.css" rel="stylesheet"> 
        <link href="<?php echo URL; ?>public/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/css/jquery.dataTables.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/css/dataTables.tableTools.min.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/css/jquery-ui.min.css" rel="stylesheet">
        <!-- jQuery -->
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui.min.js"></script>

        <script type="text/javascript" src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/dataTables.tableTools.min.js"></script>
        
        <script type="text/javascript" src="<?php echo URL; ?>public/js/javascript.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/validation.js"></script>


        <!-- Maurice Added code for survey trucker -->
        <script type="text/javascript" src="<?php echo URL; ?>public/new/js/footable.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/new/js/footable.min.js"></script>

        <link href="<?php echo URL; ?>public/new/css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL; ?>public/new/css/footable.bootstrap.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="<?php echo URL; ?>public/js/html5shiv.js"></script>
          <script src="<?php echo URL; ?>public/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body onLoad="document.getElementById('imgLoading').style.visibility = 'hidden';">

        <header>
            <?php $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo URL; ?>adminData/"><img id="mainlogo" src="<?php echo URL; ?>public/img/logo.png"></a>
                    </div>    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div id="mainmenu" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav border-right">
                            <li><a href="<?php echo URL; ?>home">HOME</a></li> 
                            <li><a href="<?php echo URL; ?>adminData">ADMIN DATA</a></li>
                            <li><a href="<?php echo URL; ?>processdata">PROCESS DATA</a></li>
                            <!-- <li><a href="<?php // echo URL; ?>">PERFORMANCE DATA</a></li> -->
                            <li><a href="<?php echo URL; ?>/../../perfomance/view_adop.php">PERFORMANCE DATA</a></li>
                            <li><a href="<?php echo URL; ?>issuetracker/viewApproved/No/1">ISSUE TRACKER</a></li>
                            
                        </ul>
                        <ul class="nav navbar-nav" id="loginInfo">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" ></span> <?php echo $_SESSION['full_name'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a style="color:rgb(0,0,0);" >DSW:<?php echo $_SESSION['countryName']; ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo URL; ?>issuetracker/issues" style="color:rgb(255,0,0);">Pending <span class="badge pull-right"><?php echo $_SESSION['issueNo']; ?></span></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo URL; ?>LoginForm/logout">Logout <span class="glyphicon glyphicon-off pull-right"></span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>

        </header>
        <div class="content"> <!--closed in footer-->
