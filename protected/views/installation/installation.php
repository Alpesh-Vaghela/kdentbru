<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
 <title><?php echo Appname;?> Installation</title>
  <meta name="author" content="Jake Rocheleau">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_URL;?>/assets/installation/css/installstyles.css">
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_URL;?>/assets/installation/css/switchery.min.css">
  <script type="text/javascript" src="<?php echo SITE_URL;?>/assets/installation/js/switchery.min.js"></script>
</head>
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
<body>
  <div id="wrapper">


  <!-- <h1><img src="<?php echo  SITE_URL.'/assets/installation/images/accournal.png'?>" style="width:250px;" ></h1> -->
 <h2>
  Installation Process</h2>
  <h1 style="font-size:18px;color:red"><?php echo $display_msg;?></h1>


  <?php
  if(phpversion()<=5.3 && phpversion()>=5.5)
     echo '<h1 style="font-size:18px;color:red">Php version must be in between 5.3 and 5.5.<br>Support : hello@shiftsystems.net</h1>';
  elseif (!extension_loaded('pdo_mysql'))
      echo '<h1 style="font-size:18px;color:red">PDO disabled on this server. Please install/enable PDO class and try again.<br>Support : hello@shiftsystems.net</h1>';
  elseif(!function_exists('curl_version'))
     echo '<h1 style="font-size:18px;color:red">Curl extension disabled on this server. Please enable curl to use SHIFT.<br>Support : hello@shiftsystems.net</h1>';
  else{
      echo '<h1 style="font-size:18px;color:green">Php Version !OK.&nbsp;&nbsp;&nbsp;Pdo Extension !OK.&nbsp;&nbsp;&nbsp;Curl Extension !OK</h1>';
      ?>
  <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
  <div class="col-submit">
    <button style="color:black;background:white">SERVER/HOSTING DATABASE DETAILS</button>

  </div>

  <div class="col-4">
    <label>
     Database Host Name
     <input class="form-control"
					 type="text" name="host_name" placeholder="Normally localhost" value="<?php echo $host_name;?>">
    </label>
  </div>

  <div class="col-4">
    <label>
      Database Name
      <input class="form-control"
					 type="text" name="db_name" placeholder="Name of the database" value="<?php echo $db_name;?>">
    </label>
  </div>

  <div class="col-4">
    <label>Database Username
<input class="form-control"
					 type="text" name="db_username" placeholder="Username to connect this database" value="<?php echo $db_username;?>">
    </label>
  </div>
  <div class="col-4">
    <label>
      Database password
      <input class="form-control"
					 type="text" name="db_pass" placeholder="Password use to authorize this database" value="<?php echo $db_pass;?>"></label>
  </div>
 <!-- <div class="col-2">
    <label>
      Codecanyon Purchase code
      <input class="form-control"
					 type="text" name="code" placeholder="It is present inside the email that you recieved when you purchased this script" value="<?php echo $code;?>"></label>
  </div> -->
  <div class="col-submit">
   <button style="color:#00a8e6;background:white;font-size:12px;">
   *Note : Save your login email and password before proceeding
   </button>

    <button class="submitbtn" name="submit_login">Continue Installation >>></button>
  </div>


  </form>


  <?php }?>



  </div>
<script type="text/javascript">
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function(html) {
  var switchery = new Switchery(html);
});
</script>
</body>
</html>