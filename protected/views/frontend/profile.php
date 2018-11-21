<header class="pageheader">
  <h3><i class="fa fa-user"></i> Profile </h3>
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
          <h3 class="panel-title">Aggiornamento Profilo</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
          <div class="panel-body">
            <div class="form-group">
             <label class="control-label col-md-3">Email</label>
             <div class="col-md-6">
              <input type="hidden" name="profilesize" id="profilesize" >
              <input class="form-control"  name="username" disabled type="text" value="<?php echo $_SESSION['email'];?>">
              <br>
              <label>La mail è per il login e non può essere modificata.</label>
            </div>
          </div>
          <div class="form-group">
           <label class="control-label col-md-3">Nome<?php //echo $_SESSION['user_id'];?></label>
           <div class="col-md-6">
            <input class="form-control"  name="f_name" type="text" value="<?php echo $user_details['firstname'];?>">
          </div>
        </div>
        <div class="form-group">
         <label class="control-label col-md-3">Last Name</label>
         <div class="col-md-6">
          <input class="form-control"  name="l_name" type="text" value="<?php echo $user_details['lastname'];?>">
        </div>
      </div>

      <div class="form-group">
       <label class="control-label col-md-3">Indirizzo</label>
       <div class="col-md-6">
        <textarea class="form-control" name="address"><?php echo $user_details['address'];?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3">Foto</label>
      <div class="col-md-4">
       <input type="file" name="profilepic" id="profilepic">
       <br> <small>Solo jpeg, png & jpeg (Max : <?php echo $upload_max_size;?>)</small>
     </div>
     <div class="col-md-4">
      <?php
      if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$_SESSION['user_id'].'/'.$user_details['user_photo_file']) && (($user_details['user_photo_file'])!=''))
        {?>
         <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$_SESSION['user_id'].'/'.$user_details['user_photo_file'];?>" width="100%">
       <?php } else{?>
        <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>"  width="100%">
      <?php }?>
    </div>
  </div>
</div>
<div class="panel-footer text-center">
  <button class="btn btn-info " type="submit" name="submit_profile"><i class="fa fa-save"></i> Aggiorna</button>
</div>
</form>

</div>
</div>


</div>
</div>
</div>
<!--===================================================-->
<!--End page content-->

<script>
  $('#profilepic').bind('change', function() {
    $('#profilesize').val(this.files[0].size);
    var a = this.files[0].size;
    var b= <?php echo ($upload_max_size*1024*1024);?>;
    if(a>b)
      alert("File size must be less than <?php echo $upload_max_size;?>");
  });
</script>