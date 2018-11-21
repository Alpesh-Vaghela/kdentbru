<?php 
/******************************************Plan1  details************************************/
$plan1_settings=$db->get_row('plans',array('id'=>1));
//print_r($plan1_settings);
define(PLAN1_ID, $plan1_settings['id']);
define(PLAN1_NAME, $plan1_settings['plan_name']);
define(PLAN1_ALLOW_STAFF, $plan1_settings['allow_staff']);
define(PLAN1_PRICE, $plan1_settings['price']);
/******************************************plan1 details************************************/
$plan2_settings=$db->get_row('plans',array('id'=>2));
define(PLAN2_ID, $plan2_settings['id']);
define(PLAN2_NAME, $plan2_settings['plan_name']);
define(PLAN2_ALLOW_STAFF, $plan2_settings['allow_staff']);
define(PLAN2_PRICE, $plan2_settings['price']);




?>


<link href="<?php echo SITE_URL.'/assets/frontend/css/pricing_style.css';?>" media="all" rel="stylesheet"
	type="text/css" />
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                            
                            <div class="row">
                           
                            <div class="col-lg-12">
                      <div class="row pricing-table"> 
                  <div class="col-sm-3"></div> 
				  <div class="col-sm-3">
					<div class="widget-container fluid-height list green">
						<div class="widget-content padded text-center">
							<h1><?php echo PLAN1_NAME;?></h1>
							<h2>
								<?php echo SITE_CURRENCY."".PLAN1_PRICE;?><span>/month</span>
							</h2>
							<a class="btn btn-block btn-default" href="#" disabled>Sign Up</a>
							
						</div>
						<ul>
						 <li class="text-center"><h4>Up to <?php echo PLAN1_ALLOW_STAFF;?>  Staff schedules</h4></li>
						 <li class="text-center"><h4>Unlimited Appointments</h4></li>
						 <li class="text-center"><h4>Customized Notifications</h4></li>
						</ul>
  				</div>
				</div>
				<div class="col-sm-3 featured">
				
					  <div class="widget-container fluid-height list orange">
						<div class="widget-content padded text-center">
							<h1><?php echo PLAN2_NAME;?></h1>
							<h2>
								<?php echo SITE_CURRENCY."".PLAN2_PRICE;?><span>/month</span>
							</h2>
							<?php if(COMPANY_PLAN_ID!=PLAN2_ID){?>
							<button class="btn btn-block btn-warning" href="#">Sign Up</button>
						<?php }?>
						</div>
						<ul>
 							<li class="text-center"><h4>Up to <?php echo PLAN2_ALLOW_STAFF;?>  Staff schedules</h4></li>
						    <li class="text-center"><h4>Unlimited Appointments</h4></li>
						    <li class="text-center"><h4>Customized Notifications</h4></li>
							
						</ul>
					</div>
				
				</div>
				
				<div class="col-sm-3"></div>
			</div>  
                  </div>
                       
                        </div>
                                </div>
