<?php 
$company_id=CURRENT_LOGIN_COMPANY_ID;
$sql="SELECT *,appointments.customer_name FROM `payments` LEFT JOIN `appointments` ON payments.appointment_id = appointments.id WHERE payments.company_id='$company_id'" ;

$payments_appointments=$db->run($sql)->fetchAll();
// echo "<pre>";
// print_r($payments_appointments);exit;

?>
<div id="page-content">
	
	<div class="row">
		<div class="col-lg-12">
			
			<div class="panel">
				
				<div class="panel-body">
					<table class="table  table-bordered" id="demo-dt-basic">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Customer Name</th>
								<th>Payment type</th>
								<th>Payment amount</th>
								<th>Payment Time</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
							if (is_array($payments_appointments)){
								$sn=1;

								foreach ($payments_appointments as $value){
									$booking_id=$db->get_var('appointments',array('id'=>$value['appointment_id']),'booking_id');
									?>
									<tr>
										<td><?php echo $sn;?></td>
										<td><?= (isset($value['customer_name']) && !empty($value['customer_name'])) ? $value['customer_name'] : ""; ?></td>
										<td><?php echo $value['payment_type'];?></td>
										<td><?php echo CURRENCY."".$value['payment_amount'];?></td>
										<td><?php echo date('d M, Y h:i:s',$value['payment_time']);?></td>
										

									</tr>
									<?php $sn++;}}?> 
								</tbody>
							</table>  
						</div>
						

					</div>
				</div>
				
			</div>
		</div>
