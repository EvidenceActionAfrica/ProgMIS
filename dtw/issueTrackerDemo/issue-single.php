<?php
  require_once ('includes/auth.php');
  require_once ('../includes/config.php');
  require_once ("../includes/functions.php");
  require_once ("../includes/form_functions.php");
  require_once ("../includes/function_convert_number_to_words.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>  
    <link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">   
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
  </head>

  <body>

    <!-- header start -->
    <div class="header clearfix">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php");
        ?>
      </div>
    </div>

    <!-- content body -->
    <div class="contentMain clearFix">

      <!-- <div class="contentLeft"><?php //require_once("includes/menuLeftBar-Settings.php"); ?></div> -->
      
      <div class="container">

        <h1 style="text-align: center; margin-top: 0px">Issue Tracking</h1>
        <div class="row">
          
          <div class="col-md-2">

            <h4>Issue Categories</h4>
            
            <ul class="nav nav-pills nav-stacked">
              <li><a href="#">Inadequate Drugs</a></li>
              <li><a href="#">Funds Disbursment</a></li>
              <li><a href="#">Forms Returns</a></li>
            </ul>

          </div>
          
          <div class="col-md-9">    

            <div class="clearfix">            

              <ul class="nav nav-pills pull-left">
                <li><a href="index.php">Map View</a></li>
                <li><a href="list.php">List View</a></li>
              </ul>
              
              <a href="new-issue.php" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Raise New Issue</a>

            </div>
            <br>

            <div id="issue-thread">

              <div class="clearfix">

                <ul class="list-unstyled list-inline pull-right">
                  <li><button class="btn btn-default"><span class="glyphicon glyphicon-arrow-up"></span> Escalate Issue</button></li>         
                  <li><button class="btn btn-default"><span class="glyphicon glyphicon-ok-sign"></span> Mark Resolved</button></li>         
 
                </ul>

              </div>
              
              <ul class="cbp_tmtimeline">
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-10 18:30"><span>4/10/13</span> <span>18:30</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h4>Ricebean Pea</h4>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia .</p>
                    </div>
                </li>
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-11T12:04"><span>4/11/13</span> <span>12:04</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h2>Greens Arugula</h2>
                        <p>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</p>
                    </div>
                </li>
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-13 05:36"><span>5/13/13</span> <span>05:36</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h2>Sprout Kohlrabi</h2>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
                    </div>
                </li>
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-13 05:36"><span>5/13/13</span> <span>05:36</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h2>Sprout Kohlrabi</h2>
                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus</p>
                    </div>
                </li>
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-13 05:36"><span>6/13/13</span> <span>05:36</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h2>Sprout Kohlrabi</h2>
                        <p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint.</p>
                    </div>
                </li>
                <li>
                    <time class="cbp_tmtime" datetime="2013-04-13 05:36"><span>7/13/13</span> <span>05:36</span></time>
                    <div class="cbp_tmicon"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="cbp_tmlabel">
                        <h2>Sprout kohlrabi</h2>
                        <p>molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repella.</p>
                    </div>
                </li>
                <li>
                    <div class="cbp_tmlabel">
                      <form>
                        <div class="form-group">
                          <textarea class="form-control" rows="7"></textarea>
                        </div>
                        <button class="btn btn-default" type="submit" >send</button>
                      </form>
                    </div>
                </li>
            </ul>
              
            </div>



          </div>



      </div><!--end of content body -->

    </div><!--end of content Main -->

    <!--jQuery Include-->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

    <!--Bootstrap3 Js Include-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>