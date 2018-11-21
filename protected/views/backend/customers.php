
<!--Page content-->
<!--===================================================-->
<div id="page-content">
  <div class="row">
   <div class="col-lg-12">
     <?php echo $display_msg;?>
     <a style="margin-top:8px;" href="<?php echo $link->link('add_customer',user);?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Aggiungi Paziente</a>
     <?php if(!isset($_REQUEST['inactive_customer'])) :?>
      
      <a style="margin-top:8px;" href="<?php echo $link->link('customers',user,'&inactive_customer=0');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Nuovi</a>
      <a style="margin-top:8px;" href="<?php echo $link->link('customers',user,'&inactive_customer=1');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Storici </a>

      <!-- <a style="margin-top:8px;" href="<?php echo $link->link('customers',user,'&inactive_customer=1');?>" class="btn btn-info"><i class="fa fa-plus"></i> Regular Paziente</a> -->
      <?php elseif($_REQUEST['inactive_customer'] == 1) : ?>
        <a style="margin-top:8px;" href="<?php echo $link->link('customers',user,'&inactive_customer=0');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Nuovi</a>
        <a style="margin-top:8px; background-color: #26C6DA;border-color: #26C6DA;" href="<?php echo $link->link('customers',user,'&inactive_customer=1');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Storici </a>

        <?php elseif($_REQUEST['inactive_customer'] == 0) : ?>
          <a style="margin-top:8px; background-color: #26C6DA; border-color: #26C6DA;" href="<?php echo $link->link('customers',user,'&inactive_customer=0');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Nuovi</a>
          <a style="margin-top:8px;" href="<?php echo $link->link('customers',user,'&inactive_customer=1');?>" class="btn btn-info"><i class="fa fa-plus"></i> Pazienti Storici </a>
        <?php endif;?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-12">
       
        <div class="tab-base">
         
          <div class="tab-content">
            <table class="table table-striped12 table-bordered" id="demo-dt-basic">
             <thead>
              <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Indirizzo</th>
                <th>Città</th>
                <th>Stato</th>
                <th>Cap</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (is_array($customers)){
                $sn=1;

                foreach ($customers as $value){?>
                 <tr>
                   <td><?php echo $sn;?></td>
                   <td>	<?php
                   if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/customers/'.$value['profile_image']) && (($value['profile_image'])!=''))
                    {?>
                     <img class="img-circle img-sm" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/customers/'.$value['profile_image']."?".rand(0, 100000);?>">
                   <?php } else{?>
                    <img class="img-circle img-sm" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Foto Profilo">
                  <?php }?>
                </td>
                <td><a href="<?php echo $link->link('edit_customer',user,'&action_edit='.$value['id']);?>"><?php echo $value['first_name'].' '.$value['last_name'];?></a></td>
                <td><a href="<?php echo $link->link('edit_customer',user,'&action_edit='.$value['id']);?>"><?php echo $value['email'];?></a></td>
                <td><?php echo $value['address'];?></td>
                <td><?php echo $value['city'];?></td>
                <td><?php echo $value['state'];?></td>
                <td><?php echo $value['zip'];?></td>

                <td>
                 <div class="btn-group">
                   <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">Azioni
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      
                     <li>
                      <a href="<?php echo $link->link('edit_customer',user,'&action_edit='.$value['id']);?>"><i class="fa fa-edit text-info"></i> Dettagli</a>
                    </li>
                    
                    <li>
                      <a href="<?php echo $link->link('customers',user,'&action_delete='.$value['id']);?>"><i class="fa fa-trash text-danger"></i> Cancella</a>
                    </li>
                    
                                            <!--     <li>
                                                <?php if ($value['visibility_status']=="inactive"){?>
                                                <a href="<?php echo $link->link('customers',user,'&action_active='.$value['id']);?>"><i class="fa fa-thumbs-o-up text-success"></i> Active</a>
                                                <?php }else{?>
                                                <a href="<?php echo $link->link('customers',user,'&action_inactive='.$value['id']);?>"><i class="fa fa-thumbs-o-down text-warning"></i> Inactive</a> <?php }?>
                                              </li> -->
                                            </ul>
                                          </div>
                                          
                                        </td>

                                      </tr>
                                      <?php $sn++;}}?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              
                            </div>
                            
                          </div>
                        </div>
