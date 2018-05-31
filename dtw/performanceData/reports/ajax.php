<?php
include('config/dbconfig.php');
include('config/functions.php');
$evidenceaction = new EvidenceAction();
if(isset($_REQUEST['checkval']) && !empty($_REQUEST['checkval'])){
	if($_REQUEST['checkval']=='firstsetcreateformname'){
		$tablename = 'form_name';
		$fields = 'form_name="'.$_REQUEST['name'].'"';
		$insertformdata = $evidenceaction->insert($tablename, $fields);
		$evidenceaction->createtable('form'.$insertformdata);
		$evidenceaction->createtable('form'.$insertformdata.'_field_text');
		$fieldname = "ADD name VARCHAR(255) NOT NULL, ADD style TEXT NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD type_id VARCHAR(255) NOT NULL";
		$evidenceaction->addfieldtotable('form'.$insertformdata.'_field_text', $fieldname);
		$field1s = 'form_table_name="form'.$insertformdata.'",form_field_name_text="form'.$insertformdata.'_field_text"';
		$where = 'id='.$insertformdata;
		$evidenceaction->update($tablename, $field1s, $where);
		$field2s = '*';
		$insertformdata1 = $evidenceaction->selectarray($tablename, $field2s, $where);
		$fieldsint = 'name="'.$_REQUEST['name'].'", type="heading"';
		$evidenceactionheading = $evidenceaction->insert($insertformdata1['form_field_name_text'], $fieldsint);
		$fields2 = 'type_id="frheadeing"';
		$where1 = 'id='.$evidenceactionheading;
		$evidenceaction->update($insertformdata1['form_field_name_text'], $fields2, $where1);
		$_SESSION['lastinsertid'] = $insertformdata;
		$_SESSION['table_field_text'] = $insertformdata1['form_field_name_text'];
		echo $insertformdata.'+++==+++'.$evidenceactionheading;
		die();
	}
	if($_REQUEST['checkval']=='editform'){
		$insertformdata = base64_decode($_REQUEST['formid']);
		$tablename = 'form_name';
		$fields = 'form_field_name_text';
		$where = 'id='.$insertformdata;
		$insertformdata1 = $evidenceaction->selectarray($tablename, $fields, $where);
		$_SESSION['lastinsertid'] = $insertformdata;
		$_SESSION['table_field_text'] = $insertformdata1['form_field_name_text'];
		header('location:new_form.php');
		die();
	}
	if($_REQUEST['checkval']=='saveform'){
		$tablename = 'form_name';
		$where = 'id='.$_SESSION['lastinsertid'];
		$field1s = '*';
		$insertformdata1 = $evidenceaction->selectarray($tablename, $field1s, $where);
		$fields = 'style="'.$_REQUEST['style'].'"';
		$where1 = 'type_id="'.$_REQUEST['id'].'" AND type="'.$_REQUEST['type'].'"';
		$evidenceaction->update($insertformdata1['form_field_name_text'], $fields, $where1);
		die();
	}
	if($_REQUEST['checkval']=='add_field_submit'){
		$tablename = 'form_name';
		$where = 'id='.$_SESSION['lastinsertid'];
		$field1s = '*';
		$insertformdata1 = $evidenceaction->selectarray($tablename, $field1s, $where);
		if(isset($insertformdata1['field_names']) && !empty($insertformdata1['field_names'])){
			$fields = 'field_names="'.$insertformdata1['field_names'].' | '.$_REQUEST['fieldname'].'"';
		}else{
			$fields = 'field_names="'.$_REQUEST['fieldname'].'"';
		}
		$evidenceaction->update($tablename, $fields, $where);
		$fieldsint = 'name="'.$_REQUEST['fieldname'].'", type="textbox"';
		echo $evidenceactiontextbox = $evidenceaction->insert($insertformdata1['form_field_name_text'], $fieldsint);
		$fields2 = 'type_id="textfield_'.$evidenceactiontextbox.'"';
		$where1 = 'id='.$evidenceactiontextbox;
		$evidenceaction->update($insertformdata1['form_field_name_text'], $fields2, $where1);
		$fieldname = "ADD ".$_REQUEST['fieldname']." VARCHAR(255) NOT NULL";
		$evidenceaction->addfieldtotable($insertformdata1['form_table_name'], $fieldname);
		die();
	}
	if($_REQUEST['checkval']=='add_text_submit'){
		$tablename = 'form_name';
		$where = 'id='.$_SESSION['lastinsertid'];
		$field1s = '*';
		$insertformdata1 = $evidenceaction->selectarray($tablename, $field1s, $where);
		$fieldsint = 'name="'.$_REQUEST['fieldtext'].'", type="text"';
		echo $evidenceactiontext = $evidenceaction->insert($insertformdata1['form_field_name_text'], $fieldsint);
		$fields = 'type_id="textmsg_'.$evidenceactiontext.'"';
		$where1 = 'id='.$evidenceactiontext;
		$evidenceaction->update($insertformdata1['form_field_name_text'], $fields, $where1);
		die();
	}
	if($_REQUEST['checkval']=='add_table_submit'){
		$tablename = 'form_name';
		$where = 'id='.$_SESSION['lastinsertid'];
		$field1s = '*';
		$insertformdata1 = $evidenceaction->selectarray($tablename, $field1s, $where);
		$fieldsint = 'name="'.$_REQUEST['tablerow'].','.$_REQUEST['tablecol'].'", type="table"';
		echo $evidenceactiontable = $evidenceaction->insert($insertformdata1['form_field_name_text'], $fieldsint);
		$fields = 'type_id="table_'.$evidenceactiontable.'"';
		$where1 = 'id='.$evidenceactiontable;
		$evidenceaction->update($insertformdata1['form_field_name_text'], $fields, $where1);
		die();
	}
}
?>