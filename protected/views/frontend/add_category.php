<?php
if (isset($_POST['add_service_category_form_submit']))
{
    //print_r($_POST);
  $category_name=$_POST['category_name'];
  $visibility_status='active';
  $created_date=date('Y-m-d');
  $ip_address=$_SERVER['REMOTE_ADDR'];


  $empt_fields = $fv->emptyfields(array('Category Name'=>$category_name));

  if ($empt_fields)
  {
    $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> 
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Following fields are empty<br>'.$empt_fields.'</div>';
  }

  elseif ($db->exists('service_category',array('category_name'=>$category_name)))
  {
    $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Service Name is already exist.
    </div>';
  }
  else
  {
   
   $insert=$db->insert("service_category",array('category_name'=>$category_name,
    'visibility_status'=>$visibility_status,
    'company_id'=>CURRENT_LOGIN_COMPANY_ID,
    'created_date'=>$created_date,
    'ip_address'=>$ip_address));
 //  $db->debug();
   if ($insert){
      /*  $event="Create a new Service Category (" . $category_name . ")";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

                                        ));*/
                                        $display_msg= '<div class="alert alert-success text-success">
                                        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                        Service Category Add Successfully.
                                        </div>';

                                        echo "<script>
                                        setTimeout(function(){
                                         window.location = '".$link->link("services",frontend)."'
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
                                            <a href="<?php echo $link->link('services',user);?>" class="btn btn-default" data-click="panel-expand"><i class="fa fa-tag"></i> Services</a>
                                            
                                          </div>
                                          <h3 class="panel-title">Add Category</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                        <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                          <div class="panel-body">
                                            <div class="row">
                                             
                                              
                                              <div class="col-md-6"> 
                                               
                                               
                                               <div class="form-group">
                                                 <label class="control-label col-md-4">Category Name<font color="red">*</font></label>
                                                 <div class="col-md-7">
                                                  <input class="form-control"  type="text" name="category_name" value="<?php echo $_POST['service_name'];?>">
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                          </div>
                                        </div>
                                        
                                        <div class="panel-footer text-right">
                                         
                                         <button class="btn btn-info" name="add_service_category_form_submit"   type="submit">Submit</button>  
                                       </div>
                                       
                                     </form>

                                   </div>
                                 </div>
                                 
                               </div>
                             </div>








