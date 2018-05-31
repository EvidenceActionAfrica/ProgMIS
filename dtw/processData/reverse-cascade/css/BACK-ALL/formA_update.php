<html>
  <head>
    <title>FormA Update</title>

    <?php
    include "header_links.php";
    include 'dbcon.php';
    ?>

    <?php
    $survey_id = "1234";
    $sheet_number = 1;
    //$datas=$GetFormData->getFormA($survey_id);

    $sheet = 1;

    $sql = "SELECT * FROM form_a";
    $query = mysql_query($sql) or die(mysql_error());

    $data = array();
    while ($row = mysql_fetch_array($query)) {
      $datas[] = array(
          'id' => $row['id'],
          'sheet_number' => $row['sheet_number'],
          'survey_id' => $row['survey_id'],
          'school_name' => $row['school_name'],
          'district' => $row['district'],
          'division' => $row['division'],
          'form_s_returned' => $row['form_s_returned'],
          'ecd_treated_male' => $row['ecd_treated_male'],
          'ecd_treated_female' => $row['ecd_treated_female'],
          'ecd_treated_children_total' => $row['ecd_treated_children_total'],
          'years_2_5_male' => $row['years_2_5_male'],
          'years_2_5_female' => $row['years_2_5_female'],
          'years_6_10_male' => $row['years_6_10_male'],
          'years_6_10_female' => $row['years_6_10_female'],
          'years_11_14_male' => $row['years_11_14_male'],
          'years_11_14_female' => $row['years_11_14_female'],
          'years_15_18_male' => $row['years_15_18_male'],
          'years_15_18_female' => $row['years_15_18_female'],
          'non_enrolled_total' => $row['non_enrolled_total'],
          'total_enrolled_in_register' => $row['total_enrolled_in_register'],
          'enrolled_male' => $row['enrolled_male'],
          'enrolled_female' => $row['enrolled_female'],
          'enrolled_treated_total' => $row['enrolled_treated_total'],
          'aeo_name' => $row['aeo_name'],
          'aeo_phone_number' => $row['aeo_phone_number'],
          'school_programme_id' => $row['school_programme_id']
      );
    }



    //$totals_per_sheet=$GetFormData->getTotals($sheet_number,$survey_id);
    //$totals_per_sheet=$GetFormData->getTotals();
    // $sql="SELECT * FROM form_a_grand_totals WHERE survey_id='$survey_id' AND sheet_number='$sheet'";
    $sql = "SELECT * FROM form_a_grand_totals";
    $query = mysql_query($sql) or die(mysql_error());

    $totals_per_sheet = array();

    while ($row = mysql_fetch_array($query)) {
      $totals_per_sheet[] = array(
          'id' => $row['id'],
          'sheet_number' => $row['sheet_number'],
          'survey_id' => $row['survey_id'],
          'ecd_treated_male_grand_total' => $row['ecd_treated_male_grand_total'],
          'ecd_treated_female_grand_total' => $row['ecd_treated_female_grand_total'],
          'ecd_treated_children_total_grand_total' => $row['ecd_treated_children_total_grand_total'],
          'years_2_5_male_grand_total' => $row['years_2_5_male_grand_total'],
          'years_2_5_female_grand_total' => $row['years_2_5_female_grand_total'],
          'years_6_10_male_grand_total' => $row['years_6_10_male_grand_total'],
          'years_6_10_female_grand_total' => $row['years_6_10_female_grand_total'],
          'years_11_14_male_grand_total' => $row['years_11_14_male_grand_total'],
          'years_11_14_female_grand_total' => $row['years_11_14_female_grand_total'],
          'years_15_18_male_grand_total' => $row['years_15_18_male_grand_total'],
          'years_15_18_female_grand_total' => $row['years_15_18_female_grand_total'],
          'non_enrolled_total_grand_total' => $row['non_enrolled_total_grand_total'],
          'total_enrolled_in_register_grand_total' => $row['total_enrolled_in_register_grand_total'],
          'enrolled_male_grand_total' => $row['enrolled_male_grand_total'],
          'enrolled_female_grand_total' => $row['enrolled_female_grand_total'],
          'enrolled_treated_total_grand_total' => $row['enrolled_treated_total_grand_total']
      );
    }
    ?>

  </head>

  <body>

<?php include 'sideMenu.php'; ?>
    <div class="contentBody">
      <div class="form-title">
        <h1>Manage Form A</h1>
      </div>
      <a class="btn-custom-small" href="formA.php">Create Form A</a>
      <table width="100%" border="1" align="center" cellspacing="1" class="table-hover">
          <tbody>
          <tr>
            <td colspan="4" rowspan="3"></td>
            <td colspan="16">3. Fill the information below for each for each school isong the correct sections of Form S</td>
          </tr>
          <tr>
            <td colspan="3">
              Enrolled ECD <br> Children <br><span class="table-small">(Section 2 on S)</span>
            </td>
            <td colspan="4">
              Enrolled Primary SChool <br>Children <br> <span class="table-small">(Section 3 on S)</span>
            </td>
            <td colspan="9">
              Non Enrolled Children <br> <span class="table-small">(Section 4 on S)</span>
            </td>
          </tr>

          <tr>
            <td colspan="3">
              Totale number of <br> children treated
            </td>

            <td>
              Children <br>in register <br> book
            </td>
            <td colspan="3">
              Total Number of <br>children treated
            </td>
            <td colspan="2">2-5 yrs</td>
            <td colspan="2">6-10 yrs</td>
            <td colspan="2">11-14yrs</td>
            <td colspan="2">15-18yrs</td>
            <td></td>
          </tr>
          <tr>
            <td>ID</td>
            <td>School name in full</td>
            <td>Programme Assigned ID</td>
            <td>S returned</td>

            <td>M</td>
            <td>F</td>
            <td>Total <br> (A)</td>
            <td>Total <br> (S)</td>
            <td>M</td>
            <td>F</td>
            <td>Total <br> (B)</td>
            <td>M</td>
            <td>F</td>
            <td>M</td>
            <td>F</td>
            <td>M</td>
            <td>F</td>
            <td>M</td>
            <td>F</td>
            <td>Total <br> (c)</td>

          </tr>
          <tr>
        <div class="conatiner four columns vfloatleft">
          <!-- <label>Survey ID</label><br> -->
          <input type="hidden" name="survey_id[]" class="survey_id" placeholder="survey_id" value="<?php echo $data['formA_survey_id'] ?>">
        </div>
        <div class="conatiner four columns vfloatleft">
          <!-- <label>Sheet Number</label><br> -->
          <input type="hidden" name="sheet_number[]" class="sheet_number" placeholder="sheet_number" value="<?php echo $data['formA_sheet_number'] ?>">
        </div>

        <div class="vclear"></div>


        <div class="conatiner four columns vfloatleft">
          <!-- <label>Aeo_name</label><br> -->
          <input type="hidden" name="aeo_name[]" class="aeo_name" placeholder="aeo_name" value="">
        </div>
        <div class="conatiner four columns vfloatleft">
          <!-- <label>district</label><br> -->
          <input type="hidden" name="district[]" class="district" placeholder="district" value="">
        </div>
        <div class="vclear"></div>

        <div class="conatiner four columns vfloatleft">
          <!-- <label>aeo_phone_number</label><br> -->
          <input type="hidden" name="aeo_phone_number[]" class="aeo_phone_number" placeholder="aeo_phone_number" value="">
        </div>
        <div class="conatiner four columns vfloatleft">
          <!-- <label>division</label><br> -->
          <input type="hidden" name="division[]" class="division" placeholder="division" value="">
        </div>
        <div class="vclear"></div>

<?php
$i = 1;
foreach ($datas as $key => $data) {
  ?>
          <td><?php echo $i;
        $i++; ?></td>
          <td>
            <div class="rowdz">
            <!-- <input type="text" name="school_name[]" placeholder="school_name" value="school_name"> -->
          <?php echo $data['school_name'] ?>
            </div>
          </td>
          <td>
            <div class="rowdz">
          <!-- <input type="text" name="school_programme_id[]" placeholder="school_programme_id" value="school_programme_id"> -->
              <?php echo $data['school_programme_id'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="form_s_returned[]" placeholder="form_s_returned" value="form_s_returned"> -->
              <?php echo $data['form_s_returned'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="ecd_treated_male[]" placeholder="ecd_treated_male" value="ecd_treated_male"> -->
              <?php echo $data['ecd_treated_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="ecd_treated_female[]" placeholder="ecd_treated_female" value="ecd_treated_female"> -->
              <?php echo $data['ecd_treated_female'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="ecd_treated_children_total[]" placeholder="ecd_treated_children_total" value="ecd_treated_children_total"> -->
              <?php echo $data['ecd_treated_children_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="total_enrolled_in_register[]" placeholder="total_enrolled_in_register" value="total_enrolled_in_register"> -->
              <?php echo $data['total_enrolled_in_register'] ?>
            </div>

          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="enrolled_male[]" placeholder="enrolled_male" value="enrolled_male"> -->
  <?php echo $data['enrolled_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="enrolled_female[]" placeholder="enrolled_female" value="enrolled_female"> -->
              <?php echo $data['enrolled_female'] ?>
            </div>

          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="enrolled_treated_total[]" placeholder="enrolled_treated_total" value="enrolled_treated_total"> -->
  <?php echo $data['enrolled_treated_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="years_2_5_male[]" placeholder="years_2_5_male" value="years_2_5_male"> -->
              <?php echo $data['years_2_5_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
          <!-- <input type="text" name="years_2_5_female[]" placeholder="years_2_5_female" value="years_2_5_female"> -->
              <?php echo $data['years_2_5_female'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="years_6_10_male[]" placeholder="years_6_10_male" value="years_6_10_male"> -->
              <?php echo $data['years_6_10_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_6_10_female[]" placeholder="years_6_10_female" value="years_6_10_female"> -->
              <?php echo $data['years_6_10_female'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_11_14_male[]" placeholder="years_11_14_male" value="years_11_14_male"> -->
              <?php echo $data['years_11_14_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_11_14_female[]" placeholder="years_11_14_female" value="years_11_14_female"> -->
              <?php echo $data['years_11_14_female'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_15_18_male[]" placeholder="years_15_18_male" value="years_15_18_male"> -->
              <?php echo $data['years_15_18_male'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_15_18_female[]" placeholder="years_15_18_female" value="years_15_18_female"> -->
              <?php echo $data['years_15_18_female'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="non_enrolled_total[]" placeholder="non_enrolled_total" value="non_enrolled_total"> -->
              <?php echo $data['non_enrolled_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <a href="formA_view_edit.php?id=<?php echo $data['id']; ?>">Edit</a>
            </div>
          </td>
          <!-- <td>
            <div class="row buttons">
              <input type="submit" name="submit"  value="submit">
            </div>
          </td> -->

          <!-- </div> -->
          </tr>

  <?php
}
?>

        <tr>
          <td colspan="4">TOATL (sum/count each column on this sheet)</td>

          <td>
            <div class="rowd">
        <!-- <input type="text" name="ecd_treated_male_total" placeholder="ecd_treated_male_total" value="ecd_treated_male_total"> -->
<?php echo $totals_per_sheet[0]['ecd_treated_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="ecd_treated_female_total" placeholder="ecd_treated_female_total" value="ecd_treated_female_total"> -->
              <?php echo $totals_per_sheet[0]['ecd_treated_female_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="ecd_treated_children_total_total" placeholder="ecd_treated_children_total_total" value="ecd_treated_children_total_total"> -->
              <?php echo $totals_per_sheet[0]['ecd_treated_children_total_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="total_enrolled_in_register_total" placeholder="total_enrolled_in_register_total" value="total_enrolled_in_register_total"> -->
              <?php echo $totals_per_sheet[0]['total_enrolled_in_register_grand_total'] ?>
            </div>

          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="enrolled_male_total" placeholder="enrolled_male_total" value="enrolled_male_total"> -->
<?php echo $totals_per_sheet[0]['enrolled_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="enrolled_female_total" placeholder="enrolled_female_total" value="enrolled_female_total"> -->
              <?php echo $totals_per_sheet[0]['enrolled_female_grand_total'] ?>
            </div>

          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="enrolled_treated_total_total" placeholder="enrolled_treated_total_total" value="enrolled_treated_total_total"> -->
<?php echo $totals_per_sheet[0]['enrolled_treated_total_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="years_2_5_male_total" placeholder="years_2_5_male_total" value="years_2_5_male_total"> -->
              <?php echo $totals_per_sheet[0]['years_2_5_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="years_2_5_female_total" placeholder="years_2_5_female_total" value="years_2_5_female_total"> -->
              <?php echo $totals_per_sheet[0]['years_2_5_female_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
        <!-- <input type="text" name="years_6_10_male_total" placeholder="years_6_10_male_total" value="years_6_10_male_total"> -->
              <?php echo $totals_per_sheet[0]['years_6_10_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_6_10_fermale_total" placeholder="years_6_10_fermale_total" value="years_6_10_fermale_total"> -->
              <?php echo $totals_per_sheet[0]['years_6_10_female_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_11_14_male_total" placeholder="years_11_14_male_total" value="years_11_14_male_total"> -->
              <?php echo $totals_per_sheet[0]['years_11_14_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_11_14_female_total" placeholder="years_11_14_female_total" value="years_11_14_female_total"> -->
              <?php echo $totals_per_sheet[0]['years_11_14_female_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_15_18_male_total" placeholder="years_15_18_male_total" value="years_15_18_male_total"> -->
              <?php echo $totals_per_sheet[0]['years_15_18_male_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="years_15_18_female_total" placeholder="years_15_18_female_total" value="years_15_18_female_total"> -->
              <?php echo $totals_per_sheet[0]['years_15_18_female_grand_total'] ?>
            </div>
          </td>
          <td>
            <div class="rowd">
              <!-- <input type="text" name="non_enrolled_total_total" placeholder="non_enrolled_total_total" value="non_enrolled_total_total"> -->
              <?php echo $totals_per_sheet[0]['non_enrolled_total_grand_total'] ?>
            </div>
          </td>
 
        </tr>


      </table>

  </body>
</html>