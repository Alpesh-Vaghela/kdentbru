<?php
$plan_id=$_POST['plan_id'];
$plan_name=$_POST['plan_name'];
$plan_price=$_POST['plan_price'];
$comany_id=$_POST['company_id'];


	// PayPal settings
if (PAYPAL_MODE=="live"){
	$paypal_email = PAYPAL_LIVE_EMAIL;
}
else{
	$paypal_email = PAYPAL_SANDBOX_EMAIL;
}

	  // $paypal_email="sharmareema29@gmail.com";
$return_url = $link->link('paypal');
$cancel_url = $link->link('upgrade_plan',frontend);
$notify_url = $link->link('paypal');

$cmd="_xclick";
	// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){

		// Firstly Append paypal account to querystring

	$querystring .= "?business=".urlencode($paypal_email)."&";
	$querystring .= "cmd=".urlencode($cmd)."&";
		// Append amount& currency (£) to quersytring so it cannot be edited in html

		//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($plan_name)."&";
	$querystring .= "item_number=".urlencode($plan_id)."&";
	$querystring .= "amount=".urlencode($plan_price)."&";
	$querystring .= "custom=".urlencode($comany_id)."&";


		//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}

		// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);

		// Append querystring with custom field
		//$querystring .= "&custom=".USERID;

		// Redirect to paypal IPN
	if(PAYPAL_MODE=="live")
	{
		header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
	}
	else
	{
		header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	}
	exit();


}else{

	// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}

	// assign posted variables to local variables
	$data['item_name']			= $_POST['item_name'];
	$data['item_number']	    = $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['custom']             = $_POST['custom'];
	// post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	if(PAYPAL_MODE=="live")
	{
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

	}
	else
	{
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	}
	if (!$fp) {
		// HTTP ERROR
	}
	else {
		//$session->redirect('plan_detail',$query);
		/*	echo "Payment Done";
			echo $data['receiver_email'];
	        echo $data['payer_email'];
	        echo $data['payment_status'];


	      */

	        $paln_id=$data['item_number'];
	        $plan_name=$data['item_name'];
	        $plan_price=$data['payment_amount'];
	        $company_id=$data['custom'];
	        $plan_detail=$db->get_row('plans',array('id'=>$paln_id));
	        
	        if (!$db->exists('plans_company',array('company_id'=>$company_id)))
	        {
	        	
	        	$plan_update=$db->insert('plans_company',array('plan_id'=>$paln_id,
	        		'plan_name'=>$plan_name,
	        		'price'=>$plan_price,
	        		'company_id'=>$company_id,
	        		'allow_staff'=>$plan_detail['allow_staff'],
	        		'created_date'=>date('Y-m-d'),
	        		'ip_address'=>$_SERVER['REMOTE_ADDR']
	        	));
	        	$insert_allplan_table=$db->insert('plans_all',array('plan_id'=>$paln_id,
	        		'plan_name'=>$plan_name,
	        		'price'=>$plan_price,
	        		'company_id'=>$company_id,
	        		'allow_staff'=>$plan_detail['allow_staff'],
	        		'created_date'=>date('Y-m-d'),
	        		'ip_address'=>$_SERVER['REMOTE_ADDR']
	        	));
	        }
	        else{
	        	$plan_update=$db->update('plans_company',array('plan_id'=>$paln_id,
	        		'plan_name'=>$plan_name,
	        		'price'=>$plan_price,
	        		'allow_staff'=>$plan_detail['allow_staff'],
	        		'created_date'=>date('Y-m-d'),
	        		'ip_address'=>$_SERVER['REMOTE_ADDR']
	        	),array('company_id'=>$company_id));
	        	$insert_allplan_table=$db->insert('plans_all',array('plan_id'=>$paln_id,
	        		'plan_name'=>$plan_name,
	        		'price'=>$plan_price,
	        		'company_id'=>$company_id,
	        		'allow_staff'=>$plan_detail['allow_staff'],
	        		'created_date'=>date('Y-m-d'),
	        		'ip_address'=>$_SERVER['REMOTE_ADDR']
	        	));


	        }


	        if ($plan_update)
	        {
	        	$session->redirect ('upgrade_plan',frontend);
	        }
	    }
	}
	fclose ($fp);




	?>