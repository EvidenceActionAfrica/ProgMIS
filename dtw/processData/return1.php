  <?php
		
		$divpho_representative=isset($_POST["divpho_representative"])?mysql_real_escape_string($_POST["divpho_representative"]):"";
		$district=isset($_POST["district"])?mysql_real_escape_string($_POST["district"]):"";
		$phone_number=isset($_POST["phone_number"])?mysql_real_escape_string($_POST["phone_number"]):"";
		$email=isset($_POST["email"])?mysql_real_escape_string($_POST["email"]):"";
		
		$division=isset($_POST["division"])?mysql_real_escape_string($_POST["division"]):"";
		$signedDate=isset($_POST["signedDate"])?mysql_real_escape_string($_POST["signedDate"]):"";
		$albendazole=isset($_POST["albendazole"])?mysql_real_escape_string($_POST["albendazole"]):"";
		$prazinqutel=isset($_POST["prazinqutel"])?mysql_real_escape_string($_POST["prazinqutel"]):"";
		$aeo=isset($_POST["aeo"])?mysql_real_escape_string($_POST["aeo"]):"";
		
		
		
        if (isset($_POST['submitSaveNew'])) {
         $query="INSERT INTO `drugs_tab_return_form`( `div_pho_representative`, `district_name`, `div_pho_phone_number`, `email`, `division_name`, `date_of_receipt`, `albendazole_returned_tablets`, `prazinqutel_returned_tablets`, `aeO`) VALUES ('$divpho_representative','$district','$phone_number','$email','$division','$signedDate','$albendazole','$prazinqutel','$aeo')";
		// echo $query;
          mysql_query($query) or die(mysql_error());
        }
        ?>
        <div id="canvas" style="margin: 0 auto">

          <h1 style="text-align: center; margin-top: 0px; font-size: 22px">Tab Return Form</h1>
          <!--<h1 class="form-title">Delivery Note</h1>-->
          <!-- table begin  =============-->
          <td style="width: 70%">
            <div id="addNewDeliveryNote" style="width: 80%; margin: 0 auto">
              <form method="post">


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
                    <td>Email</td><td><input type="text" name="email" class="input_textbox_p compact" value="<?php echo $email; ?>"/></td>
                  </tr>
                </table><br/><br/>


                <table border="0" frame="box"  align="center" cellpadding="0" style="width: 90%; border: 1px so">
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


                <table border="0" frame="box"  align="center" cellpadding="0" style="width: 90%; border: 1px so">
                  <tr style="background-color: silver;">
                    <td colspan="6" style="padding: 5px;"><b>Health Sector receipt confirmation and assumption of responsibiliyty</b></td>
                  </tr>
                
                  <tr>
                    <td>AEO</td>
                    <td><input type="text" name="aeo" class="input_textbox_p compact"  value="<?php echo $aeo; ?>"/></td>
                  </tr>
                </table><br/><br/>
                <input type="submit" name="submitSaveNew" value="Save Form" class="btn-custom-tiny" style="float: left"/>
                <div class="vclear"></div>

                <br/>
              </form>
            </div>
        </div>
