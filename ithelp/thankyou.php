<?php
//; Consulted the following URLs on Feb 23 2015 for assistance with form validation using PHP:
//; http://www.the-art-of-web.com/php/form-handler/
//; http://www.w3schools.com/php/php_form_url_email.asp
$errorFlag="0";
$recipient="";
$subhelp="";
$subject1="";
$subject2="";
$subject3="";
$sender="";
$senderPriority="";
$senderEmail="";
$senderPhoneExt="";
$senderPhone="";
$senderLocation="";
$senderWeb="-1";
$senderIT="-1";
$userNeeds="";
$subject="";
$message="";
$mailBody="";
$thankYou="";
$z = "0";
if(isset($_POST["submit"])) {
	if(empty($_POST["sender"])){
		echo "Please provide your name! <br>";
		$errorFlag="1";
	}
	if((empty($_POST["senderEmail"]))){
		echo "Please provide your email! <br>";
		$errorFlag="1";
	}
	else if(!(filter_var(($_POST["senderEmail"]), FILTER_VALIDATE_EMAIL))){
		echo "Invalid Format For Email! <br>";
		$errorFlag="1";
	}
	$x = "0"; $xFlag="0";
	if((empty($_POST["senderPhoneExt"]))){
			$x = $x + "1";
			//echo "Please provide your university phone extension! <br />";
	}
	else if(strlen(($_POST["senderPhoneExt"]))!=5){
		echo "Invalid format for phone extension; must be in form of #####! <br />";
		$x = $x + "1";
		$xFlag="1";
		$errorFlag= $errorFlag + "1";
	}
	if((empty($_POST["senderPhone"]))){
			$x = $x + "1";
			//echo "Please provide your phone number! <br />";
	}
	else if(strlen(($_POST["senderPhone"]))!=11){
		echo "Invalid format for phone number; must be in form of ###########! <br />";
		$x = $x + "1";
		$xFlag="2";
		$errorFlag= $errorFlag + "1";
	}
	if(($x >= "2")||($xFlag>"0")){
		$errorFlag = "1";
		echo "Please provide your university phone extension in the form ##### or your phone number in the form ########### ! <br />";
	}
	if(($_POST["Priority"])=="-1"){
		echo  "Please provide a Priority Number for your issue! <br>";
		$errorFlag="1";
	}
	if(($_POST["Category"])=="-1"){
		echo "Please provide a category!  If your request is for a website issue, please select 'Website (see below)' from drop-down menu under Category heading. <br>";
		$errorFlag="1";
	}
	if((($_POST["Category"])=="Hardware")&&(($_POST["Hardware_Support"])=="-1")){
		echo  "Please specify a hardware device for which you would like to make your request!";
		$errorFlag="1";
	}
	if(($_POST["Category"])=="Set-up For New User")	{
			if(isset($_POST["AccessToSharedDrive"])){
				$userNeeds .= "Access To Shared Drive, ";
			}
			else $z = $z + 1;
			if(isset($_POST["AccountForActiveNet"])){
				$userNeeds .= "Account For ActiveNet, ";
			}
			else $z = $z + 1;
			if(isset($_POST["AccountForGryphons.ca"])){
				$userNeeds .= "Account For Gryphons.ca, ";
			}
			else $z = $z + 1;
			if(issest($_POST["AccountForEmail"])){
				$userNeeds .= "Account For Email/Central Log-in, ";
			}
			else $z = $z + 1;
			if(isset($_POST["AccountForIssueTrackingSystem"])){
				$userNeeds .= "Account For Issue Tracking (JIRA/Confluence) System, "
			}
			else $z = $z + 1;
			if(isset($_POST["DepartmentCodeForPrinting"])){
				$userNeeds .= "Department Code For Printing, ";
			}
			else $z = $z + 1;
			if(isset($_POST["HumanResourcesSystemSet-up"])){
				$userNeeds .= "Human Resources System Set-up, "
			}
			else $z = $z + 1;
			if(isset($_POST["NewComputer"])){
				$userNeeds .= "New Computer, ";
			}
			else $z = $z + 1;
			if(!(empty($_POST["otherSetup"]))){
				$userNeeds .= $_POST["otherSetup"];
			}
			else $z = $z + 1;
			if($z >= "9"){
				echo "Please specify what the user needs!";
			}
	}
	if((($_POST["Category"])=="Phones/Networking")&&(($_POST["Phonework_Support"])=="-1")){
		echo  "Please specify a type of phone/networking issue for which you would like to make your request!";
		$errorFlag="1";
	}
	if((($_POST["Category"])=="Printing/Faxing")&&(($_POST["Printing_Support"])=="-1")){
		echo  "Please specify a type of printing/faxing/networking issue for which you would like to make your request!";
		$errorFlag="1";
	}
	
	if((($_POST["Category"])=="Software")&&(($_POST["Software_Support"])=="-1")){
		echo  "Please specify a type of software for which you would like to make your request!";
		$errorFlag="1";
	}
	if((($_POST["Category"])=="Virus/Security")&&(($_POST["Virus"])=="-1")){
		echo  "Please specify a type of virus/security issue for which you would like to make your request!";
		$errorFlag="1";
	}
	if($errorFlag >= "1"){
		echo "Errors found!!  Please re-fill out form, making sure you fill out all fields that have been asked for, and press submit again.";
	}
	if($errorFlag == "0"){
	$recipient="cjrc1374@gmail.com";
	$subhelp="New IT Request from IT Help Desk-Request Submission Form";
	$subject1="";
	$subject2="";
	$sender=$_POST["sender"];
    $senderEmail=$_POST["senderEmail"];
	$senderPhoneExt=$_POST["senderPhoneExt"];
	$senderPhone=$_POST["senderPhone"];
	$senderLocation=$_POST["senderLocation"];
	$senderPriority=$_POST["Priority"];
	$senderWeb=$_POST["Website_Support"];
	$senderIT=$_POST["Category"];
    if($senderIT != "Website"){
		$subject2=$senderIT;
	}
	if($senderWeb != "-1"){
		$subject1=$senderWeb;
	}
	$subject3 = "Priority: " . $senderPriority . " ";
	$subject = $subhelp . ": " . $subject3 . " " . $subject1 . " " . $subject2;
	$message=$_POST["message"];
	$headers = "From: " . $senderEmail . "\r\n";
	$headers .= "Cc: " . $senderEmail . "\r\n";

    $mailBody="Name: $sender\nEmail: $senderEmail\nUniversity Phone Extension: $senderPhoneExt\nPhone Number: $senderPhone\nLocation: $senderLocation\nPriority: $senderPriority\n";
	if($senderWeb != -1){
		$mailBody .= "Website: $senderWeb\n";
	}
	$mailBody .= "IT: $senderIT\n\n$message";
	mail($recipient, $subject, $mailBody, $headers);
    //mail($recipient, $subject, $mailBody, "From: $sender <$senderEmail>");

    $thankYou="<p>Thank you for submitting your IT Help Desk Request.  One of our representatives will get back to you as soon as possible.  If it is an urgent request you may contact us using the details below.
<br /> <br />
Best Regards,
<br /> 
<section>
Athletics IT Office<br />
</p>";
	echo "$thankYou";
}
}
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>IT Help Desk-Request Submission Form</title>
</head>
<body>
<!-- <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /> -->
<p><a href="index.html" title="Return to form">Return To Form</a></p>
<!-- <p><a href="/gryphrec/ithelp" title="Return to form">Return To Form</a></p> -->
</body>
</html>
