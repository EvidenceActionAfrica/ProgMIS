<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$tabActive = "tab5";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="css/default.css" type="text/css" rel="stylesheet">
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

              <?php
              if (isset($_POST)) {

                $payeeName = isset($_POST["payeeName"]) ? mysql_real_escape_string($_POST["payeeName"]) : "";
                $memo = isset($_POST["memo"]) ? mysql_real_escape_string($_POST["memo"]) : "";
                $project = isset($_POST["project"]) ? mysql_real_escape_string($_POST["project"]) : "";
                $amountWords = isset($_POST["amountWords"]) ? mysql_real_escape_string($_POST["amountWords"]) : "";
                $preparedBy = isset($_POST["preparedBy"]) ? mysql_real_escape_string($_POST["preparedBy"]) : "";
                $approvedBy = isset($_POST["approvedBy"]) ? mysql_real_escape_string($_POST["approvedBy"]) : "";
                $donor = isset($_POST["donor"]) ? mysql_real_escape_string($_POST["donor"]) : "";

                $cmdSave = isset($_POST["saveRecord"]) ? $_POST["saveRecord"] : "";
                if ($cmdSave) {
                  $sql = "INSERT INTO `fin_budget_crrte`(`payee_name`, `amount_words`, `memo`, `project`, `donor`, `prepared_by`, `approved_by`)";
                  $sql.="VALUES ('$payeeName','$amountWords','$memo','$project','$donor','$preparedBy','$approvedBy')";

                  mysql_query($sql) or die(mysql_error());
                }
              }
              if (isset($_GET["deleteid"])) {
                $tabActive = 'tab2';
                $id = $_GET["deleteid"];
                $sql = "DELETE from fin_budget_crrte where id='$id'";
                mysql_query($sql);
              }
              if (isset($_GET["id"])) {
                $tabActive = 'tab2';
              }
              if (isset($_POST["updateAccounts"])) {

                $tabActive = 'tab2';
              }
              ?>

              <style>
                tr{
                  height:10px;
                }
              </style>


              <div class="tabbable" >
                <ul class="nav nav-tabs">
                  <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Section 1: Add CHEQUE request Form</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab2') echo 'active'; ?>" href="#tab2" data-toggle="tab">Section 2:Filled By Accounts</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab3') echo 'active'; ?>" href="#tab3" data-toggle="tab">Section 3:Delivery Confirmation</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab4') echo 'active'; ?>" href="#tab4" data-toggle="tab">View</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab4') echo 'active'; ?>" href="#tab5" data-toggle="tab">View</a></li>      
                </ul>

                <div class="tab-content" >
                  <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
                    <h2>CHEQUE REQUEST FORM</h2>
                    <form method="POST">

                      <table>
                        <thead>
                          <tr>
                            <td >Payee Name<td colspan="6">
                                <select name="payeeName">
                                  <option value="KEPI/MOH/Bomet District">KEPI/MOH/Bomet District</option>
                                  <option value="Bomet District KNEC Account">Bomet District KNEC Account</option>
                                  <option value="Bomet District KNEC Account">Bomet District KNEC Account</option>



                                </select>

                              </td>
                          </tr>
                          <tr>
                            <td>Memo:<td colspan="6"><input type="text" name="memo" value="" /></td></td>
                          </tr>
                          <tr>
                            <td>Project(Class):<td colspan="6"><input type="text" name="project" value="" /></td></td>
                          </tr>
                          <tr>
                            <td>Donor:<td colspan="6"><input type="text" name="donor" value="" /></td></td>
                          </tr>
                          <tr>
                            <td>Amount in Words:<td colspan="6"><input type="text" name="amountWords" value="" /></td></td>
                          </tr>
                          <tr>
                            <td>Prepared By<td colspan="6">
                                <select name="preparedBy" placeholder="Prepared By">
                                  <option selected="selected"></option>
                                  <?php
                                  $sql = "select staff_name from staff";
                                  $results = mysql_query($sql);
                                  while ($row = mysql_fetch_array($results)) {
                                    echo "<option value='" . $row["staff_name"] . "'>" . $row["staff_name"] . "</option>";
                                  }
                                  ?>
                                </select>
                              </td></td>
                          </tr>
                          <tr>
                            <td>Approved By<td colspan="6">
                                <select name="approvedBy">
                                  <option selected="selected"></option>

                                  <?php
                                  $sql = "select staff_name from staff";
                                  $results = mysql_query($sql);
                                  while ($row = mysql_fetch_array($results)) {
                                    echo "<option value='" . $row["staff_name"] . "'>" . $row["staff_name"] . "</option>";
                                  }
                                  ?>
                                </select>
                              </td></td>
                          </tr>
                        </thead>
                      </table><br/><br/>
                      <input type="submit" name="saveRecord" class="btn btn-info" value="Save Record" />
                    </form>
                  </div>
                  <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
                    <h2>Accounts Office</h2>
                    <table style="width:45%; overflow-x: visible; overflow-y: scroll; float: left"width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <thead>
                        <tr style="border: 1px solid #B4B5B0;">
                          <th align="Left" width="40px">Payee Name</th>

                          <th align="Left" width="40px">Amount in Words</th>
                          <th align="Left" width="40px">Donor</th>
                          <th align="Left" width="40px">Prepared By</th>

                          <th align="Left" width="40px">Approved By</th>

                          <th align="center" width="40px">View</th>
                          <th align="center" width="40px">Del</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        //A table of the cheque requests
                        $sql = "select * from fin_budget_crrte";
                        $result = mysql_query($sql);
                        while ($row = mysql_fetch_array($result)) {

                          $payeeName = $row["payee_name"];
                          $memo = $row["memo"];
                          $project = $row["project"];
                          $amountWords = $row["amount_words"];
                          $preparedBy = $row["prepared_by"];
                          $approvedBy = $row["approved_by"];
                          $donor = $row["donor"];

                          $id = $row["id"];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">
                            <td align="left" width="40px"> <?php echo $payeeName; ?>  </td>

                            <td align="left" width="40px"> <?php echo $amountWords; ?> </td>
                            <td align="left" width="40px"> <?php echo $donor; ?>  </td>
                            <td align="left" width="40px"> <?php echo $preparedBy; ?> </td>
                            <td align="left" width="40px"> <?php echo $approvedBy; ?> </td>

                            <td align="center" width="40px"><a href="CRRTEform.php?id=<?php echo $id; ?> " ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <!--
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                      ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                            !-->
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                          </tr>
                        </tbody>
                      <?php } ?>
                      <?php
                      if (isset($_GET["id"])) {
                        $id = $_GET["id"];
                        $sql = "select * from fin_budget_crrte where id='$id' AND accounts_verified_by !=''";

                        $results = mysql_query($sql);
                        while ($row = mysql_fetch_array($results)) {
                          $payeeName = $row["payee_name"];
                          $memo = $row["memo"];
                          $project = $row["project"];
                          $amountWords = $row["amount_words"];
                          $preparedBy = $row["prepared_by"];
                          $approvedBy = $row["approved_by"];
                          $donor = $row["donor"];
                          $acc_number = $row['bank_account'];
                          $category = $row['category'];
                          $invoice = $row['invoice'];
                          $chequeNumber = $row['cheque_number'];
                          $accounts_final_approval = $row['accounts_final_approval'];
                          $verifiedBy = $row['accounts_verified_by'];
                        }
                      }
                      if (isset($_POST["updateAccounts"])) {

                        $payeeName = isset($_POST["payeeName"]) ? mysql_real_escape_string($_POST["payeeName"]) : "";
                        $memo = isset($_POST["memo"]) ? mysql_real_escape_string($_POST["memo"]) : "";
                        $project = isset($_POST["project"]) ? mysql_real_escape_string($_POST["project"]) : "";
                        $amountWords = isset($_POST["amountWords"]) ? mysql_real_escape_string($_POST["amountWords"]) : "";
                        $preparedBy = isset($_POST["preparedBy"]) ? mysql_real_escape_string($_POST["preparedBy"]) : "";
                        $approvedBy = isset($_POST["approvedBy"]) ? mysql_real_escape_string($_POST["approvedBy"]) : "";
                        $acc_number = isset($_POST['acc_number']) ? mysql_real_escape_string($_POST['acc_number']) : "";
                        $category = isset($_POST['category']) ? mysql_real_escape_string($_POST['category']) : "";
                        $invoice = isset($_POST['invoice']) ? mysql_real_escape_string($_POST['invoice']) : "";
                        $chequeNumber = isset($_POST['chequeNumber']) ? mysql_real_escape_string($_POST['chequeNumber']) : "";
                        $accounts_final_approval = isset($_POST['accounts_final_approval']) ? mysql_real_escape_string($_POST['accounts_final_approval']) : "";
                        $verifiedBy = isset($_POST['verifiedBy']) ? mysql_real_escape_string($_POST['verifiedBy']) : "";


                        $id = isset($_POST['id']) ? $_POST['id'] : "";
                        $sql = "UPDATE `fin_budget_crrte` SET `payee_name`='$payeeName',`amount_words`='$amountWords',`memo`='$memo',`project`='$project',`donor`='$donor',`prepared_by`='$preparedBy',`approved_by`='$approvedBy',`category`='$category',`invoice`='$invoice',`cheque_number`='$chequeNumber',`bank_account`='$acc_number',`accounts_final_approval`='$accounts_final_approval',`accounts_verified_by`='$verifiedBy' WHERE id='$id'";
                        //  echo $sql;
                        mysql_query($sql) or die(mysql_error());
                      }
                      ?>
                    </table>

                    <form method="post">
                      <table style="margin-left:55%;">
                        <thead>
                          <tr>
                            <td colspan="6">Payee Name</td><td colspan="6">

                              <select name="payeeName">
                                <option selected="selected" value="<?php echo $payeeName; ?>"><?php echo $payeeName; ?></option>
                                <option value="KEPI/MOH/Bomet District">KEPI/MOH/Bomet District</option>
                                <option value="Bomet District KNEC Account">Bomet District KNEC Account</option>
                                <option value="Bomet District KNEC Account">Bomet District KNEC Account</option>



                              </select>
                          </tr>
                          <tr>
                            <td colspan="6">Memo:</td><td colspan="6"><input type="text" name="memo" value="<?php echo $memo; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">Project(Class):</td><td colspan="6"><input type="text" name="project" value="<?php echo $project; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">Donor:</td><td colspan="6"><input type="text" name="donor" value="<?php echo $donor; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">Amount in Words:</td><td colspan="6"><input type="text" name="amountWords" value="<?php echo $amountWords; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">Prepared By</td><td colspan="6">
                              <select name="preparedBy" placeholder="Prepared By">
                                <option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $preparedBy; ?></option>

                                <?php
                                $sql = "select staff_name from staff";
                                $results = mysql_query($sql);
                                while ($row = mysql_fetch_array($results)) {
                                  echo "<option>" . $row["staff_name"] . "</option>";
                                }
                                ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6">Approved By</td><td colspan="6">
                              <select name="approvedBy">
                                <option selected="selected" value="<?php echo $preparedBy; ?>"><?php echo $approvedBy; ?></option>

                                <?php
                                $sql = "select staff_name from staff";
                                $results = mysql_query($sql);
                                while ($row = mysql_fetch_array($results)) {
                                  echo "<option>" . $row["staff_name"] . "</option>";
                                }
                                ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td><h2> To Be Filled By Accounts Office</h2></td>
                          </tr>
                          <tr>
                            <td colspan="6">category:</td><td colspan="6"><input type="text" name="category" value="<?php echo $category; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">invoice:</td><td colspan="6"><input type="text" name="invoice" value="<?php echo $invoice; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">Bank Account Number:</td><td colspan="6"><input type="text" name="acc_number" value="<?php echo $acc_number; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">cheque number:</td><td colspan="6"><input type="text" name="chequeNumber" value="<?php echo $chequeNumber; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">final approval by:</td><td colspan="6"><input type="text" name="accounts_final_approval" value="<?php echo $accounts_final_approval; ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="6"> verified by:</td><td colspan="6"><input type="text" name="verifiedBy" value="<?php echo $verifiedBy; ?>" /></td>
                          </tr>
                          <tr>
                            <td>
                              <br/><br/>
                              <input style="margin-left:50%" type="submit" class="btn btn-info" name="updateAccounts" value="Save Details" />
                              <input type="hidden" name="id" value="<?php echo $id; ?>" />

                            </td>
                          </tr>
                        </thead>
                      </table>

                    </form>


                  </div>

                  <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
                    <h2>Accounts Office</h2>
                    <table style="width:45%; overflow-x: visible; overflow-y: scroll; float: left"width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover">
                      <thead>
                        <tr style="border: 1px solid #B4B5B0;">
                          <th align="Left" width="40px">Payee Name</th>

                          <th align="Left" width="40px">Amount in Words</th>
                          <th align="Left" width="40px">Donor</th>
                          <th align="Left" width="40px">Prepared By</th>

                          <th align="Left" width="40px">Approved By</th>

                          <th align="center" width="40px">View</th>
                          <th align="center" width="40px">Del</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        //A table of the cheque requests
                        $sql = "select * from fin_budget_crrte";
                        $result = mysql_query($sql);
                        while ($row = mysql_fetch_array($result)) {

                          $payeeName = $row["payee_name"];
                          $memo = $row["memo"];
                          $project = $row["project"];
                          $amountWords = $row["amount_words"];
                          $preparedBy = $row["prepared_by"];
                          $approvedBy = $row["approved_by"];
                          $donor = $row["donor"];

                          $id = $row["id"];
                          ?>
                          <tr style="border-bottom: 1px solid #B4B5B0;">
                            <td align="left" width="40px"> <?php echo $payeeName; ?>  </td>

                            <td align="left" width="40px"> <?php echo $amountWords; ?> </td>
                            <td align="left" width="40px"> <?php echo $donor; ?>  </td>
                            <td align="left" width="40px"> <?php echo $preparedBy; ?> </td>
                            <td align="left" width="40px"> <?php echo $approvedBy; ?> </td>

                            <td align="center" width="40px"><a href="CRRTEform.php?id=<?php echo $id; ?> #openModal" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <!--
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick="loadRecordN('load',<?php //echo $deliveryNoteId;                     ?>);" ><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                            !-->
                            <td align="center" width="40px"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                          </tr>
                        </tbody>
                      <?php } ?>
                    </table>
                  </div>

                  <!--printing form tab-->
                  <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
                    <?php
                    if (isset($_POST['save'])) {
                      $firstname = 'firstname';
                      //$secondname = mysql_prep($_POST['secondname']);

                      //Generate booking order pdf =======================
                      date_default_timezone_set("Africa/Nairobi");
                      $currentDate = date('Y-m-d');
                      $printDetails = '
  <table width="100%" align="center" cellpadding="-5" cellspacing="0" border="">
    <tr><td> 
      <u><b style="font-size: 22px; color: #002a80;">BOOKING ORDER</b></u>
    </td></tr>
  </table>
<font style="font-size:13px">
  <h4 style="font-size:19px; color: #002a80;">CLIENT PERSONAL DETAILS </h4><br/><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">First Name : </td><td width="200px" border="1"> ' . $firstname . '</td>
      <td align="right" width="120px">Second Name : </td><td width="200px" border="1"> ' . $secondname . '</td>
    </tr>
    <tr>
      <td align="right">Phone Number : </td><td border="1"> ' . $phonenumber . '</td>
      <td align="right">Client code : </td><td border="1"> ' . $clientcode . '</td>
    </tr>
    <tr>
      <td align="right">Address : </td><td border="1"> ' . $address . '</td>
      <td align="right">Job Type : </td><td border="1"> ' . $jobtype . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Move Rep : </td><td border="1"> ' . $moverep . '</td>
    </tr>
    <tr>
      <td align="right">Email address : </td><td border="1"> ' . $emailclient . '</td>
      <td align="right">Volume CBM : </td><td border="1"> ' . $volumecbm . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Start time : </td><td border="1"> ' . $starttime . '</td>
    </tr>
    <tr>
      <td align="right">Duration : </td><td border="1"> ' . $duration . '</td>
      <td align="right">Vehicles needed : </td><td border="1"> ' . $vehiclesneeded . '</td>
    </tr>
    <tr>
      <td align="right">Client Status : </td><td border="1"> ' . $clienttype . '</td>
      <td align="right"></td><td ></td>
    </tr>
  </table>
  <br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px"><b>Important notes : </b></td>
      <td border="1" width="520px"> ' . str_replace('\r\n', "<br/>", $importantnotes) . '</td>
    </tr>
    <tr>
      <td align="right"><b>Origin : </b></td>
      <td border="1"> ' . $originArea . ',' . $originRoad . ',' . $originStreet1 . ',' . $originStreet2 . ',' . $originCompoundName . ',' . $originHouseNo . ',' . $originLandmarks . '</td>
    </tr>
    <tr>
      <td align="right"><b>Destination : </b></td>
      <td border="1"> ' . $destArea . ',' . $destRoad . ',' . $destStreet1 . ',' . $destStreet2 . ',' . $destCompoundName . ',' . $destHouseNo . ',' . $destLandmarks . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">MATERIALS </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="130px"><b>C/BOXES L  : </b> New :</td><td width="190px" border="1"> ' . $cboxeslnew . '</td>
      <td align="right" width="130px">Used : </td><td width="190px" border="1"> ' . $cboxeslused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES S : </b> New : </td><td border="1"> ' . $cboxessnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxessused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES W  : </b> New : </td><td border="1"> ' . $cboxeswnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxeswused . '</td>
    </tr>
    <tr>
      <td align="right">White Paper : </td><td border="1"> ' . $whitepaper . '</td>
      <td align="right">Corrugated : </td><td border="1"> ' . $corrugated . '</td>
    </tr>
    <tr>
      <td align="right">Packing Tapes : </td><td border="1"> ' . $packingtapes . '</td>
      <td align="right">Silica gel : </td><td border="1"> ' . $silicagel . '</td>
    </tr>
    <tr>
      <td align="right">Foam : </td><td border="1"> ' . $foam . '</td>
      <td align="right">Shredded Paper : </td><td border="1"> ' . $shreddedpaper . '</td>
    </tr>
    <tr>
      <td align="right">Plastic Boxes : </td><td border="1"> ' . $plasticboxes . '</td>
      <td align="right">Sisal Twine : </td><td border="1"> ' . $sisaltwine . '</td>
    </tr>
    <tr>
      <td align="right">Bubble Wrap : </td><td border="1"> ' . $bubblewrap . '</td>
      <td align="right">Gunny Bags : </td><td border="1"> ' . $gunnybags . '</td>
    </tr>
    <tr>
      <td align="right">Dish/Glass Carrier: </td><td border="1"> ' . $dishglasscarrier . '</td>
      <td align="right">OTHERS : </td><td border="1"> ' . $othermaterials . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">LABOUR & COSTING </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">Movers :     </td><td width="93px" border="1"> ' . $movers . '</td>
      <td align="right" width="120px">Material Charges : </td><td width="93px" border="1"> ' . $totalMaterials . '</td>
      <td align="right" width="120px">Crating Charges : </td><td width="93px" border="1"> ' . $totalCrating . '</td>
    </tr>
    <tr>
      <td align="right">Carpenters : </td><td border="1"> ' . $carpenters . '</td>
      <td align="right">Large Safe No.  : </td><td border="1"> ' . $largesafeUnit . '</td>
      <td align="right">Instant Showers: </td><td border="1"> ' . $instantshowerUnit . '</td>
    </tr>
    <tr>
      <td align="right">Electricians : </td><td border="1"> ' . $electricians . '</td>
      <td align="right">Piano Upright No.: </td><td border="1"> ' . $uprightUnit . '</td>
      <td align="right">Storage : </td><td border="1"> ' . $storagetype . '</td>
    </tr>
    <tr>
      <td align="right">Total Labourers : </td><td border="1"> ' . $totallabourers . '</td>
      <td align="right">Piano (Grand) No. : </td><td border="1"> ' . $grandpianoUnit . '</td>
      <td align="right">DSTV type : </td><td border="1"> ' . $dstvtype . '</td> 
    </tr>
    <tr>
      <td align="right"><b> </b></td><td > </td>
      <td align="right">Pictures : </td><td border="1"> ' . $picturesUnit . '</td>
      <td align="right"><b>TOTAL COST : </b></td><td border="1"> <b>' . number_format($totalbill) . '</b></td>
    </tr>
  </table>
  <br/><br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="1">
    <tr>
      <td align="left" width="320px"><h4 style="color: #002a80"> HARD ISSUES</h4></td>
      <td align="left" width="320px"><h4 style="color: #002a80"> SOFT ISSUES</h4></td>
    </tr>
    <tr>
      <td height="80px"> ' . str_replace('\r\n', "<br/>", $hardissues) . '</td>
      <td height="100px"> ' . str_replace('\r\n', "<br/>", $softissues) . '</td>

    </tr>
  </table>
</font>
                  ';

                      $pdf_name = generatePDF_quotation($moveid, $firstname, $printDetails);
                      $pdf_name_relative_path = 'pdf/bookingOrders/' . $pdf_name;


                      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                      <font align='justify' size='3px'><br/> Booking Order PDF generated</font><br/><br/>
                       <center><a href='pdf/bookingOrders/$pdf_name' target='_blank' class='btn btn-warning' style='color:black'> Download quotation PDF</a></center>
                      <br/><br/>
                    </div><br/>
                    <center><a href='bookingOrder2-print.php' class='art-button'> View other B.O.s</a></center>
                    <br/><br/><br/>
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                    ";

                      $formsubmited = true;
                    }
                    ?>
                    <div style="width: 80%; border: 1px solid black;">
                      <!-- Cheque Number -->
                      <div style="float: right" >
                        <b style="font-size: 20px">Number : </b>
                        <b style="font-size: 20px">873545 </b>
                      </div>
                      <div style="clear: both"></div>

                      <center>
                        <!-- logo image -->
                        <img src="../images/logo.png" height="60px" align="center"/>
                        <div style="clear: both"></div>

                        <!-- title -->
                        <b style="font-size: 22px; text-align: center">Cheque Request Form</b><br/>
                        <b style="font-size: 20px; text-align: center">District Training-MoE    Generic</b>


                      </center>
                      <p style="font-size: 10px">
                        Instructions: Managers (LAO, PM, PC/PA, etc.) requesting payment by cheque to a supplier, collaborator, or other payee should fill out Section 1 of this form. Project payments must be approved by the project PC/PA and non-project-specific payments approved by the CD, DCD or OM in Section 1 before submitting this to the Accounts Office. The Accounts Office then gets final approval from the CD, DCD or OM for all cheque requests and verifies all requests.
                      </p>

                      <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 1:  To be filled by the manager requesting payment by cheque</b></td>
                        </tr>
                        <tr>
                          <td width="150px"><b>Payee Name : </b></td>
                          <td>ojr gfsdf</td>
                          <td><i style="font-size: 10px; color: #636363">Exactly as it should appear on the cheque</i></td>
                        </tr>
                        <tr>
                          <td><b>Project (Class) : </b></td>
                          <td>DtW Train</td>
                          <td><i style="font-size: 10px; color: #636363">Include sub-class if relevant</i></td>
                        </tr>
                        <tr height="200px"> </tr>
                        <tr>
                          <td><b>Donor : </b></td>
                          <td>CIF002</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                        <tr>
                          <td><b>Memo : </b></td>
                          <td>District Training Budget MoE</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                        <tr>
                          <td><b>Memo : </b></td>
                          <td>District Training Budget MoE</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                          <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">Project PC/PA to approve for project requests. DCD, OM, CD to approve for non-project-specific requests.</i></td>
                        </tr>
                      </table>
                      <br/>
                      <br/>
                      <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 2:  To be filled by the manager requesting payment by cheque</b></td>
                        </tr>
                        <tr>
                          <td><b>Category: </b></td>
                          <td>ojr gfsdf</td>
                          <td>Invoice #:<i style="font-size: 10px; color: #636363"></i></td>
                        </tr>
                        <tr>
                          <td><b>Cheque Number : </b></td>
                          
                          <td><i style="font-size: 10px; color: #636363"></i></td>
                        
                          <td><b>Bank A/C : </b><i style="font-size: 10px; color: #636363"></i></td>
                          
                        </tr>
                        <tr>
                          <td><b>Final Approved By:</b></td>
                          <td><b>Signature</b></td>
                          <td><b>Date: &nbsp;&nbsp; <?php echo date("d-m-Y"); ?></b></td>
                        </tr>
                        <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">All payments by cheque require final approval by the DCD, CD, OM</i></td>
                        </tr>
                         <tr>
                          <td><b>Verified By:</b></td>
                          <td><b>Signature</b></td>
                          <td><b>Date: &nbsp;&nbsp;</b></td>
                        </tr>
                          <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">All payments by cheque are verified by the Senior Accountant before disbursement.</i></td>
                        </tr>
                      </table>

                      <br/>
                      <br/>

            <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 3:  Payee, or Cheque deliverer, to sign upon receiving/delivering the cheque If cheque delivered by Securicor, Securicor and the receipt number should be written in the Name space.</b></td>
                        </tr>
                        <tr>
                          <td colspan="2">Name</td>
                          <td>PAYEE &nbsp;/ &nbsp;DELIVERER &nbsp;<i style="font-size: 10px; color: #636363">Circle one</i><td>
                        </tr>
                        <tr>
                          <td colspan="2"><b>Signature</b></td>
                          <td ><b>Date:</b> <span style="margin-left:40%;"><b>Nat'ID NO</b></span></td>
                        </tr>
                        <tr>
                        </tr>
            </table>
                    </div>

                  </div>


            <!--printing form tab-->
                  <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
                
 <?php
                    if (isset($_POST['save'])) {
                      $firstname = 'firstname';
                      //$secondname = mysql_prep($_POST['secondname']);

                      //Generate booking order pdf =======================
                      date_default_timezone_set("Africa/Nairobi");
                      $currentDate = date('Y-m-d');
                      $printDetails = '
  <table width="100%" align="center" cellpadding="-5" cellspacing="0" border="">
    <tr><td> 
      <u><b style="font-size: 22px; color: #002a80;">BOOKING ORDER</b></u>
    </td></tr>
  </table>
<font style="font-size:13px">
  <h4 style="font-size:19px; color: #002a80;">CLIENT PERSONAL DETAILS </h4><br/><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">First Name : </td><td width="200px" border="1"> ' . $firstname . '</td>
      <td align="right" width="120px">Second Name : </td><td width="200px" border="1"> ' . $secondname . '</td>
    </tr>
    <tr>
      <td align="right">Phone Number : </td><td border="1"> ' . $phonenumber . '</td>
      <td align="right">Client code : </td><td border="1"> ' . $clientcode . '</td>
    </tr>
    <tr>
      <td align="right">Address : </td><td border="1"> ' . $address . '</td>
      <td align="right">Job Type : </td><td border="1"> ' . $jobtype . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Move Rep : </td><td border="1"> ' . $moverep . '</td>
    </tr>
    <tr>
      <td align="right">Email address : </td><td border="1"> ' . $emailclient . '</td>
      <td align="right">Volume CBM : </td><td border="1"> ' . $volumecbm . '</td>
    </tr>
    <tr>
      <td align="right">Move date : </td><td border="1"> ' . $proposedmovedate . '</td>
      <td align="right">Start time : </td><td border="1"> ' . $starttime . '</td>
    </tr>
    <tr>
      <td align="right">Duration : </td><td border="1"> ' . $duration . '</td>
      <td align="right">Vehicles needed : </td><td border="1"> ' . $vehiclesneeded . '</td>
    </tr>
    <tr>
      <td align="right">Client Status : </td><td border="1"> ' . $clienttype . '</td>
      <td align="right"></td><td ></td>
    </tr>
  </table>
  <br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px"><b>Important notes : </b></td>
      <td border="1" width="520px"> ' . str_replace('\r\n', "<br/>", $importantnotes) . '</td>
    </tr>
    <tr>
      <td align="right"><b>Origin : </b></td>
      <td border="1"> ' . $originArea . ',' . $originRoad . ',' . $originStreet1 . ',' . $originStreet2 . ',' . $originCompoundName . ',' . $originHouseNo . ',' . $originLandmarks . '</td>
    </tr>
    <tr>
      <td align="right"><b>Destination : </b></td>
      <td border="1"> ' . $destArea . ',' . $destRoad . ',' . $destStreet1 . ',' . $destStreet2 . ',' . $destCompoundName . ',' . $destHouseNo . ',' . $destLandmarks . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">MATERIALS </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="130px"><b>C/BOXES L  : </b> New :</td><td width="190px" border="1"> ' . $cboxeslnew . '</td>
      <td align="right" width="130px">Used : </td><td width="190px" border="1"> ' . $cboxeslused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES S : </b> New : </td><td border="1"> ' . $cboxessnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxessused . '</td>
    </tr>
    <tr>
      <td align="right"><b>C/BOXES W  : </b> New : </td><td border="1"> ' . $cboxeswnew . '</td>
      <td align="right">Used : </td><td border="1"> ' . $cboxeswused . '</td>
    </tr>
    <tr>
      <td align="right">White Paper : </td><td border="1"> ' . $whitepaper . '</td>
      <td align="right">Corrugated : </td><td border="1"> ' . $corrugated . '</td>
    </tr>
    <tr>
      <td align="right">Packing Tapes : </td><td border="1"> ' . $packingtapes . '</td>
      <td align="right">Silica gel : </td><td border="1"> ' . $silicagel . '</td>
    </tr>
    <tr>
      <td align="right">Foam : </td><td border="1"> ' . $foam . '</td>
      <td align="right">Shredded Paper : </td><td border="1"> ' . $shreddedpaper . '</td>
    </tr>
    <tr>
      <td align="right">Plastic Boxes : </td><td border="1"> ' . $plasticboxes . '</td>
      <td align="right">Sisal Twine : </td><td border="1"> ' . $sisaltwine . '</td>
    </tr>
    <tr>
      <td align="right">Bubble Wrap : </td><td border="1"> ' . $bubblewrap . '</td>
      <td align="right">Gunny Bags : </td><td border="1"> ' . $gunnybags . '</td>
    </tr>
    <tr>
      <td align="right">Dish/Glass Carrier: </td><td border="1"> ' . $dishglasscarrier . '</td>
      <td align="right">OTHERS : </td><td border="1"> ' . $othermaterials . '</td>
    </tr>
  </table>
  <br/>

  <h3 style="font-size:18px; color: #002a80">LABOUR & COSTING </h3><hr/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="">
    <tr>
      <td align="right" width="120px">Movers :     </td><td width="93px" border="1"> ' . $movers . '</td>
      <td align="right" width="120px">Material Charges : </td><td width="93px" border="1"> ' . $totalMaterials . '</td>
      <td align="right" width="120px">Crating Charges : </td><td width="93px" border="1"> ' . $totalCrating . '</td>
    </tr>
    <tr>
      <td align="right">Carpenters : </td><td border="1"> ' . $carpenters . '</td>
      <td align="right">Large Safe No.  : </td><td border="1"> ' . $largesafeUnit . '</td>
      <td align="right">Instant Showers: </td><td border="1"> ' . $instantshowerUnit . '</td>
    </tr>
    <tr>
      <td align="right">Electricians : </td><td border="1"> ' . $electricians . '</td>
      <td align="right">Piano Upright No.: </td><td border="1"> ' . $uprightUnit . '</td>
      <td align="right">Storage : </td><td border="1"> ' . $storagetype . '</td>
    </tr>
    <tr>
      <td align="right">Total Labourers : </td><td border="1"> ' . $totallabourers . '</td>
      <td align="right">Piano (Grand) No. : </td><td border="1"> ' . $grandpianoUnit . '</td>
      <td align="right">DSTV type : </td><td border="1"> ' . $dstvtype . '</td> 
    </tr>
    <tr>
      <td align="right"><b> </b></td><td > </td>
      <td align="right">Pictures : </td><td border="1"> ' . $picturesUnit . '</td>
      <td align="right"><b>TOTAL COST : </b></td><td border="1"> <b>' . number_format($totalbill) . '</b></td>
    </tr>
  </table>
  <br/><br/><br/>
  <table width="100%" align="left" cellpadding="0" cellspacing="0" border="1">
    <tr>
      <td align="left" width="320px"><h4 style="color: #002a80"> HARD ISSUES</h4></td>
      <td align="left" width="320px"><h4 style="color: #002a80"> SOFT ISSUES</h4></td>
    </tr>
    <tr>
      <td height="80px"> ' . str_replace('\r\n', "<br/>", $hardissues) . '</td>
      <td height="100px"> ' . str_replace('\r\n', "<br/>", $softissues) . '</td>

    </tr>
  </table>
</font>
                  ';

                      $pdf_name = generatePDF_quotation($moveid, $firstname, $printDetails);
                      $pdf_name_relative_path = 'pdf/bookingOrders/' . $pdf_name;


                      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;border-radius:10px; margin:5px;background-color:#a2ff7e;'>
                      <font align='justify' size='3px'><br/> Booking Order PDF generated</font><br/><br/>
                       <center><a href='pdf/bookingOrders/$pdf_name' target='_blank' class='btn btn-warning' style='color:black'> Download quotation PDF</a></center>
                      <br/><br/>
                    </div><br/>
                    <center><a href='bookingOrder2-print.php' class='art-button'> View other B.O.s</a></center>
                    <br/><br/><br/>
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                    ";

                      $formsubmited = true;
                    }
                    ?>
                    <div style="width: 80%; border: 1px solid black;">
                      <!-- Cheque Number -->
                      <div style="float: right" >
                        <b style="font-size: 20px">Number : </b>
                        <b style="font-size: 20px">873545 </b>
                      </div>
                      <div style="clear: both"></div>

                      <center>
                        <!-- logo image -->
                        <img src="../images/logo.png" height="60px" align="center"/>
                        <div style="clear: both"></div>

                        <!-- title -->
                        <b style="font-size: 22px; text-align: center">Cheque Request Form</b><br/>
                        <b style="font-size: 20px; text-align: center">District Training-MoE   BOMET</b>


                      </center>
                      <p style="font-size: 10px">
                  Instructions: Managers (LAO, PM, PC/PA, etc.) requesting payment by cheque to a supplier,
                   collaborator, or other payee should fill out Section 1 of this form. Project payments must
                    be approved by the project PC/PA and non-project-specific payments approved by the CD, DCD 
                    or OM in Section 1 before submitting this to the Accounts Office. The Accounts Office then
                     gets final approval from the CD, DCD or OM for all cheque requests and verifies all requests.    
                      </p>

                      <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 1:  To be filled by the manager requesting payment by cheque</b></td>
                        </tr>
                        <tr>
                          <td width="150px"><b>Payee Name : </b></td>
                          <td>ojr gfsdf</td>
                          <td><i style="font-size: 10px; color: #636363">Exactly as it should appear on the cheque</i></td>
                        </tr>
                        <tr>
                          <td><b>Project (Class) : </b></td>
                          <td>DtW Train</td>
                          <td><i style="font-size: 10px; color: #636363">Include sub-class if relevant</i></td>
                        </tr>
                        <tr height="200px"> </tr>
                        <tr>
                          <td><b>Donor : </b></td>
                          <td>CIF002</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                        <tr>
                          <td><b>Memo : </b></td>
                          <td>District Training Budget MoE</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                        <tr>
                          <td><b>Memo : </b></td>
                          <td>District Training Budget MoE</td>
                          <td><i style="font-size: 10px; color: #636363">Include  grant if relevant</i></td>
                        </tr>
                            <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">Project PC/PA to approve for project requests. DCD, OM, CD to approve for non-project-specific requests.</i></td>
                        </tr>
                    
                      </table>
                      <br/>
                      <br/>
                      <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 2:  To be filled by the manager requesting payment by cheque</b></td>
                        </tr>
                        <tr>
                          <td><b>Category: </b></td>
                          <td>ojr gfsdf</td>
                          <td>Invoice #:<i style="font-size: 10px; color: #636363"></i></td>
                        </tr>
                        <tr>
                          <td><b>Cheque Number : </b></td>
                          
                          <td><i style="font-size: 10px; color: #636363"></i></td>
                        
                          <td><b>Bank A/C : </b><i style="font-size: 10px; color: #636363"></i></td>
                          
                        </tr>
                        <tr>
                          <td><b>Final Approved By:</b></td>
                          <td><b>Signature</b></td>
                          <td><b>Date: &nbsp;&nbsp; <?php echo date("d-m-Y"); ?></b></td>
                        </tr>
                        <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">All payments by cheque require final approval by the DCD, CD, OM</i></td>
                        </tr>
                         <tr>
                          <td><b>Verified By:</b></td>
                          <td><b>Signature</b></td>
                          <td><b>Date: &nbsp;&nbsp;</b></td>
                        </tr>
                          <tr>
                          <td colspan="3"><i style="font-size: 10px; color: #636363">All payments by cheque are verified by the Senior Accountant before disbursement.</i></td>
                        </tr>
                      </table>
                      <br/>
                      <br/>

            <table frame="border" border="1" width="100%" style="border: 2px solid black">
                        <tr style="background-color: #ccccff">
                          <td colspan="3"><b>SECTION 3:  Payee, or Cheque deliverer, to sign upon receiving/delivering the cheque If cheque delivered by Securicor, Securicor and the receipt number should be written in the Name space.</b></td>
                        </tr>
                        <tr>
                          <td colspan="2">Name</td>
                          <td>PAYEE &nbsp;/ &nbsp;DELIVERER &nbsp;<i style="font-size: 10px; color: #636363">Circle one</i><td>
                        </tr>
                        <tr>
                          <td colspan="2"><b>Signature</b></td>
                          <td ><b>Date:</b> <span style="margin-left:40%;"><b>Nat'ID NO</b></span></td>
                        </tr>
                        <tr>
                        </tr>
            </table>
                    </div>












                </div>



                </div>
              </div>
            </div>
            <script>
                  $(function() {
                    $("#datepicker").datepicker();
                  });

                  function show_confirm(deleteid) {
                    if (confirm("Are you sure you want to delete?")) {
                      location.replace('?deleteid=' + deleteid);
                    } else {
                      return false;
                    }
                  }
                  function postRows() {
                    var rowCount = document.getElementById("rowCount");
                    var addRow = document.getElementById("addRow");
                    addRow.click();
                  }

                //show previous records
                function loadRecordN(req, val) {
                  console.log("the request is " + req + " and the value is" + val);
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
                  xmlhttp.open("GET", "req=" + req + "&val=" + val, true);
                  xmlhttp.send();
                }
            </script>
            <div id="openModal" class="modalDialog">
              <div style="width:80%;margin-top:1%;">
                <?php
                if (isset($_POST["updateConfirm"])) {

                  $receipt = isset($_POST["receipt"]) ? $_POST["receipt"] : "";
                  $idNo = isset($_POST["idNo"]) ? $_POST["idNo"] : "";
                  $date = date("Y-m-d");
                  $confirmedBy = isset($_POST["confirmedBy"]) ? $_POST["confirmedBy"] : "";
                  $id = $_GET["id"];
                  $sql = "UPDATE `fin_budget_crrte` SET `receipt`='$receipt',`national_id`='$idNo',`date`='$date',`confirmedBy`='$confirmedBy' WHERE `id`='$id' ";
                  echo $sql;

                  mysql_query($sql);
                }
                ?>

                <h2>Delivery Confirmation </h2>
                <a href="#close" class="btn btn-danger"style="position:absolute;margin-left:96%;margin-top:-7%;" title="Close" class="close">X</a>
                <form method="POST" style="margin-left:30%;">

                  <label for="receipt">Receipt Number</label><input type="text" name="receipt" value=""/>
                  <label for="idNo">National Id Number</label><input type="text" name="idNo" value=""/>
                  <label for="date">Date</label><input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" readonly/>
                  <label for="confirmedBy">Confirmed By</label>
                  <select name="confirmedBy">
                    <option value="deliverer" selected="selected">Cheque Deliverer</option>
                    <option value="payee">Payee</option>
                  </select>
                  <input type="submit" class="btn btn-info" name="updateConfirm" value="Confirm Details" />
                </form>

              </div>


              
              
              
              
              
              
<?php
//PDF PRINTING
error_reporting(0);

function generatePDF_quotation($moveid, $firstname, $bookingOrderDetails) {
// always load alternative config file for examples
  require_once('../tcpdf/examples/config/tcpdf_config_alt.php');
// Include the main TCPDF library (search the library on the following directories).
  $tcpdf_include_dirs = array(realpath('../tcpdf/tcpdf.php'), '/usr/share/php/tcpdf/tcpdf.php', '/usr/share/tcpdf/tcpdf.php', '/usr/share/php-tcpdf/tcpdf.php', '/var/www/tcpdf/tcpdf.php', '/var/www/html/tcpdf/tcpdf.php', '/usr/local/apache2/htdocs/tcpdf/tcpdf.php');
  foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
    if (@file_exists($tcpdf_include_path)) {
      require_once($tcpdf_include_path);
      break;
    }
  }

//===================================
// Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      $image_file = K_PATH_IMAGES . '../images/logo.jpg';
      // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
      $this->Image($image_file, 50, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // Set font
      $this->SetFont('helvetica', 'B', 20);
      // Title
      // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
      // Logo
      $image_file = K_PATH_IMAGES . 'letterhead-footer.jpg';
      // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
      $this->Image($image_file, 30, 280, 150, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // ... footer for the normal page ...
    }

  }

// create new PDF document
  $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Cube Movers');
  $pdf->SetTitle('Quotation');
  $pdf->SetSubject('Quotation');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT); // left = 2.5 cm, top = 4 cm, right = 2.5cm
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(900);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
  if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
  }

// ---------------------------------------------------------
//// set font
//  $pdf->SetFont('verdana', 'BI', 12);
// add a page
// $pdf->AddPage();
// set some text to print
  $txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// add a page
  $pdf->AddPage();


// create some HTML content
  $html = $bookingOrderDetails;

// get the first array. This will be make part of the name of pdf
  $pdf_name = '_BO.pdf';

// output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
//Close and output PDF document
// anything between ob_start and ob_end_clean will not be returned to ajax success message
  ob_start();

//to save to a directory, just add the path before the name of the pdf.
  $pdf->Output('pdf/' . $pdf_name, 'FD');
//  $pdf->Output('example_006.pdf', 'I');
  ob_end_clean();
//  echo "pdf/" . $pdf_name . $moveid . '.pdf';

  return $pdf_name;
}
?>
