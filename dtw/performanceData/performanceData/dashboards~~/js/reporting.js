$(document).ready(function(){
	console.log("reporting js");

	$('#tar').click(function(){
		console.log("tar is clicked");

			var myData="table=targeted";
			$.ajax({
				url: 'ajax_q.php',
				type: 'post',
				data: myData,
				success: function(data) {
					// console.log("data");
					// console.log(data);
					$('#here').html(data);//alert(data);
					// var cow "foreach ($ntd->global_EstimatedTotalSTH_list() as $key => $value) {
					// 	      			?>

				 //      					<tr>
				 //      						<td><?php  echo $value['p_sch_name'];?></td>
				 //      						<td><?php  echo $value['division_name'];?></td>
				 //      						<td><?php  echo $value['district_name'];?></td>
				 //      						<td><?php  echo $value['county_name'];?></td>
					// 						<td><?php echo $value['p_pri_enroll']; ?></td>
					// 						<td><?php echo $value['p_ecd_enroll']; ?></td>
					// 						<td><?php echo $value['p_ecd_sa_enroll']; ?></td>
				 //      					</tr>
					// 	      			<?php
					// 	      		}";
				}
			});

	});
});//end document ready