<?php 
if(isset($_REQUEST['action_delete']))
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
        $delete=$db->delete('activity_logs',array('id'=>$_POST['del_id']));
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Activity Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("activity",admin)."'
        	                },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect("activity",admin);
    }

}?>
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                                  <div class="row">
                                	<div class="col-lg-12">
                                	<?php echo $display_msg;?>
                                    </div>
                                	</div>
                                	<br>
                            <div class="row">
                            <div class="col-lg-12">
                                <!--Default Tabs (Left Aligned)-->
                                <!--===================================================-->
                                <div class="tab-base">
                                    <div class="tab-content">
                                      <table class="table table-striped table-bordered" id="demo-dt-basic">
                                 <thead>
					                   <tr row="">
					                   <th class="hidden-sm hidden-xs">S.No</th>
					                   <th class="hidden-sm hidden-xs">Company</th>
					                   <th class="hidden-sm hidden-xs">&nbsp;</th>
					                   <th>Event</th>
					                   <th class="hidden-sm hidden-xs">Time</th>
					                   <th>Performed By</th>
					                   
					                   <th>&nbsp;</th>
					                
					                     </tr>
					                  </thead>
					                  <tbody>
					                 <?php
                                               $db->order_by='id DESC';
                                                $all_activity_log=$db->get_all('activity_logs');
                                                if (is_array($all_activity_log)){
                                                    $sn=1;
                                                    foreach ($all_activity_log as $alla)
                                                    {
                                                    ?>
					                    <tr>
					                    <td class="hidden-sm hidden-xs"><?php echo $sn;?></td>
					                       <td>
                                                   <?php echo $db->get_var('company',array('id'=>$alla['company_id']),'company_name');?>
                                                     </td>
					                      <td class="hidden-sm hidden-xs"> <span class="icon-wrap icon-circle12 <?php if ($alla['event_type']=="customer_created" || $alla['event_type']=="appointment_created")
                                                               {echo'bg-success';}
                                                               elseif ($alla['event_type']=="customer_updated" || $alla['event_type']=="appointment_updated")
                                                               {echo'bg-warning';}
                                                               elseif ($alla['event_type']=="customer_deleted" || $alla['event_type']=="appointment_deleted")
                                                                {echo'bg-danger';}
                                                                elseif ($alla['event_type']=="login")
                                                                {echo'bg-pink';}
                                                                elseif ($alla['event_type']=="logout")
                                                                {echo'bg-purple';}
                                                           
                                                         ?>">
                                                         <?php if ($alla['event_type']=="customer_created" || $alla['event_type']=="customer_updated" || $alla['event_type']=="customer_deleted")
                                                               {echo'<i class="fa fa-user fa-lg"></i>';}
                                                               elseif ($alla['event_type']=="login")
                                                               {echo'<i class="fa fa-sign-in fa-lg"></i>';}
                                                               elseif ($alla['event_type']=="logout")
                                                               {echo'<i class="fa fa-sign-out fa-lg"></i>';}
                                                               elseif ($alla['event_type']=="appointment_created" || $alla['event_type']=="appointment_updated" || $alla['event_type']=="appointment_deleted")
                                                               {echo'<i class="fa fa-calendar fa-lg"></i>';}
                                                             
                                                         ?>
                                                              
                                                          </span></td>  
                                          <td><?php echo $alla['event'];?> at <?php echo $alla['timestamp']?></td>
                                          <td class="hidden-sm hidden-xs">  <strong> <?php 
                                                            $date1timestamp=time();
                                                            $date2timestamp=strtotime($alla['timestamp']);
                                                            $result = $feature->date_difference($date1timestamp, $date2timestamp);
                                                            if($result['day']!=0 || $result['day']>0){echo $result['day'].' day&nbsp;';}
                                                            if($result['hours']!=0 || $result['hours']>0){echo $result['hours'].' hour&nbsp;';}
                                                            if($result['hours']!=0 || $result['hours']>0){echo $result['mins'].' min&nbsp;';}
                                                            ?>ago</strong></td>
                                          <td><?php  echo $staff_first_name=$db->get_var('users',array('user_id'=>$alla['user_id']),'firstname');
                                          echo " ";
                                                    echo  $staff_last_name=$db->get_var('users',array('user_id'=>$alla['user_id']),'lastname');
                                                   ?></td>
                                                 
                                                   <td>
                                                    <a class="btn btn-danger " href="<?php echo $link->link("activity",admin,'&action_delete='.$alla['id']);?>"><i class="fa fa-trash"></i> Delete</a>
                                                     </td>
					   

					                    </tr>
					                   <?php $sn++; ?>
					                   
					                    <?php
                                                    }
                                                }else{
                                                   echo "No Activity Perform Yet!";
                                               }?>
					                  </tbody>
                           </table>
                                    </div>
                                </div>
                          
                              
                            </div>
                       
                        </div>
                                </div>
