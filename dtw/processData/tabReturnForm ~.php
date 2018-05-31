<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive = "tab1";
$level = $_SESSION['level'];
$testdata = 'testdata';
if (isset($_POST["editForm"])) {
  $tabActive = "tab2";
}
if (isset($_GET['deleteid'])) {
  $tabActive = "tab2";
}
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_tab_return= $row['priv_tab_return'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" type="text/css" href="css/modal.css"/>
      <?php require_once ("includes/meta-link-script.php"); ?>
      <script src="../js/tabs.js"></script>
      <script type="text/javascript" src="css/bootstrap/js/bootstrap-tab.js"></script>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>


    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Drugs.php"); ?>
      </div>
      <div class="contentBody" >	


        <!--tab skeleton-->
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Return Form</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Return Form</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">

              <?php
              $divpho_representative = isset($_POST["divpho_representative"]) ? mysql_real_escape_string($_POST["divpho_representative"]) : "";
              $district = isset($_POST["district"]) ? mysql_real_escape_string($_POST["district"]) : "";
              $phone_number = isset($_POST["phone_number"]) ? mysql_real_escape_string($_POST["phone_number"]) : "";
              $email = isset($_POST["email"]) ? mysql_real_escape_string($_POST["email"]) : "";

              $division = isset($_POST["division"]) ? mysql_real_escape_string($_POST["division"]) : "";
              $signedDate = isset($_POST["signedDate"]) ? mysql_real_escape_string($_POST["signedDate"]) : "";
              $albendazole = isset($_POST["albendazole"]) ? mysql_real_escape_string($_POST["albendazole"]) : "";
              $prazinqutel = isset($_POST["prazinqutel"]) ? mysql_real_escape_string($_POST["prazinqutel"]) : "";
              $aeo = isset($_POST["aeo"]) ? mysql_real_escape_string($_POST["aeo"]) : "";



              if (isset($_POST['submitSaveNew'])) {
                $query = "INSERT INTO `drugs_tab_return_form`( `div_pho_representative`, `district_name`, `div_pho_phone_number`, `email`, `division_name`, `date_of_receipt`, `albendazole_returned_tablets`, `prazinqutel_returned_tablets`, `aeo`) VALUES ('$divpho_representative','$district','$phone_number','$email','$division','$signedDate','$albendazole','$prazinqutel','$aeo')";
                // echo $query;
                mysql_query($query) or die(mysql_error());
              }

              if (isset($_POST["editForm"])) {
                $tabActive = "tab2";
                $id = $_GET["viewId"];
                $query = "UPDATE `drugs_tab_return_form` SET `div_pho_representative`='$divpho_representative',`district_name`='$district',`div_pho_phone_number`='$phone_number',`email`='$email',`division_name`='$division',`date_of_receipt`='$signedDate',`albendazole_returned_tablets`='$albendazole',`prazinqutel_returned_tablets`='$prazinqutel',`aeo`='$aeo' WHERE return_form_id='$id'";
                //echo $query;
                mysql_query($query) or die(mysql_error());

                $divpho_representative = "";
                $district = "";
                $phone_number = "";
                $email = "";

                $division = "";
                $signedDate = "";
                $albendazole = "";
                $prazinqutel = "";
                $aeo = "";
              }
              ?>


              <h1 style="text-align: center; margin-top: 0px; font-size: 22px">Tab Return Form</h1>
              <!--<h1 class="form-title">Delivery Note</h1>-->
              <!-- table begin  =============-->


              <form method="post" style="width: 80%; margin: 0 auto">


                <table border="0" frame="box"  align="center" cellpadding="0" style="width: 60%; border: 1px so">
                  <thead>
                    <tr style="background-color: silver;">
                        <td colspan="6" style="padding: 5px;" align="center"><b>Contact Details</b></td>
                    </tr>
                    <tr style="height:30px;">
                      <td align="right">Name of DivPHO/ Representative</td>
                      <td><input style="width: 200px"  type="text" name="divpho_representative" class="input_textbox_p compact" value="<?php echo $divpho_representative; ?>"/></td>

                    </tr>
                    <tr style="height:30px;">
                      <td align="right">District</td>
                      <td >
                        <select name="district"  class="input_select_p compact">
                          <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
<?php
$sql = "SELECT * FROM districts ORDER BY district_name ASC";
$result = mysql_query($sql);
while ($rows = mysql_fetch_array($result)) { //loop table rows
  ?>
                            <option value="<?php echo $rows['district_name']; ?>"<?php
                            if ($district == $rows['district_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['district_name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr style="height:30px;">
                      <td align="right">Division</td>
                      <td>
                        <select name="division"  class="input_select_p compact">
                          <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
<?php
$sql = "SELECT * FROM divisions ORDER BY district_name ASC";
$result = mysql_query($sql);
while ($rows = mysql_fetch_array($result)) { //loop table rows
  ?>
                            <option value="<?php echo $rows['district_name']; ?>"<?php
                            if ($district == $rows['district_name']) {
                              echo 'selected';
                            }
                            ?>><?php echo $rows['district_name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr style="height:30px;">
                        <td  width="50%"align="right">DivPHO Phone Number</td><td><input   style="width: 200px" type="text" name="phone_number" class="input_textbox_p compact" value="<?php echo $phone_number; ?>"/></td>
                    </tr><tr style="height:30px;"> <td align="right">Email</td><td><input type="text" name="email" style="width: 200px"  class="input_textbox_p compact" value="<?php echo $email; ?>"/></td>
                    </tr>
                 

                    <tr style="background-color: silver;">
                      <td colspan="6" style="padding: 5px;" align="center"><b>Tablet Details</b></td>
                    </tr>
                    <tr style="height:30px;">
                      <td align="right">Date of receipt of remaining tablets</td>
                      <td><input style="width: 200px"  type="text" name="signedDate" id="datepicker" class="input_textbox_p compact" value="<?php echo $signedDate; ?>"/></td>
                    </tr>
                    <tr style="height:30px;">
                      <td align="right">Albendazole returned tablets</td>
                      <td><input type="text" name="albendazole" class="input_textbox_p compact" style="width: 200px" value="<?php echo $albendazole; ?>"/></td>
                    </tr>
                      <tr style="height:30px;">
                      <td align="right">Prazinqutel returned tablets</td>
                      <td><input type="text" name="prazinqutel" class="input_textbox_p compact"  style="width: 200px" value="<?php echo $prazinqutel; ?>"/></td>
                    </tr>
                 


                    <tr style="background-color: silver;">
                      <td colspan="6" style="padding: 5px;"align="center"><b>Health Sector receipt confirmation and assumption of responsibility</b></td>
                    </tr>
                      

                    <tr style="height:30px;">
                        <td align="right">AEO</td><td><input type="text" name="aeo" style="width: 200px" class="input_textbox_p compact"  value="<?php echo $aeo; ?>"/></td>
                    </tr>
                      
                      <tr><td align="right"><?php if($priv_tab_return>=2){ ?>
                <input type="submit" name="submitSaveNew" value="Save Form" class="btn-custom-tiny" />
                 <?php } ?></td></tr>
                 
                  </thead>
                </table><br/><br/>
                <div class="vclear"></div>

                <br/>
              </form>

            </div>


            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">


              <!--================================================-->
              <!--   OTHER RECORDS           -->
              <!--================================================-->
<?php
//Delete
if (isset($_GET['deleteid'])) {
  $deleteid = $_GET['deleteid'];
  $tabActive = "tab2";
  $query = "DELETE FROM drugs_tab_return_form WHERE return_form_id='$deleteid'";
  $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
  $tabActive = 'tab2';
}
?>
              <br/><br/>
              <!--filter box-->
              <form action="#">
                <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
                <b style="margin-left:20%;width: 100px; font-size:1.5em;">Previous Tab Return Forms</b>
              </form>
              <br/><br/>

              <form method="post" style=" margin-right: 20px">
                  <table style="width:100%" border="0" align="center" cellspacing="1" class="table-hover" >
                  <thead>
                    <tr style="border: 1px solid #B4B5B0;">
                      <th align="Left" width="10px">DIVPHO</th>
                      <th align="Left" width="10px">Phone Number</th>
                      <th align="Left" width="10px">District</th>
                      <th align="Left" width="10px">Division</th>
                      <th align="Left" width="10px">Albendazole</th>
                      <th align="Left" width="10px">prazinqutel</th>
                      <th align="Left" width="10px">AEO</th>
                    
                      <th align="Left" width="10px">Date</th>
 <?php if($priv_tab_return>=1){ ?>
                      <th align="center" width="5px">View</th>
 <?php } if($priv_tab_return>=4){ ?>
                      <th align="center" width="5px">Del</th>
<?php } ?>
                    </tr>
                  </thead>
                </table>
              </form>



              <table style="width:100%;overflow-x: visible; overflow-y: scroll; float: left" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                <tbody>

<?php
$result_set = mysql_query("SELECT * FROM drugs_tab_return_form  ORDER BY return_form_id DESC");
while ($row = mysql_fetch_array($result_set)) {

  $divpho_representative = $row["div_pho_representative"];
  $district = $row["district_name"];
  $phone_number = $row["div_pho_phone_number"];
  $email = $row["email"];

  $division = $row["division_name"];
  $signedDate = $row["date_of_receipt"];
  $albendazole = $row["albendazole_returned_tablets"];
  $prazinqutel = $row["prazinqutel_returned_tablets"];
  $aeo = $row["aeo"];
  $returnId = $row["return_form_id"];
  ?>
                    <tr style="border-bottom: 1px solid #B4B5B0;">
                      <td align="left" width="10px"> <?php echo $divpho_representative; ?>  </td>
                      <td align="left" width="10px"> <?php echo $phone_number; ?> </td>
                      <td align="left" width="10px"> <?php echo $district; ?>  </td>
                      <td align="left" width="10px"> <?php echo $division; ?>  </td>
                      <td align="left" width="10px"> <?php echo $albendazole; ?>  </td>
                      <td align="left" width="10px"> <?php echo $prazinqutel; ?>  </td>
                      <td align="left" width="10px"> <?php echo $aeo; ?>  </td>
                      <td align="left" width="10px"> <?php echo $signedDate; ?>  </td>

 <?php if($priv_tab_return>=1){ ?>
                      <td align="center" width="5px"><a href="tabReturnForm.php?viewId=<?php echo $returnId; ?> #openModalTabReturn" ><img src="../images/icons/view2.png" height="20px"/></a></td>
  <?php }if($priv_tab_return>=4){ ?>         
                      <td align="center" width="5px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $returnId; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
          <?php } ?>
                    </tr>
                  </tbody>
<?php } ?>
              </table>





              <td style="padding-left: 5px">


                <!--Delete dialog-->
                <script>
                      function show_confirm(deleteid) {
                        if (confirm("Are you sure you want to delete?")) {
                          location.replace('?deleteid=' + deleteid);
                        } else {
                          return false;
                        }
                      }


                      //show previous records
                      function loadRecord(req, val) {
                        if (req == "") {
                          document.getElementById("divShowContent").innerHTML = "";
                          return;
                        }
                        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                          xmlhttp = new XMLHttpRequest();
                        }
                        else {// code for IE6, IE5
                          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function() {
                          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("divDisplayAssumption").innerHTML = xmlhttp.responseText;
                          }
                        }
                        xmlhttp.open("GET", "ajax_files/assumptions.php?req=" + req + "&val=" + val, true);
                        xmlhttp.send();
                      }
                </script>








            </div>

          </div>
        </div>



      </div>
    </div>
<?php
if (isset($_GET["viewId"])) {
  $resultMessage = "";
  if (isset($_POST["updateRecord"])) {
    $resultMessage = "<h2>Record Updated</h2>";
  }
  $search = $_GET["viewId"];

  $sql = "SELECT * FROM drugs_tab_return_form where return_form_id ='$search'";
//echo $sql;                


  $result_set = mysql_query($sql);


  while ($row = mysql_fetch_array($result_set)) {



    $divpho_representative = $row["div_pho_representative"];
    $district = $row["district_name"];
    $phone_number = $row["div_pho_phone_number"];
    $email = $row["email"];

    $division = $row["division_name"];
    $signedDate = $row["date_of_receipt"];
    $albendazole = $row["albendazole_returned_tablets"];
    $prazinqutel = $row["prazinqutel_returned_tablets"];
    $aeo = $row["aeo"];
    ?>
        <!-- Modal includes -->
        <link rel="stylesheet" type="text/css" href="css/modal.css"/>

        <!-- Bootstrap includes -->
        <link href="css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="css/bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap-tab.js"></script>
        <div id="openModalTabReturn" class="modalDialog" style="margin-top:-2%;">

          <div>
            <td style="width: 70%">

              <form method="post" style="width: 80%; margin: 0 auto">

                <tr><a style="margin-left:112%;margin-top:-5%" href="#close" class="btn btn-danger">X</a>
                  <h2 style="text-align:center"> Tab Return Form</h2>
    <?php echo $resultMessage; ?>
                </tr>
                <table border="0" frame="box"  align="center" cellpadding="0" style="width: 90%; border: 1px so">

                  <tr style="background-color: silver;">

                    <td colspan="6" style="padding: 5px;"><b>Contact Details</b></td>
                  </tr>
                  <tr>
                    <td>Name of DivPHO/ Representative</td>
                    <td><input type="text" name="divpho_representative" class="input_textbox_p compact" value="<?php echo $divpho_representative; ?>"/></td>

                  </tr>
                  <tr>
                    <td>District</td>
                    <td>
                      <select name="district"  class="input_select_p compact">
                        <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
    <?php
    $sql = "SELECT * FROM districts ORDER BY district_name ASC";
    $result = mysql_query($sql);
    while ($rows = mysql_fetch_array($result)) { //loop table rows
      ?>
                          <option value="<?php echo $rows['district_name']; ?>"<?php
      if ($district == $rows['district_name']) {
        echo 'selected';
      }
      ?>><?php echo $rows['district_name']; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Division</td>
                    <td>
                      <select name="division"  class="input_select_p compact">
                        <option value=''<?php if ($district == '') echo 'selected'; ?> ></option>
    <?php
    $sql = "SELECT * FROM divisions ORDER BY district_name ASC";
    $result = mysql_query($sql);
    while ($rows = mysql_fetch_array($result)) { //loop table rows
      ?>
                          <option value="<?php echo $rows['district_name']; ?>"<?php
      if ($district == $rows['district_name']) {
        echo 'selected';
      }
      ?>><?php echo $rows['district_name']; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>DivPHO Phone Number</td><td><input type="text" name="phone_number" class="input_textbox_p compact" value="<?php echo $phone_number; ?>"/></td>
                  </tr>
                  <tr>
                    <td>Email</td><td><input type="text" name="email" class="input_textbox_p compact" value="<?php echo $email; ?>"/></td>
                  </tr>
                </table><br/><br/>


                <table class="table-hover" border="0" frame="box"  align="center" cellpadding="0" style="width: 90%; border: 1px so">
                  <tr style="background-color: silver;">
                    <td colspan="6" style="padding: 5px;"><b>Tablet Details</b></td>
                  </tr>
                  <tr>
                    <td align="right">Date of receipt of remaining tablets</td>
                    <td><input type="text" name="signedDate" id="datepicker" class="input_textbox_p compact" value="<?php echo $signedDate; ?>"/></td>
                  </tr>
                  <tr>
                    <td align="right">Albendazole returned tablets</td>
                    <td><input type="text" name="albendazole" class="input_textbox_p compact" style="width: 100px" value="<?php echo $albendazole; ?>"/></td>
                  </tr>
                  <tr>
                    <td align="right">Prazinqutel returned tablets</td>
                    <td><input type="text" name="prazinqutel" class="input_textbox_p compact"  style="width: 100px" value="<?php echo $prazinqutel; ?>"/></td>
                  </tr>
                </table>
                <br/><br/> 


                <table class="table-hover" border="0" frame="box"  align="center" cellpadding="0" style="width: 90%; border: 1px so">
                  <tr style="background-color: silver;">
                    <td colspan="6" style="padding: 5px;"><b>Health Sector receipt confirmation and assumption of responsibility</b></td>
                  </tr>

                  <tr>
                    <td>AEO</td>
                    <td><input type="text" name="aeo" class="input_textbox_p compact"  value="<?php echo $aeo; ?>"/></td>
                  </tr>
                </table><br/><br/>
                <input type="submit" name="editForm" value="Edit Form" class="btn-custom-tiny" style="float: left"/>
                <div class="vclear"></div>

                <br/>
              </form>



          </div>  
        </div>  





    <?php
  }
}
?>




  </body>
</html>

<!--filter includes-->
<script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
<script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
<script type="text/javascript">
  $(function() {
    $('input#id_search').quicksearch('table tbody tr');
  });
</script>

<script >
   document.onkeypress = function(e)  {
    e = e || window.event;
    if (typeof e != 'undefined') {
      var tgt = e.target || e.srcElement;
      if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
        return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
    }
  }
console.log("enter Block workin...");
</script>

