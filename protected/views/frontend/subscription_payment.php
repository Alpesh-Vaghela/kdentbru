<?php 
if (isset($_REQUEST['upgradeto']) && $_REQUEST['upgradeto']!=""){
  $plan_id=$_REQUEST['upgradeto'];
  $plan_detail=$db->get_row('plans',array('id'=>$plan_id));
  
  $plan_name=$plan_detail['plan_name'];
	//$plan_price=$plan_detail['price'];
  $plan_price=1;
  $allow_staff=$plan_detail['allow_staff'];
  $company_id=CURRENT_LOGIN_COMPANY_ID;
  $company_details=$db->get_row('company',array('id'=>$company_id));
  $paid_amount_new = $plan_price*100;
  $invoice_number=rand(1, 100000);
  
  if (PAYPAL_MODE=="live"){
    $paypal_email = PAYPAL_LIVE_EMAIL;
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
  }
  else{
    $paypal_email = PAYPAL_SANDBOX_EMAIL;
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
  }
}
else{
  $session->redirect('home',frontend);
}
?>
<?php

$item_number = $_GET['item_number']; 
$txn_id = $_GET['tx'];
$payment_gross = $_GET['amt'];
$currency_code = $_GET['cc'];
$payment_status = $_GET['st'];
$transid=$txn_id;

if ($payment_status=='Completed'){
  if($txn_id!="" && $payment_gross == $plan_price){
    
   if (!$db->exists('plans_company',array('company_id'=>$company_id)))
   {
     
     $plan_update=$db->insert('plans_company',array('plan_id'=>$plan_id,
      'plan_name'=>$plan_name,
      'price'=>$plan_price,
      'company_id'=>$company_id,
      'allow_staff'=>$allow_staff,
      'created_date'=>date('Y-m-d'),
      'ip_address'=>$_SERVER['REMOTE_ADDR']));
     
     $insert_allplan_table=$db->insert('plans_all',array('invoice_no'=>$invoice_number,
       'plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'company_id'=>$company_id,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'payment_gateway'=>'paypal',
       'txn_id'=>$transid,
       'ip_address'=>$_SERVER['REMOTE_ADDR']));
   }
   else{
     $plan_update=$db->update('plans_company',array('plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'ip_address'=>$_SERVER['REMOTE_ADDR']),array('company_id'=>$company_id));

     $insert_allplan_table=$db->insert('plans_all',array('invoice_no'=>$invoice_number,
       'plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'company_id'=>$company_id,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'payment_gateway'=>'paypal',
       'txn_id'=>$transid,
       'ip_address'=>$_SERVER['REMOTE_ADDR']));
     
     
   }
   if ($plan_update)
   {
     $display_msg='<div class="alert alert-mint media fade in">
     <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
     <div class="media-left">
     <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
     <i class="fa fa-smile-o fa-lg"></i>
     </span>
     </div>
     <div class="media-body">
     <h4 class="alert-title">Payment with paypal successfully plan update!</h4>
     <p class="alert-message">Your txn id is '.$transid.'</p>
     </div>
     </div>'; 
     echo "<script>
     setTimeout(function(){
       window.location = '".$link->link("upgrade_plan",frontend)."'
     },3000);</script>";
   }
   
 }else{ 
   $display_msg='<div class="alert alert-danger">
   <i class="fa fa-frown-0"></i>
   <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times"></i></button>
   Your payment with paypal has failed.!
   </div>';
   echo "<script>
   setTimeout(function(){
     window.location = '".$link->link("upgrade_plan",frontend)."'
   },3000);</script>";
 }
}?>

<?php
require 'protected/library/stripe/init.php';
use Stripe\Stripe;
use Stripe\Charge;


if ($_POST) {
  Stripe::setApiKey(stripe_secretkey_test);
  $error = '';
  $success = '';
  try {
    if (!isset($_POST['stripeToken']))
      throw new Exception("The Stripe Token was not generated correctly");
    $return = Charge::create(array("amount" =>$paid_amount_new,
     "currency" => "usd",
     "card" => $_POST['stripeToken']));
    $success = '<div class="alert alert-success">
    <i class="lnr lnr-smile"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>
    Your payment was successful.
    </div>';
    $transid = $return->id;

    
    
    if (!$db->exists('plans_company',array('company_id'=>$company_id)))
    {
     
     $plan_update=$db->insert('plans_company',array('plan_id'=>$plan_id,
      'plan_name'=>$plan_name,
      'price'=>$plan_price,
      'company_id'=>$company_id,
      'allow_staff'=>$allow_staff,
      'created_date'=>date('Y-m-d'),
      'ip_address'=>$_SERVER['REMOTE_ADDR']));
     
     $insert_allplan_table=$db->insert('plans_all',array('plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'company_id'=>$company_id,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'payment_gateway'=>'stripe',
       'txn_id'=>$transid,
       'invoice_no'=>$invoice_number,
       'ip_address'=>$_SERVER['REMOTE_ADDR']));
   }
   else{
     $plan_update=$db->update('plans_company',array('plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'ip_address'=>$_SERVER['REMOTE_ADDR']),array('company_id'=>$company_id));

     $insert_allplan_table=$db->insert('plans_all',array('plan_id'=>$plan_id,
       'plan_name'=>$plan_name,
       'price'=>$plan_price,
       'company_id'=>$company_id,
       'allow_staff'=>$allow_staff,
       'created_date'=>date('Y-m-d'),
       'payment_gateway'=>'stripe',
       'txn_id'=>$transid,
       'invoice_no'=>$invoice_number,
       'ip_address'=>$_SERVER['REMOTE_ADDR']));
     
     
   } 
   
   if ($plan_update){ 
     
     $last_billing_date=date('Y-m-d');
     $unix=strtotime('+30 days',strtotime($last_billing_date));
     $newDate= date('Y-m-d',$unix);
     
     
     
     $display_msg='<div class="alert alert-mint media fade in">
     <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
     <div class="media-left">
     <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
     <i class="fa fa-smile-o fa-lg"></i>
     </span>
     </div>
     <div class="media-body">
     <h4 class="alert-title">Payment with stripe successfully and plan update!</h4>
     <p class="alert-message"> Your txn id is '.$transid.'</p>
     </div>
     </div>';       
     
     
     
     echo "<script>
     setTimeout(function(){
       window.location = '".$link->link("upgrade_plan",frontend)."'
     },3000);</script>";
     
     
   }
   
   
   
   
   
 }
 catch (Exception $e){
  $error = $e->getMessage();
  print_r($error);
}
}


?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<script src="https://checkout.stripe.com/v2/checkout.js"></script>

<script>
  
  $(document).ready(function() {
   $('.stripe').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    var $button = $(this),
    $form = $button.parents('form'); 

    var opts = $.extend({}, $button.data(), {
      token: function(result) {
        $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
      }
    });

    StripeCheckout.open(opts);0
  });
 });
</script>

<div id="page-content">
  <br><br>
  <div class="row">
    <div class="col-md-3" style="text-align: center;"></div>
    <div class="col-md-6" style="text-align: center;">
      <div class="invoice-wrapper" style="padding:5px,5px,5px,5px">
        <section class="invoice-container">
          <div class="invoice-inner">
            <div id="success_message"><?php echo $display_msg;?></div>
            
            <div class="row">
              <div class="col-xs-12" style="text-align: center;">
               <img  src="<?php echo SITE_LOGO;?>"  width="150px;">
             </div>
             
           </div>
           <div class="row" >
            <div class="col-xs-6 text-left">
              <h3>&nbsp;&nbsp;Invoice</h3>
            </div>
            <div class="col-xs-6 text-right">
              <h3>Invoice #<?php  echo $invoice_number;?>&nbsp;&nbsp;</h3>
              <strong>Order Date:</strong><?php  echo date('d M Y');?>&nbsp;&nbsp;
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-xs-6 text-left">
              <address>
                <strong>&nbsp;&nbsp;Billed To:</strong><br>
                &nbsp;&nbsp;<?php echo $company_details['company_name'];?><br>
                &nbsp;&nbsp;<?php echo  $company_details['company_address'];?>
                &nbsp;&nbsp;<?php echo  $company_details['company_city'];?> <?php echo  $company_details['company_state'];?><br>
                &nbsp;&nbsp;<?php echo  $company_details['company_zip'];?>
              </address>
            </div>
            <div class="col-xs-6 text-right">
                                          <!--   <address>
                                                <strong>Shipped To:</strong><br>
                                                Jane Smith<br>
                                                1234 Main<br>
                                                Apt. 4B<br>
                                                Springfield, ST 54321
                                              </address> -->
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12 pad-top">
                                              <div class="panel panel-default">
                                                <div class="panel-heading">
                                                  <h3 class="panel-title">Subscription Summary</h3>
                                                </div>
                                                <div class="panel-body">
                                                  <div class="table-responsive">
                                                    <table class="table table-condensed">
                                                      <thead>
                                                        <tr>
                                                          <td><strong>Plan Name</strong></td>
                                                          <td class="text-center"><strong>Price/Month</strong></td>
                                                          
                                                          <td class="text-right"><strong>Totals</strong></td>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr>
                                                          <td><?php echo ucfirst($plan_name);?></td>
                                                          <td class="text-center"><?php echo SITE_CURRENCY;?><?php echo number_format($plan_price,2);?></td>
                                                          
                                                          <td class="text-right"><?php echo SITE_CURRENCY;?><?php echo number_format($plan_price,2);?></td>
                                                        </tr>
                                                        
                                                        
                                                        <tr style="border-top:2px solid #ccc">
                                                          <td class="thick-line"></td>
                                                          <td class="thick-line text-right"><strong>Total</strong></td>
                                                          <td class="thick-line text-right"><?php echo SITE_CURRENCY;?><?php echo number_format($plan_price,2);?></td>
                                                        </tr>
                                                        
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class=""> 
                                            <div class="row">
                                              <div class="col-md-4">
                                               <form action="<?php echo $paypalURL;?>" method="post">
                                                <!-- Identify your business so that you can collect the payments. -->
                                                <input type="hidden" name="business" value="<?php echo $paypal_email;?>">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                <input type="hidden" name="item_name" value="<?php echo PLAN2_NAME; ?>">
                                                <input type="hidden" name="item_number" value="<?php echo PLAN2_ID; ?>">
                                                <input type="hidden" name="amount" value="<?php echo PLAN2_PRICE; ?>">
                                                <input type="hidden" name="currency_code" value="USD">
                                                
                                                <!-- Specify URLs -->
                                                <input type='hidden' name='cancel_return' value='<?php echo $link->link('upgrade_plan',frontend);?>'>
                                                <input type='hidden' name='return' value='<?php echo $link->link('subscription_payment',frontend,'&upgradeto='.$plan_id);?>'>
                                                
                                                <!-- Display the payment button. -->
                                                <button class="btn btn-primary btn-block" type="submit" name="submit" border="0">Paypal</button>
                                              </form> 
                                            </div>
                                            <div class="col-md-4"><button class="btn btn-block  btn-success w-250"  id="rzp-button1" >Razorpay</button></div>
                                            <div class="col-md-4">
                                             <form action="" method="post">
                                               <input type="hidden" name ="DO_STEP_1" value="true">
                                               <button  class="btn btn-danger btn-block stripe active m-t-1" data-currency="USD"
                                               data-key="<?php echo stripe_publishkey_test ?>"
                                               data-email="By <?php echo COMPANY_EMAIL;?>"
                                               data-name="<?php echo COMPANY_NAME?>"
                                               data-image="https://yt3.ggpht.com/-JY_UMJ41jcM/AAAAAAAAAAI/AAAAAAAAAAA/VjMkCWuljc0/s288-c-k-no-mo-rj-c0xffffff/photo.jpg"
                                               data-description="Plan Subscription"
                                               data-amount="<?php echo $paid_amount_new;?>">Stripe</button>
                                             </form> </div>
                                             
                                             
                                           </div>
                                           
                                           
                                           
                                           
                                           


                                         </div>
                                       </div>
                                       
                                       
                                     </section>
                                   </div></div>
                                   <div class="col-md-3" style="text-align: center;"></div>
                                 </div>
                               </div>
                               
                               
                               
                               
                               
                               <!--########################################################################################################-->                     
                               <!--###################################### Rozarpay coding #################################################-->
                               <!--########################################################################################################-->                                     
                               
                               <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                               <script>
                                var options = {
    "key": "rzp_test_SaahXtvstXGPqG",   //rzp_live_uJTne5Up0ZZeXk
    "amount": "<?php echo $paid_amount_new?>", 
    "display_currency":"USD",
    "display_amount":"<?php echo $plan_price;?>",
    "name": "<?php echo $plan_name?>",
    "description": "Plan Subscription",
    "image": "https://yt3.ggpht.com/-JY_UMJ41jcM/AAAAAAAAAAI/AAAAAAAAAAA/VjMkCWuljc0/s288-c-k-no-mo-rj-c0xffffff/photo.jpg",
    "theme.emi_mode": true,
    "handler": function (response){
      if(response.error_code)
      {
        alert("Some problem occured during payment! Please contact exfi@iwcnetwork.com or call 91-562-4052090");
      }else
      {
          //  alert("Your payment with transaction#"+response.razorpay_payment_id+" was successful. Our team will get back to you in 24 hrs !")
           // alert(JSON.stringify(response));
           var pid=response.razorpay_payment_id;
           var cid='<?php echo CURRENT_LOGIN_COMPANY_ID;?>';
           var plan_id='<?php echo $plan_id;?>';
           var total_amount='<?php echo $plan_price;?>';
           var invoice_number='<?php echo $invoice_number;?>'
           
           $.ajax({
             type: 'post',
             url: '<?php echo $link->link('ajax',frontend);?>',
             data:'razorpay_payment_id='+pid+
             '&company_id='+cid+
             '&plan_id='+plan_id+
             '&total_amount='+total_amount+
             'invoice_number='+invoice_number,
             
             success: function (data)
             {
               
              $("#success_message").html(data);

              setTimeout(function()
              {
               window.location = '<?php echo $link->link("upgrade_plan",frontend);?>';
             },3000);
              
            }
          });


           
         }
       },
       "prefill": { 
        "name": "",
        "email": ""
      },
      "notes": {
        "address": ""
      },
      "theme": {
        "color": "#3498db"
      }
      
    };

    var rzp1 = new Razorpay(options); 
    document.getElementById('rzp-button1').onclick = function(e){
      rzp1.open();
      e.preventDefault();
      e.stopPropagation();
    }

  </script>