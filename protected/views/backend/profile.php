
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
                                            <h3 class="panel-title">Profile Update form</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                        <form method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                            <div class="panel-body">
                                                <div class="form-group">
 <label class="control-label col-md-3">Email</label>
            <div class="col-md-6">
              <input type="hidden" name="profilesize" id="profilesize" >
              <input class="form-control"  name="username" disabled type="text" value="<?php echo $_SESSION['email'];?>">
              <br>
              <label>Your email is for logging in and cannot be changed.</label>
            </div>
          </div>
 <div class="form-group">
 <label class="control-label col-md-3">First Name<?php //echo $_SESSION['user_id'];?></label>
            <div class="col-md-6">
              <input class="form-control"  name="f_name" type="text" value="<?php echo CURRENT_LOGIN_USER_FNAME;?>">
            </div>
          </div>
 <div class="form-group">
 <label class="control-label col-md-3">Last Name</label>
            <div class="col-md-6">
              <input class="form-control"  name="l_name" type="text" value="<?php echo CURRENT_LOGIN_USER_LNAME;?>">
            </div>
          </div>

  
          <div class="form-group">
            <label class="control-label col-md-3">Profile Pic</label>
            <div class="col-md-4">
             <input type="file" name="profilepic" id="profilepic">
               <br> <small>Only jpeg, png & jpeg (Max : <?php echo $upload_max_size;?>)</small>
            </div>
            <div class="col-md-4">
             
      <img class="img-circle img-lg" src="<?php echo $admin_image;?>"  width="100%">
            
            </div>
          </div>
                                            </div>
                                            <div class="panel-footer text-center">
                                                <button class="btn btn-info btn-block12" type="submit" name="submit_profile"><i class="fa fa-save"></i> Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End page content-->

<script>
  $('#profilepic').bind('change', function() {
  $('#profilesize').val(this.files[0].size);
  var a = this.files[0].size;
  var b= <?php echo ($upload_max_size*1024*1024);?>;
if(a>b)
  alert("File size must be less than <?php echo $upload_max_size;?>");
});
  </script>