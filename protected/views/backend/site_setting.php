
                    <div id="page-content">
                         <div class="row">
                         
                            <div class="eq-height">
                              
                                <div class="col-sm-6 eq-box-sm"> 
                                <?php echo $display_msg;?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-control">
                                                <button class="btn btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></button>
                                                <button class="btn btn-default" data-click="panel-reload"><i class="fa fa-refresh"></i></button>
                                                <button class="btn btn-default" data-click="panel-collapse"><i class="fa fa-chevron-down"></i></button>
                                                <button class="btn btn-default" data-dismiss="panel"><i class="fa fa-times"></i></button>
                                            </div>
                                            <h3 class="panel-title">Setting Update form</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                     <form method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                        <div class="panel-body">
                                         <div class="row">

 <div class="col-md-6">
   <div class="form-group">
            <label class="control-label col-md-4">Company-Name</label>
            <div class="col-md-8">
              <input class="form-control"  name="name" type="text" value="<?php echo $settings['name'];?>">
            </div>
          </div>
   <div class="form-group">
            <label class="control-label col-md-4">Company-Email</label>
            <div class="col-md-8">
              <input class="form-control"  name="email" type="text" value="<?php echo $settings['email'];?>">
            </div>
   </div>
    <div class="form-group">
 <label class="control-label col-md-4">Company-Website</label>
     <div class="col-md-8">
                <input class="form-control" type="text" name="website" value="<?php echo $settings['website'];?>">
              </div></div>
  <div class="form-group">
                   <label class="control-label col-md-4">Address</label>
                  <div class="col-md-8">
              <textarea class="form-control" name="address"><?php echo html_entity_decode($settings['address']);?>
              </textarea>
            </div>
          </div>

          <div class="form-group">
          <label class="control-label col-md-4">Countries</label>
          <div class="col-md-8">
<select  class="form-control" name="country" >
    <option value="0" selected="selected">---Select Country---</option>
    <?php
    $countryList=$feature->get_country_list();
     if(is_array($countryList))foreach($countryList as $key=>$value){?>
    <option value="<?php echo $key;?>" <?php if($key==$settings['country']) echo "selected";?> ><?php echo $value;?></option>
<?php }?>
</select>
          </div>
          </div>
          <div class="form-group">
                   <label class="control-label col-md-4">State</label>
                  <div class="col-md-8">
              <input class="form-control" name="state" type="text" value="<?php echo $settings['state'];?>">
            </div>
          </div>
          <div class="form-group">
                   <label class="control-label col-md-4">City</label>
                  <div class="col-md-8">
             <input class="form-control" name="city" type="text" value="<?php echo $settings['city'];?>">
            </div>
          </div>

           <div class="form-group">
                   <label class="control-label col-md-4">Zip</label>
                  <div class="col-md-8">
              <input class="form-control"  name="zip" type="text" value="<?php echo $settings['zip'];?>">
            </div>
          </div>

          <div class="form-group">
                   <label class="control-label col-md-4">Telephone 1</label>
                  <div class="col-md-8">
              <input class="form-control"  name="telephone1" type="text" value="<?php echo $settings['telephone1'];?>">
            </div>
          </div>
          <div class="form-group">
                   <label class="control-label col-md-4">Telephone 2</label>
                  <div class="col-md-8">
              <input class="form-control"  name="telephone2" type="text" value="<?php echo $settings['telephone2'];?>">
            </div>
          </div>
            <div class="form-group">
                   <label class="control-label col-md-4">Fax</label>
                  <div class="col-md-8">
              <input class="form-control"  name="fax_number" type="text" value="<?php echo $settings['fax_number'];?>">
            </div>
          </div>







 </div>
  <div class="col-md-6">

             <div class="form-group">
    <label class="control-label col-md-4">Currency symbol</label>
                     <div class="col-md-8">
              <input class="form-control" name="currencysymbol" type="text" value="<?php echo $settings['currency_symbol'];?>" >
              </div>
            </div>
            
           <div class="form-group">
            <input type="hidden" name="db_timezone" id="db_timezone" value="<?php echo $settings['timezone'];?>">
                   <label class="control-label col-md-4">Time Zone</label>
                  <div class="col-md-8">
                  <select class="form-control" name="timezone" id="timezone">
<?php
$timezones=$feature->get_timezones();
if(is_array($timezones)) foreach ($timezones as $key=>$value){?>
                  <option value="<?php echo $value['zone'];?>" <?php if($settings['timezone']==$value['zone'])echo "selected";?>><?php echo $value['zone']." ( ".$value['diff_from_GMT']." )";?></option>
                  <?php }?>
 </select>
            </div>
          </div>
           <div class="form-group">
              <input type="hidden" name="date_format" id="date_format" value="<?php echo $settings['date_format'];?>">
                   <label class="control-label col-md-4">Date Format</label>
                  <div class="col-md-8">
             <select class="form-control" name="dateformat" id="dateformat">
                     <option <?php if ($settings['date_format']=="d/m/Y")echo 'selected="selected"';?> value="d-m-Y">dd/mm/yyyy</option>
                     <option <?php if ($settings['date_format']=="Y/m/d")echo 'selected="selected"';?> value="Y-m-d">yyyy/mm/dd</option>
                     <option <?php if ($settings['date_format']=="m/d/Y")echo 'selected="selected"';?> value="m-d-Y">mm/dd/yyyy</option>
                     <option <?php if ($getdata['date_format']=="d-m-Y")echo 'selected="selected"';?> value="d-m-Y">dd-mm-yyyy</option>
                     <option <?php if ($settings['date_format']=="Y-m-d")echo 'selected="selected"';?> value="Y-m-d">yyyy-mm-dd</option>
                     <option <?php if ($settings['date_format']=="m-d-Y")echo 'selected="selected"';?> value="m-d-Y">mm-dd-yyyy</option>
                     <option <?php if ($settings['date_format']=="d-M-Y")echo 'selected="selected"';?> value="d-M-Y">dd-MM-yyyy  (Ex.<?php echo date('d-M-Y');?>)</option>
              </select></div></div>


 <div class="form-group">
 <label class="control-label col-md-4">No of days(Remember me)</label>
 <div class="col-md-8">
 <input class="form-control"  type="text" name="cookie_expire" value="<?php echo $settings['cookie_expire'];?>">
 </div>
 </div>
      <div class="form-group">
            <label class="control-label col-md-4">Upload Logo</label>
            <div class="col-md-4"><input type="file" name="logo" id="logo">
                 <small>Only jpg , png & jpeg  (Max : <?php echo $upload_max_size;?>)</small></div>
             
             
          
            <div class="col-md-4">
              <?php if(file_exists(SERVER_ROOT.'/uploads/logo/'.$settings['logo']) && (($settings['logo'])!=''))
              { ?>
                <img src="<?php echo SITE_URL.'/uploads/logo/'.$settings['logo'].'?id='.rand(0, 89);?>" width="100%">
               <?php } else{?>
              	<img src="<?php echo SITE_URL.'/assets/frontend/images/-text.png';?>"  width="100%">
             <?php } ?>
          </div>
 
 <input type="hidden" name="logosize" id="logosize" >
 <input type="hidden" name="pdflogosize" id="pdflogosize" >

 </div>
 <h4>Social Login Configuration</h4>
      <div class="form-group">
    <label class="control-label col-md-4">Facebook API Id</label>
                     <div class="col-md-8">
         <input class="form-control" type="text" name="facebook_api_id"  value="<?php echo $settings['facebook_api_id'];?>" >
              </div>
            </div>
                <div class="form-group">
    <label class="control-label col-md-4">Facebook API Secret</label>
                     <div class="col-md-8">
         <input class="form-control" type="text" name="facebook_api_secret"  value="<?php echo $settings['facebook_api_secret'];?>">
             <p> <a class="text-info" href="https://developers.facebook.com/apps/" target="_blank"><i class="fa fa-link"></i> Configure Facebook API id and Secret id. </a></p>
              </div>
            </div>
            
            
            
             <div class="form-group">
    <label class="control-label col-md-4">Google Client Id</label>
                     <div class="col-md-8">
         <input class="form-control" type="text" name="google_client_id"  value="<?php echo $settings['google_client_id'];?>">
              </div>
            </div>
                <div class="form-group">
    <label class="control-label col-md-4">Google Client Secret</label>
                     <div class="col-md-8">
         <input class="form-control" type="text" name="google_client_secret"  value="<?php echo $settings['google_client_secret'];?>">
             <p> <a class="text-info" href="https://console.cloud.google.com/apis/" target="_blank"><i class="fa fa-link"></i> Configure Google Client id and Secret id.</a></p>
              </div>
            </div>
</div>
</div></div>
                                                   
                                        <div class="panel-footer text-center">
                                         
                                         <button class="btn btn-info " type="submit" name="submit_settings"><i class="fa fa-save"></i> Update</button>  
                                        </div>
                                        
                                         </form>

                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>


<script>
  $('#logo').bind('change', function() {
  $('#logosize').val(this.files[0].size);
  var a = this.files[0].size;
  var b= <?php echo ($upload_max_size*1024*1024);?>;
if(a>b)
  alert("File size must be less than <?php echo $upload_max_size;?>");
});
          $('#pdflogo').bind('change', function() {

        	  $('#pdflogosize').val(this.files[0].size);
        	  var a = this.files[0].size;
        	  var b= <?php echo ($upload_max_size*1024*1024);?>;
        	if(a>b)
        	  alert("File size must be less than <?php echo $upload_max_size;?>");

        	});

          </script>
