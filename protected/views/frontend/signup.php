<?php 
$setting = $db->get_row('settings');
if (isset($_POST['signup_form_submit'])){

    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];

    $empt_fields = $fv->emptyfields(array('FullName'=>$name,
      'Email'=>$email,
      'Password'=>$pass,
      'Confirm Password'=>$confirmPassword,
  ));

    if ($empt_fields)
    {
        $display_msg= '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Oops! Following fields are empty<br>'.$empt_fields.'</div>';
    }

    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $display_msg='<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Oopes! Enter a valid email.
        </div>';
    }
    elseif($confirmPassword!=$pass )
    { 
        $display_msg='<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Oopes! Password and Confirm password not same.
        </div>';
    }
    elseif ($db->exists('users',array('email'=>$email)))
    {
        $display_msg= '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        This Email is already exist.
        </div>';
    }
    else
    {    
        $encrypt_password = $password->hashBcrypt( $pass, '10', PASSWORD_DEFAULT) ;
        $fullname=explode(" ", $name);
        $first_name=$fullname['0'];
        $last_name=$fullname['1'];
        $insert=$db->insert('users',array('firstname'=>trim($first_name),
          'lastname'=>trim($last_name),
          'email'=>trim($email),
          'password'=>$encrypt_password,
          'user_type'=>'admin',
          'staff_login'=>'yes',
          'visibility_status'=>'inactive',
          'create_date'=>date('Y-m-d'),
          'ip_address'=>$_SERVER['REMOTE_ADDR']
      ));
        $last_insert_id=$db->insert_id;
        if ($insert)
        {
            
         $display_msg= '<div class="alert alert-success text-success">
         <i class="fa fa-smile-o"></i> 
         <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
         Account Created Successfully.!
         </div>';
         
         echo "<script>
         setTimeout(function(){
           window.location = '".$link->link("setup_company",frontend,'&new_company='.$last_insert_id)."'
       },3000);</script>";
   }
   
   
}}?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $setting['name'];?></title>
    <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet"> <!--Roboto Slab Font [ OPTIONAL ] -->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet"><!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet"><!--Jasmine Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet"><!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet"><!--Switchery [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css';?>" rel="stylesheet"><!--Bootstrap Select [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jasmine.css';?>" rel="stylesheet"><!--Demo [ DEMONSTRATION ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/custom.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
    <script src="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.js';?>"></script>
    
</head>
<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
<body>
    <div id="container" class="cls-container">
        <!-- REGISTRATION FORM -->
        <!--===================================================-->
        <div class="lock-wrapper">
            <div class="panel lock-box">
             <!-- <div class="center"> <img alt="" src="<?php echo SITE_URL.'/assets/frontend/img/user.png';?>" class="img-circle"/> </div> -->
             <h4> Create an Account for Free!!</h4>
             <!--   <p class="text-center">Create an Account for Free!</p> -->
             <div class="row">
                <?php echo $display_msg;?>
                <form id="registration" class="form-inline" action="" method="post">
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div id="demo-error-container"></div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="text-left">
                            <label for="signupInputName" class="control-label">Full Name</label>
                            <input  type="text" placeholder="Enter Full Name" class="form-control" name="name" value="<?php echo $_POST['name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="text-left">
                            <label for="signupInputEmail" class="control-label">Email Address</label>
                            <input type="email" placeholder="Enter Email Address" class="form-control" name="email" value="<?php echo $_POST['email'];?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12"> 
                        <div class="text-left">
                            <label for="signupInputPassword" class="control-label">Password</label>
                            <input  type="password" placeholder="Password" class="form-control lock-input" name="password" value="<?php echo $_POST['password'];?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="text-left">
                            <label for="signupInputRepassword" class="control-label">Retype Password</label>
                            <input  type="password" placeholder="Retype Password" class="form-control lock-input" name="confirmPassword"  value="<?php echo $_POST['confirmPassword'];?>"/>
                        </div>
                    </div>
                           <!--  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <div class="text-left pad-btm">
                                    <label for="checkboxtickmark" class="form-checkbox form-icon control-label">
                                    <input id="checkboxtickmark" type="checkbox" name="agree" value="agree" >
                                    Agree with the terms and conditions 
                                    </label>
                                </div>
                            </div> -->
                            <button type="submit" name="signup_form_submit" class="btn btn-block btn-primary">
                                Sign In
                            </button>
                        </form>
                    </div>
                </div>
                <div class="registration"> Already registered! <a href="<?php echo $link->link('login',frontend);?>"> <span class="text-primary"> Please Login Here </span> </a> </div>
            </div>
            <!--===================================================-->
            <!-- REGISTRATION FORM -->
        </div>
        <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-2.1.1.min.js';?>"></script> 
        <script src="<?php echo SITE_URL.'/assets/frontend/js/bootstrap.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/fast-click/fastclick.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/js/scripts.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.js';?>"></script> 
    </body>
    </html>