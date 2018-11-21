<?php if(isset($_REQUEST['action_delete']))
{
    $delete_id=$_REQUEST['action_delete'];

    $display_msg='<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
	Are you sure ? You want to delete this .
	<input type="hidden" name="del_id" value="'.$delete_id.'" >
	<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
	<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
	</div>
	</form>';
    if(isset($_POST['yes']))
    {
       
        $delete=$db->delete('company',array('id'=>$_POST['del_id']));
       
       
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Customer Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("customers",admin,'&action_id='.$company_id)."'
        	                },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('customers&action_id='.$company_id,admin);
    }

}?>
                    <div id="page-content">
                            <div class="row">
                            <div class="col-lg-12">
                            <div class="tab-base">
                                 <div class="tab-content">
                                      <table class="table table-striped table-bordered" id="demo-dt-basic">
                                      <thead>
					                   <tr row="">
					                     <th>logo</th>
					                    <th>Name</th>
					                   <th>Email Address</th>
					                   <th>Address</th>
					                   <th>Current Plan</th>
					                   <th>Created Date</th>
					                   <th>Action</th>
					                     </tr>
					                  </thead>
					                  <tbody>
					                   <?php
					                   $customers=$db->get_all('company');
					                   
                                            if (is_array($customers)){
                                                $sn=1;

                                            foreach ($customers as $value){
                                            
                                if(file_exists(SERVER_ROOT.'/uploads/company/'.$value['id'].'/logo/'.$value['company_logo']) && (($value['company_logo'])!=''))
                                {
                                    $company_logo=SITE_URL.'/uploads/company/'.$value['id'].'/logo/'.$value['company_logo'];
                                }
                                else
                                {
                                    $company_logo="//www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
                                }
                                                
                                 $current_plan=$db->get_row('plans_company',array('company_id'=>$value['id']));               
                                                
                                                ?>
					                    <tr>
					                    <td class="check hidden-xs"><img src="<?php echo $company_logo;?>" width="100px;" height="50px;"></td>
                                          <td><a href="<?php echo $link->link('company_detail',admin,'&action_id='.$value['id']);?>"><?php echo $value['company_name'];?></a></td>
					                      <td><a href="<?php echo $link->link('company_detail',admin,'&action_id='.$value['id']);?>"><?php echo $value['company_email'];?></a></td>
					                      <td><?php echo $value['company_address'];?><br>
					                          <?php echo $value['company_state'];?> <?php echo $value['company_city'];?> <?php echo $value['company_zip'];?>
					                   
					                      </td>
					                      <td><?php echo ucfirst($current_plan['plan_name']);?></td>
					                      <td><?php echo date(SITE_DATE_FORMAT,strtotime($value['created_date']));?></td>
					                

					                      <td>
					                        <div class="btn-group">
                                             <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                        	
                                            	<li>
                                            <a href="<?php echo $link->link('company_detail',admin,'&action_id='.$value['id']);?>"><i class="fa fa-edit text-info"></i> Company Details</a>
                                              </li>
                                              <li>
                                            <a href="<?php echo $link->link('quick_booking',admin,'&action_id='.$value['id']);?>"><i class="fa fa-edit text-info"></i> Bookings</a>
                                              </li>
                                              	<li>
                                                 <a href="<?php echo $link->link('reviews',admin,'&action_id='.$value['id']);?>"><i class="fa fa-star text-info"></i> Reviews</a>
                                              </li>
                                              	<li>
                                              	  <?php
                                    $ccid=CURRENT_LOGIN_COMPANY_ID;
                                      $ccid=$value['id'];
                                     $query="SELECT `user_id` FROM `users` WHERE `company_id`='$ccid' ORDER BY user_id DESC LIMIT 0, 1";
                                            $ds=$db->run($query)->fetch();
                                            $sid=$ds['user_id'];
                                            ?>
                                            <a href="<?php echo $link->link('staff',admin,'&action_id='.$value['id'].'&sid='.$sid);?>"><i class="fa fa-users text-info"></i> Staff</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('customers',admin,'&action_id='.$value['id']);?>"><i class="fa fa-user text-info"></i> Customers</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('services',admin,'&action_id='.$value['id']);?>"><i class="fa fa-truck text-info"></i> Services</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('rooms_seats',admin,'&action_id='.$value['id']);?>"><i class="fa fa-bed text-info"></i> Rooms/Seats</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('notifications',admin,'&action_id='.$value['id']);?>"><i class="fa fa-bell text-info"></i> Notifications</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('account_preferences',admin,'&action_id='.$value['id']);?>"><i class="fa fa-sliders text-info"></i> Account Preference</a>
                                              </li>
                              
                                           
                                      
                                            </ul>
                                          </div></td>

					                    </tr>
					                   <?php $sn++;}}?>
					                  </tbody>
                           </table>
                                    </div>
                                </div>
                              
                            </div>
                       
                        </div>
                                </div>
