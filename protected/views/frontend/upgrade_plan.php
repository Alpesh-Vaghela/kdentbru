
<link href="<?php echo SITE_URL.'/assets/frontend/css/pricing_style.css';?>" media="all" rel="stylesheet" type="text/css" />
<style>
.corner{
	position: absolute;
	top: 5%;
	right: 2%;
	font-size: 15px;
	transform: rotate(360deg);
	
}
.corner1{
	position: absolute;
	top: 0%;
	right: 2%;
	font-size: 15px;
	transform: rotate(360deg);
	
}

</style> 
<!--Page content-->
<!--===================================================-->
<div id="page-content">
	<div class="row">
		<h2>Current Plan: <?php echo COMPANY_PLAN_NAME;?></h2> 
	</div>
	<br>
	<div class="row">
		
		<div class="col-lg-12">
			<div class="row pricing-table"> 
				<div class="col-sm-3"></div> 
				<div class="col-sm-3">
					<div class="widget-container fluid-height list green">
						<div class="widget-content padded text-center">
							<?php if(COMPANY_PLAN_ID==PLAN1_ID){echo "<span class='corner label label-danger'>Current plan</span>";}?>
							<h1><?php echo PLAN1_NAME;?></h1>
							<h2>
								<?php echo CURRENCY."".PLAN1_PRICE;?><span>/month</span>
							</h2>
							<a class="btn btn-block btn-default" href="#" disabled>Sign Up</a>
							
						</div>
						<ul>
							<li class="text-center"><h4>Up to <?php echo PLAN1_ALLOW_STAFF;?> Staff schedules</h4></li>
							<li class="text-center"><h4>Unlimited Appointments</h4></li>
							<li class="text-center"><h4>Customized Notifications</h4></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3 featured">
					
					<div class="widget-container fluid-height list orange">
						<div class="widget-content padded text-center">
							<?php if(COMPANY_PLAN_ID==PLAN2_ID){echo "<span class='corner1 label label-danger'>Current plan</span>";}?>
							<h1><?php echo PLAN2_NAME;?></h1>
							<h2>
								<?php echo CURRENCY."".PLAN2_PRICE;?><span>/month</span>
							</h2>
							<a class="btn btn-block btn-warning" href="<?php echo $link->link('subscription_payment',frontend,'&upgradeto='.PLAN2_ID)?>"  <?php if(COMPANY_PLAN_ID==PLAN2_ID){?>disabled <?php }?> >Sign Up</a>
						</div>
						<ul>
							<li class="text-center"><h4>Up to <?php echo PLAN2_ALLOW_STAFF;?>  Staff schedules</h4></li>
							<li class="text-center"><h4>Unlimited Appointments</h4></li>
							<li class="text-center"><h4>Customized Notifications</h4></li>
							
						</ul>
					</div>
					
				</div>
				<div class="col-sm-3">
					
					
					
					
				</div>
			</div>  
		</div> 
		
	</div>
</div>
