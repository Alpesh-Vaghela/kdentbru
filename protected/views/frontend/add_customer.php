<?php
if (isset($_POST['add_contact_form_submit']))
{
  $email=$_POST['email'];
  $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $mobile_pre_code=$_POST['mobile_pre_code'];
  $mobile_number=$_POST['mobile_number'];
  $office_phone_number=$_POST['office_phone_number'];
  $home_phone_number=$_POST['home_phone_number'];
  $address=$_POST['address'];
  $city=$_POST['city'];
  $state=$_POST['state'];
  $zip=$_POST['zip'];
  $visibility_status='active';
  $created_date=date('Y-m-d');
  $ip_address=$_SERVER['REMOTE_ADDR'];
  $customer_profilepic=$_FILES['customer_profilepic'];


$empt_fields = $fv->emptyfields(array(
                                      'First Name'=>$first_name
    
));

if ($empt_fields)
{
      $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
}

elseif (!$fv->check_email($email) AND $email!='')
{
        $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Oops! Wrong Email Format.
    </div>';
}
elseif ($db->exists('customers',array('email'=>$email,'company_id'=>CURRENT_LOGIN_COMPANY_ID)) AND $email!='')
{
    $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            This contact is already exist.
    </div>';
}
elseif ($customer_profilepic['name']!='')
{
  // ...if from photos.........
  
    $handle= new upload($_FILES['customer_profilepic']);
     $path = SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/customers/';

    if(!is_dir($path))
    {
        if(!file_exists($path)){
            mkdir($path);
        }
    }

    $newfilename = $handle->file_new_name_body=time();
    $ext=$handle->file_src_name_ext;
    $filename = $newfilename.'.'.$ext;

    if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png' )
    {
        if ($handle->uploaded) {
            $handle->Process($path);
            if ($handle->processed)
            {
             $insert=$db->insert("customers",array('company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                                                 'email'=>$email,
                                                                'first_name'=>$first_name,
                                                                'last_name'=>$last_name,
                                                                'mobile_number'=>$mobile_number,
                                                                'office_phone_number'=>$office_phone_number,
                                                                'home_phone_number'=>$home_phone_number,
                                                                'address'=>$address,
                                                                'city'=>$city,
                                                                'state'=>$state,
                                                                'zip'=>$zip,
                                                                'visibility_status'=>$visibility_status,
                                                                'created_date'=>$created_date,
                                                                'profile_image'=>$filename,
                                                                'ip_address'=>$ip_address));
   //$db->debug();
   $last_insert_id=$db->insert_id;
    if ($insert){
         $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name). " was added";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_created',
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'event_type_id'=>$last_insert_id,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
                 $display_msg= '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button> Contact save successfully.
                        </div>';

          echo "<script>
                         setTimeout(function(){
                    window.location = '".$link->link("customers",user)."'
                          },3000);</script>";



    }
            }
        }
    }




     
}
elseif ($_POST['photo_webcam']!='')
{
  // ...if from photos.........
  $img = $_POST['photo_webcam'];
    $folderPath = SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/customers/';
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);

             $insert=$db->insert("customers",array('company_id'=>CURRENT_LOGIN_COMPANY_ID,
                 'email'=>$email,
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'mobile_number'=>$mobile_number,
                'office_phone_number'=>$office_phone_number,
                'home_phone_number'=>$home_phone_number,
                'address'=>$address,
                'city'=>$city,
                'state'=>$state,
                'zip'=>$zip,
                'visibility_status'=>$visibility_status,
                'created_date'=>$created_date,
                'profile_image'=>$fileName,
                'ip_address'=>$ip_address));
   //$db->debug();
   $last_insert_id=$db->insert_id;
    if ($insert){
         $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name). " was added";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_created',
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'event_type_id'=>$last_insert_id,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
                 $display_msg= '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button> Contact save successfully.
                        </div>';

          echo "<script>
                         setTimeout(function(){
                    window.location = '".$link->link("customers",user)."'
                          },3000);</script>";



    }
     
}


else
{
 
   $insert=$db->insert("customers",array('company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                         'email'=>$email,
                                        'first_name'=>$first_name,
                                        'last_name'=>$last_name,
                                        'mobile_number'=>$mobile_number,
                                        'office_phone_number'=>$office_phone_number,
                                        'home_phone_number'=>$home_phone_number,
                                        'address'=>$address,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'zip'=>$zip,
                                        'visibility_status'=>$visibility_status,
                                        'created_date'=>$created_date,
                                        'ip_address'=>$ip_address));
   //$db->debug();
   $last_insert_id=$db->insert_id;
    if ($insert){
         $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name). " was added";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_created',
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'event_type_id'=>$last_insert_id,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
                 $display_msg= '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button> Contact save successfully.
                        </div>';

          echo "<script>
                         setTimeout(function(){
                    window.location = '".$link->link("customers",user)."'
                          },3000);</script>";



    }
}
}?>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                         <div class="row">
                          <div class="col-md-12 "> 
                                <?php echo $display_msg;?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-control">
                                                <a href="<?php echo $link->link('customers',user);?>" class="btn btn-default" data-click="panel-expand"><i class="fa fa-users"></i> Customers</a>
                                              
                                            </div>
                                            <h3 class="panel-title">Add Customer</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                     <form id="add_contact_form12" method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                        <div class="panel-body">
                                          <div class="row">
                         
                              
                                <div class="col-md-6"> 
                       
                     
                       <div class="form-group">
                           <label class="control-label col-md-4">Email</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="name@address.com" type="text" name="email" value="<?php echo $_POST['email'];?>">
                           </div>
                        </div>
                        <div class="form-group" id="business_name_id">
                           <label class="control-label col-md-4">First name<font color="red">*</font></label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="first_name" value="<?php echo $_POST['first_name'];?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4">Last name</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="last_name" value="<?php echo $_POST['last_name'];?>">
                           </div>
                        </div>
                           <div class="form-group">
                           <label class="control-label col-md-4">Mobile No.</label>
                         
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="mobile_number" value="<?php echo $_POST['mobile_number'];?>">
                           </div>
                        </div>
                      <div class="form-group">
                           <label class="control-label col-md-4">Office No.</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="office_phone_number" value="<?php echo $_POST['office_phone_number'];?>">
                           </div>
                        </div>
                         <div class="form-group">
                           <label class="control-label col-md-4">Home No.</label>
                           
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="home_phone_number" value="<?php echo $_POST['home_phone_number'];?>">
                           </div>
                        </div>
                       </div>
                  <div class="col-md-6">
                   <div class="form-group">
                           <label class="control-label col-md-4">Address</label>
                           <div class="col-md-8">
                              <textarea class="form-control" rows="5" name="address"><?php echo $_POST['address'];?></textarea>
                           </div>
                        </div>
                          <div class="form-group">
                           <label class="control-label col-md-4">City</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="city" value="<?php echo $_POST['city'];?>">
                           </div>
                        </div>
                         <div class="form-group">
                           <label class="control-label col-md-4">State</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="state" value="<?php echo $_POST['state'];?>">
                           </div>
                        </div>
                         <div class="form-group">
                           <label class="control-label col-md-4">Zip</label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="zip" value="<?php echo $_POST['zip'];?>">
                           </div>
                        </div>
                
                        
                     <!--     <div class="form-group">
                           <label class="control-label col-md-4">Status</label>
                           <div class="col-md-8">
                              <select class="form-control" name="visibility_status">
                                 <option value="active" <?php if ($_POST['visibility_status']=='active'){echo 'selected';}?>>Active</option>
                                 <option value="inactive" <?php if ($_POST['visibility_status']=='inactive'){echo 'selected';}?>>Inactive</option>
                              </select>
                           </div>
                        </div> -->
                          </div>
                  </div>
                  <div class="form-group">
       <label class="control-label col-md-4">Foto</label>
       <div class="col-md-6 file_input" >
          <select class="form-control" onclick="show_method(this.value)">
            <option>Select One..</option>
            <option value="1">Upload From Photos</option>
            <option value="2">Upload from WebCam</option>
          </select>
      </div>
    </div>
    <div class="form-group" id="photo_pc" style="display: none;">
       <label class="control-label col-md-4">Foto</label>
       <div class="col-md-6 file_input" >
          <input type="file" name="customer_profilepic" id="customer_profilepic" placeholder="Upload Image" class="form-control">
      </div>
    </div>
      <div class="row" id="photo_cam" style="display: none;">
          <div class="col-md-6">
              <div id="my_camera"></div>
              <br/>
              <input type=button value="Take Snapshot" onClick="take_snapshot()">
              <input type="hidden" name="photo_webcam" class="image-tag">
          </div>
          <div class="col-md-6">
              <div id="results">Your captured image will appear here...</div>
          </div>
      </div>
                  </div>
                                                    
                                        <div class="panel-footer text-center">
                                         
                                         <button class="btn btn-info" name="add_contact_form_submit"  id="add_contact_form_submit_id12121" type="submit"> <i class="fa fa-save"></i> Submit</button>  
                                        </div>
                                        
                                         </form>

                                    </div>
                                </div>
                         
                        </div>
                    </div>
<script type="text/javascript">
  // ..................webcam setting.........
  function show_method(value){
   
    if(value=='1'){
      $(".image-tag").val('');
      document.getElementById('results').innerHTML = 'Your captured image will appear here...';
      document.getElementById("photo_pc").style.display='block';
      document.getElementById("photo_cam").style.display='none';

    }else if(value=='2'){
      Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
   Webcam.attach( '#my_camera' );
    $("#customer_profilepic").val('');
      document.getElementById("photo_cam").style.display='block';
      document.getElementById("photo_pc").style.display='none';

    }else{
    document.getElementById("photo_cam").style.display='none';
      document.getElementById("photo_pc").style.display='none'; }
  }
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }

</script>







