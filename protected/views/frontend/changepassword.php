

<header class="pageheader">
                        <h3><i class="fa fa-key"></i> Change Password </h3>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo SITE_URL;?>"> Home </a> </li>
                                <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans));?></li>
                            </ol>
                        </div>
                    </header>
                    <!--Page content-->
                    <!--===================================================-->
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
                                            <h3 class="panel-title">Password Update form</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                     <form method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                        <div class="panel-body">
                                         <div class="form-group">
                                         <label class="control-label col-md-3">Old Password</label>
                                                    <div class="col-md-6">
                                                      <input class="form-control"  name="oldpassword" type="password" value="">
                                                    </div>
                                                  </div>
                                         <div class="form-group">
                                         <label class="control-label col-md-3">New Password</label>
                                                    <div class="col-md-6">
                                                      <input class="form-control"  name="newpassword" type="password" value="">
                                                    </div>
                                                  </div>
                                         <div class="form-group">
                                         <label class="control-label col-md-3">Confirm Password</label>
                                                    <div class="col-md-6">
                                                      <input class="form-control"  name="confirmpassword" type="password" value="">
                                                    </div>
                                                  </div>
                                                  
                                                  </div>
                                                   
                                        <div class="panel-footer text-center">
                                         
                                         <button class="btn btn-info" type="submit" name="submit_changepassword"><i class="fa fa-save"></i> Update</button>  
                                        </div>
                                        
                                         </form>

                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>