<?php

class smsreceiver extends Controller {

    public $smsReceiverModel;
    /*
    This function will receive the intial  text from the Provider and separate the text to 5 parts. If 5 parts are not 
    retrieved it will return an error.
    */
    public function index($phoneNumber,$text) {
    	//Get Full length of string text
    	$fullLength=strlen($text);

    	//The text is separated by "-". So we need to find the first - to get waterpoint id
    	$len=stripos($text, "-");
    	$this->onFalseResult($len);
    	$waterpointId=substr($text, 0,$len);
    	$this->onFalseResult($waterpointId);

    	//The text should now remove everything before the first "-"
    	$newstart=$len+1;
    	$text=substr($text, $newstart,$fullLength);
    	$fullLength=strlen($text);



		$len=stripos($text, "-");
		$this->onFalseResult($len);
		$issueCode=substr($text, 0,$len);
		$this->onFalseResult($issueCode);

		//The text should now remove everything before the first "-"
    	$newstart=$len+1;
    	$text=substr($text, $newstart,$fullLength);
    	$fullLength=strlen($text);


    	$len=stripos($text, "-");
		$this->onFalseResult($len);
		$issueStatus=substr($text, 0,$len);
		if($issueStatus=="" || is_int($issueStatus)==false ){
			$issueStatus=1;
		}

		//The text should now remove everything before the first "-"
    	$newstart=$len+1;
    	$text=substr($text, $newstart,$fullLength);
    	$fullLength=strlen($text);

   
		$remark=substr($text,0);
		
		$this->onReceive($phoneNumber,$waterpointId,$issueCode,$issueStatus,$remark);
    }
    public function onFalseResult($result=null){
    	//enter the function for returning error message to user here.Replace the code below with it
    	if($result==null){
    		echo "It Failed";
    		return null;

    	}

    }

    public function onReceive($phoneNumber,$waterpointId,$issueCode,$issueStatus,$remark){
    	//Anything received that is incorrect/invalid will stop the receiving process and send out an error/null. 
    	//If the process is stopped it should return an error message in the for of a text
    	date_default_timezone_set("Africa/Nairobi");
    	$smsReceiverModel=$this->loadModel('smsReceiverModel');
    	// echo $phoneNumber;
    	// echo "<br/>";
    	// echo $waterpointId;
    	// echo "<br/>";
    	// echo $issueCode;
    	// echo "<br/>";
    	// echo $issueStatus;
    	// echo "<br/>";
    	// echo $remark;


    	//Get the staff member details from staff_list using the phone number

    	$staffDetails=$smsReceiverModel->getStaffData($phoneNumber);
    	$this->onFalseResult($staffDetails);
    	//confirm the waterpoint id exists in the waterpoint details
    	$waterpointStatus=$smsReceiverModel->confirmWaterpointId($waterpointId,$staffDetails[0]['country']);
    	$this->onFalseResult($staffDetails);
    	//Get the category and subcategory id
    	$category=$smsReceiverModel->getIssueCategory($issueCode,"category");
    	$this->onFalseResult($category);
    	$subCategory=$smsReceiverModel->getIssueCategory($issueCode,"sub_category");
    	$this->onFalseResult($subCategory);

    	//make sure the issue status is valid i.e between 1 and 3
    	if($issueStatus>3){
    		$this->onFalseResult();//automatic null returned
    		
    	}

    	//Final Check on the data-- just to make sure(not neccessary)


    	if($staffDetails==null || $category ==null || $subCategory==null || $issueStatus==null || $waterpointStatus==null){

			$this->onFalseResult();//automatic null returned

    	}else{
    		//insert the new issue

    		//put the variables in an array newIssue

    		$newIssue=array(
    			"country"=>$staffDetails[0]["country"],
    			"office_location"=>$staffDetails[0]["office_location"],
    			"waterpoint_id"=>$waterpointId,
    			"category"=>$category,
    			"sub_category"=>$subCategory,
    			"issue_status"=>$issueStatus,
    			"issue_remarks"=>$remark,
    			"full_name"=>$staffDetails[0]["id"],
    			"raised_by"=>$staffDetails[0]["full_name"],
    			"date_created"=>date('d-M-Y'),

    			);
    		
    			$newIssue["complete"]=0;
    		

    		$smsReceiverModel->addData("issues",$newIssue);

    	}


    }




}
