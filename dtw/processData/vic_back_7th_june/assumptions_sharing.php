<?php
require_once ("includes/auth.php"); //use root
require_once ('../includes/config.php'); //use root
require_once('assumptions.func.php');
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();

// get all the data from the assumptions table
$data=get_assumptions();

// create an assumption
if (isset($_POST['assumptions_submit'])) {

  $column_head=addslashes(trim($_POST['column_head']));
  $assumption=addslashes(trim($_POST['assumption']));
  $refrence=addslashes(trim($_POST['refrence']));

  create_assumption($refrence,$column_head,$assumption);

  header("Location:assumptions_sharing.php");

}

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=get_assumption_by_id($id);

}

// edit an assumption
if (isset($_POST['submitEditAssumption'])) {
  $id = $_POST['id'];
  $column_head=addslashes(trim($_POST['column_head']));
  $assumption=addslashes(trim($_POST['assumption']));
  $refrence=addslashes(trim($_POST['refrence']));
  update_assumptions($id,$refrence,$column_head,$assumption);
  header("Location:assumptions_sharing.php");
}

// delet an assumption
if (isset($_GET['deleteid'])) {
  $deleteid = $_GET['deleteid'];
  deleteRow('assumption_sharing',$deleteid);

  header("Location:assumptions_sharing.php");
 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>
    <script src="../js/jquery.min.js"></script>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
      <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >
        <!--================================================-->
        <?php

    
          
        ?>

        <!--<h1 >School List</h1>-->
        <form action="#">
          <!-- <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /> -->
          <img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/schools.php?searchQuery=<?php echo $searchQuery; ?>">Export to Excel</a> -->
          <b style="text-align: center; margin-top: 0px; font-size: 22px; margin-left: 100px ">Assumption Sharing</b>
          <!--<a class="btn-custom-small" href="#addSchool">Add School</a>-->
        </form>
        <br/>
        <div >
          <div style="width:4500px; margin-right: 20px; overflow-y: scroll">
          </div>

          <div>
              <form action="#">
                  <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a> -->
                  <a class="btn-custom-small" href="#addCounty">Add Assumption</a>
              </form>
              <a class="btn-custom-small" href="assumptions_sharing.php">Refresh</a>
              <div class="vclear"></div>
              <table id="assumption_sharing" class="table-hover sharing-table">
                <thead>
                  <th>Refrence</th>
                  <th>Column Head</th>
                  <th>Assumption</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </thead>
                <tbody>
              <?php 


                foreach ($data as $key => $value) {
                    # code...
                    ?>
                            <tr>  
                              <td class="sharing-column1"><?php echo $value['refrence'] ?></td>
                              <td class="sharing-column2"><?php echo $value['column'] ?></td>
                              <td class="sharing-column3"><?php echo $value['assumption'] ?></td>
                                <!--edit button-->
                              <form method="POST" action="#editCounty">
                               <input type="hidden" name="id" value="<?php echo $value['id'] ?>"/>
                                <td class="sharing-column4"><input type="submit" name="editDetails" value="" style="background: url(../images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                                <td class="sharing-column4"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $value['id']; ?>)' ><img src="../images/icons/delete.png" height="20px"/></a></td>
                              </form>
                            </tr>
                        </div>
                    <?php
                }
             ?>
              </tbody>
            </table>

            <div id="addCounty" class="modalDialog">
              <div>
                <a href="#close" title="Close" class="close">X</a>
                <form action="assumptions_sharing.php" method="post">
                  <div >
                    <h1>Add District</h1>
                  </div>
                  <center>
                    <div style="padding: 5px; margin: 0px auto">
                      <h3 >Add District Details</h3>
                      <table border="0">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <tr>
                          <td>Refrence </td>
                          <td> 
                            <input type="text" class="input_textbox" name="refrence" placeholder="refrence number" value="column_head">
                          </td>
                        </tr>
                        <tr>
                          <td>Column Head </td>
                          <td> 
                            <input type="text" class="input_textbox" name="column_head" placeholder="column_head" value="column_head">
                          </td>
                        </tr>
                        <tr>
                          <td>Assumption</td><td>
                            <textarea name="assumption" cols="80" rows="10">

                            </textarea> 

                      </td>
                       
                      </table>
                    </div>
                  </center>
                  <br/><br/><br/><br/>
                  <center>
                    <div>
                      <input type="submit" class="btn-custom" name="assumptions_submit"  value="Add Assumption"/>
                    </div>
                  </center>
                </form>
              </div>
            </div>



            <!--==== Modal EDIT ======-->
            <div id="editCounty" class="modalDialog">
              <div>
                <a href="#close" title="Close" class="close">X</a>
                <form action="" method="post">
                  <div >
                    <h1>Edit Assumtion <?php echo $details[0]['refrence'] ?></h1>
                  </div>
                  <center>
                    <div style="padding: 5px; margin: 0px auto">
                      <h3 >Edit Assumption Details</h3>
                      <table border="0">
                        
                        <input type="hidden" name="id" value="<?php echo $details[0]['id']; ?>"/>
                        <tr>
                          <td>Refrence </td>
                          <td> 
                            <input type="text" class="input_textbox" name="refrence" placeholder="" value="<?php echo $details[0]['refrence'] ?>">
                          </td>
                        </tr>
                        <tr>
                          <td>Column Head </td>
                          <td> 
                            <input type="text" class="input_textbox" name="column_head" placeholder="" value="<?php echo $details[0]['column'] ?>">
                          </td>
                        </tr>
                        <tr>
                          <td>Assumption</td><td>
                            <textarea name="assumption" cols="80" rows="10">
                              <?php echo $details[0]['assumption'] ?>
                            </textarea> 

                      </td>
                       
                      </table>
                    </div>
                  </center>
                  <br/><br/><br/><br/>
                  <center>
                    <div>
                      <input type="submit" class="btn-custom" name="submitEditAssumption"  value="Edit County Details"/>
                    </div>
                  </center>
                </form>
              </div>
            </div>


          </div>
        </div>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
    $(function() {
      $('input#id_search').quicksearch('table tbody tr');
    });

    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>


<script>
  //GET district
  function get_district(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }

</script>

    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>

