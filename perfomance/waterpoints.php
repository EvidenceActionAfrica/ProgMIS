<?php
include ('header.php');
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>    
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="js/gmap3.js"></script>
    <script>
    var macDoList = [
<?php


$query = mysqli_query($mysqli, "SELECT waterpoint_name,admin_territory_details.admin_territory_name as village_name,longitude,latitude FROM waterpoint_details LEFT JOIN admin_territory_details ON admin_territory_details.id = waterpoint_details.village
                    WHERE country = '$country_val' AND longitude != '' AND longitude != '.' AND latitude != '' AND latitude != '.' ");

$js='';
while ($waterpoints = mysqli_fetch_assoc($query)) {
   $js.='{lat:'.$waterpoints['latitude'].',lng:'.$waterpoints['longitude'].',data:{drive:false,zip:"waterpoint: '.mysqli_real_escape_string($mysqli,$waterpoints['waterpoint_name']).'",city:"village: '.mysqli_real_escape_string($mysqli,$waterpoints['village_name']).'"}},' ;
}
$js=rtrim($js,',');

echo $js;


?>];
</script>
    <style>
      #container{
        position:relative;
        height:700px;
      }
      #googleMap{
        border: 1px dashed #C0C0C0;
        width: 100%;
        height: 520px;
      }
      
      /* cluster */
      .cluster{
      	color: #FFFFFF;
      	text-align:center;
      	font-family: Verdana;
      	font-size:14px;
      	font-weight:bold;
      	text-shadow: 0 0 2px #000;
        -moz-text-shadow: 0 0 2px #000;
        -webkit-text-shadow: 0 0 2px #000;
      }
      .cluster-1{
        background: url(img/m1.png) no-repeat;
        line-height:53px;
      	width: 53px;
      	height: 52px;
      }
      .cluster-2{
        background: url(img/m2.png) no-repeat;
        line-height:56px;
      	width: 60px;
      	height: 55px;
      }
      .cluster-3{
        background: url(img/m3.png) no-repeat;
        line-height:66px;
      	width: 70px;
      	height: 65px;
      }
      
      /* infobulle */
      .infobulle{
        overflow: hidden; 
        cursor: default; 
        clear: both; 
        position: relative; 
        height: 34px; 
        padding: 0; 
        background-color: rgb(57, 57, 57);
        border-radius: 4px 4px; 
        -moz-border-radius: 4px 4px;
        -webkit-border-radius: 4px 4px;
        border: 1px solid #2C2C2C;
      }
      .infobulle .bg{
        font-size:1px;
        height:16px;
        border:0px;
        width:100%;
        padding: 0px;
        margin:0px;
        background-color: #5E5E5E;
      }
      .infobulle .text{
        color:#FFFFFF;
        font-family: Verdana;
        font-size:11px;
        font-weight:bold;
        line-height:25px;
        padding:4px 20px;
        text-shadow:0 -1px 0 #000000;
        white-space: nowrap;
        margin-top: -17px;
      }
      .infobulle.drive .text{
        background: url(images/drive.png) no-repeat 2px center;
        padding:4px 20px 4px 36px;
      }
      .arrow{
        position: absolute; 
        left: 45px; 
        height: 0; 
        width: 0; 
        margin-left: 0; 
        border-width: 10px 10px 0 0; 
        border-color: #2C2C2C transparent transparent; 
        border-style: solid;
      }
      
    </style>
     <?php
     if($country_val == 1) {         
         $lat_long = '-0.091702, 38.767956';
     } elseif($country_val == 2){
         $lat_long = '1.763091, 32.645072';
     } elseif($country_val == 3){
         $lat_long = '-12.033886, 34.402884';
     }else{
         $lat_long = '-2.45463, 23.152884';
     }
     ?>
    <script type="text/javascript">
    
      $(function(){
      
        $("#googleMap").gmap3({
          map:{
            options: {              
              center:[<?php echo $lat_long ?>],                      
              zoom: 6,
              mapTypeId: google.maps.MapTypeId.ROADMAP // This value can be set to define the map type ROADMAP/SATELLITE/HYBRID/TERRAIN
            }
          },
          marker: {
            values: macDoList,
            cluster:{
              radius:60,
              // This style will be used for clusters with more than 0 markers
              0: {
                content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
                width: 53,
                height: 52
              },
              // This style will be used for clusters with more than 20 markers
              20: {
                content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
                width: 56,
                height: 55
              },
              // This style will be used for clusters with more than 50 markers
              50: {
                content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
                width: 66,
                height: 65
              },
              events: {
                click: function(cluster) {
                  var map = $(this).gmap3("get");
                  map.setCenter(cluster.main.getPosition());
                  map.setZoom(map.getZoom() + 1);
                }
              }
            },
            options: {
              icon: new google.maps.MarkerImage("http://maps.gstatic.com/mapfiles/icon_green.png")
            },
            events:{
              mouseover: function(marker, event, context){
                $(this).gmap3(
                  {clear:"overlay"},
                  {
                  overlay:{
                    latLng: marker.getPosition(),
                    options:{
                      content:  "<div class='infobulle"+(context.data.drive ? " drive" : "")+"'>" +
                                  "<div class='bg'></div>" +
                                  "<div class='text'>" + context.data.city + " (" + context.data.zip + ")</div>" +
                                "</div>" +
                                "<div class='arrow'></div>",
                      offset: {
                        x:-46,
                        y:-73
                      }
                    }
                  }
                });
              },
              mouseout: function(){
                $(this).gmap3({clear:"overlay"});
              }
            }
          }
        });
        
      });
    </script> 
<div class="row">

    <div class="col-md-2">

        <div class="sidebar">
            <?php require_once ('includes/left_bar.php'); ?>
        </div>

    </div>

    <div class="col-md-10">

        <div id="googleMap" >

        </div>
        <p class="text_foot" style="margin-top: 5px;">Click on the image(s) or zoom out the map to view different waterpoints in detail.</p>

        
    </div>
</div>

</body>

</html>       