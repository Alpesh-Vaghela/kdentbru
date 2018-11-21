

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME;?></title>
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
<body>
        <div id="container" class="cls-container">
            <div class="lock-wrapper">
                <div class="panel lock-box"> 
                    <div class="center"> <img alt="" src="<?php echo SITE_URL.'/assets/frontend/img/user.png';?>" class="img-circle"/> </div>
                    <h4> Hello User !</h4>
                    <p class="text-center">Please enter your email to get your Account Password</p>
                    <div class="row">
                    <?php echo $display_msg;?>
                        <?php if($exists==1 && isset($_REQUEST['random']) && $_REQUEST['random']!='' ){?>
      <form method="post" action="">
         <input class="form-control"  type="hidden" placeholder="token" name="token"  value="<?php echo $_REQUEST['random'];?>">
  
        <div class="form-group">
          <div class="text-left">
            <label class="text-muted">Type Password</label>
            <input class="form-control"  type="password" placeholder="Password" name="password">
          </div>
        
        <div class="text-left">
            <label class="text-muted">Retype Password</label>
            <input class="form-control"  type="password" placeholder="Retype Password" name="retypepassword">
          </div>
        </div>
         <button class="btn btn-block btn-primary" name="change_pass"><i class="fa  fa-check-circle-o fa-lg"></i> Submit</button>
        </form>
        
        <?php }else{?>
        
        
           <form action="<?php $_SERVER['PHP_SELF'];?>" class="form-inline" method="post">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <div class="text-left">
                                    <label class="text-muted">Email ID</label>
                                    <input name="email" type="text" placeholder="Enter Email ID" class="form-control"  />
                                </div>
                                
                                <button type="submit"  name="forgot_pass" class="btn btn-block btn-primary">
                                <i class="fa  fa-check-circle-o fa-lg"></i> Submit
                                </button>
                            </div>
                        </form>
     <?php }?>
                    </div>
                </div>
                <div class="registration">  <a href="<?php echo $link->link('login',admin);?>"> <span class="text-primary"><i class="fa  fa-arrow-circle-o-left fa-lg"></i> Back to Login </span> </a> </div>
            </div>
        </div>
        <!--===================================================--> 
        <!-- END OF CONTAINER -->
        <!--JAVASCRIPT-->
        <!--=================================================-->
        <!--jQuery [ REQUIRED ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-2.1.1.min.js';?>"></script> 
        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/js/bootstrap.min.js';?>"></script>
        <!--Fast Click [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/fast-click/fastclick.min.js';?>"></script>
        <!--Jasmine Admin [ RECOMMENDED ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/js/scripts.js';?>"></script>
        <!--Switchery [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.js';?>"></script>
        <!--Bootstrap Select [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.js';?>"></script> 
    </body>
</html>