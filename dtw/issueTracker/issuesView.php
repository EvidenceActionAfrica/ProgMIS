<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    if (isset($_POST['submitSaveAction'])) {
      $raisedby=isset($_POST["raisedby"])?mysql_real_escape_string($_POST["raisedby"]):"";
      $handledby=isset($_POST["handledby"])?mysql_real_escape_string($_POST["handledby"]):"";
      $actiontaken=isset($_POST["actiontaken"])?mysql_real_escape_string($_POST["actiontaken"]):"";
      $response=isset($_POST["response"])?mysql_real_escape_string($_POST["response"]):"";
      $status=isset($_POST["status"])?mysql_real_escape_string($_POST["status"]):"";
      $issueid=$_GET["id"];
      $sql="INSERT INTO `issues_actions`(`issueid`, `actiontaken`, `staff`,";
      $sql.="`timeframe`, `response`) ";
      $sql.="VALUES ('$issueid','$actiontaken','$handledby','0','$response')";
      mysql_query($sql);
      
      $sql="Update issues set status='$status' WHERE id='$issueid'";
      mysql_query($sql);
      $messageToUser = "Action Taken Saved Successfully!";

      //Log Entry Data
      //$arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
      //funclogAdminData($arrLogAdminData);
    }
?>
    


<div >

          <br/><br/>
          <!--filter box-->
          <form action="#">
              
            <td><input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /></td>
            <b style="margin-left:20%;width: 100px; font-size:1.5em;">All Issues </b>
          </form>
          <br/><br/>
                 <?php include("../includes/messageBox.php"); ?>
          <table style="width:100%; overflow-x: visible; overflow-y: scroll; float: left;" width="100%" border="1" frame="box" align="center" cellspacing="1" class="table-hover">
            <thead>
              <tr style="border: 1px solid #B4B5B0;">
                <th align="Left" width="2%">ID</th>
                <th align="Left" width="4%">When Sent</th>
                <th align="Left" width="12%">County</th>
                <th align="Left" width="12%">District</th>
                <th align="Left" width="12%">IssueType</th>
                <th align="Left" width="12%">Subject</th>
                <th align="Left" width="12%">Description</th>
                <th align="Left" width="12%">Raised By</th>
                <th align="Left" width="12%">Handled By</th>
                <th align="Left" width="10%">Status</th>
                <th colspan="2" align="Left" width="10%">Action Taken</th>
                <th colspan="2" align="Left" width="10%">Communication</th>
                
<!--                    <th align="center" width="10%">View</th>
                <th align="center" width="10%">Del</th>-->
              </tr>
            </thead>
            <tbody>

              <?php
              $sql = "SELECT * FROM issues ORDER BY id DESC";

              $result_set = mysql_query($sql);

              while ($row = mysql_fetch_array($result_set)) {
                $id = $row["id"];
                $timestamp = $row["timestamp"];
                $county = $row["county"];
                $district = $row["district"];
                $issue_category = $row["issue_category"];
                $subject = $row["subject"];
                $description = $row["description"];
                $raisedby = $row["raisedby"];
                $handledby = $row["handledby"];
                $status = $row["status"];
                ?>
                <tr>
                  <td align="left" > <?php echo $id; ?>  </td>
                  <td align="left" > <?php echo $timestamp; ?> </td>
                  <td align="left" > <?php echo $county; ?> </td>
                  <td align="left" > <?php echo $district; ?> </td>
                  <td align="left" > <?php echo $issue_category; ?> </td>
                  <td align="left" > <?php echo $subject; ?> </td>
                  <td align="left" > <?php echo $description; ?>  </td>
                  <td align="left" > <?php echo $raisedby; ?>  </td>
                  <td align="left" > <?php echo $handledby; ?>  </td>
                  <td align="center"> <?php echo $status; ?> </td>
                  <!--===-->
                  <form method="POST" action="#openModalActions">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <td align="center"><input type="submit" name="viewActions" value="View Actions" /></td>
                  </form> 
            <td><a href="issuesAll.php?id=<?php echo $id; ?>#openModalAddAction"/>Take Action</a></td>
                   
                  <td align="center"><a href="?id=<?php echo $id; ?>#openModal" >Send SMS</a></td>
                  <td align="center"><a href="?id=<?php echo $id; ?>#openModal2" >Send Email</a></td>
                </tr>
              </tbody>
            <?php } ?>
          </table>

        </div>
 

