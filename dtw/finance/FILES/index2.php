<?php
  require_once ('includes/auth.php');
  require_once ('../includes/config.php');
  require_once ("../includes/functions.php");
  require_once ("../includes/form_functions.php");
     $crudResult="";//This will be used to display the status of a crud i.e record updated/record added/record deleted
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>  
    <link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">   
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

      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
      </div>
      <?php
      //This is the delete query
      //I have placed it here beacuse of the crudResult display which should be right below this code
          if(isset($_REQUEST['deleteId'])){
            $deleteId=$_REQUEST['deleteId'];

            $sql="DELETE from fin_budget_cat_district where id='$deleteId'";
            mysql_query($sql);
            $crudResult="<h2 style='background:#bada66;color:#FFF;text-align:center'>Record Deleted</h2>";
          }
         
      ?>
      <div class="contentBody">
          <?php echo $crudResult; ?>
        <h1 style="text-align: center; margin-top: 0px">Finance And Budgeting</h1>

        <?php

          date_default_timezone_set('Africa/Nairobi');
          require_once('includes/finance.class.php');

          //Call global $database variable for PDO
          global $database;

          
          //Get requested page view and set default page view if not set
          if (isset($_REQUEST['view'])) {
            $view = $_REQUEST['view'];
          } else {
            $view = 'budget';
          }

          if ($view == 'budget') {

            if (isset($_REQUEST['cat'])) {
              $budget_cat = $_REQUEST['cat'];
            } else {
              $budget_cat = 'district';
            }

            if ($budget_cat = 'district') {

              $budget_category = 2;

              $database->query('SELECT * FROM fin_budget_type WHERE category = :category',
                array(
                  ':category'=> $budget_category
                )
              );
              $budget_types = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Budget</th>
                    <th>District</th>
                    <th>Deworming Wave</th>
                    <th>Budget Total (KSH)</th>
                  </tr>
                </thead>

                <tbody>

                  <?php 

                    foreach ($budget_types as $budget_type) {

                        $database->query('SELECT * FROM rollout_wave_districts');
                        $count = $database->count();

                        if ( $count > 0 ) {

                          $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                              foreach ($results as $key => $value) {

                                $database->query('SELECT * FROM deworming_waves WHERE id = :id',
                                  array(
                                    ':id'=>$value['wave']
                                  )
                                );
                                $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                                $database->query('SELECT SUM(total) AS budget_total FROM fin_budget_cat_district WHERE wave = :wave AND district = :district AND budget_cat = :budget_cat AND budget_type = :budget_type',
                                  array(
                                    ':wave'=>$value['wave'],
                                    ':district' => urldecode($value['district']),
                                    ':budget_cat' => $budget_category,
                                    ':budget_type' => $budget_type['id']

                                  )
                                );
                                $total = $database->statement->fetch(PDO::FETCH_ASSOC);

                                $hyperlink = 'view=budget-single&cat='.$budget_category.'&wave='.$value['wave'].'&type='.urlencode($budget_type['id']).'&loc='.urlencode($value['district']).'';

                                ?> 
                                <tr>

                                  <td><a href="?<?php echo $hyperlink; ?>"><?php echo $budget_type['budget_type']; ?></a></td>
                                  <td><a href="?<?php echo $hyperlink; ?>"><?php echo $value['district'] ;?></a></td>
                                  <td><a href="?<?php echo $hyperlink; ?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                                  <th><a href="?<?php echo $hyperlink; ?>"><?php if ( $total['budget_total'] != NULL ) { echo number_format($total['budget_total']); } else { echo '<small class="muted"><i>Budget Not Prepared</i></small>'; } ?></a></th>
                                 
                                </tr>
                              
                           <?php }

                         } else {

                        echo "<td colspan='4'><h3>No Disrict Budgets Have been Created.</td></h3>";

                      }  

                    } ?>

                </tbody>
              </table>

              <?php

            } 

          } else if ($view == 'budget-single') {

            if (isset($_POST['add-budget-record'])) {
              $crudResult="";
              include('includes/gump.class.php');
              $gump = new GUMP();

              $value = $gump->sanitize($_POST);

              $gump->validation_rules(array(
                  'item-category' => 'required',
                  'item'  => 'required',
                  'accountability-form' => 'required',
                  'units' => 'required',
                  'days' => 'required',
                  'unit-cost' => 'required',
                  'recepient' => 'required'
              ));

              $validated_data = $gump->run($value);

              if($validated_data === false) {
                echo $errors = $gump->get_readable_errors(true);     
              } else {
                $financeClass->addDistrictBudgetRecord($validated_data);
              $crudResult="<h2 style='background:#bada66;color:#FFF;text-align:center'>Budget Record Added</h2>";
        

              }

            } ?>

            <div id="budget-form-container">

              <h3>Add A Budget Record</h3>

              <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">
                <input type="text" name="location" value="<?php echo $_GET['loc']; ?>" hidden/>
                <input type="text" name="wave" value="<?php echo $_GET['wave']; ?>" hidden/>
                <input type="text" name="budget_cat" value="<?php echo $_GET['cat']; ?>" hidden/>
                <input type="text" name="budget_type" value="<?php echo $_GET['type']; ?>" hidden/>
                <div class="table-responsive">
                  <table class="table table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th colspan="2">Item Description</th>
                        <th>Accountability Form</th>
                        <th>P<sub/>a&#x25;</sub><br>/Units</th>
                        <th>Days</th>
                        <th>Unit<br>Cost</th>
                        <th>Total</th>
                        <th>Recepient</th>
                        <th>Description</th>
                        <th>Accounting </th>
                        <th>Forms/Receipts</th>
                      </tr>
                    </thead>
                    <tbody id="addinput">   
                      <tr class="row-1">
                        <td>
                          <select name="item-category">
                            <option value="">Item Category</option>
                            <?php
                              $database->query("SELECT * FROM fin_budget_item_cat");
                              $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                              foreach ($results as $key => $value) {
                                echo '<option value="'.$value['id'].'">'.$value['item_cat'].'</option>';
                              }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select name="item">
                            <option value="">Item</option>
                            <?php
                              $database->query("SELECT * FROM fin_budget_items");
                              $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                              foreach ($results as $key => $value) {
                                echo '<option value="'.$value['id'].'">'.$value['item_desc'].'</option>';
                              }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select name="accountability-form">
                            <option value=""></option>
                            <option value="Fin 5">Fin 5</option>
                            <option value="Fin 6">Fin 6</option>
                            <option value="Fin 7">Fin 7</option>
                            <option value="FIN 8II">FIN 8II</option>
                            <option value="Fin 9">Fin 9</option>
                            <option value="Statement">Statement</option>
                            <option value="Original Receipts">Original Receipts</option>
                          </select>
                        </td>
                        <td class="units" ><input type="text" value="0" name="units"/></td>
                        <td class="days" ><input type="text" value="0" name="days"/></td>
                        <td class="unit_cost"><input type="text" value="0" name="unit-cost"/></td>
                        <td class="total" ><input type="text" value="0" name="total" disabled /></td>
                        <td><textarea name="recepient"></textarea></td>
                        <td><textarea name="description"></textarea></td>
                        <td><textarea name="accounting"></textarea></td>
                        <td><textarea name="forms"></textarea></td>
                      </tr>   
                      <tr id="submit-row"><td colspan="11"><button name="add-budget-record" class="btn btn-primary">Add Budget Record</button></td></tr>        
                    </tbody>        
                  </table>
                  
                </div>
              </form>   

              <?php 

                $database->query('SELECT SUM(total) AS budget_total FROM fin_budget_cat_district WHERE wave = :wave AND district = :district AND budget_cat = :budget_cat AND budget_type = :budget_type',
                  array(
                    ':wave'=>$_GET['wave'],
                    ':district' => urldecode($_GET['loc']),
                    ':budget_cat' => $_GET['cat'],
                    ':budget_type' => $_GET['type']
                  )
                );
                $the_total = $database->statement->fetch(PDO::FETCH_ASSOC);
                $budget_total = $the_total['budget_total'];

              ?>

              <h3>District Training MOE Budget for <?php echo $_REQUEST['selectdistrict']; ?> District ,<?php echo $_REQUEST['selectwave']; ?> Wave</h3>
              <h3>Budget Total : <?php echo number_format($budget_total); ?></h3>

              <div class="table-responsive">

                <table class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th colspan="2">Item Description</th>
                      <th>Accountability Form</th>
                      <th>P<sub/>a&#x25;</sub><br>/Units</th>
                      <th>Days</th>
                      <th>Unit<br>Cost</th>
                      <th>Total</th>
                      <th>Recepient</th>
                      <th>Description</th>
                      <th>Accounting </th>
                      <th>Forms/Receipts</th>
                      <th>Edit</th>
                      <th>Delete</th>
                      <th colspan="2"></th>
                      <th class="hidden" ></th>
                    </tr>
                  </thead>  
                  <tbody>  
                    <?php 

                      $database->query('SELECT * FROM fin_budget_cat_district WHERE wave = :wave AND district = :district AND budget_cat = :budget_cat AND budget_type = :budget_type',
                        array(
                          ':wave'=>$_GET['wave'],
                          ':district' => urldecode($_GET['loc']),
                          ':budget_cat' => $_GET['cat'],
                          ':budget_type' => $_GET['type']
                        )
                      );
                      $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                      foreach ($results as $key => $value) {

                        $database->query('SELECT item_cat FROM fin_budget_item_cat WHERE id = :id',
                          array(
                            ':id'=>$value['item_category']
                          )
                        );
                        $cat = $database->statement->fetch(PDO::FETCH_ASSOC);

                        $database->query('SELECT item_desc FROM fin_budget_items WHERE id = :id',
                          array(
                            ':id'=>$value['item']
                          )
                        );
                        $item_desc = $database->statement->fetch(PDO::FETCH_ASSOC);


                        ?>
                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                          <tr>
                            <td><?php echo $cat['item_cat']; ?></td>
                            <td><?php echo $item_desc['item_desc']; ?></td>
                            <td><?php echo $value['acc_form']; ?></td>
                            <td><input type="text" value="<?php echo $value['units']; ?>" name="units" disabled/></td>
                            <td><input type="text" value="<?php echo $value['unit_cost']; ?>" name="days" disabled/></td>
                            <td><input type="text" value="<?php echo $value['days']; ?>" name="unit_cost" disabled/></td>
                            <td><input type="text" value="<?php echo $value['units'] * $value['unit_cost'] * $value['days']; ?>" name="total" disabled /></td>
                            <td><input type="text" value="<?php echo $value['recepient']; ?>" name="recepient" disabled/></td>
                            <td><textarea name="description" disabled><?php echo $value['unit_description']; ?></textarea></td>
                            <td><textarea name="accounting" disabled><?php echo $value['accounting']; ?></textarea></td>
                            <td><textarea name="forms" disabled><?php echo $value['forms_receipts']; ?></textarea></td>
                            <td><a href="<?php echo basename( $_SERVER['REQUEST_URI'] )."&editId=".$value['id']."#openModal"; ?>"><img src="../images/icons/view2.png" height="20px"/></a></td>
                            <td><a href="javascript:void(0)" onclick='show_confirm(<?php echo $value['id']; ?>)'><img src="../images/icons/delete.png" height="20px"/></a></td>
                            <td class="hidden"><?php echo $value['id']; ?></td>
                          </tr> 
                        </form>
                    <?php } ?>
                  </tbody> 
                  <tfoot>
                      <tr>
                          <th colspan="6" align="right"> Budget Total</th>
                          <th> <?php echo number_format($budget_total); ?> </th>
                          <th colspan="6">&nbsp;</th>
                      </tr>                      
                  </tfoot>       
                </table>

              </div>      

            </div>

          <?php } else if ($view == 'budget-form') {

            $database->query('SELECT district,wave,budget_cat,budget_type, SUM(total) AS budget_total FROM fin_budget_cat_district GROUP BY district,wave,budget_cat,budget_type HAVING SUM(total) != 0') ;
            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

            ?>

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Budget</th>
                  <th>District</th>
                  <th>Deworming Wave</th>
                </tr>
              </thead>

              <tbody>

                <?php  

                  foreach ($results as $key => $value) {

                    $href = '?view=budget-form-single&form-type='.$_REQUEST['form-type'].'&budget-cat='.$value['budget_cat'].'&wave='.$value['wave'].'&budget-type='.$value['budget_type'].'&loc='.urlencode($value['district']).'';

                    $database->query('SELECT budget_type FROM fin_budget_type WHERE id = :id', array(
                      ':id' => $value['budget_type']
                      )
                    ) ;
                    $budget_type = $database->statement->fetch(PDO::FETCH_ASSOC);                        


                    $database->query('SELECT deworming_wave FROM deworming_waves WHERE id = :id', array(
                      ':id' => $value['wave']
                      )
                    ) ;
                    $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                  ?>

                    <tr>
                      <td><a href="<?php echo $href;?>"><?php echo $budget_type['budget_type']; ?></a></td>
                      <td><a href="<?php echo $href;?>"><?php echo urldecode($value['district']); ?></a></td>
                      <td><a href="<?php echo $href;?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                    </tr>
                    
                  <?php } ?>

              </tbody>
            </table>

          <?php } else if ($view == 'budget-form-single') {

            $formtype = $_REQUEST['form-type'];

            $database->query('SELECT 
              fin_budget_cat_district.total,
              fin_budget_cat_district.recepient,
              SUM(fin_budget_cat_district.total) AS budget_total, 
              fin_budget_items.item_desc,
              fin_budget_item_cat.item_cat,
              fin_budget_type.budget_type,
              fin_budget_category.category AS budget_category,
              deworming_waves.deworming_wave
              FROM fin_budget_cat_district
              JOIN fin_budget_item_cat ON fin_budget_cat_district.item_category = fin_budget_item_cat.id 
              JOIN fin_budget_items ON fin_budget_cat_district.item = fin_budget_items.id
              JOIN fin_budget_type ON fin_budget_cat_district.budget_type = fin_budget_type.id 
              JOIN fin_budget_category ON fin_budget_cat_district.budget_cat = fin_budget_category.id 
              JOIN deworming_waves ON fin_budget_cat_district.wave = deworming_waves.id 
              WHERE 
                fin_budget_cat_district.district = :district AND 
                fin_budget_cat_district.wave = :wave AND 
                fin_budget_cat_district.budget_cat = :budget_cat AND 
                fin_budget_cat_district.budget_type = :budget_type 
                GROUP BY fin_budget_cat_district.id', 
              array(
                ':district'    => urldecode($_GET['loc']),
                ':wave'        => $_GET['wave'],
                ':budget_cat'  => $_GET['budget-cat'],
                ':budget_type' => $_GET['budget-type']
              )
            );
            $BudgetResults = $database->statement->fetchall(PDO::FETCH_ASSOC);

            echo'<pre>'; 
            print_r($BudgetResults);
            echo '</pre>';

            if ( $formtype == 'recon' ) { ?>

              <a href="#" class="btn btn-primary">Export to PDF</a><br><br>

              <div id="budget-form-container" class="form-budget">

                <div id="budget-form-header">

                  <img src="../images/logo.png"/>

                  <h2>Financial Reconciliation Return Form</h2>
                  <h3><?php echo urldecode($_GET['loc']).' '.$BudgetResults[0]['budget_category'].' Budget ('.$BudgetResults[0]['budget_type'] .') For Deworming Wave: '.$BudgetResults[0]['deworming_wave'].''; ?></h3><br>

                  <div id="budget-form-header-meta">

                    <p class="meta"><span class="meta-label">Name:</span></p>
                    <p class="meta"><span class="meta-label">Date:</span> <?php echo date('jS F Y') ?></p>
                    <p class="meta"><span class="meta-label">Amount (Words):</span> </p> 

                    <h5>Notes:</h5>
                    <p class="notes"> If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                    <p class="notes">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>       

                  </div>                  

                </div>  

                <div id="budget-form-body">

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Unit Description</th>
                        <th>Amount Advanced (Ksh)</th>
                        <th>Amount Spent (Including Other Allowed Costs)</th>
                        <th>Variance between Advanced &amp; Amount Spent</th>
                      </tr>
                    </thead>
                    <tbody>
                      <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">
                        <tr>
                          <td>Amount forwarded to your district</td>
                          <td></td>
                          <td colspan="2"></td>
                        </tr>
                        <tr>
                          <td>Coordination Allowance for DEO</td>
                          <td class="advanced"><input type="text" id="" name="advanced" value="" disabled/></td>
                          <td class"spent"><input type="text" id="" name="" value=""/></td>
                          <td class="variance"><input type="text" id="" name="" value="" disabled/></td>
                        </tr>
                        <tr>
                          <td colspan="5" id="remarks"><textarea name="remarks">Remarks</textarea></td>
                        </tr>
                      </form>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><button type="submit" name="save-reconsiliation-form" class="btn btn-primary btn-block">Save</button></td>
                            <td></td>
                        </tr>
                    </tfoot>
                  </table>

                </div>
                <div id="budget-form-footer">
                  <p><b>Prepared By: </b><?php echo $_SESSION['staff_name'] ?></p>
                  <p><b>Date: </b><?php echo date('jS F Y') ?></p>
                  <p><b>Signature: </b></p>
                </div>
              </div>

            <?php } else if ( $formtype == 'recon' ) {

            } else if ( $formtype == 'imprest' ) {

            } else if ( $formtype == 'cheque' ) {

            }

          }

        ?>          

      </div><!--end of content body -->
    </div><!--end of content Main -->

    <!--jQuery Include-->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

    <!--Bootstrap Js Include-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!--Chained Select Box for County and District select box-->
    <script type="text/javascript">
      //GET district
      function get_district(txt) {
        $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
          $('#selectdistrict').html(data);
          console.log(data);
        });
      }
      function show_confirm(deleteid) {
        if (confirm("Are you sure you want to delete?")) {
          location.replace('<?php basename( $_SERVER['REQUEST_URI'] ) ?>?deleteId=' + deleteid);
        } else {
          return false;
        }
      }
    </script>

    <!--Auto Calculate Butdget Item total-->
    <script type="text/javascript">
      var tablrow = $('#addinput tr');

      $(document).on( 'change', $('.units input,.days input,.unit_cost input'), function(){

        var value_1 = $('.units input').val(),
          value_2 = $('.days input').val(),
          value_3 = $('.unit_cost input').val(),
          prod = value_1 * value_2 * value_3;

        $('.total input').attr('value',prod);

      });
    </script>

    <!--Prevent Entry of non numericals in selected budget fields-->
    <script type="text/javascript">
      $(document).find("#addinput tr td input").keydown(function (e) {
              // Allow: backspace, delete, tab, escape, enter and .
              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                   // Allow: Ctrl+A
                  (e.keyCode == 65 && e.ctrlKey === true) || 
                   // Allow: home, end, left, right
                  (e.keyCode >= 35 && e.keyCode <= 39)) {
                       // let it happen, don't do anything
                       return;
              }
              // Ensure that it is a number and stop the keypress
              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                  e.preventDefault();
              }
          });
      });
    </script>



  </body>
</html>
<?php
if(isset($_REQUEST[editId])){

  $crudResult="";
  $editId=$_REQUEST["editId"];
  if(isset($_REQUEST["updateBudgetRecord"])){  // The crud operation update

 $district=isset($_POST["district"])?mysql_real_escape_string($_POST["district"]):"";
  $wave=isset($_POST["wave"])?mysql_real_escape_string($_POST["wave"]):"";
  $category=isset($_POST["budget_cat"])?mysql_real_escape_string($_POST["budget_cat"]):"";
  $budget_type=isset($_POST["budget_type"])?mysql_real_escape_string($_POST["budget_type"]):"";
  $items_cat=isset($_POST["items_cat"])?mysql_real_escape_string($_POST["items_cat"]):"";
  $item=isset($_POST["item"])?mysql_real_escape_string($_POST["item"]):"";
  $item_desc=isset($_POST["item_desc"])?mysql_real_escape_string($_POST["item_desc"]):"";
  $acc_form=isset($_POST["acc_form"])?mysql_real_escape_string($_POST["acc_form"]):"";
  $units=isset($_POST["units"])?mysql_real_escape_string($_POST["units"]):"";
  $unit_cost=isset($_POST["unit_cost"])?mysql_real_escape_string($_POST["unit_cost"]):"";
  $days=isset($_POST["days"])?mysql_real_escape_string($_POST["days"]):"";
  $total=isset($_POST["total"])?mysql_real_escape_string($_POST["total"]):"";
  $recepient=isset($_POST["recepient"])?mysql_real_escape_string($_POST["recepient"]):"";
  $unit_description=isset($_POST["unit_description"])?mysql_real_escape_string($_POST["unit_description"]):"";
  $accounting=isset($_POST["accounting"])?mysql_real_escape_string($_POST["accounting"]):"";
  $forms_receipts=isset($_POST["forms_receipts"])?mysql_real_escape_string($_POST["forms_receipts"]):"";
  //Now for the update process to work we need to turn some of the variables to their numeric form
  //i.e some values appear as text with the interface but are actually generated from their respective foreign keys
  //1.Budget_type

  $sql="select id from fin_budget_type where budget_type='$budget_type' LIMIT 1";
  $result=mysql_query($sql);
  while($key=mysql_fetch_array($result)){
    $budget_type=$key["id"];
  }
  //echo $budget_type;


  //2.Item Category
  $sql="select id from fin_budget_item_cat where item_cat='$items_cat'";
  $result=mysql_query($sql);
  while($key=mysql_fetch_array($result)){
    $items_cat=$key["id"];
  }
  //echo $items_cat;


//3.item

$sql="select id from fin_budget_items where item_desc='$item'";
$result=mysql_query($sql);
while($key=mysql_fetch_array($result)){
  $item=$key["id"];
}
//echo $item;


//Now for the update operation

$sql="UPDATE `fin_budget_cat_district` SET `district`='$district',`wave`='$wave',";
$sql.="`budget_type`='$budget_type',`item_category`='$items_cat',`item`='$item',";
$sql.="`acc_form`='$acc_form',`units`='$units',`unit_cost`='$unit_cost',`days`='$days',`total`='$total',";
$sql.="`recepient`='$recepient',`unit_description`='$unit_description',`accounting`='$accounting',";
$sql.="`forms_receipts`='$forms_receipts' WHERE `id`='$editId'";

//echo $sql;
mysql_query($sql);
   $crudResult="<h2 style='background:#bada66;color:#FFF;text-align:center'>Budget Record updated</h2>";


}



$sql="select * from fin_budget_cat_district where id='$editId'";
$editResult=mysql_query($sql);


while($key=mysql_fetch_array($editResult)){  //Contigency placed with this loop:If no record is found the modal won't display
  $district=$key["district"];
  $wave=$key["wave"];
  $category=$key["budget_cat"];
  $budget_type=$key["budget_type"];
  $item_cat=$key["item_category"];
  $item=$key["item"];
  $item_desc=$key["item_desc"];
  $acc_form=$key["acc_form"];
  $units=$key["units"];
  $unit_cost=$key["unit_cost"];
  $days=$key["days"];
  $total=$key["total"];
  $recepient=$key["recepient"];
  $unit_description=$key["unit_description"];
  $accounting=$key["accounting"];
  $forms_receipts=$key["forms_receipts"];

?>

<div id="openModal" class="modalDialog">
         
  <div style="width:80%;margin-top:5%;">
    <a href="<?php basename( $_SERVER['REQUEST_URI'] ) ?>#close" class="btn btn-danger"style="margin-left:96%;argin-top:-1%;" title="Close" class="close">X</a>
    
    <h2 style="margin-left:35%">Edit Budget Record Form</h2>
        <?php echo $crudResult; ?>
        <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">

            <table>
              <thead>
                <tr>
                  <td>District</td>
                  <td><select name="district">
                          <option selected="selected" value="<?php echo $district; ?>"><?php echo $district; ?></option>
                          <?php
                          //This will provide a dropdown with districts that have a deworming wave 
                          $sql="SELECT district FROM rollout_wave_districts";
                           $result=mysql_query($sql); 
                           while($value=mysql_fetch_array($result)){
                            echo "<option value='".$value["district"]."'>".$value["district"]."</option>";
                           }

                            ?>
                      </select>


                  </td>

                  <td>Wave</td>
                  <td><input type="text" name="wave" value="<?php echo $wave; ?>" />
                  </td>
                
               
                  <td>Budget Type</td>
                  <td>
                    <select name="budget_type">

                         <?php
                          //This will provide a dropdown with item categories that have a deworming wave 
                          $sql="SELECT * FROM fin_budget_type where id<=2";
                           $result=mysql_query($sql); 
                           
                           while($value=mysql_fetch_array($result)){
                            echo "<option value='".$value["budget_type"]."'>".$value["budget_type"]."</option>";
                           }
                           
                          $sql.=" where id='".$budget_type."'";
                          $result=mysql_query($sql);
                          while($value=mysql_fetch_array($result)){
                            echo "<option selected=\"selected\" value='".$value["budget_type"]."'>".$value["budget_type"]."</option>";
                           }                             
                            ?>
                    
                      </select>
                  </td>
               

                </tr>
                <tr>
                  <td>Item Category</td>
                  <td><select name="items_cat">

                         <?php
                          //This will provide a dropdown with item categories that have a deworming wave 
                          $sql="SELECT * FROM fin_budget_item_cat";
                           $result=mysql_query($sql); 
                           
                           while($value=mysql_fetch_array($result)){
                            echo "<option value='".$value["item_cat"]."'>".$value["item_cat"]."</option>";
                           }
                           
                          $sql.=" where id='".$item_cat."'";
                          $result=mysql_query($sql);
                          while($value=mysql_fetch_array($result)){
                            echo "<option selected=\"selected\" value='".$value["item_cat"]."'>".$value["item_cat"]."</option>";
                           }                             
                            ?>
                    
                      </select>
                  </td>
                  <td>Item</td>
                  <td><select name="item">
                          
                          <?php
                          //This will provide a dropdown with Items that have a deworming wave 
                          $sql="SELECT * FROM fin_budget_items";
                           $result=mysql_query($sql); 
                           while($value=mysql_fetch_array($result)){
                            echo "<option value='".$value["item_desc"]."'>".$value["item_desc"]."</option>";
                           }
                             $sql.=" where id='".$item."'";
                          $result=mysql_query($sql);
                          while($value=mysql_fetch_array($result)){
                            echo "<option selected=\"selected\" value='".$value["item_desc"]."'>".$value["item_desc"]."</option>";
                           } 


                            ?>
                      </select>
                  </td>


                  <td>Account Forms</td>
                  <td><input type="text" name="acc_form" value="<?php echo $acc_form; ?>" />
                  </td>
                
                

                </tr>
                <tr>
                  <td>Units</td>
                  <td><input type="text" name="units" value="<?php echo $units; ?>" />
                  </td>
                  <td>Units Cost</td>
                  <td><input type="text" name="unit_cost" value="<?php echo $unit_cost; ?>" />
                  </td>
                  <td>Days</td>
                  <td><input type="text" name="days" value="<?php echo $days; ?>" />
                  </td>
               
                

                </tr>
                <tr>
                
                <td>Total</td>
                  <td><input type="text" name="total" value="<?php echo $total; ?>" />
                </td>
                
                <td>Recepient</td>
                  <td><input type="text" name="recepient" value="<?php echo $recepient; ?>" />
                  </td>

                <td>Unit Description</td>
                <td colspan="4"><textarea name="unit_description"><?php echo $unit_description; ?></textarea>
                </td>


                </tr>
                <tr>
                  <td>Form Receipt</td>
                  <td><input type="text" name="forms_receipts" value="<?php echo $forms_receipts; ?>" />
                  </td>

                  <td>Accounting</td>
                  <td colspan="4"><textarea name="accounting"><?php echo $accounting; ?></textarea>
                  </td>


                </tr>

                <tr>
                  <td colspan="5"><input type="submit" name="updateBudgetRecord" class="btn btn-success" value="Update Details" /></td>


                </tr>



              </thead>
            </table>

        </form> 
  </div>
</div>


<?php
}
}
?>




