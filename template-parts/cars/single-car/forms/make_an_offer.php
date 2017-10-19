<?php
global $car_dealer_options;
 if(isset($car_dealer_options['make_offer_form_status']) && !$car_dealer_options['make_offer_form_status']){
    return;
 } 
 ?>
<li>
    <a data-toggle="modal" data-target="#make_an_offer" href="javascrip:void(0)"><i class="fa fa-tag"></i><?php echo esc_html__('Make an Offer', 'cardealer');?></a>
    <div class="modal fade" id="make_an_offer" tabindex="-1" role="dialog" aria-labelledby="make_an_offer_lbl" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="make_an_offer_lbl"><?php echo esc_html__('Make An Offer', 'cardealer');?></h4>
                </div>
                <div class="modal-body">
				<?php 
                    if( isset($car_dealer_options['make_offer_form']) && !empty($car_dealer_options['make_offer_form']) && $car_dealer_options['make_offer_contact_7'] == true ) {
                        echo do_shortcode($car_dealer_options['make_offer_form']);
                    } else {
                        ?>
                    <form name="make_an_offer" class="gray-form" method="post" id="make_an_offer_test_form"><div class="row">
                        <input type="hidden" name="action" class="form-control" value="make_an_offer_action" />                                    
                		<input type="hidden" name="mno_nonce" class="form-control" value="<?php echo wp_create_nonce("make_an_offer"); ?>">
                        <input type="hidden" name="car_id" value="<?php echo get_the_ID()?>">
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_fname"><?php esc_html_e( "First Name", "cardealer" );?>*</label>
                            <input type="text" name="mao_fname" class="form-control" id="mao_fname" maxlength="25"/>  
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_lname"><?php esc_html_e( "Last Name", "cardealer" );?>*</label>
                            <input type="text" name="mao_lname" class="form-control" id="mao_lname" maxlength="25"/>                                        
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_email"><?php esc_html_e('Email', 'cardealer');?>*</label>
                            <input type="text" name="mao_email" id="mao_email" class="form-control" >
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_phone"><?php esc_html_e('Home Phone', 'cardealer');?>*</label>
                            <input type="text" name="mao_phone" id="mao_phone" class="form-control" maxlength="15" >
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_message"><?php esc_html_e( "Comment", "cardealer" ); ?></label>
                            <textarea name="mao_message" class="form-control" id="mao_message" maxlength="300"></textarea>                                        
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="mao_reques_price"><?php esc_html_e( "Request Price", "cardealer" ); ?>*</label>
                            <input type="text" name="mao_reques_price" id="mao_reques_price" class="form-control" maxlength="15" >                                   
                        </div></div>  
                		<div class="col-sm-12"><div class="form-group">
                			<div id="recaptcha2"></div>
                		</div></div>		
                        <div class="col-sm-12"><div class="form-group">
                			<button id="make_an_offer_test_request" class="button red" ><?php echo esc_html__('Send', 'cardealer');?></button>
                			<span class="make_an_offer_test_spinimg"></span>
                			<p class="make_an_offer_test_msg" style="display:none;"></p>
                        </div></div>
                    </div></form>
                <?php
                    }?>
				</div>
            </div>
        </div>
    </div>
</li>