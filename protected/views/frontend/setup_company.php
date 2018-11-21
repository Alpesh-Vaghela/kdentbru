<?php 
$setting = $db->get_row('settings');

if(isset($_REQUEST['new_company']))
{
  $user_id=$_REQUEST['new_company'];
  $user_details=$db->get_row('users',array('user_id'=>$user_id));
  $default_plan_details=$db->get_row('plans',array('default'=>'1'));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> <?php echo $setting['name'];?></title>
   <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
   <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
   <!--Roboto Slab Font [ OPTIONAL ] -->
   <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet">
   <!--Bootstrap Stylesheet [ REQUIRED ]-->
   <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet">
   <!--Jasmine Stylesheet [ REQUIRED ]-->
   <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet">
   <!--Font Awesome [ OPTIONAL ]-->
   <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet">
   <!--Switchery [ OPTIONAL ]-->
   <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jquery-steps.min.css';?>" rel="stylesheet">
   <style>
   .btn-group-vertical>.btn-group:after,.btn-group-vertical>.btn-group:before,.btn-toolbar:after,.btn-toolbar:before,.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.dl-horizontal dd:after,.dl-horizontal dd:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before,.nav:after,.nav:before,.navbar-collapse:after,.navbar-collapse:before,.navbar-header:after,.navbar-header:before,.navbar:after,.navbar:before,.pager:after,.pager:before,.panel-body:after,.panel-body:before,.row:after,.row:before
   {
      display: table;
      content: " "
   }
</style>
</head>
<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
<body>
   <div id="container" class="">
      <div class="boxed">
         <!--CONTENT CONTAINER-->
         <!--===================================================-->
         <div id="content-container">
            <div id="page-content">
               <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                     <?php echo $display_msg;?>
                     <section class="panel">
                        <div class="panel-heading">
                           <h3 class="panel-title">Welcome to <?php echo SITE_NAME;?>( Company Setup )</h3>
                        </div>
                        <div class="panel-body">
                           <div id="after_post_message_ba"></div>
                           <form class="form-horizontal form-bordered" method="POST" action="" id="wizard">
                              <input type="hidden" name="submit" value="">
                              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                              <div class="wizard-title"> Welcome </div>
                              <div class="wizard-container">
                                 <div class="form-group">
                                    <div class="col-md-12">
                                       <h4 class="text-primary"> <i class="fa fa-book"></i> Set Business Information</h4>
                                       <p class="text-muted"> We'll get you booking appointments in no time.</p>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label"> Your Business<font class="text-danger">*</font> : </label>
                                    <div class="col-sm-6">
                                       <input class="form-control" name="company_name" type="text" placeholder="Type your Business Name"  value="<?php echo $company_name?>"/>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Industry: </label>
                                    <div class="col-sm-6">
                                       <select class="form-control" name="company_industry">
                                          <option value="1">Computers / Technology</option>
                                          <option value="2">Consulting / Business Services</option>
                                          <option value="2">Church / Religious Organization</option>
                                          <option value="3">Education</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label"> Business Email: </label>
                                    <div class="col-sm-6">
                                       <input class="form-control" name="company_email" type="email" placeholder="Business Email" value="<?php echo $user_details['email'];?>" />
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Phone No<font class="text-danger">*</font>: </label>
                                    <div class="col-sm-6">
                                       <input type="text" name="company_phone" placeholder="Business Phone" data-mask="+99-99-9999-9999" class="form-control" />
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <input type="hidden" name="date_format" id="date_format" value="<?php echo $settings['date_format'];?>">
                                    <label class="col-sm-2 control-label">Date Format : </label>
                                    <div class="col-sm-6">
                                       <select class="form-control" name="company_date_format" id="dateformat">
                                          <option <?php if ($settings['date_format']=="d/m/Y")echo 'selected="selected"';?> value="d-m-Y">dd/mm/yyyy</option>
                                          <option <?php if ($settings['date_format']=="Y/m/d")echo 'selected="selected"';?> value="Y-m-d">yyyy/mm/dd</option>
                                          <option <?php if ($settings['date_format']=="m/d/Y")echo 'selected="selected"';?> value="m-d-Y">mm/dd/yyyy</option>
                                          <option <?php if ($getdata['date_format']=="d-m-Y")echo 'selected="selected"';?> value="d-m-Y">dd-mm-yyyy</option>
                                          <option <?php if ($settings['date_format']=="Y-m-d")echo 'selected="selected"';?> value="Y-m-d">yyyy-mm-dd</option>
                                          <option <?php if ($settings['date_format']=="m-d-Y")echo 'selected="selected"';?> value="m-d-Y">mm-dd-yyyy</option>
                                          <option <?php if ($settings['date_format']=="d-M-Y")echo 'selected="selected"';?> value="d-M-Y">dd-MM-yyyy  (Ex.<?php echo date('d-M-Y');?>)</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Currency:</label>
                                    <div class="col-sm-6">
                                       <input class="form-control" name="company_currencysymbol" type="text" value="<?php echo $company_currencysymbol;?>">
                                       
                                    </div>
                                 </div>
                              </div>
                              <!--/ Wizard Container 1 -->
                              <!-- Wizard Container 2 -->
                              <div class="wizard-title"> Hours </div>
                              <div class="wizard-container">
                                 <div class="form-group">
                                    <div class="col-md-12">
                                       <h4 class="semibold text-primary"> <i class="fa fa-clock-o"></i> Set Your Business Hours </h4>
                                       <p class="text-muted">Let your Customers know when you're open </p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="form-group">
                                       <input type="hidden" name="db_timezone" id="db_timezone" value="<?php echo $settings['timezone'];?>">
                                       <label class="control-label col-md-3">Time Zone</label>
                                       <div class="col-md-6">
                                          <select class="form-control" name="timezone" id="timezone">
                                             <?php
                                             $timezones=$feature->get_timezones();
                                             if(is_array($timezones)){ 
                                               foreach ($timezones as $key=>$value){?>
                                                <option value="<?php echo $value['zone'];?>" <?php if(TIMEZONE==$value['zone'])echo "selected";?>><?php echo $value['zone']." ( ".$value['diff_from_GMT']." )";?></option>
                                             <?php }}?>
                                          </select>
                                       </div>
                                    </div>
                                    <table class="table table-hover table-vcenter">
                                       <tbody>
                                          <?php $day_array=array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
                                          if (is_array($day_array)){
                                            foreach ($day_array as $als){
                                              ?>
                                              <tr>
                                                <td><span style="border-radius:50px;" class="btn btn-mint"><?php echo ucfirst($als);?></span>
                                                   <input type="hidden" name="day[]" value="<?php echo $als;?>">
                                                </td>
                                                <td>
                                                   <select name="on_or_off[]" class="form-control" >
                                                      <option  value="on">On</option>
                                                      <option  value="off">Off</option>
                                                   </select>
                                                </td>
                                                <td > <input  class="form-control"  type="time" name="starttime[]" value="08:00" required="">
                                                </td>
                                                <td >
                                                   <input class="form-control" type="time" name="endtime[]" value="23:00" required="">
                                                </td>
                                             </tr>
                                          <?php }
                                       }?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <!--/ Wizard Container 2 -->
                           <!-- Wizard Container 3 -->
                           <div class="wizard-title"> Staff </div>
                           <div class="wizard-container">
                              <div class="form-group">
                                 <div class="col-md-12">
                                    <h4 class="semibold text-primary"> <i class="fa fa-user"></i> Your Staff (Company admin)</h4>
                                    <p class="text-muted"> Don't worry - you can always edit these later</p>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                       <label>Name: <?php echo $user_details['firstname']." ".$user_details['lastname'];?></label>
                                    </div>
                                    <div class="col-md-4">
                                       <label>Email: <?php echo $user_details['email'];?></label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--/ Wizard Container 3 -->
                           <!-- Wizard Container 4 -->
                           <div class="wizard-title"> Services</div>
                           <div class="wizard-container">
                              <div class="form-group">
                                 <div class="col-md-12">
                                    <h4 class="semibold text-primary"> <i class="fa fa-cog"></i> Add the Services You Offer</h4>
                                    <p class="text-muted"> Don't worry - you'll be able to edit these and add more later</p>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <h5>Service Name</h5>
                                    </div>
                                    <div class="col-md-3">
                                       <h5>Time</h5>
                                    </div>
                                    <div class="col-md-3">
                                       <h5>Price ( <?php echo $setting['currency_symbol'];?> )</h5>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <input class="form-control" name="service_name"
                                       type="text" value="Sample Service" />
                                    </div>
                                    <div class="col-md-3">
                                       <input class="form-control"
                                       name="service_time" type="text" value="60" />
                                    </div>
                                    <div class="col-md-3">
                                       <input class="form-control" name="service_cost" type="text" 
                                       value="0" />
                                    </div>
                                 </div>
                              </div>
                              
                           </div>
                           
                        </form>
                        <!--/ END Form Wizard -->
                     </div>
                  </section>
               </div>
               <div class="col-md-2"></div>
            </div>
         </div>
         <!--===================================================-->
         <!--End page content-->
      </div>
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
<!--Jquery Steps [ OPTIONAL ]-->
<script src="<?php echo SITE_URL.'/assets/frontend/plugins/jquery-steps/jquery-steps.min.js';?>"></script>
<!--Bootstrap Wizard [ OPTIONAL ]-->
<script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js';?>"></script>
<!--Fullscreen jQuery [ OPTIONAL ]-->
<script src="<?php echo SITE_URL.'/assets/frontend/plugins/screenfull/screenfull.js';?>"></script>
<!--Form Wizard [ SAMPLE ]-->
<script src="<?php echo SITE_URL.'/assets/frontend/js/demo/wizard.js12121';?>"></script>
<!--Form Wizard [ SAMPLE ]-->
<script src="<?php echo SITE_URL.'/assets/frontend/js/demo/form-wizard.js';?>"></script>

<script>
   $("#wizard").steps({
     headerTag: ".wizard-title",
     bodyTag: ".wizard-container",
     onFinished: function() {
              // do anything here ;)
             // alert("finished!");
             // ("#wizard").submit();

             $.ajax({
               type: 'post',
               url: '<?php echo $link->link('setup_company_ajax',user);?>',
               data: $('#wizard').serialize(),
               dataType: 'json',
               success: function (data) {
                  
                $("#after_post_message_ba").html(data.msg);
                if(data.error==false){
                  setTimeout(function(){
                    window.location = '<?php echo $link->link('login',user);?>';
                 },3000);
               }
            }
         });
          }
       });


    </script>
 </body>
 </html>