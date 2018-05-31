<head>
  <style>
    body{
      font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
      font-size: 13px;
    }

    /*=====================*/
    /*tables*/

    table {
      max-width: 100%;
      background-color: transparent;
      border-collapse: collapse;
      border-spacing: 0;
      font-size: 13px;
    }

    .table {
      width: 100%;
      margin-bottom: 20px;
    }
    .table:hover {
      width: 100%;
      margin-bottom: 20px;
      background:#D2EFF2;
    }
    .table th,
    .table td {
      padding: 8px;
      line-height: 20px;
      text-align: left;
      vertical-align: top;
      border-top: 1px solid #dddddd;
    }

    .table th {
      font-weight: bold;
    }

    .table thead th {
      vertical-align: bottom;
    }

    .table caption + thead tr:first-child th,
    .table caption + thead tr:first-child td,
    .table colgroup + thead tr:first-child th,
    .table colgroup + thead tr:first-child td,
    .table thead:first-child tr:first-child th,
    .table thead:first-child tr:first-child td {
      border-top: 0;
    }

    .table tbody + tbody {
      border-top: 2px solid #dddddd;
    }

    .table .table {
      background-color: #ffffff;
    }

    .table-condensed th,
    .table-condensed td {
      padding: 4px 5px;
    }

    .table-bordered {
      border: 1px solid #dddddd;
      border-collapse: separate;
      *border-collapse: collapse;
      border-left: 0;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
    }

  </style>
  <link rel="stylesheet" href="files/style.css" type="text/css">
<script type="text/javascript" src="files/jquery-1.js"></script>
</head>
<body>
  
  <div style="background-color: #E7E3E0; width: 100%">

    <div style="width: 100%; background-color: white">
      <img src="files/logo.png">
    </div>

    <div style="width: 100%;margin: 20px auto;">
      <div style="width: 100%;">
        <table style="width: 100%">
          <tr>
            <td><img src="images/ministry_of_education.png"/></td>
            <td align="center">
              <b style="font-size: 17px; ">NATIONAL SCHOOL-BASED DEWORMING PROGRAMME<br/>Teacher Training Attendance Form (ATTNT)</b>
            </td>
            <td><img src="images/pill.png"/></td>
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
            District Name &nbsp;: <input type="text" /><br/>
            Division Name : <input type="text" /><br/>
          </td>
          <td align="center">
            Training Venue : <input type="text" /><br/>
          </td>
          <td align="center">
            Date : (dd/mm/yy) : <input type="text" /><br/>
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
          <td ><input type="text" /></td>
          <td rowspan="3"><b>Notes : </b><textarea rows="2" style="width: 100%"></textarea></td>
        </tr>
        <tr>
          <td><b>Position : </b></td>
          <td><input type="text" /></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Mobile Phone : </b></td>
          <td><input type="text" /></td>
          <td></td>
        </tr>
      </table>
      <br/><br/><br/>
      <!--======================-->





      <div style="width: 100%;">
        <table style="width: 100%">
          <tr>
            <td><img src="images/ministry_of_education.png"/></td>
            <td align="center">
              <b style="font-size: 17px; ">NATIONAL SCHOOL-BASED DEWORMING PROGRAMME<br/>Teacher Training Attendance Form (ATTNT)</b>
            </td>
            <td><img src="images/pill.png"/></td>
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
            <input type="text" /><!--school name -->
            <br/><br/><br/>
            <b>Programme ID : </b>
            <br/>
            <input type="text" value=""/><br/><!--programme id-->
            <br/><br/>
          </td>
          <td>
            Head Teacher<br/>(or representative)<br/>
            <input type="text" value=""/><!--head teacher-->
          </td>
          <td>Mobile Number<br/>
            <input type="text" value="254"/></td>
          <td>I have received (please tick)<br/>
            <input type="checkbox" name="vehicle" value="Bike">Kshs. 1,000 (Transport & Lunch)<br>
            <input type="checkbox" name="vehicle" value="Car">Teacher training Packet <br/><br/>
            <b>Signature</b><br/>
            ..............................
          </td>
          <td rowspan="2" style="min-width: 200px" >My school has received:<br/>(Please tick all that apply)<br/><br/>
            <input type="checkbox" name="form" value="Bike">Form E &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Form N &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Form S &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Form E-P &nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Form N-P &nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Form S-P &nbsp;<input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">100 Airtime <input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Albendazole <input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Praziquantel <input type="text" size="4"/>packs<br/>
            <input type="checkbox" name="form" value="Bike">Table poles <input type="text" size="4"/>packs<br/>
            <br/><br/>
          </td>
        </tr>
        <tr>
          <td><b>This school is:</b><br/>
            <input type="checkbox" name="vehicle" value="Bike">Treating for bilhazia<br>
            <input type="checkbox" name="vehicle" value="Car">NOT Treating for bilhazia
          </td>
          <td>Health Teacher<br/>(or representative)<br/>
            <input type="text" /></td>
          <td>Mobile Number<br/>
            <input type="text" value="254"/></td>
          <td>I have received (please tick)<br/>
            <input type="checkbox" name="vehicle" value="Bike">Kshs. 1,000 (Transport & Lunch)<br>
            <input type="checkbox" name="vehicle" value="Car">Teacher training Packet <br/><br/>
            <b>Signature</b><br/>
            ..............................<br/>
          </td>
          <!--<td></td>-->
          <!--<td>My school has received: (tick appropriately)</td>-->
        </tr>
      </table>

    </div>
  </div>

</body>