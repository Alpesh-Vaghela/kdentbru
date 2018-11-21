<?php 
$months_array = array(1 => 'Jan',
                      2 => 'Feb',
                      3 => 'Mar',
                      4 => 'Apr',
                      5 => 'May',
                      6 => 'Jun',
                      7 => 'Jul',
                      8 => 'Aug',
                      9 => 'Sep',
                      10 => 'Oct',
                      11 => 'Nov',
                      12 => 'Dec');
?>


<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title><?php //echo Appname;?> Installation</title>
  <meta name="author" content="Jake Rocheleau">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_URL;?>/assets/installation/css/installstyles.css">
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_URL;?>/assets/installation/css/switchery.min.css">
  <script type="text/javascript" src="<?php echo SITE_URL;?>/assets/installation/js/switchery.min.js"></script>
  <style>
h2 {
    display: block;
    font-size: 2.1em;
    line-height: 1.45em;
    font-family: 'Laila', serif;
    text-align: center;
    font-weight: bold;
    color: #555;
    text-shadow: 1px 1px 0 #fff;
}


</style>
</head>

<body>
  <div id="wrapper">
   <!-- <h1><img src="<?php echo  SITE_URL.'/assets/installation/images/accournal.png'?>" style="width:250px;" ></h1> -->
 <h2>
  Installation Process</h2>
  <h1 style="font-size:18px;color:red"><?php echo $display_msg;?></h1>

  <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">

 <div class="col-submit">
    <button style="color:black;background:white">COMPANY/BUSINESS DETAILS</button>

  </div>
  <div class="col-4">
    <label>
      Company/Business Name
      <input class="form-control"
					type="text" name="com_name" placeholder="Your business/company Name" value="<?php echo $com_name;?>">
    </label>
  </div>
    <div class="col-4">
    <label>
      UEN No
      <input class="form-control" type="text" name="com_uen_no" placeholder="unique entity number" value="<?php echo $com_uen_no;?>">
    </label>
  </div>

  <div class="col-4">
    <label>
      UEN type

       <select class="form-control" name="com_uen_type" style="height: 23px;" >
                     <option   value="">Select</option>
                     <option <?php if ($com_uen_type=="LP")echo 'selected="selected"';?>  value="LP">Limited Partnership(LP)</option>
                     <option <?php if ($com_uen_type=="LL")echo 'selected="selected"';?>  value="LL">Limited Liability Partnerships(LL)</option>
                     <option <?php if ($com_uen_type=="FC")echo 'selected="selected"';?>  value="FC">Foreign Companies(FC)</option>
                     <option <?php if ($com_uen_type=="PF")echo 'selected="selected"';?>  value="PF">Public Accounting Firms(LL)</option>
                     <option <?php if ($com_uen_type=="UL")echo 'selected="selected"';?>  value="UL">Unregistered Local Entities(UL)</option>
                     <option <?php if ($com_uen_type=="UF")echo 'selected="selected"';?>  value="UF">Unregistered Foreign Entities(UF)</option>
               </select>
         </label>
  </div>
    <div class="col-4">

    <label style="height:65px">
      GST registered<br>

      <span style="height: 23px;">

      <input <?php if ($gst_registered=="yes"){echo "checked";}?> id="gr_yes" class="form-control"  type="radio" name="gst_registered"  value="yes" >Yes
      <input <?php if ($gst_registered=="no"){echo "checked";}?> id="gr_no" class="form-control"  type="radio" name="gst_registered"  value="no" >No
      </span>


    </label>
  </div>
    <div class="col-4">
    <label>GST No
       <input class="form-control" type="text" name="com_gst_no" placeholder="GST No (if gst registered)" value="<?php echo $com_gst_no;?>">

    </label>
  </div>

  <div class="col-4">
    <label>GST reporting period (3 or 6 monthly)
    <select class="form-control" name="gst_reporting_period" style="height: 23px;">
              <option <?php if ($gst_reporting_period=="3"){echo "selected";}?> value="3">3 monthly</option>
              <option <?php if ($gst_reporting_period=="6"){echo "selected";}?> value="6">6 monthly</option>

         </select>
         </label></div>
          <div class="col-4">
    <label>Start of financial year
    <br><br>
    <span>
     <select class="form-control" name="start_date_financial_year" style="height: 23px;width: 40%;">
      <?php $date_range=range(1, 31);
       if (is_array($date_range)){
          foreach ($date_range as $dr)
          {?>
              <option  <?php if ($start_date_financial_year==$dr){echo "selected";}?>  value="<?php echo $dr;?>"><?php echo $dr;?></option>
       <?php }
      }?>



              </select>&nbsp;&nbsp;&nbsp;<select class="form-control" name="start_month_financial_year" style="height: 23px;width: 40%;">
      <?php if (is_array($months_array)){
          foreach ($months_array as $number=>$month_name)
          {?>
              <option <?php if ($start_month_financial_year==$month_name){echo "selected='selected'";}?>  value="<?php echo $month_name;?>"><?php echo $month_name;?></option>
       <?php }
      }?>



              </select></span> </label> </div>
           <div class="col-4">
    <label>Phone
    <input class="form-control" type="text" name="com_phone" placeholder="Phone number" value="<?php echo $com_phone;?>">
         </label></div>
           <div class="col-4">
          <label>Fax
             <input class="form-control" type="text" name="com_fax" placeholder="Fax number" value="<?php echo $com_fax;?>">
         </label></div>


  <div class="col-4">
    <label>
      Email for communication (must be valid)
     	<input class="form-control" type="text" name="com_email" placeholder="Email used for sending mails" value="<?php echo $com_email;?>">
         </label>
  </div>
  <div class="col-4">
    <label>
      Date format for documents and system
      <select class="form-control" name="date_format" style="height: 23px;">
                     <option <?php if ($date_format=="d-m-Y"){echo "selected";}?>  value="d-m-Y">dd/mm/yyyy</option>
                     <option <?php if ($date_format=="Y-m-d"){echo "selected";}?> value="Y-m-d">yyyy/mm/dd</option>
                     <option <?php if ($date_format=="m-d-Y"){echo "selected";}?>  value="m-d-Y">mm/dd/yyyy</option>
                     <option <?php if ($date_format=="d-m-Y"){echo "selected";}?>  value="d-m-Y">dd-mm-yyyy</option>
                     <option <?php if ($date_format=="Y-m-d"){echo "selected";}?>  value="Y-m-d">yyyy-mm-dd</option>
                     <option <?php if ($date_format=="m-d-Y"){echo "selected";}?>  value="m-d-Y">mm-dd-yyyy</option>
                     <option <?php if ($date_format=="d-M-Y"){echo "selected";}?>  value="d-M-Y">dd-MM-yyyy  (Ex.<?php echo date('d-M-Y');?>)</option>

              </select>
    </label>
  </div>
  <div class="col-4">
    <label>Currency symbol
      <input class="form-control" name="currency_symbol" type="text" value="<?php echo $currency_symbol;?>"
              placeholder="$"> </label> </div>




  <div class="col-submit">
    <button style="color:black;background:white">SUPER ADMIN LOGIN DETAILS</button>

  </div>
  <div class="col-2">
    <label>
      Login EMAIL (Must be a valid one)
      <input class="form-control"
					type="text" name="adminemail" placeholder="Will be used for login and communications" value="<?php echo $adminemail;?>">
    </label>
  </div>
  <div class="col-2">
    <label>
      Login Password
      <input class="form-control"
					type="password" name="adminpass" placeholder="Try to use a secure password" value="<?php echo $adminpass;?>">
    </label>
  </div>
    <div class="col-submit">
   <button style="color:#00a8e6;background:white;font-size:12px;">
   *Note : Save your login email and password before proceeding
   </button>

    <button class="submitbtn" name="submit_final">Continue Installation >>></button>
  </div>

  </form>
  </div>

<script type="text/javascript">
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function(html) {
  var switchery = new Switchery(html);
});
</script>

</body>
</html>