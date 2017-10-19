<?php
global $car_dealer_options;
if(isset($car_dealer_options['email_friend_form_status']) && !$car_dealer_options['email_friend_form_status']){
    return;
}
?>
<li>
    <a data-toggle="modal" data-target="#email_to_friend" href="javascrip:void(0)"><i class="fa fa-envelope"></i><?php echo esc_html__('Email to a Friend', 'cardealer');?></a>        
    <div class="modal fade" id="email_to_friend" tabindex="-1" role="dialog" aria-labelledby="email_to_friend_lbl" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="email_to_friend_lbl"><?php echo esc_html__('Email to a Friend', 'cardealer');?></h4>
                </div>
                <div class="modal-body">
					<?php 
					if( isset($car_dealer_options['email_friend_form']) && !empty($car_dealer_options['email_friend_form']) && $car_dealer_options['email_friend_contact_7'] == true ) {
						echo do_shortcode($car_dealer_options['email_friend_form']);
					} else {
				    ?>
                    <form name="friend_email_form" class="gray-form" method="post" id="friend-email-form"><div class="row">
                        <input type="hidden" name="action" value="email_to_friend">
                        <input type="hidden" name="car_id" value="<?php echo get_the_ID()?>">
                        <input type="hidden" name="etf_nonce" value="<?php echo wp_create_nonce("email-to-friend-form");?>">
                        <div class="col-sm-6"><div class="form-group">
                            <label for="uname"><?php esc_html_e( "Name", "cardealer" );?>*</label>
                            <input type="text" name="uname" class="form-control" id="uname" required maxlength="25"/>                                        
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
                            <label for="email"><?php esc_html_e('Email', 'cardealer');?>*</label>
                            <input type="text" name="email" id="email" class="form-control" required>
                        </div></div>
                        <div class="col-sm-12"><div class="form-group">
                            <label for="friends_email"><?php esc_html_e('Friend Email', 'cardealer');?>*</label>
                            <input type="text" name="friends_email" id="friends_email" class="form-control" required>
                        </div></div>
                        <div class="col-sm-12"><div class="form-group">
                            <label for="message"><?php esc_html_e( "Message", "cardealer" ); ?></label>
                            <textarea name="message" class="form-control" id="message" maxlength="300"></textarea>                                        
                        </div></div>
                        <div class="col-sm-6"><div class="form-group">
							<div id="recaptcha4"></div>
						</div>  </div>                                                          
                        <div class="col-sm-6"><div class="form-group">
                            <button id="submit_friend_frm" class="button red" ><?php echo esc_html__('Send', 'cardealer');?></button>
                            <span class="spinimg"></span>
                            <div class="friend-frm-msg" style="display: none;"></div>
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