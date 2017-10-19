<?php
/**
 * Template file for Schedule Test Drive Form
 * */
 global $car_dealer_options;
 if(isset($car_dealer_options['schedule_drive_form_status']) && !$car_dealer_options['schedule_drive_form_status']){
    return;
 } 
 ?>
<li>
    <a class="dealer-form-btn" data-toggle="modal" data-target="#shedule_test_drive" href="#"><i class="fa fa-dashboard"></i><?php echo esc_html__('Schedule Test Drive', 'cardealer');?></a>
    <div class="modal fade" id="shedule_test_drive" tabindex="-1" role="dialog" aria-labelledby="shedule_test_drive_lbl" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					   <span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="shedule_test_drive_lbl"><?php echo esc_html__('Schedule Test Drive', 'cardealer');?></h4>
				</div>
				<div class="modal-body">
					<?php 
					if( isset($car_dealer_options['schedule_drive_form']) && !empty($car_dealer_options['schedule_drive_form']) && $car_dealer_options['schedule_drive_contact_7'] == true ) {
						echo do_shortcode($car_dealer_options['schedule_drive_form']);
					} else {
				    ?>
					<form class="gray-form" method="post" id="schedule_test_form"><div class="row">
						<input type="hidden" name="action" class="form-control" value="shedule_test_drive_action">
						<input type="hidden" name="shedule_test_drive_nonce" class="form-control" value="<?php echo wp_create_nonce("shedule_test_drive_nonce"); ?>">
						<input type="hidden" name="car_id" value="<?php echo get_the_ID()?>">
                        <div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('First Name', 'cardealer');?>*</label>
							<input type="text" name="first_name" class="form-control" maxlength="25">
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Last Name', 'cardealer');?>*</label>
							<input type="text" name="last_name" class="form-control" maxlength="25">
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Email', 'cardealer');?>*</label>
							<input type="text" name="email" class="form-control" >
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Mobile', 'cardealer');?></label>
							<input type="text" name="mobile" class="form-control" maxlength="15">
						</div></div>
						<div class="col-sm-12"><div class="form-group">
							<label><?php echo esc_html__('Address', 'cardealer');?></label>
							<textarea class="form-control" name="address" rows="4" maxlength="300"></textarea>
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('State', 'cardealer');?>*</label>
							<input type="text" name="state" class="form-control" maxlength="25">
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Zip', 'cardealer');?>*</label>
							<input type="text" name="zip" class="form-control" maxlength="15">
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Preferred Contact', 'cardealer');?></label>
							<div class="radio">
								<label><input style="width:auto" class="check" type="radio" name="preferred_contact" value="email"  checked><?php echo esc_html__('Email', 'cardealer');?></label>
							</div>
							<div class="radio">
								<label><input style="width:auto" type="radio" name="preferred_contact" value="phone" ><?php echo esc_html__('Phone', 'cardealer');?></label>
							</div>
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<label><?php echo esc_html__('Test Drive ?', 'cardealer');?></label>
							<div class="radio">
								<label><input style="width:auto" type="radio" class="test_drive check" name="test_drive" value="yes"  checked><?php echo esc_html__('Yes', 'cardealer');?></label>
							</div>
							<div class="radio">
								<label><input style="width:auto" type="radio" class="test_drive" name="test_drive" value="no" ><?php echo esc_html__('No', 'cardealer');?></label>
							</div>
						</div></div>
						<div class="col-sm-6"><div class="form-group show_test_drive">
							<label><?php echo esc_html__('Date', 'cardealer');?>*</label>
							<input type="text" name="date" class="form-control date date-time" >
						</div></div>
						<div class="col-sm-6"><div class="form-group show_test_drive">
							<label><?php echo esc_html__('Time', 'cardealer');?>*</label>
							<input type="text" name="time" class="form-control time date-time"  >
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<div id="recaptcha3"></div>
						</div></div>
						<div class="col-sm-6"><div class="form-group">
							<button id="schedule_test_request" class="button red" ><?php echo esc_html__('Request Test Drive', 'cardealer');?></button>
							<span class="schedule_test_spinimg"></span>
							<p class="schedule_test_msg" style="display:none;"></p>
						</div></div>
					</div></form>
				    <?php
					}
				?>
				</div>
			</div>
		</div>
    </div>
</li>  