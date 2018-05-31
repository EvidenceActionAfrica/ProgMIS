<?php
include('config/dbconfig.php');
include('config/functions.php');
//session_destroy(); 
//echo $_SESSION['lastinsertid'];?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link href="style.css" style="text/css" rel="stylesheet">
<div class="wrapper">
	<div class="wrapleft">
		<ul>
			<li class="firstcrtefewfoemdiv"><?php /*if(isset($_SESSION['lastinsertid']) && !empty($_SESSION['lastinsertid'])){}else{*/?>
				<a href="javascript:void(0);" id="firstcrtefewfoem">
					Create New Form
		        </a>
<?php //}?></li>
<li><a href="javascript:void(0);" id="add_text_box">Add Text Box</a></li>
<li><a href="javascript:void(0);" id="add_text_msg">Add Text</a></li>
<li><a href="javascript:void(0);" id="add_text_table">Add Table</a></li>
<li><a href="javascript:void(0);" onclick="saveform();">Save</a></li>
<li class="checksub"><a href="javascript:void(0);">Created Form List</a>
<ul class="subclass">
	<?php 
	$evidenceaction = new EvidenceAction();
	$tablename = "form_name";
	$fields = '*';
	$where = '1=1';
	$insertformdataname = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
	//echo '<pre>';
	$insertformdatanamevf = array_reverse($insertformdataname);//echo '</pre>';
	foreach($insertformdatanamevf as $insertformdataval){?>
	<li><a href="javascript:void(0);" onclick="edit_form('ajax.php?checkval=editform&formid=<?php echo base64_encode($insertformdataval['id']);?>');"><?php echo $insertformdataval['form_name'];?></a></li>
		
<?php	}?>
</ul></li>

	</ul>
	</div>
	<div class="wrapreigh">
	<div class="wecval">
		<span id="formstr"></span>
	</div>
<div id="divform1" class="divformclasssec">
<?php
//$_SESSION['lastinsertid'] = 1;
//$_SESSION['table_field_text'] = 'form1_field_text';
if(isset($_SESSION['lastinsertid']) && !empty($_SESSION['lastinsertid'])){
	$fields = '*';
	$where = '1=1';
	$insertformdata = $evidenceaction->mysql_fetch_all($_SESSION['table_field_text'], $fields, $where);
	/*echo '<pre>';
	print_r($insertformdata);
	echo '<pre>';
	die();*/
	//echo $_SESSION['lastinsertid'];
}?>
<form class="formclass">
	<input type="hidden" value="<?php if(isset($_SESSION['lastinsertid']) && !empty($_SESSION['lastinsertid'])){echo $_SESSION['lastinsertid'];}?>" name="formid" id="formid"/>
	
	<?php if(isset($insertformdata) && !empty($insertformdata)){
			foreach ($insertformdata as $insertformdataval){
		if(isset($insertformdataval['type']) && !empty($insertformdataval['type']) && ($insertformdataval['type']=='heading')){?>
			<span id="frheadeing" id="<?php echo $insertformdataval['type_id'];?>" class="frmele" data-type="heading" style="<?php echo $insertformdataval['style'];?>"><?php echo $insertformdataval['name'];?></span>
		<?php }
		if(isset($insertformdataval['type']) && !empty($insertformdataval['type']) && ($insertformdataval['type']=='textbox')){?>
			<span class="textfield textfieldspan frmele" id="<?php echo $insertformdataval['type_id'];?>" data-fieldname="<?php echo $insertformdataval['name'];?>"  data-type="textbox" style="<?php echo $insertformdataval['style'];?>"></span>
		<?php }
		if(isset($insertformdataval['type']) && !empty($insertformdataval['type']) && ($insertformdataval['type']=='text')){?>
			<span class="textmsg textmsgspan frmele" id="<?php echo $insertformdataval['type_id'];?>" data-type="text" style="<?php echo $insertformdataval['style'];?>"><?php echo $insertformdataval['name'];?></span>
		<?php }
		if(isset($insertformdataval['type']) && !empty($insertformdataval['type']) && ($insertformdataval['type']=='table')){
			$numn = explode(',',$insertformdataval['name']);?>
			<table cellpadding="0" cellspacing="0" border="0" id="<?php echo $insertformdataval['type_id'];?>" class="frmtable frmele" data-type="table" style="<?php echo $insertformdataval['style'];?>">
			<?php for($k=1;$k<($numn[0]+1);$k++){?>
				<tr>
				<?php for($kk=1;$kk<($numn[1]+1);$kk++){?>
					<td  class="tdclass">&nbsp;</td>
				<?php }?>
				</tr>
			<?php }?>
			</table>
		<?php }
		
	}
}
	if(isset($insertformdata['form_name']) && !empty($insertformdata['form_name'])){?>
	<span <?php if(isset($insertformdata['style']) && !empty($insertformdata['style'])){?>style="<?php echo $insertformdata['style'];?>"<?php }?>  id="frheadeing"><?php echo $insertformdata['form_name'];?></span>
	<?php }?>
</form>
</div>
</div>
<div class="clearFix"></div>
</div>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
function edit_form(txt){
	window.location = txt;
}
function saveform(){
	$('.frmele').each(function(){
		$.post('ajax.php', {checkval:'saveform',id:$(this).attr('id'),type:$(this).attr('data-type'),style:$(this).attr('style')}).done(function(data) {//alert(data);
		});
	}); 	
}
function clocomdix(txt)	{
	$('#'+txt).fadeOut('4000');
} 
$(function() {//alert($("#frheadeing").length);
	if($("#frheadeing").length>0){$("#frheadeing").draggable({ containment: ".formclass" }).resizable();}
	if($(".textfield").length>0){$(".textfield").draggable({ containment: ".formclass" }).resizable();}
	if($(".textmsg").length>0){$(".textmsg").draggable({ containment: ".formclass" }).resizable();}
	if($(".frmtable").length>0){$(".frmtable").draggable({ containment: ".formclass" }).resizable();}
	//Step 1 create form
	$("#firstcrtefewfoem").on('click',function(){
		$('#createfomna').fadeIn('4000');
		$('#createfomna_comment_popup').css({
					position:'absolute',
					left: ($(window).width() - $('#createfomna_comment_popup').outerWidth())/2,
					top: ($(window).height() - $('#createfomna_comment_popup').outerHeight())/2
				});
	});
	//Step 2
	$("#form_name_submit").on('click',function(){
		$.post('ajax.php', {checkval:'firstsetcreateformname',name:$("#form_name").val()}).done(function(data) {//alert(data);
		var dtdvsg = data.split("+++==+++");
		if($("#frheadeing").length>0){
			$("#frheadeing").html($("#form_name").val());
		}else{
			$("#formstr").after('<span id="frheadeing" id="header_'+dtdvsg[1]+'" data-type="heading" class="frmele">'+$("#form_name").val()+'</span>');
		}			
			$('#createfomna').fadeOut('4000');
			//$("#createfomna,#firstcrtefewfoem").css("display","none");
			$("#formid").val(dtdvsg[0]);
			$("#frheadeing").draggable({ containment: ".formclass" });
			$("#header_"+dtdvsg[1]).css('position','absolute').css('max-width','950px');
			saveform();
		}); 
	});
	//add text box to form
	$("#add_text_box").on('click',function(){
		$('#addtext').fadeIn('4000');
		$('#addtext_comment_popup').css({
					position:'absolute',
					left: ($(window).width() - $('#addtext_comment_popup').outerWidth())/2,
					top: ($(window).height() - $('#addtext_comment_popup').outerHeight())/2
				});
	});
	//add text to form
	$("#add_text_msg").on('click',function(){
		$('#addtextmsg').fadeIn('4000');
		$('#addtextmsg_comment_popup').css({
					position:'absolute',
					left: ($(window).width() - $('#addtextmsg_comment_popup').outerWidth())/2,
					top: ($(window).height() - $('#addtextmsg_comment_popup').outerHeight())/2
				});
	});
	//add table to form
	$("#add_text_table").on('click',function(){
		$('#addtexttable').fadeIn('4000');
		$('#addtexttable_comment_popup').css({
					position:'absolute',
					left: ($(window).width() - $('#addtexttable_comment_popup').outerWidth())/2,
					top: ($(window).height() - $('#addtexttable_comment_popup').outerHeight())/2
				});
	});
	//last Step Save
	setInterval(function() {
				saveform()
				}, 30000);
	//Add Text Box to db
	$("#add_field_submit").on('click',function(){
		$.post('ajax.php', {checkval:'add_field_submit',fieldname:$("#field_name").val()}).done(function(data) {//alert(data);
			$("#formstr").after('<span class="textfield textfieldspan frmele" id="textfield_'+data+'" data-fieldname="'+$("#field_name").val()+'"  data-type="textbox"></span>');
			$('#addtext').fadeOut('4000');
			$(".textfield").draggable({ containment: ".formclass" }).resizable();
			$("#textfield_"+data).css('position','absolute').css('max-width','950px');
			saveform();
		}); 
	});
	//Add Text to db
	$("#add_text_submit").on('click',function(){
		$.post('ajax.php', {checkval:'add_text_submit',fieldtext:$("#field_text").val()}).done(function(data) {//alert(data);
			$("#formstr").after('<span class="textmsg textmsgspan frmele" id="textmsg_'+data+'" data-type="text">'+$("#field_text").val()+'</span>');
			$('#addtextmsg').fadeOut('4000');
			$(".textmsg").draggable({ containment: ".formclass" }).resizable();
			$("#textmsg_"+data).css('position','absolute').css('max-width','950px');
			saveform();
		}); 
	});
	//Add Table to db
	$("#add_table_submit").on('click',function(){
		$.post('ajax.php', {checkval:'add_table_submit',tablerow:$('#field_text_row').val(),tablecol:$('#field_text_col').val()}).done(function(data) {//alert(data);
			var tacv = '<table cellpadding="0" cellspacing="0" border="0" id="table_'+data+'" class="frmtable frmele" data-type="table">';
			for(k=1;k<parseInt($('#field_text_row').val())+1;k++){
				tacv +='<tr>';
				for(kk=1;kk<parseInt($('#field_text_col').val())+1;kk++){
					tacv +='<td  class="tdclass">&nbsp;</td>';
				}
				tacv +='</tr>';
			}
			tacv +='</table>';
    		$("#formstr").after(tacv);
			$('#addtexttable').fadeOut('4000');
			$(".frmtable").draggable({ containment: ".formclass" }).resizable();
			$("#table_"+data).css('position','absolute').css('max-width','950px');
			saveform();
		}); 
	});
});
</script>
<!--create form-->
<div class="comment_overlay"  id="createfomna">
	<div class="comment_popup"   id="createfomna_comment_popup">
		<div onclick="clocomdix('createfomna');" class="com_close">X</div>
		<div class="subheadding">Create New Form</div>
		<div class="inner_wrapper livefix">
			<div class="inner">
				<div class="allPst">
					<div class="createfomna">
						<div class="forlable"><span>Enter Form Name : </span><input  type="text" name="form_name" id="form_name" class="text"/></div>
						<div class="forlable_button"><input  type="button" name="form_name_submit" id="form_name_submit" class="button" value="Create Form"/></div>
					</div>
					<div class="clearFix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--add text field-->
<div class="comment_overlay"  id="addtext">
	<div class="comment_popup" id="addtext_comment_popup">
		<div onclick="clocomdix('addtext');" class="com_close">X</div>
		<div class="subheadding">Add Text Box</div>
		<div class="inner_wrapper livefix">
			<div class="inner">
				<div class="allPst">
					<div class="createfomna">
						<div class="forlable"><span>Field Name : </span><input  type="text" name="field_name" id="field_name" class="text"/></div>
						<div class="forlable_button"><input  type="button" name="add_field_submit" id="add_field_submit" class="button" value="Add Text Box"/></div>
					</div>
					<div class="clearFix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--add text-->
<div class="comment_overlay"  id="addtextmsg">
	<div class="comment_popup" id="addtextmsg_comment_popup">
		<div onclick="clocomdix('addtextmsg');" class="com_close">X</div>
		<div class="subheadding">Add Text</div>
		<div class="inner_wrapper livefix">
			<div class="inner">
				<div class="allPst">
					<div class="createfomna">
						<div class="forlable"><span>Text : </span>
						<textarea name="field_text" id="field_text" class="textnm"></textarea></div>
						<div class="forlable_button"><input  type="button" name="add_text_submit" id="add_text_submit" class="button" value="Add Text"/></div>
					</div>
					<div class="clearFix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--add table-->
<div class="comment_overlay"  id="addtexttable">
	<div class="comment_popup" id="addtexttable_comment_popup">
		<div onclick="clocomdix('addtexttable');" class="com_close">X</div>
		<div class="subheadding">Add Table</div>
		<div class="inner_wrapper livefix">
			<div class="inner">
				<div class="allPst">
					<div class="createfomna">
						<div class="forlable"><span>Row : </span>
						<input type="text" name="field_text_row" id="field_text_row" class="textnmsmall" /></div>
						<div class="forlable"><span>Column : </span>
						<input type="text" name="field_text_col" id="field_text_col" class="textnmsmall" /></div>
						<div class="forlable_button"><input  type="button" name="add_table_submit" id="add_table_submit" class="button" value="Add Table"/></div>
					</div>
					<div class="clearFix"></div>
				</div>
			</div>
		</div>
	</div>
</div>