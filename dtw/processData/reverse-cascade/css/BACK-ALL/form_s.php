        <form method="post" action="form_s_submit.php">
          <!--header-->
          <div style="width: 100%;">
            <table style="width: 100%">
              <tr>
                <td width="70px">
                  <div style="border: 1px solid black; padding: 10px">
                    Survey ID <br/>
                    <input type="text" size="9" name="survey_id" value="000174"/><br/>
                  </div>
                </td>
                <td><img src="images/pill.png"/></td>
                <td align="center">
                  <b style="font-size: 17px; ">FORM S : SCHOOL TREATMENT SUMMARY FORM<br/>(ALBENDAZOLE)</b>
                </td>
                <td><b style="font-size: 60px">S</b></td>
              </tr>
            </table>
          </div><br/>
          <!-- Section 1 =============-->
          <b style="font-size: 12px; ">Complete Sections 1-5 in full using all Forms N and E.</b>
          <table border="2" align="center" cellpadding="5" style="width: 100%;">
            <tr style="background-color: silver;">
              <td colspan="6" style="padding: 5px;"><b>Section 1: </b><i>School Details</i></td>
            </tr>
            <tr>
              <td align="center">
                <b>SCHOOL NAME : </b><br/>
                <select name='school' id='school' onchange="hideSaveButton();" >
                  <?php
                  $result_set = mysql_query("SELECT * FROM schools ORDER BY p_orig_schname ASC");
                  while ($row = mysql_fetch_array($result_set)) {
                    echo "<option value=\"{$row['p_orig_schname']}\">{$row['p_orig_schname']}</option>";
                  }
                  ?></select><br/>
              </td>
              <td align="center">
                <b>INDICATE SCHOOL TYPE : </b><br/>
                <select name='school_type' id='school_type' onchange="hideSaveButton();" >
                  <option value="Public">Public</option>
                  <option value="Private">Private</option>
                  <option value="Other">Other</option>
                </select>
              </td>
              <td align="center">
                <b>Date of Deworming Day<br/>(yyyy-mm-dd) </b><br/>
                <input name="deworming_date" id="deworming_date" type="text"  /><br/>
              </td>
            </tr>
            <tr>
              <td align="center">
                <b>DISTRICT : </b><br/>
                <select name='school_district' id='moverep' onchange="hideSaveButton();" >
                  <?php
                  $result_set = mysql_query("SELECT * FROM districts ORDER BY district_name ASC");
                  while ($row = mysql_fetch_array($result_set)) {
                    echo "<option value=\"{$row['district_name']}\">{$row['district_name']}</option>";
                  }
                  ?></select>
              </td>
              <td  align="center">
                <b>DIVISION : </b><br/>
                <select name='school_division' id='moverep' onchange="hideSaveButton();" >
                  <?php
                  $result_set = mysql_query("SELECT * FROM divisions ORDER BY division_name ASC");
                  while ($row = mysql_fetch_array($result_set)) {
                    echo "<option value=\"{$row['division_name']}\">{$row['division_name']}</option>";
                  }
                  ?></select>
              </td> 
              <td align="center">
                <b>ZONE : </b><br/><input type="text" name="zone" />
              </td> 
            </tr>
          </table>
          <br/>
          <!-- Section 2 =============-->
          <table border="2" align="center" cellpadding="0" style="width: 100%;">
            <tr style="background-color: silver;">
              <td colspan="6" style="padding: 5px;"><b>Section 2: </b><i>Use summary section 6 (final summary) of all forms Es for Enrolled ECD children to fill below.</i></td>
            </tr>
            <tr>
              <td rowspan="2" width="30%">
                <b>Enrolled ECD Age Children </b><br/>Recorded on Form Es where box 1 is ticked
              </td>
              <td colspan="3" style="min-width: 310px">
                <b>TOTAL NUMBER OF ECS CHILDREN TREATED </b>
              </td>
              <td rowspan="2" align="center">
                <b>Adults<br/>Treatment:</b><br/>
              </td>
              <td rowspan="2" align="center">
                <b>Tablets<br/>spoiled:</b><br/>
              </td>
            </tr>
            <tr>
              <td> <b>MALE : </b> </td>
              <td> <b>FEMALE : </b> </td>
              <td> <b>TOTAL : </b> </td>
            </tr>
            <tr>
              <td> <b>TOTAL: </b>  </td>
              <td><input type="text" name="ecd_treated_male" value="" style="width: 99%"/></td>
              <td><input type="text" name="ecd_treated_female" value="" style="width: 99%"/></td>
              <td><input type="text" name="ecd_treated_children_total" value="" style="width: 99%"/></td>
              <td><input type="text" name="ecd_adults_treated" value="" style="width: 99%"/></td>
              <td><input type="text" name="ecd_tablets_spoilt" value="" style="width: 99%"/></td>
            </tr>
          </table>
          <br/>
          <!-- Section 3 =============-->
          <table border="2" align="center" cellpadding="0" style="width: 100%;">
            <tr style="background-color: silver;">
              <td colspan="10" style="padding: 5px;"><b>Section 3: </b><i>Use summary section 6 (final summary) of each Forms E for Enrolled primary school children to fill in below.</i></td>
            </tr>
            <tr>
              <td colspan="10" style="padding: 5px;"><b>Enrolled Primary School Children</b> Recorded on Form Es where box 2 is ticked</td>
            </tr>
            <tr>
              <td rowspan="2" width="7%">
                <b>Class</b>
              </td>
              <td colspan="3">
                TOTAL NUMBER OF CHILDREN IN REGISTER BOOK
              </td>
              <td colspan="3">
                TOTAL NUMBER OF CHILDREN IN TREATED
              </td>
              <td rowspan="2" align="center">
                <b>Adults<br/>Treatment:</b><br/>
              </td>
              <td rowspan="2" align="center">
                <b>Tablets<br/>spoiled:</b><br/>
              </td>
            </tr>
            <tr>
              <td> <b>MALE : </b> </td>
              <td> <b>FEMALE : </b> </td>
              <td> <b>TOTAL : </b> </td>
              <td> <b>MALE : </b> </td>
              <td> <b>FEMALE : </b> </td>
              <td> <b>TOTAL : </b> </td>
            </tr>
            <tr>
              <td align="center"> 1. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 2. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 3. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 4. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 5. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 6. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 7. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> 8. </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr>
              <td align="center"> Other </td>
              <td><input type="text" name="register_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="register_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_male[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_female[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="treated_total[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="adults_treated[]" value="" style="width: 99%"/></td>
              <td><input type="text" name="tablets_spoilt[]" value="" style="width: 99%"/></td>
            </tr>
            <tr style="border: 2px solid black">
              <td align="center"><b> TOTAL </b></td>
              <td><input type="text" name="number_in_register_male_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="number_in_register_female_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="number_in_register_class_total_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="number_treated_male_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="number_treated_female_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="number_treated_total_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="adults_treated_total" value="" style="width: 99%; font-weight: bold"/></td>
              <td><input type="text" name="tablets_spoilt_total" value="" style="width: 99%; font-weight: bold"/></td>
            </tr>
          </table>
          <br/>

          <!-- Section 4 =============-->
          <table border="2" align="center" cellpadding="0" style="width: 100%;">
            <tr style="background-color: silver;">
              <td colspan="12" style="padding: 5px;"><b>&nbsp;Section 4: </b><i>Use summary section 6 (final summary) of all Forms Ns to fill in below.</i></td>
            </tr>
            <tr>
              <td rowspan="2" width="15%">
                <b>Non Enrolled Children</b><br/>Recorded on form N
              </td>
              <td colspan="2"  align="center">
                <b>2-5 yrs</b>
              </td>
              <td colspan="2" align="center">
                <b>6-10 yrs</b>
              </td>
              <td colspan="2" align="center">
                <b>11-14 yrs</b>
              </td>
              <td colspan="2" align="center">
                <b>15-18 yrs</b>
              </td>
              <td rowspan="2" align="center">
                <b>Total<b/>
              </td>
              <td rowspan="2" align="center">
                <b>Adults<br/>Treatment:</b><br/>
              </td>
              <td rowspan="2" align="center">
                <b>Tablets<br/>spoiled:</b><br/>
              </td>
            </tr>
            <tr>
              <td align="center"> <b style="font-size: 18px">M </b> </td>
              <td align="center"> <b style="font-size: 18px">F </b> </td>
              <td align="center"> <b style="font-size: 18px">M </b> </td>
              <td align="center"> <b style="font-size: 18px">F </b> </td>
              <td align="center"> <b style="font-size: 18px">M </b> </td>
              <td align="center"> <b style="font-size: 18px">F </b> </td>
              <td align="center"> <b style="font-size: 18px">M </b> </td>
              <td align="center"> <b style="font-size: 18px">F </b> </td>
            </tr>
            <tr>
              <td><b>Total:</b></td>
              <td align="center"><input type="text" name="years_2_5_male" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_2_5_female" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_6_10_male" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_6_10_female" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_11_14_male" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_11_14_female" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_15_18_male" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="years_15_18_female" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="non_enrolled_total" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="non_enrolled_adults_treated" value="" style="width: 99%"/></td>
              <td align="center"><input type="text" name="non_enrolled_tablets_spoilt" value="" style="width: 99%"/></td>
            </tr>
          </table>
          <br/>

          <!--== Section 5 =============-->
          <table frame="box" align="center" cellpadding="0" style="width: 100%;">
            <tr style="background-color: silver;">
              <td colspan="12" style="padding: 5px; border: 1px solid black"><b>Section 5: </b><i>Calculate all treated (use the letters for totals to guide you) and report tablet balance to be returned to AEO.</i></td>
            </tr>
            <tr>
              <td width="17%"> Albendazole Received by School: </td>
              <td width="17%" style="border-right: 1px solid black"> 
                <input type="text" name="albendazole_received" value="" style="width: 70%"/> 
              </td>
              <td rowspan="2" width="25%" style="font-size: 12px"> <b>TOTAL TREATMENTS</b> (Add each column using letters provided to guide you)</td>
              <td align="center"> <b>Children:</b><br/> (A+B+C)</td>
              <td align="center"> <b>Adults:</b><br/> (D+E+F)</td>
              <td align="center"> <b>Tablets spoiled:</b><br/> (G+H+I)</td>
            </tr>
            <tr>
              <td width="15%"> Albendazole Returned to School: </td>
              <td width="15%" style="border-right: 1px solid black"> 
                <input type="text" name="albendazole_returned" value="" style="width: 70%"/> 
              </td>
              <td > <input type="text" name="total_a_b_c" value="" style="width: 99%"/> </td>
              <td > <input type="text" name="total_d_e_f" value="" style="width: 99%"/> </td>
              <td > <input type="text" name="total_g_h_i" value="" style="width: 99%"/> </td>
            </tr>
          </table>
          <br/>

          <div style="border: 1px solid black; padding: 5px">
            Head Teacher Name : <input type="text" name="head_teacher" style="width:200px"/>
            Phone Number : <input type="text" name="phone_number" style="width:200px"/>
          </div>
          <br/>
          <!--== SECTION FOR COMPLETION BY AEO: =============-->
          <table border="1" align="center" cellpadding="5" style="width: 100%;background-color: silver;">
            <tr>
              <td colspan="12" style="padding: 5px; border: 1px solid black"><b>SECTION FOR COMPLETION BY AEO:</b><i>Complete in full. Ref</i></td>
            </tr>
            <tr>
              <td> AEO Name : <input type="text" name="aeo_name" value="" /></td>
              <td> Phone Number : <input type="text" name="aeo_phone_number" value="" /> </td>
            </tr>
            <tr>
              <td> Date S Received : <input type="text" name="date_s_received" value=""/></td>
              <td> Programme Assigned School IS SCH : <input name="school_programme_id" type="text" value=""/></td>
            </tr>
          </table>
          <br/><br/>
          <input type="submit" name="submit" value="Submit form" >
            <br/><br/>
        </form>
        <h3>File upload</h3>
        <form action="upload/upload_form.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="section" value="1245" />
          <label for="file">Upload CSV file containing sections 1, 2, 4 and 5: </label>
          <input type="file" name="file" />
          <input type="submit" name="submit" value="Upload" />
        </form>
        <br /><br />
        <form action="upload/upload_form.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="section" value="3" />
          <label for="file">Upload CSV file containing section 3: </label>
          <input type="file" name="file" />
          <input type="submit" name="submit" value="Upload" />
        </form>
      </div>
    </div>
    <div class="clearFix"></div>
    </b>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->

    <script type="text/javascript">
                $(document).ready(function() {
                  $("#deworming_date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    showOn: 'focus',
                    buttonImageOnly: true,
                    buttonImage: 'calendar/cal.gif',
                    buttonText: 'Pick a date',
                    onClose: function(dateText, inst) {
                      //$("#EndDate").val($("#proposedmovedate").val());
                    }
                  });
                  $('#deworming_date').datepicker("option", 'minDate', new Date($("#deworming_date").datepicker('getDate')));
                });
    </script>
  </body>
</html>



