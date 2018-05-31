<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once ("../includes/logTracker.php");

if (isset($_POST["Export"])) {
  $activeModule=intval($_GET['module']);
  $query = "select user_email,user_name,action,description,time_stamp from log_admindata WHERE module=".$activeModule;
  $export = mysqli_query($db_mysqli_connection,$query) or die("Sql error : " . mysqli_error($db_mysqli_connection));
  $fields = mysqli_affected_rows($db_mysqli_connection);

  // for ($i = 0; $i < $fields; $i++) {
  //   $header .= mysql_field_name($export, $i) . "\t";
  // }
  while($rows=mysqli_fetch_field($export)){
    $header.=$rows->name."\t";
  }
  while ($row = mysqli_fetch_row($export)) {
    $line = '';
    foreach ($row as $value) {
      if ((!isset($value) ) || ( $value == "" )) {
        $value = "\t";
      } else {
        $value = str_replace('"', '""', $value);
        $value = '"' . $value . '"' . "\t";
      }
      $line .= $value;
    }
    $data .= trim($line) . "\n";
  }
  $data = str_replace("\r", "", $data);

  if ($data == "") {
    $data = "\nNo Record(s) Found!\n";
  }
  mysqli_free_result($export);
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=exportAdminLogs.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  print "$header\n$data";
}
if(!isset($_GET['module'])){
header("Location:index.php");
}else{
  $M_module=$_GET['module'];
  $sql='SELECT * from log_modules WHERE id='.$M_module;
  $result=mysqli_query($db_mysqli_connection,$sql)or die(mysqli_error($db_mysqli_connection));
  $M_moduleName='';
  while($row=mysqli_fetch_assoc($result)){
      $M_moduleName=$row['module'];
  }
  mysqli_free_result($result);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php
        require_once ("includes/menuNav.php"); 
        ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
       <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
      </div>
      <div class="contentBody">
        <!--================================================--> 
        <form action="#" method="POST">
          <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;"><?php echo $M_moduleName;?> Data Logs</b>
          <!--<a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a>-->

          <input type="submit" class="btn-custom-small" name="Export" value="Export to Excel" />
        </form>
        <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <div style="margin-right: 20px ">
              <table width="100%" border="0" cellspacing="1" class="table-hover" >
                <thead>
                  <tr style="border: 1px solid #B4B5B0;">
                  <th align="Left" width="10%">User </th>
                    <th align="Left" width="10%">User Email</th>
                    <th align="Left" width="20%">Action</th>
                    <th align="Left" width="30%">Description</th>
                    <th align="Left" width="10%">Time Stamp</th>
                  </tr>
                </thead>
              </table>
            </div>

            <div style="width:100%; height:470px; overflow-x: visible; overflow-y: scroll; ">
              <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover" id="data-table">
                <tbody>
                  <?php
                  $sql = "SELECT * FROM log_admindata";
                  if (isset($_POST["search"])) {
                    $search = $_POST["search"];
                    $sql.=" where user_id like'%$search%' or user_name like'%$search%' or user_email like'%$search%' or action like'%$search%' or id like'%$search%' or time_stamp like'%$search%'";
                    $sql.=' AND module='.$M_module;
                  }else{
                    $sql.=' WHERE module='.$M_module;
                  }
                  $sql.=" ORDER BY id DESC ";
                  $result_set = mysqli_query($db_mysqli_connection,$sql);
                  //echo $sql;
                  while ($row = mysqli_fetch_assoc($result_set)) {
                    $id = $row['id'];
                    $user_id = $row['user_id'];
                    $user_Name = $row['user_name'];
                  
                    $user_email = $row["user_email"];
                    $action = $row["action"];
                    $description = $row["description"];
                    $time_stamp = $row["time_stamp"];
                    ?>
                    <tr style="border-bottom: 1px solid #B4B5B0;">
                      <td align="left" width="10%"><?php
                        echo substr($user_Name, 0, 15);
                        if (strlen($user_Name) > 15)
                          echo "...";
                        ?>
                      </td>
                      <td align="left" width="10%"><?php
                        echo substr($user_email, 0, 15);
                        if (strlen($user_email) > 15)
                          echo "...";
                        ?>
                      </td>
                      <td align="left" width="20%"> <?php echo $action; ?>  </td> 
                      <td align="left" width="30%"> <?php echo $description; ?>  </td>
                      <td align="left" width="10%"> <b><?php echo $time_stamp; ?></b>  </td>
                    </tr>
                  </tbody>
                <?php }
                  mysqli_free_result($result_set);
                 ?>
              </table>
            </div>
          </form>
        </div>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
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

<?php
mysqli_close($db_mysqli_connection);
?>

