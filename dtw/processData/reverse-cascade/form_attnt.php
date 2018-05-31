<?php
// require_once ("../../includes/auth.php"); //use root
// require_once ('../../includes/config.php'); // use root
//Form ATTNT
if(isset($_POST['Submit']))
{
//Sel All Fields Populated
{	
	$attnt_district_id = $_POST['attnt_district_id'];
	$attnt_division_id= $_POST['attnt_division_id'];
	$training_venue= $_POST['training_venue'];
	$training_date = $_POST['training_date'];
	$trainer_name= $_POST['trainer_name'];
	$trainer_position= $_POST['trainer_position'];
	$trainer_phone_num= $_POST['trainer_phone_num'];
	$any_notes= $_POST['any_notes'];
	$attnt_school_name= $_POST['attnt_school_name'];
	$school_id= $_POST['school_id'];
	$t1_name= $_POST['t1_name'];
	$t1_mobile= $_POST['t1_mobile'];
	$t1_received_transport= $_POST['t1_received_transport'];
	$t1_received_ttpack= $_POST['t1_received_ttpack'];
	$attnt_sch_treatment = $_POST['attnt_sch_treatment'];
	$t2_name= $_POST['t2_name'];
	$t2_mobile= $_POST['t2_mobile'];
	$t2_received_transport = $_POST['t2_received_transport'];
	$t2_received_ttpack= $_POST['t2_received_ttpack'];
	$received_form_e= $_POST['received_form_e'];
	$packs_received_form_e= $_POST['packs_received_form_e'];
	$received_form_n= $_POST['received_form_n'];
	$packs_received_form_n= $_POST['packs_received_form_n'];
	$received_form_s= $_POST['received_form_s'];
	$packs_received_form_s= $_POST['packs_received_form_s'];
	$received_form_ep= $_POST['received_form_ep'];
	$packs_received_form_ep= $_POST['packs_received_form_ep'];
	$received_form_np = $_POST['received_form_np'];
	$packs_received_form_np= $_POST['packs_received_form_np'];
	$received_form_sp= $_POST['received_form_sp'];
	$packs_received_form_sp = $_POST['packs_received_form_sp'];
	$received_airtime= $_POST['received_airtime'];
	$packs_received_airtime= $_POST['packs_received_airtime'];
	$received_alb= $_POST['received_alb'];
	$number_received_alb= $_POST['number_received_alb'];
	$received_pzq= $_POST['received_pzq'];
	$number_received_pzq= $_POST['number_received_pzq'];
	$received_poles= $_POST['received_poles'];
	$number_received_poles= $_POST['number_received_poles'];
 
	$query = "INSERT INTO attnt_bysch (attnt_district_id,attnt_division_id,training_venue,training_date,trainer_name,trainer_position,trainer_phone_num,
	any_notes,attnt_school_name,school_id,t1_name,t1_mobile,t1_received_transport,t1_received_ttpack,attnt_sch_treatment,t2_name,t2_mobile,
	t2_received_transport,t2_received_ttpack,received_form_e,packs_received_form_e,received_form_n,packs_received_form_n,received_form_s,packs_received_form_s,
	received_form_ep,packs_received_form_ep,received_form_np,packs_received_form_np,received_form_sp,packs_received_form_sp,received_airtime,
	packs_received_airtime,received_alb,number_received_alb,received_pzq,number_received_pzq,received_poles,number_received_poles) 
	VALUES('{$attnt_district_id}','{$attnt_division_id}','{$training_venue}','{$training_date}','{$trainer_name}','{$trainer_position}','{$trainer_phone_num}',
	'{$any_notes}','{$attnt_school_name}','{$school_id}','{$t1_name}','{$t1_mobile}','{$t1_received_transport}','{$t1_received_ttpack}',
	'{$attnt_sch_treatment}','{$t2_name}','{$t2_mobile}','{$t2_received_transport}','{$t2_received_ttpack}','{$received_form_e}','{$packs_received_form_e}',
	'{$received_form_n}','{$packs_received_form_n}','{$received_form_s}','{$packs_received_form_s}','{$received_form_ep}','{$packs_received_form_ep}',
	'{$received_form_np}','{$packs_received_form_np}','{$received_form_sp}','{$packs_received_form_sp}','{$received_airtime}','{$packs_received_airtime}',
	'{$received_alb}','{$number_received_alb}','{$received_pzq}','{$number_received_pzq}','{$received_poles}','{$number_received_poles}')";
	mysql_query($query) or die ("Error in query: $query");
	header("Location: form_attnt.php");
}
}
?>
      <div class="contentBody">
      <h1 style="text-align: center; margin-top: 0px">Process Data</h1>
		<div style="width: 100%;margin: 20px auto;">
		<form action="" method="POST">
      <div style="width: 100%;">
        <table style="width: 100%">
          <tr>
            <td><img src="../../images/ministry_of_education.png"/></td>
            <td align="center">
              <b style="font-size: 17px; ">NATIONAL SCHOOL-BASED DEWORMING PROGRAMME<br/>Teacher Training Attendance Form (ATTNT)</b>
            </td>
            <td><img src="../../images/pill.png"/></td>
          </tr>
        </table>
      </div>
      <!--At Training-->
      <div style="width: 100%; background-color: silver; border: 1px solid black">
        <b>&nbsp;At Training</b>
      </div>
      <div style="width: 100%; border: 1px solid black">
        <ul>
          <li>MoE Trainer should complete sections on this page. There is one page for each school to complete in the pages that follow.</li>
          <li>Teachers form the same school should complete the school resources section together AT THE END OF THE SESSION WHEN COLLECTING RESOURCES. Tick only those Resources received. Each <u>Teacher</u> should sig and Teachers from the <u>same school</u> should sign together</li>
          <li>Each school MUST INDICATE if they are treating for Bilhazia</li>
          <li>This is a financial accountability document. Teachers must tick and sign for receipt of items and cash.</li>
        </ul>
      </div>
      <br/>
      <!--After training-->
      <div style="width: 100%; background-color: silver; border: 1px solid black">
        <b>&nbsp;After Training</b>
      </div>
      <div style="width: 100%; border: 1px solid black">
        Return this form to the DEO; DEO should return this form along with any money remaining form the Training Exercise to the national team in Nairobi.    
      </div>
      <br/>
      <br/>
      <!--Training session details-->
      <div style="width: 100%; background-color: silver; border: 1px solid black">
        <b>&nbsp;Training Session Details</b>
      </div>
      <table border="1" style="width: 100%">
        <tr>
          <td style="padding: 10px">
            District Name &nbsp;:
			<select name="attnt_district_id"  style="width: 160px;" required>
				<option value=''>Select District</option>
				<?php
				$dist_sql = "SELECT * FROM districts ORDER BY district_name ASC";
				$result = mysql_query($dist_sql);
				while ($dist = mysql_fetch_array($result)) { //loop table rows
				?>
				<option value="<?php echo $dist['district_id']; ?>"><?php echo $dist['district_name']; ?></option>
				<?php } ?>
		    </select>
            <br/>
            Division Name :
			<select name="attnt_division_id"  style="width: 160px;" required>
				<option value=''>Select Division</option>
				<?php
				$dist_sql = "SELECT * FROM divisions ORDER BY division_name ASC";
				$result = mysql_query($dist_sql);
				while ($dist = mysql_fetch_array($result)) { //loop table rows
				?>
				<option value="<?php echo $dist['division_id']; ?>"><?php echo $dist['division_name']; ?></option>
				<?php } ?>
		    </select>
            <br/>
          </td>
          <td align="center">
            Training Venue : <input name="training_venue" type="text" id="training_venue" />
            <br/>
          </td>
          <td align="center">
            Date : (dd/mm/yy) : <input name="training_date" type="text" id="training_date" />
            <br/>
          </td>
        </tr>
      </table>
      <br/>
      <br/>
      <!--Training details-->
      <div style="width: 100%; background-color: silver; border: 1px solid black">
        <b>&nbsp;Training Details</b>
      </div>
      <table frame="box" style="width: 100%">
        <tr>
          <td width="120px"><b>Name : </b></td>
          <td ><input name="trainer_name" type="text" id="trainer_name" /></td>
          <td rowspan="3"><b>Notes : </b><textarea name="any_notes" rows="2" id="any_notes" style="width: 100%"></textarea></td>
        </tr>
        <tr>
          <td><b>Position : </b></td>
          <td><input name="trainer_position" type="text" id="trainer_position" /></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Mobile Phone : </b></td>
          <td><input name="trainer_phone_num" type="text" id="trainer_phone_num" /></td>
          <td></td>
        </tr>
      </table>
      <br/><br/><br/>
      <!--======================-->
      <div style="width: 100%;">
        <table style="width: 100%">
          <tr>
            <td><img src="../../images/ministry_of_education.png"/></td>
            <td align="center">
              <b style="font-size: 17px; ">NATIONAL SCHOOL-BASED DEWORMING PROGRAMME<br/>Teacher Training Attendance Form (ATTNT)</b>
            </td>
            <td><img src="../../images/pill.png"/></td>
          </tr>
        </table>
      </div><br/>
      <!--=========================-->
      <b style="font-size: 12px; ">Fill in the Programmme ID for your school as indicated in Form P</b>
      <div style="width: 100%; background-color: silver; padding: 0px; border: 1px solid black">
        <b>&nbsp;1. TEACHER ATTENDANCE RECORD</b>
      </div>
      <table border="1"  cellpadding="2" style="width: 100%">
        <tr align="center" style="font-weight: bold">
          <td>School</td>
          <td>Teacher name</td>
          <td>Contact Information</td>
          <td>Indicate which received<br/>PER TEACHER</td>
          <td colspan="2" >Indicate which received<br/>PER SCHOOL</td>
        </tr>
        <tr>
          <td><b>School Name:</b><br/>          
            <input name="attnt_school_name" type="text" id="attnt_school_name" />
            <!--school name -->
            <br/><br/><br/>
            <b>Programme ID : </b>
            <br/>
            <input name="school_id" type="text" id="school_id" value=""/><br/><!--programme id-->
            <br/><br/>          </td>
          <td>
            Head Teacher<br/>(or representative)<br/>
            <input name="t1_name" type="text" id="t1_name" value=""/>
          <!--head teacher-->          </td>
          <td>Mobile Number<br/>
            <input name="t1_mobile" type="text" id="t1_mobile" value="254"/></td>
          <td>I have received (please tick)<br/>
            <input name="t1_received_transport" type="checkbox" id="t1_received_transport" value="Yes" />            
            Kshs. 1,000 (Transport & Lunch)<br>
            <input name="t1_received_ttpack" type="checkbox" id="t1_received_ttpack" value="Yes" />            
            Teacher training Packet <br/><br/>
            <b>Signature</b><br/>
            ..............................          </td>
          <td rowspan="2" style="min-width: 200px" >My school has received:<br/>(Please tick all that apply)<br/><br/>
            <input name="received_form_e" type="checkbox" id="received_form_e" value="Yes" />            
            Form E &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="packs_received_form_e" type="text" id="packs_received_form_e" size="4"/>
            packs<br/>
            <input name="received_form_n" type="checkbox" id="received_form_n" value="Yes" />            
            Form N &nbsp;&nbsp;&nbsp;&nbsp;<input name="packs_received_form_n" type="text" id="packs_received_form_n" size="4"/>packs<br/>
            <input name="received_form_s" type="checkbox" id="received_form_s" value="Yes" />            
            Form S &nbsp;&nbsp;&nbsp;&nbsp;<input name="packs_received_form_s" type="text" id="packs_received_form_s" size="4"/>packs<br/>
            <input name="received_form_ep" type="checkbox" id="received_form_ep" value="Yes" />
            Form E-P &nbsp;<input name="packs_received_form_ep" type="text" id="packs_received_form_ep" size="4"/>packs<br/>
            <input name="received_form_np" type="checkbox" id="received_form_np" value="Yes" />
            Form N-P &nbsp;<input name="packs_received_form_np" type="text" id="packs_received_form_np" size="4"/>packs<br/>
            <input name="received_form_sp" type="checkbox" id="received_form_sp" value="Yes" />            
            Form S-P &nbsp;
            <input name="packs_received_form_sp" type="text" id="packs_received_form_sp" size="4"/>
            packs<br/>
            <input name="received_airtime" type="checkbox" id="received_airtime" value="Yes" />
            100 Airtime
            <input name="packs_received_airtime" type="text" id="packs_received_airtime" size="4"/>            
            packs<br/>
            <input name="received_alb" type="checkbox" id="received_alb" value="Yes" />
            Albendazole
            <input name="number_received_alb" type="text" id="number_received_alb" size="4"/>            
            packs<br/>
            <input name="received_pzq" type="checkbox" id="received_pzq" value="Yes" />
            Praziquantel 
            <input name="number_received_pzq" type="text" id="number_received_pzq" size="4"/>
            packs<br/>
            <input name="received_poles" type="checkbox" id="received_poles" value="Yes">Table poles <input name="number_received_poles" type="text" id="number_received_poles" size="4"/>packs<br/>
            <br/><br/>          </td>
        </tr>
        <tr>
          <td><b>This school is</b><br />
              <label>
                <input type="radio" name="attnt_sch_treatment" value="Yes" />
                Treating for Bilhazia</label>
              <br />
              <label>
                <input type="radio" name="attnt_sch_treatment" value="No" />
                Not Treating for Bilhazia</label>
              <br /></td>
          <td>Health Teacher<br/>(or representative)<br/>
            <input name="t2_name" type="text" id="t2_name" /></td>
          <td>Mobile Number<br/>
            <input name="t2_mobile" type="text" id="t2_mobile" value="254"/></td>
          <td>I have received (please tick)<br/>
            <input name="t2_received_transport" type="checkbox" id="t2_received_transport" value="Yes" />
            Kshs. 1,000 (Transport & Lunch)<br>
            <input name="t2_received_ttpack" type="checkbox" id="t2_received_ttpack" value="Yes" />            
            Teacher training Packet <br/><br/>
            <b>Signature</b><br/>
            ..............................<br/>          </td>
          <!--<td></td>-->
          <!--<td>My school has received: (tick appropriately)</td>-->
        </tr>
		<tr><td colspan="5" align="center"><input class="btn-custom-small" type="submit" name="Submit" value="Submit Details" /></td></tr>
      </table>
	</form>
    </div>
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->










