<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="description" content="Description" />
<meta name="keywords" content="Keywords" />

<!-- CSS includes -->
<link rel="stylesheet" href="../../css/style.css"  type="text/css" media="screen" />
<!-- <link rel="stylesheet" href="css/vstyle.css" type="text/css" > -->
<link rel="stylesheet" type="text/css" href="../../css/vstyle.css"/>
<link rel="stylesheet" href="css/style-n.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style-s.css" type="text/css" media="screen" /><!-- county report-->

<link rel="stylesheet" href="css/reports-css.css" type="text/css" media="screen" />

<!-- Bootstrap includes -->
<link href="../../css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"/>

<!-- victor -->


<style type="text/css">
.vzoom-level{
	float: left;
}
#vzoom{ 
	display: block;
}

#national_report_container{
/*zoom: 0.5;
width: 1142px;
margin: 0px auto;*/
}

#report_container{
/*zoom: 0.7;*/
/*width: 1142px;*/
margin: 0px auto;

}

/*only target mozilla browsers*/
/*  @-moz-document  #report_container {
    -moz-transform: scale(0.8);
    margin-top: -90px !important;
    padding-top: 0px !important;
    /*width: 100%;
  }*/

#warning_no_data{
  display: none;
}

.alert.info {
color: #205a94;
}
.alert.info {
border-color: #446d99;
background: url(img/sprites/alertboxes/bg-information.png) repeat-x #a5c8f4;
}

.alert {
text-shadow: 0 1px 1px #fff;
}

.bold-undeline{
  font-weight: bold;
  text-decoration: underline;
}

.national_report_table .left-align , .national_donor_report_table .left-align, .county_report_table .left-align, .district_report_table .left-align {
  text-align: right;
}

.alert {
position: relative;
border: 1px solid;
border-radius: 3px;
clear: both;
margin-bottom: 9px;
margin-top: 10px;
padding: 7px 15px;
padding-left: 30px;
-webkit-box-shadow: inset 1px 1px 0 0 rgba(255,255,255,0.65);
-moz-box-shadow: inset 1px 1px 0 0 rgba(255,255,255,0.65);
box-shadow: inset 1px 1px 0 0 rgba(255,255,255,0.65);
}

.alert.info span.icon {
background: url(img/icons/packs/fugue/16x16/information.png);
}

.alert span.icon {
display: inline-block;
width: 16px;
height: 16px;
position: absolute;
left: 7px;
top: 50%;
margin-top: -8px;
} 

.icon {
background-repeat: no-repeat;
height: 24px;
width: 24px;
}

#footer-partner{
  margin-left: 80px;
}
.footer-slogan{
  font-size: 30px;
  color:#205677;
  padding: 20px 20px 20px 20px;
  font-style: italic;
  text-align: center;
}

#footer-logos{
  padding-top: 10px;
  padding-bottom: 30px;
}
#footer-logos img{
  height: 60px;
  margin-left: 8%;
}

</style>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>

  <style type="text/css">
  .display_none{
				display: none;
			}

</style>

<!-- IMPORTANT add all JS at the end. Charts may not work if things come after it -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/exporting.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/jspdf.js"></script>
<script src="js/jspdf.plugin.addimage.js"></script>
<script src="js/jspdf.plugin.autoprint.js"></script>
<script src="js/jspdf.plugin.cell.js"></script>
<script src="js/jspdf.plugin.from_html.js"></script>
<script src="js/jspdf.plugin.javascript.js"></script>
<script src="js/jspdf.plugin.sillysvgrenderer.js"></script>
<script src="js/jspdf.plugin.split_text_to_size.js"></script>
<script src="js/jspdf.plugin.standard_fonts_metrics.js"></script>
<script src="js/jspdf.plugin.total_pages.js"></script>
<script src="js/jspdf.PLUGINTEMPLATE.js"></script>
<script src="js/html2canvas.js"></script>
<script src="js/canvg.js"></script>
<!-- canvg -->
<script src="js/canvg/rgbcolor.js"></script>
<script src="js/canvg/StackBlur.js"></script>
<script src="js/canvg/canvg.js"></script>



<script src="js/reports-custom.js"></script>

<script type="text/javascript">
  // $(document).ready(function(){
  //   console.log("sdcdcsdcsdcsdcsddscscsdc");
  // $('body').html($('body').html().replace('Gender','cows'));
  // });//end document ready
  
</script>

<script type="text/javascript">
function vzoom(z,w){
  document.getElementById("national_report_container").style.zoom=z;
  // document.getElementById("national_report_container").style['MozTransform']="scale("+z+")";
  document.getElementById("national_report_container").style.width=w;
  // document.getElementById("national_report_container").style.margin="0 auto";

  document.getElementById("report_container").style.zoom=z;
  // document.getElementById("report_container").style['MozTransform']="scale("+z+")";
  document.getElementById("report_container").style.width=w;
  document.getElementById("report_container").style.margin="0 auto";
}
</script>