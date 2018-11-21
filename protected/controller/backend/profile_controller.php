<?php
if(isset($_POST['submit_profile']))
{
	$firstname=$_POST['f_name'];
	$lastname=$_POST['l_name'];

	$address=$_POST['address'];
	$profilepic=$_FILES['profilepic'];



	    if($profilepic['name']!=''){
	$handle= new upload($_FILES['profilepic']);
	$path = SERVER_ROOT.'/uploads/admin/';
	if(!is_dir($path))
	{
		if(!file_exists($path)){     
			mkdir($path); 
		} 
	}

	if(file_exists(SERVER_ROOT.'/uploads/admin/'.$settings['admin_image']) && (($settings['admin_image'])!=''))
	{
		unlink(SERVER_ROOT.'/uploads/admin/'.$settings['admin_image']);
	}
	$newfilename = $handle->file_new_name_body= time();
	$ext = $handle->image_src_type;
	$filename = $newfilename.'.'.$ext;
	//$file_size = $_FILES ['file'] ['size'] / 1024;

	if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png' )
	{
		if ($handle->uploaded) {
			$handle->Process($path);
			if ($handle->processed)
			{
				$update=$db->update('settings',array('admin_first_name'=>$firstname,
				                                     'admin_last_name'=>$lastname,
				                                     'admin_image'=>$filename
				                                      ),array('admin_login_email'=>$_SESSION['email']));
		
			}
		}
	}}
	else
	{
	    $update=$db->update('settings',array('admin_first_name'=>$firstname,
	                                         'admin_last_name'=>$lastname),array('admin_login_email'=>$_SESSION['email']));
	   
	}

	if($update)
	{
		$display_msg='<div class="alert alert-success text-success">
		<i class="fa fa-smile-o"></i> 
		    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
		    Success! Data Updated.
		</div>';

		echo "<script>
                 setTimeout(function(){
	    		  window.location = '".$link->link("profile",admin)."'
	                },3000);</script>";
}}
?>