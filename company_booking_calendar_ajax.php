<?php
   session_start ();
   
   /**
    * *** define document path**********
    */
   define ( 'SERVER_ROOT', dirname ( __FILE__ ) );
   define ( 'SITE_ROOT', $_SERVER ['HTTP_HOST'] );
   $protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
   $get_script_path = pathinfo ( $_SERVER ['SCRIPT_NAME'] );
   define ( 'SCRIPT_DIR_PATH', $get_script_path ['dirname'] );
   define ( 'SCRIPT_BASE_NAME', $get_script_path ['basename'] );
   define ( 'SCRIPT_FILE_NAME', $get_script_path ['filename'] );
   unset ( $get_script_path );
   if(SCRIPT_DIR_PATH==='/')
       define ( 'SITE_URL', $protocol . SITE_ROOT);
   else
       define ( 'SITE_URL', $protocol . SITE_ROOT . SCRIPT_DIR_PATH );
   
   ini_set ( 'error_reporting', E_ALL );
   ini_set ( 'display_errors', '1' );
   ini_set ( 'start_up_errors', '1' );
   error_reporting ( E_ALL ^ E_NOTICE );
   
   
    
   require(SERVER_ROOT . '/protected/setting/database.php');
   require(SERVER_ROOT . '/protected/library/db_class.php');
   
   //require(SERVER_ROOT . '/protected/setting/router.php');
   
   $db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
   ?>
<?php 
   // this is for date function
   function createDateRangeArray($strDateFrom,$strDateTo)
   {
      $aryRange=array();
   
       $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
       $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
   
       if ($iDateTo>=$iDateFrom)
       {
           array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
           while ($iDateFrom<$iDateTo)
           {
               $iDateFrom+=86400; // add 24 hours
               array_push($aryRange,date('Y-m-d',$iDateFrom));
           }
       }
       return $aryRange;
   }
   // this is for empty function
   function emptyfields($value, $display = NULL) {
       $newarray = array ();
       if(is_array($value)){
           foreach ( $value as $key => $val ) {
               if ($val=='')
   
                   $newarray [] = $key;
   
           }
       }
       if ($display != NULL && count($newarray)!=0)
           echo $this->form_warning ( $newarray, 'Following fields are empty ! <br>please correct them', 'array' );
       if (count ( $newarray ) != 0)
       {
           foreach ($newarray as $e) {
               $empt_fields .= $e . '<br>';
           }
           return $empt_fields;
       }
       else
       {
           return false;
       }
   }
   // this is for time function
   function create_time_range($start, $end, $interval = '15 mins', $format = '12') {
       $startTime = strtotime($start);
       $endTime   = strtotime($end);
       // $returnTimeFormat = ($format == '12')?'g:iA':'G:i';
       $returnTimeFormat = ($format == '12')?'g:i A':'G:i';
   
       $current   = time();
       $addTime   = strtotime('+'.$interval, $current);
       $diff      = $addTime - $current;
   
       $times = array();
       while ($startTime < $endTime) {
           $times[] = date($returnTimeFormat, $startTime);
           $startTime += $diff;
       }
       $times[] = date($returnTimeFormat, $startTime);
       return $times;
   }
   
   function decryptIt( $q ) {
       $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
       $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
       return( $qDecoded );
   }
   ?>
<?php 
   /****************************************************************************************************/
   /***************************** Load Staff by assign services********************************/
   /***************************************************************************************************/
   
   if(isset($_POST['load_provider_by_service']))
   {
        
          $service_id=$_REQUEST['load_provider_by_service'];
               $company_id=$_REQUEST['company_id'];?>
<?php
   $db->order_by='user_id DESC';
   $allstaff=$db->get_all('users',array('visibility_status'=>'active','user_type'=>'staff','company_id'=>$company_id));
   if (is_array($allstaff)){?>
<option value="">---Seleziona---</option>
<?php foreach ($allstaff as $alls){
   if ($db->exists('assign_services',array('staff_id'=>$alls['user_id'],'service_id'=>$service_id)))
     {?>
<option value="<?php echo $alls['user_id'];?>"><?php echo ucwords($alls['firstname']." ".$alls['lastname']);?></option>
<?php }}}?>
<?php }?>
<?php 
   /****************************************************************************************************/
   /***************************** Load Staff Working Hours and provided services********************************/
   /***************************************************************************************************/
   
   
   if(isset($_POST['load_provider_detail']))
   {
        
          $provider_id=$_REQUEST['load_provider_detail'];
          $company_id=$_REQUEST['company_id'];
   
          $common_data_company_setting=$db->get_row('company',array('id'=>$company_id));
          $company_currency_symbole=$common_data_company_setting['company_currencysymbol'];
          
          
          $staff_detail=$db->get_row('users',array('user_id'=>$provider_id));
          if ($staff_detail['working_day']!="" && $staff_detail['working_on_off']!=""
              && $staff_detail['working_start_time']!=""
              && $staff_detail['working_end_time']!="")
          {
              $working_day=unserialize($staff_detail['working_day']);
              $working_on_off=unserialize($staff_detail['working_on_off']);
              $working_start_time=unserialize($staff_detail['working_start_time']);
              $working_end_time=unserialize($staff_detail['working_end_time']);
          
          }
          else{
              $working_day=unserialize($common_data_company_setting['working_day']);
              $working_on_off=unserialize($common_data_company_setting['working_on_off']);
              $working_start_time=unserialize($common_data_company_setting['working_start_time']);
              $working_end_time=unserialize($common_data_company_setting['working_end_time']);
          }
          ?>
<div class="panel">
<div class="panel-heading">
  <h4><strong class="text-danger"><i class="fa fa-headphones"></i>  <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?>&#39;s Service </strong></h4>
</div>
                                    <div class="panel-body np">
                                      <div id="demo-chat-body" class="collapse in">
                                            <div class="nano has-scrollbar" style="height:200px">
                                                <div class="nano-content pad-all" tabindex="0">
                                        <table class="table">
 <tbody>
      <?php $services=$db->get_all('assign_services',array('company_id'=>$company_id,
                                                           'staff_id'=>$provider_id));
         if (is_array($services)){
         foreach ($services as $als)
         {
             
             $services_details=$db->get_row('services',array('id'=>$als['service_id']));
        
         ?>
      <tr>
         <td><?php echo ucwords($services_details['service_name']);?></td>
         <td><?php echo $company_currency_symbole.''.number_format($services_details['service_cost'],2);?></td>
         <td><?php echo $services_details['service_time']+$services_details['service_buffer_time'];?></td>
      </tr>
      <?php }}?>
   </tbody>

</table>
                                                </div>
                                            <div class="nano-pane">
                                            <div class="nano-slider" style="height: 92px; transform: translate(0px, 0px);"></div>
                                            </div>
                                            </div>
                                          
                                        </div>
                                        <!--===================================================-->
                                        <!--Chat widget-->
                                    </div>
                                </div>
<hr>
<h4><strong class="text-danger"><i class="fa fa-clock-o"></i> <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?>&#39;s Weekly Schedule</strong></h4>
<hr>
<table class="table">
   <tbody>
      <?php 
         if (is_array($working_day)){
             foreach ($working_day as $key=>$value){
                 $day_name=$value;
                 $on_off=$working_on_off[$key];
                 $starttime=$working_start_time[$key];
                 $endtime=$working_end_time[$key];
                ?>
      <tr>
         <td><?php echo ucfirst($day_name);?></td>
         <?php if ($on_off=="on"){?> 
         <td><?php echo $starttime;?> - <?php echo $endtime;?></td>
         <?php }else{?>
         <td>Closed</td>
         <?php }?>
      </tr>
      <?php }}?>
   </tbody>
</table>
                                        
<?php }?>   
<?php 
   /****************************************************************************************************/
   /***************************** Submit Reviews *********************************************/
   /***************************************************************************************************/
   if (isset($_POST['add_review_submit']))
   {
      $comid=$_POST['company_id'];
      $review_provider_name=$_POST['review_provider_name'];
      $review_email=$_POST['review_email'];
      $review_detail=substr($_POST['review_detail'],0,250);
      $status='pending';
      $rating_stars=$_POST['rating_stars'];
      $visibility_status='active';
      $created_date=date('Y-m-d');
      $ip_address=$_SERVER['REMOTE_ADDR'];
      
   
    if ($review_provider_name=="")
      {
           $return['msg']='<div class="alert alert-danger text-danger">
                  		<i class="fa fa-frown-o text-danger"></i>
                              <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                              Enter Name!</div>';
                          $return['error']=true;
                          echo json_encode($return);
   
      }
      elseif (!filter_var($review_email, FILTER_VALIDATE_EMAIL))
      {
      
          $return['msg']='<div class="alert alert-danger text-danger">
                  		<i class="fa fa-frown-o text-danger"></i>
              <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
              Enter correct Email!</div>';
          $return['error']=true;
          echo json_encode($return);
      
      }
      
    else{
       $insert=$db->insert('review',array('company_id'=>$comid,
                                          'review_provider_name'=>$review_provider_name,
                                          'review_email'=>$review_email,
                                          'review_detail'=>$review_detail,
                                          'status'=>$status,
                                          'rating'=>$rating_stars,
                                          'created_date'=>$created_date,
                                          'ip_address'=>$ip_address));
         
          if ($insert){$return['msg']='<div class="alert alert-success text-success">
                                      	<i class="fa fa-smile-o"></i>
                                          <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                           Review Added Successfully.!
                                          </div>';
                          $return['error']=false;
                          echo json_encode($return);
   
   
      }
   }
   }  
   ?>  
<?php 
   /****************************************************************************************************/
   /*****************************load time sloat of staff*********************************************/
   /***************************************************************************************************/
   
   if (isset($_POST['load_time_range'])){
       
       $service_provider=$_POST['load_time_range'];
       $appointment_date=$_POST['adate'];
       
      /*******************Check Appontment time exist in working  time or not on working day  ************/
      $dayName=date("l", strtotime($appointment_date));
      $working_day=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_day'));
      $working_on_off=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_on_off'));
      $working_start_time=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_start_time'));
      $working_end_time=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_end_time'));
      
      $w=true;
      if (is_array($working_day))
      {
          foreach ($working_day as $key=>$value)
          {
              if (ucfirst($value)==$dayName)
              {
      
                  $on_off=$working_on_off[$key];
                $startt=$working_start_time[$key];
                $endt=$working_end_time[$key];
              break;
              }
      
          }
          
           $times = create_time_range($startt, $endt, '30 mins', $format = '24');
          if (is_array($times)){
              foreach ($times as $t)
                                {?>
<option value="<?php echo $t;?>"><?php echo date('h:i A',strtotime($t));?></option>
<?php }}
   }
    
   function create_time_range($start, $end, $interval = '15 mins', $format = '12') {
       $startTime = strtotime($start);
       $endTime   = strtotime($end);
       // $returnTimeFormat = ($format == '12')?'g:i:s A':'G:i:s';
       $returnTimeFormat = ($format == '12')?'g:i A':'H:i:s';
   
       $current   = time();
       $addTime   = strtotime('+'.$interval, $current);
       $diff      = $addTime - $current;
   
       $times = array();
       while ($startTime < $endTime) {
           $times[] = date($returnTimeFormat, $startTime);
           $startTime += $diff;
       }
       $times[] = date($returnTimeFormat, $startTime);
       return $times;
   }
    
   }?>