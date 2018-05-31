	<?php
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
		//echo $count;
			while($_POST["countyName".$count] !=null){

			$districtName=isset($_POST["districtName".$count])?mysql_real_escape_string($_POST["districtName".$count]):"";
			$countyName=isset($_POST["countyName".$count])?mysql_real_escape_string($_POST["countyName".$count]):"";
			$boxNo=isset($_POST["boxNo".$count])?mysql_real_escape_string($_POST["boxNo".$count]):0;
			$boxIds=isset($_POST["boxIds".$count])?mysql_real_escape_string($_POST["boxIds".$count]):"";
		
			$dtb=isset($_POST["dtb".$count])?mysql_real_escape_string($_POST["dtb".$count]):0;
			$ttb=isset($_POST["ttb".$count])?mysql_real_escape_string($_POST["ttb".$count]):0;


			
			$sql="INSERT INTO `materials_packaging_history`(`countyName`, `districtName`, `noBox`, `dtb`, `ttb`,`printlist_id`,`locked`) ";
			$sql.=" VALUES ('$countyName','$districtName','$boxNo','$dtb','$ttb','$printlistId',0)";
		//	echo $sql."<br/>";
			mysql_query($sql)or die(mysql_error());

			++$count;
			}
			//This will make the editing process of the active printlist's package inaccessible
			$sql="update materials_printlist_history set packaged=1 where status=1";
			mysql_query($sql);
		//	echo $sql."<br/>";
			$tabActive = 'tab1';
	}
        
$priv_materials_edit=4;

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
					$link="materials_packing_strict.php?id='$id'";
					?>
					<tr rowspan="3" >
					<td><?php echo $id; ?></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="countyName<?php echo $id; ?>" value="<?php echo $countyName;?>" /></td>
					<td><input  class="num-only input-max uneditable-input" type="text" name="districtName<?php echo $id; ?>" value="<?php echo $districtName;?>" /></td>
					<td><input  class="num-only input-mini" type="text" name="boxNo<?php echo $id; ?>" value="" /></td>
					<td><input  class="num-only input-mini" type="text" name="dtb<?php echo $id; ?>" value="" /></td>
					<td><input  class="num-only input-mini" type="text" name="ttb<?php echo $id; ?>" value="" /></td>
							
				</tr>
				<?php 
				++$id;
				}
					?>
					  <?php if($priv_materials_edit>=2){ ?>
					<tr><td colspan="11"><input type="submit" name="savePackages" class="btn-custom" value="Save Details" style="margin-left:40%;" /></td></tr>
			  <?php } ?>
				</table>
               </form> 


                        <?php
                     



                      }else{
                          ?>
                       <h2 id="h2info"style="background:#bada66;">The Active Printlist's General Packing Information has already been set.Select Edit in the Materials Distribution to make changes or to Print to it.</h2>
                       <?php
                      }
                        ?>
