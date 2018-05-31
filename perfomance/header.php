<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        ob_start();

        if (!isset($_SESSION["email"])) {

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

        <title>Evidence Action:DSW</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->    
        <link href="../dsw/public/css/bootstrap.min.css" rel="stylesheet">
        <link href="../dsw/public/css/bootstrap-responsive.min.css" rel="stylesheet"> 
        <link href="../dsw/public/css/font-awesome.min.css" rel="stylesheet">
        <link href="../dsw/public/css/style.css" rel="stylesheet">
        <link href="../dsw/public/css/jquery.dataTables.css" rel="stylesheet">
        <link href="../dsw/public/css/jquery-ui.min.css" rel="stylesheet">
        <link href="../dsw/public/css/jquery.timepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="modal.css">        

        <!-- jQuery -->
        <script type="text/javascript" src="../dsw/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="../dsw/public/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../dsw/public/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../dsw/public/js/javascript.js"></script>
        <script type="text/javascript" src="../dsw/public/js/custom.js"></script>
        <script type="text/javascript" src="../dsw/public/js/validation.js"></script>

        <script type="text/javascript" src="../dsw/public/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../dsw/public/js/jquery.timepicker.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/superTables.css" rel="stylesheet" type="text/css" />

        <style>
            .content{
                color:#3276B1;
                font-style: italic;
            }
            .plus{
                color:#ffffff;
                background-color:#3276B1;
                padding: 4px;                
                border-radius: 2px;
                font-weight: normal;
                cursor: pointer;
            }
        </style>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../dsw/public/js/html5shiv.js"></script>
          <script src="../dsw/public/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

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
                        <a class="navbar-brand" href="../dsw/adminData/"><img id="mainlogo" src="../dsw/public/img/logo.png"></a>
                    </div>    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div id="mainmenu" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav border-right">
                            <li><a href="../dsw/home">HOME</a></li> 
                            <li><a href="../dsw/adminData">ADMIN DATA</a></li>
                            <li><a href="../dsw/processdata">PROCESS DATA</a></li>
                            <li><a href="view_adop.php">PERFORMANCE DATA</a></li>
                            <li><a href="../dsw/issuetracker/issues">ISSUE TRACKER</a></li>
                            <li><a href="../dsw/feedback"</a>FEEDBACK</li>
                        </ul>
                        <ul class="nav navbar-nav " id="loginInfo">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" ></span> <?php echo $_SESSION['full_name'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a style="color:rgb(0,0,0);" >DSW:<?php echo $_SESSION['countryName']; ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="../dsw/issuetracker/issues" style="color:rgb(255,0,0);">Pending <span class="badge pull-right"><?php echo $_SESSION['issueNo']; ?></span></a></li>
                                    <li class="divider"></li>
                                    <li><a href="../dsw/LoginForm/logout">Logout <span class="glyphicon glyphicon-off pull-right"></span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>
            <!--==============================Code for setting the country number===========================-->
            <?php
            require_once ('includes/config.php');
            $logged_in_name = $_SESSION["email"];
            $country_val = strtolower($_SESSION['countryName']);
            $column_priv = 'priv_fleet_list_' . $country_val;
            $query_priv = "SELECT $column_priv FROM staff_list WHERE email = '$logged_in_name'";
            $result_priv = mysqli_query($mysqli, $query_priv) or die(mysql_error($mysqli));
            $row_priv = mysqli_fetch_assoc($result_priv);
            $priv = $row_priv[$column_priv];
            $country_val = $_SESSION['country'];
            ?>
        </header>

        <div class="container"> <!--closed in footer-->
