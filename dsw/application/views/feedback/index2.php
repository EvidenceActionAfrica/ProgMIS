<div>
  <p>
    <?php


?>
</p>
  <table width="60%" align="center">
    <!--<b style="text-align: center; font-size: 22px">Add New Feedback</b>-->
    <tr>
      <th align="right">Feedback by : </th>
      <th align="right"><div align="left">
        <input class="input_textbox_p" type="text" name="raisedby" value="<?php echo $_SESSION['staff_name'] ?>" readonly="readonly"/>
      </div></th>
    </tr>
    <tr>
      <th align="right">Category : </th>
      <th align="right"><div align="left">
        <select class="input_select_p" name="category">
          <option value="General">General</option>
          <option value="Admin Data">Admin Data</option>
          <option value="Process Data">Process Data</option>
          <option value="Performance Data">Performance Data</option>
        </select>
      </div></th>
    </tr>
    <tr>
      <th align="right">Sub-Category : </th>
      <th align="right"><div align="left">
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
      </div></th>
    </tr>
    <tr>
      <th align="right">Description : </th>
      <th align="right"><div align="left">
        <textarea  cols="40" rows="3" name="description" ></textarea>
      </div></th>
    </tr>
    <tr>
      <th></th>
      <th><div align="left"></div></th>
    </tr>
  </table>
  <table width="60%" align="center">
    <!--<b style="text-align: center; font-size: 22px">Add New Feedback</b>-->
    <tr>
      <th width="29%"></th>
      <th width="71%" align="left"> <input type="submit" class="btn-custom-pink" name="AddFeedback"  value="Submit Feedback"/>
      </th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
</div>