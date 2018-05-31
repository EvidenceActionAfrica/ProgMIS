<?php include ('header.php');?>
<div class="col-md-9 col-md-offset-2" style=" margin-top: 3%;">
    <div class="row">
        <?php
        if (isset($_GET['message'])) {
            echo '<div  class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert">
  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><span class="text-center" >' . $_GET['message'] . '</span></div>';
        }
        ?>

        <!-- <div class="clearfix"></div> -->
    </div>
    <br />
<div class="contentBody">




        <!--tabbable +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add feedback</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View feedback</a></li>
          </ul>
          <div class="tab-content">
            <!--tab 1 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <?php
              if (isset($_POST['AddFeedback'])) {
                $category = addslashes($_POST['category']);
                $subcategory = addslashes($_POST['subcategory']);
                $description = addslashes($_POST['description']);
                $raisedby = addslashes($_POST['raisedby']);

                //If no Errors Submit Form
                $query = "INSERT INTO feedback (category,subcategory,description,raisedby) 
                  VALUES ('$category','$subcategory','$description','$raisedby')";
                mysql_query($query) or die(mysql_error());
                $messageToUser = "Feedback Added Successfully.";

                $emailBody = "<b>Category : </b>" . $category . "<br/><br/>"
                        . "<b>Sub Category : </b>" . $subcategory . "<br/><br/>"
                        . "<b>Description : </b>" . $description . "<br/><br/>"
                        . "<b>Raised By : </b>" . $raisedby . "<br/><br/>";

                //send Email to client ============================================
                require 'email/class.phpmailer.php';
                try {
                  $mail = new PHPMailer(true); //New instance, with exceptions enabled
                  $mail->IsSendmail();  // tell the class to use Sendmail
                  $mail->AddReplyTo('mail@evidenceaction.org', "Sender");
                  $mail->From = "mail@evidence-action.com"; //$sess_email;
                  $mail->FromName = "DSW PROGMIS";
                  $to = 'leah.ndikuwera@evidenceaction.org';
                  $mail->AddAddress($to);
                  $mail->Subject = "DTW Feedback";
                  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                  $mail->WordWrap = 80; // set word wrap
                  $mail->IsHTML(true);
                  $mail->Body = $emailBody;
                  $mail->AddCC('ramadhan.swalleh@evidenceaction.org', 'Leah Ndikuwera'); //$sess_email, $sess_name
                  //$mail->AddCC('evelyne@xemplar.biz', 'Everlyne Kemunto');
                  $mail->AddBCC('ednah.wenwa@evidenceaction.org');
                  $mail->Send();
                } catch (phpmailerException $e) {
                  echo $e->errorMessage();
                }
              }
              ?>
              <br/>
              <br/>
              <div style="margin: 0px auto; width: 80%">
                Fill in the form below to record any error observed while using the system <br/>
                <!--~submit your feedback / recommendation<br/>-->
              </div>
              <br/>
              <?php include("includes/messageBox.php"); ?>
              <form action="" method="POST">
                <table width="60%" align="center">
                  <!--<b style="text-align: center; font-size: 22px">Add New Feedback</b>-->
                  <tr>
                    <th align="right">Feedback by : </th>
                    <th align="left"><input class="input_textbox_p" type="text" name="raisedby" value="<?php echo $_SESSION['staff_name'] ?>" readonly/></th>
                  </tr>
                  <tr>
                    <th align="right">Category : </th>
                    <th align="left">
                      <select class="input_select_p" name="category">
                        <option value="General">General</option>
                        <option value="Admin Data">Admin Data</option>
                        <option value="Process Data">Process Data</option>
                        <option value="Performance Data">Performance Data</option>
                      </select>
                    </th>
                  </tr>
                  <tr>
                    <th align="right">Sub-Category : </th>
                    <th align="left">
                      <select class="input_select_p" name="subcategory">
                        <option value="Other">Other</option>
                        <option value="">-----------Admin Data--------</option>
                        <option value="ProgramGeography">Program Geography</option>
                        <option value="ContactLists">Contact lists</option>
                        <option value="Waterpoints">Waterpoints</option>
                        <option value="Assets">Asset Lists</option>
                        <option value="FleetInventory">Fleet Inventory</option>
                        <option value="FleetRecords">Fleet Records</option>
                        <option value="FleetReports">Fleet Reports</option>
                        <option value="Chlorine">Chlorine</option>
                        <option value="DispenserParts">Dispenser Parts</option>
                        <option value="">-----------Process Data--------</option>
                        <option value="Drugs">Expansion</option>
                        <option value="ChlorineDelivery">Chlorine Delivery</option>
                        <option value="PromoterEngagement">Promoter Engagement</option>
                        <option value="Finance">Issue Tracker</option>
                        <option value="ContinuosEvaluation">Continuos Evaluation</option>
                        <option value="">-----------Performance Data--------</option>
                        <option value="Standard Reports">Standard Reports</option>
                        <option value="Roll-out">Adoption Rates</option>
                        <option value="Materials">Diarrhea rates</option>
                        <option value="Finance">Waterpoint Map</option>
                        <option value="Finance">Other</option>
                      </select>
                    </th>
                  </tr>
                  <tr>
                    <th align="right">Description : </th>
                    <th align="left">
                      <textarea  cols="40" rows="3" name="description" ></textarea>  
                    </th>
                  </tr>
                  <tr>
                    <th></th>
                    <th align="left">
                      <input type="submit" class="btn-custom-pink" name="AddFeedback"  value="Submit Feedback"/>
                    </th>
                  </tr>
                </table>
              </form>
              <br/>
              <br/>
            </div>
            <!--tab 2 ==================================================================================================-->
            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <br/>
              <center>
                <b style="font-size: 20px; width: 100%; text-align: center">Raised issues/feedback comments</b>
              </center>
              <br/>

              <!--              <div style=" margin-right: 20px">
                              <form method="post">
                                <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
                                  <thead>
                                    <tr style="border: 1px solid #B4B5B0;">
                                      <th align="Left" width="2%">No.</th>
                                      <th align="Left" width="10%">Category</th>
                                      <th align="Left" width="15%">Sub Category</th>
                                      <th align="Left" width="7%">Raised by</th>
                                      <th align="Left" width="30%">Description</th>
                                      <th align="Left" width="5%">Status</th>
                                      <th align="Left" width="15%">Remarks</th>
                                    </tr>
                                  </thead>
                                </table>
                              </form>
                            </div>-->

              <div style="width:100%; height:400px; overflow-x: visible; overflow-y: scroll; ">
                <table width="100%" border="1" frame="box" align="center" cellspacing="1" class="table-hover" id="data-table">
                  <thead>
                    <tr style="border: 1px solid #B4B5B0;">
                      <!--<th align="Left" width="2%">No.</th>-->
                      <th align="Left" width="7%">Raised by</th>
                      <th align="Left" width="10%">Category</th>
                      <th align="Left" width="15%">Sub Category</th>
                      <th align="Left" width="30%">Description</th>
                      <th align="Left" width="5%">Status</th>
                      <th align="Left" width="15%">Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result_set = mysql_query("SELECT * FROM feedback ORDER BY category,subcategory ASC ");
                    while ($row = mysql_fetch_array($result_set)) {
                      $id = $row['id'];
                      $category = $row['category'];
                      $subcategory = $row['subcategory'];
                      $raisedby = $row['raisedby'];
                      $description = $row['description'];
                      $status = $row['status'];
                      $remarks = $row['remarks'];
                      ?>
                      <tr style="border-bottom: 1px solid #B4B5B0;">
                        <!--<td align="left" width="2%"> <?php echo $id; ?>  </td>-->
                        <td align="left" width="7%"> <?php echo $raisedby; ?>  </td> 
                        <td align="left" width="10%"> <?php echo $category; ?>  </td> 
                        <td align="left" width="15%"> <?php echo $subcategory; ?>  </td> 
                        <td align="left" width="30%"> <?php echo $description; ?>  </td> 
                        <td align="left" width="5%"> <?php echo $status; ?>  </td> 
                        <td align="left" width="15%"> <?php echo $remarks; ?>  </td> 
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <br/>
            </div>
          </div>
        </div>
      </div>
</div>
















