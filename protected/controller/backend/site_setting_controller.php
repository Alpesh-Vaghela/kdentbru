<?php
if(isset($_POST['submit_settings']))
{
  //  print_r($_POST);
	$name=$_POST['name'];
	$email=$_POST['email'];
	$website=$_POST['website'];
	$address=htmlentities($_POST['address']);
	$maxsizeallowed=$feature->getMaximumFileUploadSize();
	$country=$_POST['country'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$zip=$_POST['zip'];
	$timezone=$_POST['timezone'];
	$dateformat=$_POST['dateformat'];
	$telephone1=$_POST['telephone1'];
	$telephone2=$_POST['telephone2'];
	$fax_number=$_POST['fax_number'];



	$fiscal_month=$_POST['fiscalmonth'];
	$com_uen_no=$_POST['com_uen_no'];
	$com_uen_type=$_POST['com_uen_type'];
	$is_gst_registered=$_POST['is_gst_registered'];
    $com_gst_no=$_POST['com_gst_no'];
    $gst_reporting_period=$_POST['gst_reporting_period'];
    $start_date_financial_year=$_POST['start_date_financial_year'];
    $start_month_financial_year=$_POST['start_month_financial_year'];

    $currency_symbol=$_POST['currencysymbol'];
    $pdflogosize=$_POST['pdflogosize'];
	$logosize=$_POST['logosize'];
    $cookie_value=$_POST['cookie_expire'];
	$setting_logo=$_FILES['logo'];
	$pdf_logo=$_FILES['pdf_logo'];

	$create_date=date('y-m-d,h:i:s');
	$ip_address=$_SERVER['REMOTE_ADDR'];
	
	
	$facebook_api_id=$_POST['facebook_api_id'];
	$facebook_api_secret=$_POST['facebook_api_secret'];
	$google_client_id=$_POST['google_client_id'];
	$google_client_secret=$_POST['google_client_secret'];

	//For logo
	$handle= new upload($setting_logo);
	$ext=$handle->file_src_name_ext;
	$path=SERVER_ROOT.'/uploads/logo/';
	if(!is_dir($path))
	{
		if(!file_exists($path)){
			mkdir($path);
		}
	}
	elseif ($email=='')
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Company-Email cannot be empty.
		</div>';
	}

	elseif(!$fv->check_email($email))
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Please enter valid format in company-email.
		</div>';
	}
	elseif ($logosize>$maxsizeallowed)
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i>
	        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
	        Logo File must be less than '.$upload_max_size.'
		</div>';
	}
	elseif ($pdflogosize>$maxsizeallowed)
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i>
	        </button>
                PDF Logo File must be less than '.$upload_max_size.'
                		</div>';
	}
	elseif ($ext!='jpeg' && $ext!='jpg' && $ext!='png' && $setting_logo['name'] !='' )
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i>
	        </button>
Only jpeg,jpg and png files are allowed for print logo
		</div>';
	}
	elseif(($setting_logo['name']) != ''){
	if(file_exists(SERVER_ROOT.'/uploads/logo/'.$settings['logo']) && (($settings['logo'])!=''))
	{
		unlink(SERVER_ROOT.'/uploads/logo/'.$settings['logo']);
	}
	$newfilename = $handle->file_new_name_body=time();
	$ext = $handle->image_src_type;
	$filename = $newfilename.'.'.$ext;
	if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png' || $handle->image_src_type == 'JPG')
	{
		if ($handle->uploaded) {
			$handle->Process($path);
			if ($handle->processed)
			{
				$update=$db->update('settings',array('name'=>$name,
                                				     'email'=>$email,
                                				     'website'=>$website,
                                				     'address'=>$address,
                                				     'country'=>$country,
                                				     'city'=>$city,
                                				     'state'=>$state,
                                				     'zip'=>$zip,
                                				     'timezone'=>$timezone,
                                				     'date_format'=>$dateformat,
                                				     'telephone1'=>$telephone1,
                                				     'telephone2'=>$telephone2,
				                                     'currency_symbol'=>$currency_symbol,
                                				     'cookie_expire'=>$cookie_value,
                                				     'logo'=>$filename,
				                                     'fax_number'=>$fax_number,
                                				  //   'facebook_api_id'=>$facebook_api_id,
                                				  //   'facebook_api_secret'=>$facebook_api_secret,
                                				  //   'google_client_id'=>$google_client_id,
                                				  //   'google_client_secret'=>$google_client_secret
                                				  ),array('id'=>1));
}
		}
	}}
	else{
		$update=$db->update('settings',array('name'=>$name,
                                		     'email'=>$email,
                                		     'website'=>$website,
                                		     'address'=>$address,
                                		     'country'=>$country,
                                		     'city'=>$city,
                                		     'state'=>$state,
                                		     'zip'=>$zip,
                                		     'timezone'=>$timezone,
                                		     'date_format'=>$dateformat,
                                		     'telephone1'=>$telephone1,
                                		     'telephone2'=>$telephone2,
                                		     'currency_symbol'=>$currency_symbol,
                                		     'cookie_expire'=>$cookie_value,
                                		     'fax_number'=>$fax_number,
                                		    // 'facebook_api_id'=>$facebook_api_id,
                                		    // 'facebook_api_secret'=>$facebook_api_secret,
                                		    // 'google_client_id'=>$google_client_id,
                                			// 'google_client_secret'=>$google_client_secret
                                			),array('id'=>1));

	}

	//for Pdf logo
	$handle= new upload($pdf_logo);
	$ext_pdf=$handle->file_src_name_ext;
	$path=SERVER_ROOT.'/uploads/pdflogo/';
	if(!is_dir($path))
	{
	    if(!file_exists($path)){
	        mkdir($path);
	    }
	}
	if ($ext_pdf!='jpeg' && $ext_pdf!='jpg' && $ext_pdf!='png' && $pdf_logo['name'] !='' )
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i>
	        </button>
Only jpeg,jpg and png files are allowed for pdf logo
		</div>';
	}
	elseif(($pdf_logo['name']) != ''){
	    if(file_exists(SERVER_ROOT.'/uploads/pdflogo/'.$settings['pdflogo']) && (($settings['pdflogo'])!=''))
	    {
	        unlink(SERVER_ROOT.'/uploads/pdflogo/'.$settings['pdflogo']);
	    }
	    $newfilename = $handle->file_new_name_body=time();
	    $ext = $handle->image_src_type;
	    $filename = $newfilename.'.'.$ext;

	    if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png' || $handle->image_src_type == 'JPG')
	    {
	        if ($handle->uploaded) {

	            $handle->Process($path);
	            if ($handle->processed)
	            {
	                $update=$db->update('settings',array('name'=>$name,'email'=>$email,'website'=>$website,'address'=>$address,'country'=>$country,'city'=>$city,'state'=>$state,'zip'=>$zip,'timezone'=>$timezone,'date_format'=>$dateformat,'telephone1'=>$telephone1,'telephone2'=>$telephone2,'currency_symbol'=>$currency_symbol,'cookie_expire'=>$cookie_value,'pdflogo'=>$filename),array('id'=>1));
	                /*entry in activity log table*/
	               /* $event="Update site setting and Change pdf logo";
	                $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                	                  'event'=>$event,
                                	                  'created_date'=>date('Y-m-d'),
                                	                  'ip_address'=>$_SERVER['REMOTE_ADDR']

	                ));*/
	            }
	        }
	    }}
	if($update)
	{
		$display_msg='<div class="alert alert-success text-success">
		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Success! Data Updated.
		</div>';

		echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("site_setting",admin)."'
        	                },3000);</script>";
	}
}
?>