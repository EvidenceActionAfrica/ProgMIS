<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';
$updateResult="";

require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();
if(isset($_POST["saveDTB"])){
$tabActive = 'tab3';

}

if(isset($_GET["tab"])){

$tabActive="tab".$_GET["tab"];
$county=$_GET["countyName"];
$district=$_GET["districtName"];
}
if(isset($_GET["unpackId"])){
	$sql="UPDATE materials_printlist_history set packaged=0 where status=1";
	mysql_query($sql);
	$_GET="";
	$tabActive = 'tab2';
}
if(isset($_POST["teacherSave"])){
	$county=isset($_POST["county2"])?mysql_real_escape_string($_POST["county2"]):"";
	$district=isset($_POST["district2"])?mysql_real_escape_string($_POST["district2"]):"";
	$tabActive = 'tab4';
}


if(isset($_POST["districtSave"])){
	$county=isset($_POST["county1"])?$_POST["county1"]:"";
	$district=isset($_POST["district1"])?$_POST["district1"]:"";
	$boxes1=isset($_POST["boxes1"])?$_POST["boxes1"]:"";
	$tabActive = 'tab3';
}


		$sql="select * from materials_printlist_history where status=1";

		$resultA=mysql_query($sql);
		while($row=mysql_fetch_array($resultA)){

			$printlistId=$row["id"];
		}

	if(isset($_POST["savePackages"])){
		//We must first clear all records related to the active printlist before the insert since the same data
		//will be reentered into the databse with the code below.
		$sql="DELETE from materials_packaging_history where printlist_id=".$printlistId;
		mysql_query($sql);
		$tabActive = 'tab2';
		//As long as there exists a district perform this loop.

		$count=1;
		echo $count;
			while($_POST["boxNo".$count] !=null){

			$districtName=isset($_POST["districtName".$count])?mysql_real_escape_string($_POST["districtName".$count]):"";
			$countyName=isset($_POST["countyName".$count])?mysql_real_escape_string($_POST["countyName".$count]):"";
			$boxNo=isset($_POST["boxNo".$count])?mysql_real_escape_string($_POST["boxNo".$count]):"";
			$boxIds=isset($_POST["boxIds".$count])?mysql_real_escape_string($_POST["boxIds".$count]):"";
			$totalBoxes=isset($_POST["totalBoxes".$count])?mysql_real_escape_string($_POST["totalBoxes".$count]):"";
			$box1=isset($_POST["box1".$count])?mysql_real_escape_string($_POST["box1".$count]):"";
			$box2=isset($_POST["box2".$count])?mysql_real_escape_string($_POST["box2".$count]):"";
			$box3=isset($_POST["box3".$count])?mysql_real_escape_string($_POST["box3".$count]):"";
			$box4=isset($_POST["box4".$count])?mysql_real_escape_string($_POST["box4".$count]):"";

			$sql="INSERT INTO `materials_packaging_history`(`countyName`, `districtName`, `noBox`, `boxId`, `totalBoxes`, `box1`, `box2`, `box3`, `box4`,`printlist_id`,`locked`) ";
			$sql.=" VALUES ('$countyName','$districtName','$boxNo','$boxIds','$totalBoxes','$box1','$box2','$box3','$box4','$printlistId',0)";
		//	echo $sql."<br/>";
			mysql_query($sql)or die(mysql_error());

			++$count;
			}
			//This will make the editing process of the active printlist's package inaccessible
			$sql="update materials_printlist_history set packaged=1 where status=1";
			mysql_query($sql);
			$tabActive = 'tab2';
	}
	if(isset($_POST["updatePackages"])){
			//we need to delete the entries in the database so that they may be reentered.
	//	$sql="DELETE from materials_packaging_history where printlist_id=".$printlistId;
//		mysql_query($sql);
			$count=1;
		while($_POST["countyName".$count] !=null){

					$countyName=isset($_POST["countyName".$count])?mysql_real_escape_string($_POST["countyName".$count]):"";
					$districtName=isset($_POST["districtName".$count])?mysql_real_escape_string($_POST["districtName".$count]):"";
					$noBox=isset($_POST["noBox".$count])?mysql_real_escape_string($_POST["noBox".$count]):"";
					$boxIds=isset($_POST["boxIds".$count])?mysql_real_escape_string($_POST["boxIds".$count]):"";
					$totalBoxes=isset($_POST["totalBoxes".$count])?mysql_real_escape_string($_POST["totalBoxes".$count]):"";
					$box1=isset($_POST["box1".$count])?mysql_real_escape_string($_POST["box1".$count]):"";
					$box2=isset($_POST["box2".$count])?mysql_real_escape_string($_POST["box2".$count]):"";
					$box3=isset($_POST["box3".$count])?mysql_real_escape_string($_POST["box3".$count]):"";
					$box4=isset($_POST["box4".$count])?mysql_real_escape_string($_POST["box4".$count]):"";




			$sql="UPDATE `materials_packaging_history` SET ";
			$sql.="`noBox`='$noBox',`boxId`='$boxIds',`totalBoxes`='$totalBoxes',`box1`='$box1',`box2`='$box2',`box3`='$box3',";
			$sql.="`box4`='$box4' WHERE `countyName`='$countyName' AND `districtName`='$districtName'";
			//echo $sql;
			mysql_query($sql);
			++$count;

	}
}

      ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link href="../css/tabs_css.css" rel="stylesheet" type="text/css"/>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script src="../js/tabs.js"></script>
  </head>


  <body>
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
        require_once ("includes/menuLeftBar-Materials.php");
        ?>
      </div>
      <div class="contentBody" >
           <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

				<h4 class="text-center">Warning!</h4>
				   This Form will only display data from the active printlist order.Before you continue, make sure the active printlist 
				   is the one agreed upon.
   		   </div>
      
        <div class="tabbable" >
          <ul class="nav nav-tabs">

            <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Number Of Boxes</a></li>
            <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Packaging History</a></li>
         
      <!---      <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">District Training Boxes</a></li>
             <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Teacher Training Boxes</a></li>
         -->
          </ul>
          <div class="tab-content">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
            	<?php
                  //We check if the active printlist has a confirmed quote and that it is locked.
                   //   If it does have a confirmed quote and lock the data below will not be displayed
                      $sql="Select * from materials_printlist_history where status=1 AND packaged=1";
                      $results=mysql_query($sql);
                     
                      $check=mysql_affected_rows();
                      if($check<1){

                      ?>

                            <form method="POST" style="margin-left:2%;">
                            	<div style="margin-left:10%;">
                                <img style="width:10%;" src="../images/gklogo.png"/>
									<b>Kenya National School-Based Deworming Programme</b>
                                <img style="width:10%;" src="../images/kwaAfya.png"/>
                              <hr style="font-weight:bolder;color:#EEEE;"/>
                                </div>   
				<h4 style="margin-left:20%;">Number of boxes and their unique ID per District in each county</h4>
				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Id</th> 
						<th>County</th>
						<th>District</th>
						<th>Number Of Boxes</th>
						<th>Box Id Numbers</th>
						<th>District Training Boxes</th>
						<th>Teacher Training Boxes</th>
						
					</tr>
					<?php
			$sql="Select * from materials_printlist_history where status=1";
                      $results=mysql_query($sql);
                      while($row=mysql_fetch_array($results)){
                      	$districts=$row["districts"];
                      }
                      $districts=unserialize($districts);
					$sql="SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r where a.district_name=r.activity_venu ";
			 		

       foreach ($districts as $key => $value) {
       	
       	 if($key==0){
              $sql.="AND a.district_name='".$value."'";        
          }else{
           $sql.=" OR a.district_name='".$value."'";
         }

       }

$sql.="GROUP BY a.district_name ORDER BY county_name,district_name ASC";
			 			$result= mysql_query($sql);
  				$resultB=mysql_query($sql);
  				$id=1;
					while($row=mysql_fetch_array($resultB)){
					$countyName=$row["county_name"];
					$districtName=$row["district_name"];
					$link="materials_packing.php?id='$id'";
					?>
					<tr rowspan="3" >
					<td><?php echo $id; ?></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="countyName<?php echo $id; ?>" value="<?php echo $countyName;?>" /></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="districtName<?php echo $id; ?>" value="<?php echo $districtName;?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="boxNo<?php echo $id; ?>" value="" /></td>
				
					<td><textarea name="boxIds<?php echo $id; ?>"></textarea></td>
		   <td><a href="materials_packing.php?tab=3&districtName=<?php echo $districtName; ?>&countyName=<?php echo $districtName;?>"><img src="../images/icons/view2.png" height="20px"/></a></td>
			   <td><a href="materials_packing.php?tab=4&districtName=<?php echo $districtName; ?>&countyName=<?php echo $districtName;?>"><img src="../images/icons/view2.png" height="20px"/></a></td>
				
				</tr>
				<?php 
				++$id;
				}
					?>

					<tr><td colspan="11"><input type="submit" name="savePackages" class="btn btn-info" value="Save Details" style="margin-left:40%;" /></td></tr>
				</table>
               </form> 


                        <?php
                     



                      }else{
                          ?>
                       <h2 id="h2info"style="background:#bada66;">The Active Printlist has already been Packaged .Selet view in the Packaging history to make changes or to Print to it.</h2>
                       <?php
                      }
                        ?>
            </div>
    <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
	

	<?php
	$sql="select * from materials_printlist_history where packaged=1";
    $result=mysql_query($sql);
	$numrow=mysql_affected_rows();
	if($numrow>=1){

		?>
<form method="post">

  <h2 id="h2info"style="background:#bada66;"><?php echo $updateResult;  ?></h2>
	<table align="center" class="table table-bordered table-condensed  table-hover">
	   <tr>
	   	<th>Printlist Id</th>
	   	 <th>Vendor Id</th>
	   	 <th>Vendor Name</th>
	   	 <th>Prepared By</th>
	   	 <th>Time Stamp</th>
	   	 <th>Active</th>
	   	 <th>View Packaging Information</th>
	   	 <th>Delete</th>
	   	 
	   	</tr>
	   	<?php

	   		   	while($row=mysql_fetch_array($result)){
	   	
			   if($row["status"]==1){
			   	$active="YES";
			   	  echo "<tr style='background:#bada66;'>";
			   }else{
			   	$active="NO";
			   	echo " <tr>";
			   }
			   
			   $unixDate=$row["time_set"];
			   $year=date('Y',$unixDate);
			   $month=date('M',$unixDate);
               $day=date('d',$unixDate);
               $suffix=date('S',$unixDate);
			   $hour=date('g',$unixDate);
			//   $min=date('i',$unixDate);
			   $setTime=date('A',$unixDate);
			   $dayWeek=date('l',$unixDate);

			 //  $date=date("Y-m-d",$row["date"]);
              $date=$day."<sup>".$suffix."</sup> ".$month." ".$year." -".$hour." ".$setTime." ".$dayWeek;
			  // $date=$row["date"];

	   		?>
	 
	   		   <td><?php echo $row["id"]; ?></td>
	   		   <td><?php echo $row["vendor_id"]; ?></td>
			   <td><?php echo $row["vendor_name"]; ?></td>
			   <td><?php echo $row["prepared_by"]; ?></td>
			   <td><?php echo $date; ?></td>
			   <td><?php echo $active; ?></td>
			   <td><a href="materials_packing.php?id=<?php echo $row['id'] ?>#editPackage"><img src="../images/icons/view2.png" height="20px"/></a></td>
			   <td><a href="javascript:void(0)" onclick="show_confirm(<?php echo $row['id']; ?>)"><img src="../images/icons/delete.png" height="20px"/></a></td>
	   </tr>
	   <?php
			}
		?>

	   </table>
</form>
<?php
}else{

?>

  <h2 id="h2info"style="background:#bada66;">No Vendor has Set their Packaging information</h2>
<?php
}



if(isset($_POST["saveDTB"])){


$docTitles[]=["masterTrainer","Dcpacket","Dpho","Dtb","ttb","hfd","gdlm","ttk","formA","formAp","posterA","posterB"];
//This are the documents will pass thru. I have put them like this because they will always be as they are now.

//We will loop through an array checking if the doc titles have a certain number. i.e mastertriners box1 ,2 an so forth
//The values will then be passed into a single array
$count=1;//This is for checking box 1,2,3
$append=0;//This is for going through the different elements in the array doctitles
$dtbArray=Array();
$boxes1=$_POST["boxes1"];
$county1=$_POST["county1"];
$district1=$_POST["district1"];
//echo "The value of mt1 is".$_POST[$docTitles[1].'1'];
//echo "Master Trainers</br>";
//This is where the quantities of all the boxes will be entered
while(isset($_POST[$docTitles[0][$append].$count])){

$dtbArray[]=$docTitles[0][$append].$count;
if($count<$boxes1){
++$count;

}else{
	++$append;
	$count=1;
}

}

//This is how we will insert the new box quantities.
//I made the decision to save all the quantities in the boxes inside a serialized array that we will put on a single field
//The Number of Boxes though will have a box of its own for simplicity

$sql="UPDATE materials_packaging_history set dtb='$boxes1',dtb_quantites='$dtbArray' WHERE printlist_id='$printlistId'";
$sql.=" AND countyName='$county1' AND districtName='$district1'";
mysql_query($sql) or die(mysql_error());



}
?>

	</div>
            <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">

				<form action="materials_packing.php" method="post" style="margin-left:10%;">
                            	
                            		<h2>District Training Box</h2>
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>

							<?php
							$tablename = 'counties';
							$fields = 'id, county';
							$where = '1=1';
							$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
							?>

							<div class="row" style="font-size:1.3em;font-weight:bold;margin:5%;margin-left:15%;">
								<div class="span4">
									<label>County<?php echo ": ".$county; ?></label>
								</div>
									<br/><br/>
								<div class="span4">
									<label>District<?php echo ": ".$district; ?></label>
									
								</div>
							</div>





			                  									<br/>
			                  	Box Type:<h3>District Training</h3><br/>	&nbsp; Boxes To Pack: &nbsp; </td>
					<input type="text" name="boxes1" class="input-mini" value="<?php echo $boxes1; ?>" />
					<input type="hidden" name="county1" class="input-mini" value="<?php echo $county; ?>"/>
					<input type="hidden" name="district1" class="input-mini" value="<?php echo $district; ?>"/>
					<input type="submit" class="btn btn-info" id="districtSave" name="districtSave" value="Generate materials" />
			                  	<br/><br/>
					         
               <?php
							if(isset($county) && isset($district)){
					?>
		<a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="materials_packing.php?pdfDTB='<?php echo $district; ?>'&county=<?php echo $county; ?>">View Pdf</a>
			         	<h3>Contents</h3>
	
				
				
				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<th>Box ".$append."</th>";
							++$append;
							--$count;
						}
					?>
					</tr>
					<?php

					//Finding out no of division fr this district

					$sql="select * from divisions where district_name='".$district."'";
					$resultA=mysql_query($sql);
					$noDiv=mysql_affected_rows();

				//	echo $noDiv;
				//	echo $sql;
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out the teacher training variables

//Masters Package





	//This Logic is  quite simple. We are extracting the serialized array from the db from the column assumptions
	//now the array is an array within an array.The arrangements of the elements are as follows
	//0.Materials 1.Packet 2.var1  3.var2  4.var3  5.var4 6.var5 7.extra
	//These assumptions ALWAYS  belong to the active printlist

            $sql="select assumptions from materials_printlist_history where status=1";
            $resultA=mysql_query($sql);
            $materialDesc=array();
            while($key=mysql_fetch_array($resultA)){
             $materialDesc=unserialize($key["assumptions"]);

            }
          
            foreach ($materialDesc as $key => $value) {
		           

		//		echo $key." ".$value[0].$value[1].$value[3].$value[4]."<br/>";	


            	switch($value[0]){


            		case "ATTNR-MoESTST Day 1":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;

	case "ATTNR-MoESTST Day 2":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;


	case "ATTNR- Moh Day 1":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;


	case "ATTNR- MoH Day 2":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;


	case "Form MT":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;


	case "Form P (school list)":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;

case "Form P (programme activities)":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($value[1]+$value[2]+$value[3]+$value[4]+$value[5])*$percent;
						$masterTrainers=ceil($masterTrainers);

            		break;

//Master Triners Packet End

//Dc Packet Start






				}
			}
/*

					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='Master Trainers Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($row["var1"]+$row["var2"]+$row["var3"]+$row["var4"]+$row["extra"])*$percent;
						$masterTrainers=ceil($masterTrainers);

					}
					*/

$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DC Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						if($row["var2"]==0){
							$row["var2"]=1;
						}


						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}
						$dcPacket+=(($row["var1"]*$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$dcPacket=ceil($dcPacket+$row["extra"]);

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DPHO Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$dphoPackets+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$dphoPackets=ceil($dphoPackets+$row["extra"]);

					}
						$sql="select * from materials_desc where materials ='District Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$dtb+=(($row["var1"]+($row["var2"]*$noDiv))+($row["var3"]+$row["var4"]))*$percent;
						$dtb=ceil($dtb+$row["extra"]);

					}

				$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet (new)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb+=(($row["var1"]+($noDiv*$row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$ttb=ceil($ttb+$row["extra"]);

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Handout on Financial Disbursements'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
								$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$hfd+=(($row["var1"]+($noDiv*$row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$hdf=ceil($hfd+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Guide for District Level Managers (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$gdlm+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$gdlm=ceil($gdlm+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Kit (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttk+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$ttk=ceil($ttk+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form A'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
					$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formA+=((($row["var1"]*$noDiv)+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$formA=ceil($formA+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form AP'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formAp+=((($row["var1"]*$noDiv)+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$formAp=ceil($formAp+$row["extra"]);
					}
						$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 1'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster1+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$poster1=ceil($poster1+$row["extra"]);
					}
						$sql="select * from materials_desc where material_category ='Regional Training Boxes' AND materials='Poster 2'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
							}


						$poster2+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$poster2=ceil($poster2+$row["extra"]);
					}
						// echo $row["materials"]; 
						//Master Trainers Packet
					/*					//long method 
					if($key["materials"]=="ATTNR-MoESTST Day 1"){
					      $attnr_moed1_perdist = $key["var1"];
					    }

					if($key["materials"]=="ATTNR-MoEST Day 2"){
					      $attnr_moed2_perdist = $key["var1"];
					    }

					if($key["materials"]=="ATTNR- Moh Day 1"){
					      $attnr_mohd1_perdist = $key["var1"];
					    }
					     
					     
					if($key["materials"]=="ATTNR- MoH Day 2"){
					      $attnr_mohd2_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form MT"){
					      $formMT_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form P (school list)"){
					      $formP_slist_perdist = $key["var1"];
					    }

					if($key["materials"]=="Form P (programme activities)"){
					      $formP_pactivities_perdist = $key["var1"];
					    }
				
					//
									*/
				
				//$masterTrainers=$attnr_moed1_perdist+$attnr_moed2_perdist+$attnr_mohd1_perdist+ $attnr_mohd2_perdist+ $formMT_perdist
				//+$formP_slist_perdist+$formP_pactivities_perdist;
					?>

					<tr rowspan="3" >
					<td>1
					&nbsp; Master Trainers Packet: &nbsp; </td>
					<td><?php echo $masterTrainers; ?></td>

					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='masterTrainer".$append."' value=''/></td>";
							++$append;
							--$count;
						}
					?>
				</tr>
				<tr rowspan="3" >
					<td>2
					&nbsp; DC Packet: &nbsp; </td>
					<td><?php echo $dcPacket; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='Dcpacket".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>3
					&nbsp; DPHO Packet: &nbsp; </td>
					<td><?php echo $dphoPackets; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='Dpho".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>4
					&nbsp;District Training Booklet: &nbsp; </td>
					<td><?php echo $dtb; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='Dtb".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>5
					&nbsp;Teacher Training Booklet: &nbsp; </td>
					<td><?php echo $ttb; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='ttb".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>6
					&nbsp;
				Handout on Financial Disbursements: &nbsp; </td>
					<td><?php echo $hfd; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='hfd".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>7
					&nbsp;
				Guide for District Level Managers (old): &nbsp; </td>
					<td><?php echo $gdlm; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='gdlm".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>
				<tr rowspan="3" >
					<td>8
					&nbsp;
				 Teacher Training Kit (old): &nbsp; </td>
					<td><?php echo $ttk; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='ttk".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>

					<tr rowspan="3" >
					<td>9
					&nbsp;
				 Form A: &nbsp; </td>
					<td><?php echo $formA; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='formA".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>

	<tr rowspan="3" >
					<td>10
					&nbsp;
				  Form AP: &nbsp; </td>
					<td><?php echo $formAp; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='formAp".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>

	<tr rowspan="3" >
					<td>11
					&nbsp;
				  Poster 1 - Deworming Date: &nbsp; </td>
					<td><?php echo $poster1; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='posterA".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>

	<tr rowspan="3" >
					<td>12
					&nbsp;
				  Poster 2 – Behavior change &nbsp; </td>
					<td><?php echo $poster2; ?></td>
					
					<?php

						$count=$boxes1;
						$append=1;
						
						while($count){
							echo "<td><input type='text' class='input-mini' name='posterB".$append."' value=''/></td>";
							++$append;
							--$count;
						}
						?>
				</tr>

				</table>

               <input type="submit" name="saveDTB" value="Save Details" style="margin-left:30%;"class="btn btn-info" />
				<?php 
               }
               ?>
               </form>

               
             </div> 


            <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">


	<form method="post" style="margin-left:10%;">
                            	<div style="margin-left:10%;">

                            		<h2>Teacher Training Box</h2>
			                                <img style="width:10%;" src="../images/gklogo.png"/>
												<b>Kenya National School-Based Deworming Programme</b>
			                                <img style="width:10%;" src="../images/kwaAfya.png"/>
			                              <hr style="font-weight:bolder;color:#EEEE;"/>
			                                 
			             
							<?php
							$tablename = 'counties';
							$fields = 'id, county';
							$where = '1=1';
							$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
							?>

							<div class="row">
								<div class="span4">
									<label>County</label>
									<select onchange="get_district2(this.value);" id="selectcounty" name="county2" class="input_select">
									<?php
										if($county){
									echo "  <option selected=\"selected\" value=\"$county\">$county</option>";
										}else{

									?>
									  <option selected="selected" value="">Choose County</option>
									  <?php }
									  foreach ($insertformdata as $insertformdatacab) { ?>
									    <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
									  <?php } ?>
									</select>
								</div>

								<div class="span4">
									<label>District</label>
									<select onchange="submitCounty();" id="selectdistrict2" name="district2" class="input_select">
									  <?php
										if($district){
									echo "  <option selected=\"selected\" value=\"$district\">$district</option>";
										}else{
											?>
									  <option selected="selected" value="">Choose District</option>
									
										<?php } ?>

									</select>
								</div>
							</div>





			                  					<input type="submit" style="display:none;" id="teacherSave" name="teacherSave" value="save" />
			                  					<br/>
			                  	Box Type:<h3>Teacher Training</h3><br/>
					         
               <?php
							if(isset($county) && isset($district)){
					?>
			                  
	<a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="materials_packing.php?pdfTTB=<?php echo $district; ?>&county=<?php echo $county; ?>">View Pdf</a>
		
			                  	<h3>Contents</h3>

 							</div> 

				<table class="table table-bordered table-condensed table-striped table-hover">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
					<?php
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out everything but the teacher training variables

					//Teacher Training


					//find out the number of schools in the districts selected
					$sql="select * from a_bysch where county_name='$county' AND district_name='$district'";

					$resultE=mysql_query($sql);
					$noSch=mysql_affected_rows();

				//	echo $noSch."<h1>Help</h1>";
					//Find out no of schisto schools
					//ap_attached column logic:if Yes it is a schisto school else sth

					$sql="select * from a_bysch where county_name='$county' AND district_name='$district' AND (ap_attached='YES' or ap_attached='Yes')";
					
					$resultE=mysql_query($sql);
					$noSchisto=mysql_affected_rows();
					//echo $noSchisto." schisto schools<br/>";
					//finding out the no of sth schools
					//ap_attached column logic:if Yes it is a schisto school else sth
					
					
					$sql="select * from a_bysch where county_name='$county' and district_name='$district' AND (ap_attached='NO' or ap_attached='No')";
					//echo $sql;
					$resultE=mysql_query($sql);
					$noSth=mysql_affected_rows();


					//echo $noSth." sth schools";


/*
						$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb=((($row["var1"]*$noSch)+($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$ttb=ceil($ttb+$row["extra"]);

					}

					*/


	//This Logic is  quite simple. We are extracting the serialized array from the db from the column assumptions
	//now the array is an array within an array.The arrangements of the elements are as follows
	//0.Materials 1.Packet 2.var1  3.var2  4.var3  5.var4 6.var5 7.extra
	//These assumptions ALWAYS  belong to the active printlist

            $sql="select assumptions from materials_printlist_history where status=1";
            $resultA=mysql_query($sql);
            $materialDesc=array();
            while($key=mysql_fetch_array($resultA)){
             $materialDesc=unserialize($key["assumptions"]);

            }
          
            foreach ($materialDesc as $key => $value) {
		           

			//	echo $key." ".$value[0].$value[1].$value[3].$value[4]."<br/>";	


            	switch($value[0]){



            		case "Teacher Training Booklet":

				$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$ttb=ceil($ttb+$value[7]);

            		break;


            		case "Form E Packet (20 forms each)":

            			$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formE=((($value[3]*$noSch))+($value[4]+$value[5]))*$percent;
						$formE=ceil($formE+$value[7]);
						$formE=ceil($value[2]*$formE);


            		break;
            		

            		case "Form N Packet (15 forms each)":

            		$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formN=((($value[3]*$noSch))+($value[4]+$value[5]))*$percent;
						$formN=ceil($formN+$value[7]);
						$formN=ceil($value[2]*$formN);

            		break;

          		case "Form S Packet (5 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formS=((($value[3]*$noSth))+($value[4]+$value[5]))*$percent;
						$formS=ceil($formS+$value[7]);
						$formS=ceil($value[2]*$formS);


            		break;


            		case "Form E-P Packet (20 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formEp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formEp=ceil($formEp+$value[7]);
						$formEp=ceil($value[2]*$formEp);



            		break;


            		case "Form N-P Packet (15 forms each)":
					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formNp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formNp=ceil($formNp+$value[7]);
						$formNp=ceil($value[2]*$formNp);


            		break;

            		case "Form S-P Packet (5 forms each)":


						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formSp=((($value[3]*$noSchisto))+($value[4]+$value[5]))*$percent;
						$formSp=ceil($formSp+$value[7]);
						$formSp=ceil($value[2]*$formSp);




            		break;

            		case "ATTNT Packet (20 forms each)":

					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$attnt=((($value[3]))+($value[4]+$value[5]))*$percent;
						$attnt=ceil($attnt+$value[7]);
						$attnt=ceil($value[2]*$attnt);

            		break;


            		case "Poster 1- Date":

						$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster1=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$poster1=ceil($poster1);


            		break;
            		case "Poster 2- Behavior Change":

					$percent=($value[6]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster2=((($value[2]*$noSch)+($value[3]))+($value[4]+$value[5]))*$percent;
						$poster2=ceil($poster2);

            		break;


            	}


            }


	?>






						<tr rowspan="3" >
					<td>1
					&nbsp; Teacher Training Booklet: &nbsp; </td>
					<td><?php echo $ttb; ?></td>
					
					</tr>


						<tr rowspan="3" >
					<td>2
					&nbsp; Form E Packet (20 forms each): &nbsp; </td>
					<td><?php echo $formE; ?></td>
					
					</tr>

						

						<tr rowspan="3" >
					<td>3
					&nbsp; Form N Packet (15 forms each): &nbsp; </td>
					<td><?php echo $formN; ?></td>
					
					</tr>

					
						<tr rowspan="3" >
					<td>4
					&nbsp; Form S Packet (5 forms each): &nbsp; </td>
					<td><?php echo $formS; ?></td>
					
					</tr>
						<tr rowspan="3" >
					<td>5
					&nbsp; Form E-P Packet (20 forms each): &nbsp; </td>
					<td><?php echo $formEp; ?></td>
					
					</tr>

						
						<tr rowspan="3" >
					<td>6
					&nbsp; Form N-P Packet (5 forms each): &nbsp; </td>
					<td><?php echo $formNp; ?></td>
					
					</tr>

						<tr rowspan="3" >
					<td>7
					&nbsp; Form S-P Packet (5 forms each): &nbsp; </td>
					<td><?php echo $formSp; ?></td>
					
					</tr>

					
						<tr rowspan="3" >
					<td>8
					&nbsp; ATTNT Packet (20 forms each): &nbsp; </td>
					<td><?php echo $attnt; ?></td>
					
					</tr>

						
						<tr rowspan="3" >
					<td>9
					&nbsp; Poster 1- Date: &nbsp; </td>
					<td><?php echo $poster1; ?></td>
					
					</tr>

						
					<tr rowspan="3" >
					<td>10
					&nbsp; Poster 2- Behavior Change: &nbsp; </td>
					<td><?php echo $poster2; ?></td>
					
					</tr>

									
							
								
								



						<?php


					

					?>
				

				</table>
               </form>

               <?php 
               }
               ?>



            </div>

            </div>
          </div>
        </div>




<div id="editPackage" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div style="height:480px;overflow:auto;">
  	<div>
    <a href="materials_packing.php" title="Close" class="close">X</a>
    <!-- ================= -->
    <?php

$printlistId=$_GET["id"];
    ?>
    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>

                   <form method="POST" style="margin-left:2%;">
                            	<div style="margin-left:10%;">

                                <img style="width:10%;" src="../images/gklogo.png"/>
									<b>Kenya National School-Based Deworming Programme</b>
                                <img style="width:10%;" src="../images/kwaAfya.png"/>
                              <hr style="font-weight:bolder;color:#EEEE;"/>
                                </div>   
				<h4 style="margin-left:20%;">Number of boxes and their unique ID per District in each county</h4>
				<table class="table table-bordered table-condensed table-striped table-hover" style="">
					<tr>
						<th>Id</th> 
						<th>County</th>
						<th>District</th>
						<th>Number Of Boxes</th>
						<th>Total Boxes Per County</th>
						<th>Box Id Numbers</th>
						<th>Box 1</th>
						<th>Box 2</th>
						<th>Box 3</th>
						<th>Box 4</th>
						<th>Status</th>
						
					</tr>
					<?php

					$sql="SELECT * from materials_packaging_history where printlist_id=".$printlistId;
			 			$result= mysql_query($sql);
  				$resultB=mysql_query($sql);
  				$id=1;
					while($row=mysql_fetch_array($resultB)){
					$countyName=$row["countyName"];
					$districtName=$row["districtName"];
					$noBox=$row["noBox"];
					$boxIds=$row["boxId"];
					$totalBoxes=$row["totalBoxes"];
					$box1=$row["box1"];
					$box2=$row["box2"];
					$box3=$row["box3"];
					$box4=$row["box4"];

					?>
					<tr rowspan="3" >
					<td><?php echo $id; ?></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="countyName<?php echo $id; ?>" value="<?php echo $countyName;?>" /></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="districtName<?php echo $id; ?>" value="<?php echo $districtName;?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="noBox<?php echo $id; ?>" value="<?php echo $noBox; ?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="totalBoxes<?php echo $id; ?>" value="<?php echo $totalBoxes; ?>" /></td>
					<td><textarea name="boxIds<?php echo $id; ?>"><?php echo $boxIds; ?></textarea></td>
					<td><input  class="num-only input-mini" type="text" name="box1<?php echo $id; ?>" value="<?php echo $box1; ?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="box2<?php echo $id; ?>" value="<?php echo $box2; ?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="box3<?php echo $id; ?>" value="<?php echo $box3; ?>" /></td>
					<td><input  class="num-only input-mini"  type="text" name="box4<?php echo $id; ?>" value="<?php echo $box4; ?>" /></td>
					<td style='background:#bada66;'><?php  

					$boxes=($noBox-($box1+$box2+$box3+$box4));
						if($boxes<0){
							echo "Extra Boxes Found";
						}
						if($boxes>0){
							echo "Boxes Missing";
						}
						if($boxes==0){
							echo "OK";
						}
						?>

					</td>
					
				</tr>
				<?php 
				++$id;
				}
					?>

					<tr><td colspan="5"><input type="submit" name="updatePackages" class="btn btn-info" value="Update Details" style="margin-left:40%;margin-top:5%;" /></td>
						<td colspan="5"><a  class="btn btn-info" style="text-decoration:none;margin-top:5%;" target="blank" href="materials_packing.php?pdfView='<?php echo $printlistId; ?>'">View Pdf</a></td>
   
					</tr>
				</table>



		</div>
	</div>
</div>















			<script>



      $(document).find("input.num-only").keydown(function (e) {
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

	            function submitCounty() {
	              var selectButton = document.getElementById('teacherSave');
	              selectButton.click();
		        
	            }
   	            function submitDistrict() {
	              var selectButton = document.getElementById('districtSave');
	              selectButton.click();
		        
	            }
				  //GET district
				  function get_district(txt) {
					$.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
					  $('#selectdistrict').html(data);//alert(data);
					});
				  }
				   function get_district2(txt) {
					$.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
					  $('#selectdistrict2').html(data);//alert(data);
					});
				  }
	
				function show_confirm(deleteid) {
				      if (confirm("Are you sure you want to delete?")) {
				        location.replace('?unpackId=' + deleteid);
				      } else {
				        return false;
				      }
				    }
            </script>

					<?php

if(isset($_GET["pdfView"])){
  $pdfView=$_GET["pdfView"];

					$sql="SELECT * from materials_packaging_history where printlist_id=".$pdfView;
			 			$result= mysql_query($sql);
  				$resultB=mysql_query($sql);
  				$id=1;

  				  $data="<div style=\"margin-left:10%;\">
                               
                                </div>   
				<table class=\"table table-bordered table-condensed table-striped table-hover\">
					<tr>
						<th>Id</th> 
						<th>County</th>
						<th>District</th>
						<th>Number Of Boxes</th>
						<th>Total Boxes Per County</th>
						<th>Box Id Numbers</th>
						<th>Box 1</th>
						<th>Box 2</th>
						<th>Box 3</th>
						<th>Box 4</th>
						<th>Status</th>
						
					</tr>";
					while($row=mysql_fetch_array($resultB)){
					$countyName=$row["countyName"];
					$districtName=$row["districtName"];
					$noBox=$row["noBox"];
					$boxId=$row["boxId"];
					$totalBoxes=$row["totalBoxes"];
					$box1=$row["box1"];
					$box2=$row["box2"];
					$box3=$row["box3"];
					$box4=$row["box4"];
      			$data.="<tr><td>";
      			$data.=$id;
      			$data.="</td><td>";
      			$data.=$countyName;
				$data.="</td><td>";
				$data.=$districtName;
				$data.="</td><td>";
				$data.=$noBox;      			
				$data.="</td><td>";
				$data.=$totalBoxes;
				$data.="</td><td>";
				$data.=$boxId;
				$data.="</td><td>";
				$data.=$box1;
				$data.="</td><td>";
				$data.=$box2;
				$data.="</td><td>";
				$data.=$box3;
				$data.="</td><td>";
				$data.=$box4;
				$data.="</td><td>";
				

				$boxes=($noBox-($box1+$box2+$box3+$box4));
						if($boxes<0){
						$data.="Extra Boxes Found";
						}
						if($boxes>0){
						$data.= "Boxes Missing";
						}
						if($boxes==0){
						$data.= "OK";
						}



      			$data.="</td></tr>";





	++$id;
				}


$data.="</table>";


//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
 //$_SESSION["tableData"].="Hello";
  header("Location:../tcpdf/examples/materials_packing_pdf.php?pdf=material_packing.pdf");
  exit();









}

if(isset($_GET["pdfDTB"])){
  $pdfDTB=$_GET["pdfDTB"];
$county=$_GET["county"];
					        	
			        
						
							$tablename = 'counties';
							$fields = 'id, county';
							$where = '1=1';
							$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
						




			               $data="<br/><br/>Box Type:<h3>District Training</h3><br/>";

					         $data.="County: ".$county." District Name: ".$pdfDTB;
           			        $data.=" 	<h3>Contents</h3>
	

				<table class=\"table table-bordered table-condensed table-striped table-hover\">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
				";
				

					//Finding out no of division fr this district

					$sql="select * from divisions where district_name=".$pdfDTB."";
					//$data.=$sql;
					$resultA=mysql_query($sql);
					$noDiv=mysql_affected_rows();

				//	echo $noDiv;
				//	echo $sql;
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out the teacher training variables

//Masters Package

					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='Master Trainers Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$masterTrainers+=($row["var1"]+$row["var2"]+$row["var3"]+$row["var4"]+$row["extra"])*$percent;
						$masterTrainers=ceil($masterTrainers);

					}

$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DC Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						if($row["var2"]==0){
							$row["var2"]=1;
						}


						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}
						$dcPacket+=(($row["var1"]*$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$dcPacket=ceil($dcPacket+$row["extra"]);

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND packet='DPHO Packet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						


						$dphoPackets+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$dphoPackets=ceil($dphoPackets+$row["extra"]);

					}
						$sql="select * from materials_desc where materials ='District Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}

						$dtb+=(($row["var1"]+($row["var2"]*$noDiv))+($row["var3"]+$row["var4"]))*$percent;
						$dtb=ceil($dtb+$row["extra"]);

					}

				$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet (new)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb+=(($row["var1"]+($noDiv*$row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$ttb=ceil($ttb+$row["extra"]);

					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Handout on Financial Disbursements'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
								$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$hfd+=(($row["var1"]+($noDiv*$row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$hdf=ceil($hfd+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Guide for District Level Managers (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$gdlm+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$gdlm=ceil($gdlm+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Kit (old)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttk+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$ttk=ceil($ttk+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form A'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
					$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formA+=((($row["var1"]*$noDiv)+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$formA=ceil($formA+$row["extra"]);
					}
					$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Form AP'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formAp+=((($row["var1"]*$noDiv)+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$formAp=ceil($formAp+$row["extra"]);
					}
						$sql="select * from materials_desc where material_category !='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 1'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster1+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$poster1=ceil($poster1+$row["extra"]);
					}
						$sql="select * from materials_desc where material_category ='Regional Training Boxes' AND materials='Poster 2'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
							}


						$poster2+=(($row["var1"]+$row["var2"])+($row["var3"]+$row["var4"]))*$percent;
						$poster2=ceil($poster2+$row["extra"]);
					}
				
               

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>1
					&nbsp; Master Trainers Packet: &nbsp; </td>";
					$data.="<td>".$masterTrainers."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>2
					&nbsp; DC Packet: &nbsp;</td>";
					$data.="<td>".$dcPacket."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>3
					&nbsp; DPHO Packet: &nbsp; </td>";
					$data.="<td>".$dphoPackets."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>4
					&nbsp;District Training Booklet: &nbsp; </td>";
					$data.="<td>".$dtb."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>5
					&nbsp;Teacher Training Booklet: &nbsp;  </td>";
					$data.="<td>".$ttb."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>6
					&nbsp;
				Handout on Financial Disbursements: &nbsp;  </td>";
					$data.="<td>".$hfd."</td>";
					$data.="</tr>";


					$data.="<tr rowspan=\"3\" >";
					$data.="<td>7
					&nbsp;
				Guide for District Level Managers (old): &nbsp;  </td>";
					$data.="<td>".$gdlm."</td>";
					$data.="</tr>";

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>8
					&nbsp;
				 Teacher Training Kit (old): &nbsp;  </td>";
					$data.="<td>".$ttk."</td>";
					$data.="</tr>";

				$data.="<tr rowspan=\"3\" >";
					$data.="<td>9
					&nbsp;
				 Form A: &nbsp;  </td>";
					$data.="<td>".$formA."</td>";
					$data.="</tr>";


				$data.="<tr rowspan=\"3\" >";
					$data.="<td>10
					&nbsp;
				  Form AP: &nbsp;  </td>";
					$data.="<td>".$formAp."</td>";
					$data.="</tr>";

				$data.="<tr rowspan=\"3\" >";
					$data.="<td>11
					&nbsp;
				  Poster 1 - Deworming Date: &nbsp; </td>";
					$data.="<td>".$poster1."</td>";
					$data.="</tr>";


				$data.="<tr rowspan=\"3\" >";
					$data.="<td>12
					&nbsp;
				  Poster 2 – Behavior change &nbsp;</td>";
					$data.="<td>".$poster2."</td>";
					$data.="</tr>";



//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
 //$_SESSION["tableData"].="Hello";
  header("Location:../tcpdf/examples/materials_packing_pdf.php?pdf=material_packingDTB.pdf");
  exit();









}


if(isset($_GET["pdfTTB"])){
  $district=$_GET["pdfTTB"];
  $county=$_GET["county"];


                	$data.="Box Type:<h3>Teacher Training</h3><br/>";



					$data.="County: ".$county." District Name: ".$district;
                	$data.="
					         

			                  	<h3>Contents</h3>

				<table class=\"table table-bordered table-condensed table-striped table-hover\">
					<tr>
						<th>Document Title</th>
						<th>Quantity</th>
						
					</tr>
					";
					$count=1;
					//$sql="select * from materials_desc where packet='Master Trainers Packet' or packet='DC Packet'";
					//$sql.=" or packet='DMOH Packet' or packet='District Training Booklet'";
					//$sql.=" or materials= 'Teacher Training Booklet' or packet=''";

					//This logic will only filter out everything but the teacher training variables

					//Teacher Training


					//find out the number of schools in the districts selected
					$sql="select * from a_bysch where county_name='$county' AND district_name='$district'";

					$resultE=mysql_query($sql);
					$noSch=mysql_affected_rows();

				//	echo $noSch."<h1>Help</h1>";
					//Find out no of schisto schools
					//ap_attached column logic:if Yes it is a schisto school else sth

					$sql="select * from a_bysch where county_name='$county' AND district_name='$district' AND (ap_attached='YES' or ap_attached='Yes')";
					
					$resultE=mysql_query($sql);
					$noSchisto=mysql_affected_rows();
					//echo $noSchisto." schisto schools<br/>";
					//finding out the no of sth schools
					//ap_attached column logic:if Yes it is a schisto school else sth
					
					
					$sql="select * from a_bysch where county_name='$county' and district_name='$district' AND (ap_attached='NO' or ap_attached='No')";
					//echo $sql;
					$resultE=mysql_query($sql);
					$noSth=mysql_affected_rows();


					//echo $noSth." sth schools";



						$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Teacher Training Booklet'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$ttb=((($row["var1"]*$noSch)+($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$ttb=ceil($ttb+$row["extra"]);

					}














						$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form E Packet (20 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formE=((($row["var2"]*$noSch))+($row["var3"]+$row["var4"]))*$percent;
						$formE=ceil($formE+$row["extra"]);
						$formE=ceil($row["var1"]*$formE);
					}
						
	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form N Packet (15 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formN=((($row["var2"]*$noSch))+($row["var3"]+$row["var4"]))*$percent;
						$formN=ceil($formN+$row["extra"]);
						$formN=ceil($row["var1"]*$formN);
					}

	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form S Packet (5 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formS=((($row["var2"]*$noSth))+($row["var3"]+$row["var4"]))*$percent;
						$formS=ceil($formS+$row["extra"]);
						$formS=ceil($row["var1"]*$formS);
					}
					

	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form E-P Packet (20 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formEp=((($row["var2"]*$noSchisto))+($row["var3"]+$row["var4"]))*$percent;
						$formEp=ceil($formEp+$row["extra"]);
						$formEp=ceil($row["var1"]*$formEp);
					}
					

	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form N-P Packet (15 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formNp=((($row["var2"]*$noSchisto))+($row["var3"]+$row["var4"]))*$percent;
						$formNp=ceil($formNp+$row["extra"]);
						$formNp=ceil($row["var1"]*$formNp);
					}

	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Form S-P Packet (5 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$formSp=((($row["var2"]*$noSchisto))+($row["var3"]+$row["var4"]))*$percent;
						$formSp=ceil($formSp+$row["extra"]);
						$formSp=ceil($row["var1"]*$formSp);
					}

	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='ATTNT Packet (20 forms each)'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$attnt=((($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$attnt=ceil($attnt+$row["extra"]);
						$attnt=ceil($row["var1"]*$attnt);
					}


	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 1- Date'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster1=((($row["var1"]*$noSch)+($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$poster1=ceil($poster1);
					}
					
	
	$sql="select * from materials_desc where material_category ='Teacher Training Boxes' AND material_category !='other' AND materials='Poster 2- Behavior Change'";
					$resultB=mysql_query($sql);

					while($row=mysql_fetch_array($resultB)){
						$percent=($row["var5"]+100)/100;
						if($percent==10){
							$percent=1;
						}


						$poster2=((($row["var1"]*$noSch)+($row["var2"]))+($row["var3"]+$row["var4"]))*$percent;
						$poster2=ceil($poster2);
					}	
						



				$data.="<tr rowspan=\"3\" >";
					$data.="<td>1
					&nbsp; Teacher Training Booklet: &nbsp;</td>";
					$data.="<td>".$ttb."</td>";
					$data.="</tr>";




				$data.="<tr rowspan=\"3\" >";
					$data.="<td>2
					&nbsp; Form E Packet (20 forms each): &nbsp;</td>";
					$data.="<td>".$formE."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>3
					&nbsp; Form N Packet (15 forms each): &nbsp;</td>";
					$data.="<td>".$formN."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>4
					&nbsp; Form S Packet (5 forms each): &nbsp; </td>";
					$data.="<td>".$formS."</td>";
					$data.="</tr>";




					$data.="<tr rowspan=\"3\" >";
					$data.="<td>5
					&nbsp; Form E-P Packet (20 forms each): &nbsp; </td>";
					$data.="<td>".$formEp."</td>";
					$data.="</tr>";

					

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>6
					&nbsp; Form N-P Packet (5 forms each): &nbsp;</td>";
					$data.="<td>".$formNp."</td>";
					$data.="</tr>";
	
				
					$data.="<tr rowspan=\"3\" >";
					$data.="<td>7
					&nbsp; Form S-P Packet (5 forms each): &nbsp; </td>";
					$data.="<td>".$formSp."</td>";
					$data.="</tr>";



					$data.="<tr rowspan=\"3\" >";
					$data.="<td>8
					&nbsp; ATTNT Packet (20 forms each): &nbsp;</td>";
					$data.="<td>".$attnt."</td>";
					$data.="</tr>";
	

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>9
					&nbsp; Poster 1- Date: &nbsp;</td>";
					$data.="<td>".$poster1."</td>";
					$data.="</tr>";
	

					$data.="<tr rowspan=\"3\" >";
					$data.="<td>10
					&nbsp; Poster 2- Behavior Change: &nbsp;</td>";
					$data.="<td>".$poster2."</td>";
					$data.="</tr>";
	





//$_SESSION["tableData"]=$sql;
 $_SESSION["tableData"]=$data;
 //$_SESSION["tableData"].="Hello";
  header("Location:../tcpdf/examples/materials_packing_pdf.php?pdf=material_packingTTB.pdf");
  exit();









}












ob_flush();



					?>