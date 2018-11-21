<?php $current_tab=$_COOKIE['current_tab'];
if ($current_tab!="preferences" && $current_tab!="pending" && $current_tab!="published" && $current_tab!="hidden")
 {$current_tab="preferences";}
$preferences_settings_details=$db->get_row('preferences_settings',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));

if ($current_tab=="pending")
{
 $reviews=$db->get_all('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'pending'));
 
}
elseif ($current_tab=="published")
{
 $reviews=$db->get_all('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'publish'));
 
}
elseif ($current_tab=="hidden")
{
 $reviews=$db->get_all('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'hide'));
 
}
$hide_count=$db->get_count('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'hide'));
$publish_count=$db->get_count('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'publish'));
$pending_count=$db->get_count('review',array('company_id'=>CURRENT_LOGIN_COMPANY_ID,'status'=>'pending'));

if (isset($_POST['update_preference_update_form_submit']))
{
  
  $enable_review=$_POST['enable_review'];
  
  $update=$db->update('preferences_settings',array('enable_review'=>$enable_review)
    ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
  if ($update)
  {
    $display_msg='<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button>
    Success! Data Updated.
    </div>';
    
    echo "<script>
    setTimeout(function(){
     window.location = '".$link->link("reviews",frontend)."'
   },3000);</script>";
 }
 
}
if (isset($_REQUEST['action_publish']))
{
  $update=$db->update('review',array('status'=>'publish'),array('id'=>$_REQUEST['action_publish']));
  if ($update){
    $session->redirect('reviews',frontend);
  }

}
elseif (isset($_REQUEST['action_hide']))
{
  $update=$db->update('review',array('status'=>'hide'),array('id'=>$_REQUEST['action_hide']));
  if ($update){
    $session->redirect('reviews',frontend);
  }
}
elseif (isset($_REQUEST['action_delete']))
{
  $delete=$db->delete('review',array('id'=>$_REQUEST['action_delete']));
  if ($delete){
    $session->redirect('reviews',frontend);
  }
}
?>
<div id="page-content">
  <div class="row">
    <div class="col-lg-12">
      <?php echo $display_msg;?>
      <!--Stacked Tabs Left-->
      <!--===================================================-->
      <div class="tab-base tab-stacked-left">
        <!--Nav tabs-->
        <ul class="nav nav-tabs">
          <li tab="preferences" class="set_cookie <?php if ($current_tab=='preferences'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="false"><i class="fa fa-list"></i> Preferences </a>
          </li>
          <li tab="pending" class="set_cookie <?php if ($current_tab=='pending'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i class="fa fa-clock-o"></i> Pending <span class="badge"><?php echo $pending_count;?></span></a>
          </li>
          <li tab="published" class="set_cookie <?php if ($current_tab=='published'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i class="fa fa-check-circle-o"></i> Published  <span class="badge"><?php echo $publish_count;?></span></a>
          </li>
          <li tab="hidden" class="set_cookie <?php if ($current_tab=='hidden'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i class="fa fa-eye-slash"></i> Hidden <span class="badge"><?php echo $hide_count;?></span></a>
          </li>
          
        </ul>
        <!--Tabs Content-->
        <div class="tab-content">
          <?php if ($current_tab=='preferences'){?>
            
           <h3 class="text-thin">Post Customer Reviews on Your Booking Page</h3>
           <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
            <div class="panel-body">
              <div class="form-group">
                <div class="col-md-8">
                 <div class="checkbox">
                  <label class="form-checkbox form-icon form-text">
                    <h4>Enable Review</h4><input <?php if (ENABLE_REVIEW=="yes"){echo 'checked';}?>  type="checkbox" name="enable_review"  value="yes"></label><br>
                    
                  </div>
                </div>
                
              </div>
            </div>
            <div class="panel-footer">
             <button class="btn btn-info" name="update_preference_update_form_submit"   type="submit"> <i class="fa fa-save"></i> Submit</button>  
           </div>
           
         </form>
         
       <?php }elseif ($current_tab=='pending' || $current_tab=='published'|| $current_tab=='hidden'){?>
        <h3 class="text-thin"><?php echo ucfirst($current_tab);?> Reviews</h3>
        <table class="table table-hover table-vcenter"> 
          <thead>
            <tr>
              <th width="20%">&nbsp;</th> 
              <th width="60%">&nbsp;</th> 
              <th width="10%">&nbsp;</th>
              <th width="10%">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if (is_array($reviews)){
              foreach ($reviews as $review_detail){
                ?>
                <tr>
                 <td><?php echo date('D M d,Y',strtotime($review_detail['created_date']));?></td>
                 <td><?php echo ucwords($review_detail['review_provider_name']);?><br> <?php echo ucfirst($review_detail['review_detail']);?> </td>
                 <td> <?php 
                 $rating= $review_detail['rating'];
                 for ($x = 1; $x <= 5; $x++) {?>
                   <?php if($x<=$rating){?><i style="color:#ed8323;" class="fa fa-star"></i><?php }else{?>
                     <i class="fa fa-star-o"></i>
                   <?php }}?>  
                 </td>
                 <td>
                   <?php if ($review_detail['status']=="pending" || $review_detail['status']=="hide" ){?>
                     <a href="<?php echo $link->link("reviews",user,'&action_publish='.$review_detail['id']);?>"><i class="fa fa-check  text-success"></i></a>
                   <?php }
                   if ($review_detail['status']=="pending" || $review_detail['status']=="publish" ){?>
                     <a href="<?php echo $link->link("reviews",user,'&action_hide='.$review_detail['id']);?>"><i class="fa fa-eye-slash  text-info"></i></a>
                   <?php }?>
                   <a href="<?php echo $link->link("reviews",user,'&action_delete='.$review_detail['id']);?>"><i class="fa fa-trash  text-danger"></i></a>
                 </td>
                 
                 
               </tr>
             <?php }}?>
             
           </tbody>
         </table>
         
         
       <?php }?>
       
     </div>
   </div>
   <!--===================================================-->
   <!--End Stacked Tabs Left-->
 </div>
 
</div>
</div>