<?php
global $car_dealer_options;
if(isset($car_dealer_options['req_info_form_status']) && !$car_dealer_options['req_info_form_status']){
    return;
}

 ?>
<li><a class="dealer-form-btn" data-toggle="modal" data-target="#request_more_info_mdl" data-whatever="@mdo" href="#"><i class="fa fa-question-circle"></i><?php echo esc_html__('Request More Info', 'cardealer');?></a>
    <div class="modal fade" id="request_more_info_mdl" tabindex="-1" role="dialog" aria-labelledby="request_more_info_lbl" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="request_more_info_lbl"><?php echo esc_html__('Request More Info', 'cardealer');?></h4>
                </div>
                <div class="modal-body">
                    <?php 
                    if( isset($car_dealer_options['req_info_form']) && !empty($car_dealer_options['req_info_form']) && $car_dealer_options['req_info_contact_7'] == true ) {
                        echo do_shortcode($car_dealer_options['req_info_form']);
                    } else {
                        ?>
                        <form class="gray-form reset_css" method="post" id="inquiry-form"><div class="row">
                            <input type="hidden" name="action" class="form-control" value="car_inquiry_action">
                            <input type="hidden" name="car_id" value="<?php echo get_the_ID()?>">
                            <input type="hidden" name="rmi_nonce" value="<?php echo wp_create_nonce("req-info-form");?>">
                            <div class="col-sm-6"><div class="form-group">
                                <label><?php echo esc_html__('First Name', 'cardealer');?>*</label>
                                <input type="text" name="first_name" class="form-control" required maxlength="25">
                            </div></div>
                            <div class="col-sm-6"><div class="form-group">
                                <label><?php echo esc_html__('Last Name', 'cardealer');?>*</label>
                                <input type="text" name="last_name" class="form-control" required maxlength="25">
                            </div></div>
                            <div class="col-sm-6 form-group">
                                <label><?php echo esc_html__('Preferred Contact', 'cardealer');?></label>
                                <div class="radio">
                                    <label><input style="width:auto;" type="radio" name="contact" value="email" checked="checked"><?php echo esc_html__('Email', 'cardealer');?></label>
                                </div>
                                <div class="radio">
                                    <label><input style="width:auto;" type="radio" name="contact" value="phone"><?php echo esc_html__('Phone', 'cardealer');?></label>
                                </div>
                            </div>
                            <div class="col-sm-6"><div class="form-group">
                                <label><?php echo esc_html__('Email', 'cardealer');?>*</label>
                                <input type="text" name="email" class="form-control" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label><?php echo esc_html__('Mobile', 'cardealer');?></label>
                                <input type="text" name="mobile" class="form-control"  maxlength="15">
                            </div></div>
                            <div class="col-sm-6"><div class="form-group">
                                <label><?php echo esc_html__('Address', 'cardealer');?></label>
                                <textarea class="form-control" name="address" rows="4" maxlength="300"></textarea>
                            </div></div>
                            <div class="col-sm-6"><div class="form-group">
                                <label><?php echo esc_html__('State', 'cardealer');?>*</label>
                                <input type="text" name="state" class="form-control" maxlength="25">
                            </div>
                            <div class="form-group">
                                <label><?php echo esc_html__('Zip', 'cardealer');?>*</label>
                                <input type="text" name="zip" class="form-control"  maxlength="15">
                            </div></div>
                            <div class="col-sm-6"><div class="form-group">
								<div id="recaptcha1"></div>
							</div>  </div>                          
                            <div class="col-sm-6"><div class="form-group">
                                <button id="submit_request" class="button red" ><?php echo esc_html__('Request a service', 'cardealer');?></button>
                                <span class="spinimg"></span>
                                <div class="inquiry-msg" style="display:none;"></div>
                            </div></div></div>
                        </form>
                        <?php
                    }?>
                </div>
            </div>
        </div>
    </div>
</li>