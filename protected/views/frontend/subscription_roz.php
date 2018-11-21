 <?php
 if (is_array($employees_susped)){
     $subtotal=count($employees_susped)*PRICE_PER_USER;
     
     if (TAX_RATE!="")
     {
       $tax=($subtotal*TAX_RATE)/100;
   }else{
       $tax=0;
   }
   $paid_amount=$subtotal+$tax;
   $paid_amount_new = $paid_amount*100;
   
   
   $emp_id_array=array();
   foreach ($employees_susped as $ae)
   {
    array_push($emp_id_array, $ae['employee_id']);
}
if (is_array($emp_id_array)){
    $emp_string=implode("_", $emp_id_array);
} 
$invoice_number=rand(1, 100000);
}else{
    $session->redirect('home',frontend);
}
?>  
<div id="content-container">
  <div class="pageheader">
    <h3><i class="fa fa-money"></i>Payment</h3>
    <div class="breadcrumb-wrapper">
     <ol class="breadcrumb">
       <li class="active">Payment</li>
   </ol>
</div>
</div>
<div id="page-content">
    <div class="invoice-wrapper">
        <section class="invoice-container">
            <div class="invoice-inner">
             <div id="success_message"></div>
             <div class="row">
                <div class="col-xs-12" style="text-align: center;">
                 <img  src="<?php echo SITE_LOGO;?>"  width="200px;">
             </div>
             
         </div>
         <div class="row">
            <div class="col-xs-6">
                <h3>Invoice</h3>
            </div>
            <div class="col-xs-6 text-right">
                <h3>Invoice #<?php  echo $invoice_number;?></h3>
                <strong>Order Date:</strong><?php  echo date('d M Y');?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <address>
                    <strong>Billed To:</strong><br>
                    <?php echo $company_details['company_name'];?><br>
                    <?php echo  $company_details['company_address'];?>
                    <?php echo  $company_details['city'];?> <?php echo  $company_details['stats'];?><br>
                    <?php echo  $company_details['country'];?> <?php echo  $company_details['zip'];?>
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
                                                    <h3 class="panel-title">Subscription summary</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <td><strong>Employee Name</strong></td>
                                                                    <td class="text-center"><strong>Price/User</strong></td>
                                                                    
                                                                    <td class="text-right"><strong>Totals</strong></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (is_array($employees_susped)){
                                                                    foreach ($employees_susped as $ale)
                                                                        {?>
                                                                            
                                                                          <tr>
                                                                            <td><?php echo ucfirst($ale['emp_name'])." ".$ale['emp_surname'];?></td>
                                                                            <td class="text-center"><?php echo SITE_CURRENCY;?><?php echo number_format(PRICE_PER_USER,2);?></td>
                                                                            
                                                                            <td class="text-right"><?php echo SITE_CURRENCY;?><?php echo number_format(PRICE_PER_USER,2);?></td>
                                                                        </tr>
                                                                        
                                                                        
                                                                    <?php }
                                                                }?>
                                                                
                                                                
                                                                <tr style="border-top:2px solid #ccc">
                                                                    <td class="thick-line"></td>
                                                                    <td class="thick-line text-right"><strong>Subtotal</strong></td>
                                                                    <td class="thick-line text-right"><?php echo SITE_CURRENCY;?><?php echo number_format($subtotal,2);?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-line"></td>
                                                                    <td class="no-line text-right"><strong>Tax (@<?php echo TAX_RATE;?>%)</strong></td>
                                                                    <td class="no-line text-right"><?php echo SITE_CURRENCY;?><?php echo number_format($tax,2);?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="no-line"></td>
                                                                    <td class="no-line text-right"><strong>Total</strong></td>
                                                                    <td class="no-line text-right"><?php echo SITE_CURRENCY;?><?php echo number_format($paid_amount,2);?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center no-print"> 
                                      <button class="btn btn-xl  btn-success w-250"  id="rzp-button1">Pay@ <i class="fa fa-usd "></i><?php echo $paid_amount?></button>  
                                  </div>
                              </div>
                          </section>
                      </div>
                  </div>
              </div>
              <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
              <script>
                var options = {
    "key": "rzp_test_SaahXtvstXGPqG",   //rzp_live_uJTne5Up0ZZeXk
    "amount": "100", 
    "display_currency":"USD",
    "display_amount":"<?php echo $paid_amount;?> (INR 87544)",
    
    "name": "Timenox",
    "description": "Employee Subscription",
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
           var eids='<?php echo $emp_string;?>';
           var cid='<?php echo $_SESSION['company_id'];?>';

           var subtotal='<?php echo $subtotal;?>';
           var tax='<?php echo $tax;?>';
           var total_amount='<?php echo $paid_amount;?>';
           var invoice_number='<?php echo $invoice_number;?>';
           $.ajax({
             type: 'post',
             url: '<?php echo $link->link('test_durgesh',frontend);?>',
             data:'razorpay_payment_id='+pid+
             '&emp_array='+eids+
             '&company_id='+cid+
             '&subtotal='+subtotal+
             '&tax='+tax+
             '&total_amount='+total_amount+
             '&invoice_numbar='+invoice_number,
             
             success: function (data)
             {
                $("#success_message").html(data);

                setTimeout(function()
                {
                   window.location = '<?php echo $link->link("users",frontend);?>';
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
}

</script>
