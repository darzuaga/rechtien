<?php
global $car_dealer_options;
if(isset($car_dealer_options['financial_form_status']) && !$car_dealer_options['financial_form_status']){
    return;
}
?>
<li>
    <a data-toggle="modal" data-target="#financial_form_mdl" href="javascrip:void(0)"><i class="fa fa-file-text-o"></i><?php echo esc_html__('Financial Form', 'cardealer');?></a>
	<div class="modal fade" id="financial_form_mdl" tabindex="-1" role="dialog" aria-labelledby="financial_form_lbl" aria-hidden="true">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title" id="financial_form_lbl"><?php echo esc_html__('Financial Form', 'cardealer');?></h4>
		</div>
		<div class="modal-body">
		<?php 
		if( isset($car_dealer_options['financial_form']) && !empty($car_dealer_options['financial_form']) && $car_dealer_options['financial_form_contact_7'] == true ) {
			echo do_shortcode($car_dealer_options['financial_form']);
		} else {
    		?>
    		<form name="financial_form" class="gray-form" method="post" id="financial_form">
        		<input type="hidden" name="action" class="form-control" value="financial_form_action">
        		<input type="hidden" name="financial_nonce" class="form-control" value="<?php echo wp_create_nonce("financial_form"); ?>">
        		<input type="hidden" name="car_id" value="<?php echo get_the_ID()?>">
                <div class="main">
        		<div class="container-fluid"><div class="row"><div class="col-sm-12"><div class="finance-form-block clearfix">
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'First Name', 'cardealer' );?>*</label>
        		<input type="text" name="first_name" class="form-control" id="first_name" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Middle Initial', 'cardealer' );?></label>
        		<input type="text" name="middle_initial" class="form-control" id="middle_initial" maxlength="5" />
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Last Name', 'cardealer' );?>*</label>
        		<input type="text" name="last_name" class="form-control" id="last_name" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Street Address', 'cardealer' );?>*</label>
        		<input type="text" name="street_address" class="form-control" id="street_address" maxlength="250"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-3 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'City', 'cardealer' );?>*</label>
        		<input type="text" name="city" class="form-control" id="city" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-md-2 col-sm-3 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'State', 'cardealer' );?>*</label>
        		<div class="selected-box">
        			<select class="selectpicker" name="state" id="state" >
        			<option value=""><?php esc_html_e( 'Select One:', 'cardealer' );?></option>
        			<option value="alabama"><?php esc_html_e( 'Alabama', 'cardealer' );?></option>
        			<option value="alaska"><?php esc_html_e( 'Alaska', 'cardealer' );?></option>
        			<option value="arizona"><?php esc_html_e( 'Arizona', 'cardealer' );?></option>
        			<option value="arkansas"><?php esc_html_e( 'Arkansas', 'cardealer' );?></option>
        			<option value="california"><?php esc_html_e( 'California', 'cardealer' );?></option>
        			<option value="colorado"><?php esc_html_e( 'Colorado', 'cardealer' );?></option>
        			<option value="connecticut"><?php esc_html_e( 'Connecticut', 'cardealer' );?></option>
        			<option value="delaware"><?php esc_html_e( 'Delaware', 'cardealer' );?></option>
        			<option value="district_of_columbia"><?php esc_html_e( 'District of Columbia', 'cardealer' );?></option>
        			<option value="florida"><?php esc_html_e( 'Florida', 'cardealer' );?></option>
        			<option value="georgia"><?php esc_html_e( 'Georgia', 'cardealer' );?></option>
        			<option value="hawaii"><?php esc_html_e( 'Hawaii', 'cardealer' );?></option>
        			<option value="idaho"><?php esc_html_e( 'Idaho', 'cardealer' );?></option>
        			<option value="iiiinois"><?php esc_html_e( 'Lllinois', 'cardealer' );?></option>
        			<option value="indiana"><?php esc_html_e( 'Indiana', 'cardealer' );?></option>
        			<option value="iowa"><?php esc_html_e( 'Iowa', 'cardealer' );?></option>
        			<option value="kansas"><?php esc_html_e( 'Kansas', 'cardealer' );?></option>
        			<option value="kentucky"><?php esc_html_e( 'Kentucky', 'cardealer' );?></option>
        			<option value="louisiana"><?php esc_html_e( 'Louisiana', 'cardealer' );?></option>
        			<option value="maine"><?php esc_html_e( 'Maine', 'cardealer' );?></option>
        			<option value="maryland"><?php esc_html_e( 'Maryland', 'cardealer' );?></option>
        			<option value="massachusetts"><?php esc_html_e( 'Massachusetts', 'cardealer' );?></option>
        			<option value="michigan"><?php esc_html_e( 'Michigan', 'cardealer' );?></option>
        			<option value="minnesota"><?php esc_html_e( 'Minnesota', 'cardealer' );?></option>
        			<option value="mississippi"><?php esc_html_e( 'Mississippi', 'cardealer' );?></option>
        			<option value="missouri"><?php esc_html_e( 'Missouri', 'cardealer' );?></option>
        			<option value="montana"><?php esc_html_e( 'Montana', 'cardealer' );?></option>
        			<option value="nebraska"><?php esc_html_e( 'Nebraska', 'cardealer' );?></option>
        			<option value="nevada"><?php esc_html_e( 'Nevada', 'cardealer' );?></option>
        			<option value="new_hampshire"><?php esc_html_e( 'New Hampshire', 'cardealer' );?></option>
        			<option value="new_jersey"><?php esc_html_e( 'New Jersey', 'cardealer' );?></option>
        			<option value="new_mexico"><?php esc_html_e( 'New Mexico', 'cardealer' );?></option>
        			<option value="new_york"><?php esc_html_e( 'New York', 'cardealer' );?></option>
        			<option value="north_carolina"><?php esc_html_e( 'North Carolina', 'cardealer' );?></option>
        			<option value="north_dakota"><?php esc_html_e( 'North Dakota', 'cardealer' );?></option>
        			<option value="ohio"><?php esc_html_e( 'Ohio', 'cardealer' );?></option>
        			<option value="oklahoma"><?php esc_html_e( 'Oklahoma', 'cardealer' );?></option>
        			<option value="oregon"><?php esc_html_e( 'Oregon', 'cardealer' );?></option>
        			<option value="pennsylvania"><?php esc_html_e( 'Pennsylvania', 'cardealer' );?></option>
        			<option value="rhode_island"><?php esc_html_e( 'Rhode Island', 'cardealer' );?></option>
        			<option value="south_carolina"><?php esc_html_e( 'South Carolina', 'cardealer' );?></option>
        			<option value="south_dakota"><?php esc_html_e( 'South Dakota', 'cardealer' );?></option>			
        			<option value="tennessee"><?php esc_html_e( 'Tennessee', 'cardealer' );?></option>
        			<option value="texas"><?php esc_html_e( 'Texas', 'cardealer' );?></option>
        			<option value="utah"><?php esc_html_e( 'Utah', 'cardealer' );?></option>
        			<option value="vermont"><?php esc_html_e( 'Vermont', 'cardealer' );?></option>
        			<option value="virginia"><?php esc_html_e( 'Virginia', 'cardealer' );?></option>
        			<option value="washington"><?php esc_html_e( 'Washington', 'cardealer' );?></option>
        			<option value="west_virginia"><?php esc_html_e( 'West Virginia', 'cardealer' );?></option>
        			<option value="wisconsin"><?php esc_html_e( 'Wisconsin', 'cardealer' );?></option>
        			<option value="wyoming"><?php esc_html_e( 'Wyoming', 'cardealer' );?></option>
        			</select>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-md-2 col-sm-2 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Zip', 'cardealer' );?>*</label>
        		<input type="text" name="zip" class="form-control" id="zip" maxlength="15"/>
        		</div>
        		</div>
        
        		<div class="col-md-5 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Preferred Email Address', 'cardealer' );?>*</label>
        		<input type="text" name="preferred_email_address" class="form-control" id="preferred_email_address" />
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Daytime Phone Number', 'cardealer' );?>*</label>
        		<input type="text" name="daytime_phone_number" class="form-control" id="daytime_phone_number" maxlength="15"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Mobile Number', 'cardealer' );?>*</label>
        		<input type="text" name="mobile_phone_number" class="form-control" id="mobile_phone_number" maxlength="15"/>
        		</div>
        		</div>
        
        		</div></div></div></div>
        		<br>
        		<br>
        
        		<div class="container-fluid">
        		<div class="row">
        		<div class="col-sm-6">
        		<div class="finance-form-block clearfix">
        
        		<div class="col-sm-12">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Date of Birth', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_month" id="date_of_birth_month" >
        			<option value=""><?php esc_html_e( 'Month', 'cardealer' );?></option>
        			<?php for($i=01;$i<13;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_day" id="date_of_birth_day" >
        			<option value=""><?php esc_html_e( 'Day', 'cardealer' );?></option>
        			<?php for($i=01;$i<32;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_year" id="date_of_birth_year" >
        			<option value=""><?php esc_html_e( 'Year', 'cardealer' );?></option>
        			<?php for($i=1925;$i<2018;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Social Security Number (SSN)', 'cardealer' );?>*</label>
        		<input type="text" name="social_security_number" class="form-control" id="social_security_number" maxlength="15"/>
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Employer Name', 'cardealer' );?>*</label>
        		<input type="text" name="employer_name" class="form-control" id="employer_name" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Employer Phone', 'cardealer' );?>*</label>
        		<input type="text" name="employer_phone" class="form-control" id="employer_phone" maxlength="25" />
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Job Title', 'cardealer' );?>*</label>
        		<input type="text" name="job_title" class="form-control" id="job_title" maxlength="25"/>
        		</div>
        		</div>
        
        		</div>
        		</div>
            
                <div class="col-sm-6">
        		<div class="finance-form-block clearfix">
            	<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Living Arrangements', 'cardealer' );?>*</label>
        		<div class="selected-box">
        			<select class="selectpicker" name="living_arrangements" id="living_arrangements" >
        			<option value=""><?php esc_html_e( 'Select One', 'cardealer' );?></option>
        			<option value="rent"><?php esc_html_e( 'Rent', 'cardealer' );?></option>
        			<option value="own"><?php esc_html_e( 'Own', 'cardealer' );?></option>
        			<option value="live_with_parents"><?php esc_html_e( 'Live With Parents', 'cardealer' );?></option>
        			</select>
        		</div>
                </div>
        		</div>
                
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Monthly Rent/Mortgage Payment', 'cardealer' );?>*</label>
        		<input type="text" name="monthly_rent" class="form-control" id="monthly_rent" />
        		</div>
        		</div>
                
        		<div class="col-sm-12">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Length of Time at Current Address', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_time_at_current_add_year" id="length_of_time_at_current_add_year" >
        			<option value=""><?php esc_html_e( 'Year(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Year', 'cardealer' );?> "><?php esc_html_e( '1 Year', 'cardealer' );?></option>
        			<?php for($i=2;$i<31;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i.' Years' , 'cardealer' );?>"><?php echo esc_html__( $i .' Years', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_time_at_current_add_month" id="length_of_time_at_current_add_month" >
        			<option value=""><?php esc_html_e( 'Month(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Month', 'cardealer' );?>"><?php esc_html_e( '1 Month', 'cardealer' );?></option>
        			<?php for($i=2;$i<12;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i .' Months' , 'cardealer' );?>"><?php echo esc_html__( $i .' Months', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
                </div>
        		</div>
        		</div>
                <div class="col-sm-8">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Length of Employment', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_employment_year" id="length_of_employment_year" >
        			<option value=""><?php esc_html_e( 'Year(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Year', 'cardealer' );?>"><?php esc_html_e( '1 Year', 'cardealer' );?></option>
        			<?php for($i=2;$i<31;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i .' Years' , 'cardealer' );?>"><?php echo esc_html__( $i .' Years', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_employment_month" id="length_of_employment_month" >
        			<option value=""><?php esc_html_e( 'Month(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Month', 'cardealer' );?>"><?php esc_html_e( '1 Month', 'cardealer' );?></option>
        			<?php for($i=2;$i<12;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i .' Months' , 'cardealer' );?>"><?php echo esc_html__( $i .' Months', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-sm-4">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Annual Income', 'cardealer' );?>*</label>
        		<input type="text" name="annual_income" class="form-control" id="annual_income" maxlength="15"/>
        		</div>
        		</div>
                
        		<div class="col-sm-12">
                <div class="form-group">
        		<label><input type="checkbox" name="joint_application" class="join-inout" id="joint_application"/><?php esc_html_e( 'Joint Application', 'cardealer' );?></label>
        		</div>
                </div>
        		</div>
        		</div>
        		</div>
        		</div>
        		
        		</div>
                <br>
        		<br>
        		
        		<div class="container-fluid">
        		<div class="row">
        		<div class="col-sm-12">
        		<div class="finance-form-block clearfix">
        		<br>
        		<div class="col-sm-12 form-title text-center">
        		<h4><?php esc_html_e( 'Applicant Additional Income Information', 'cardealer' );?></h4>
        		<p><?php esc_html_e( 'Complete "Other Income" and "Source of Other Income" only if you want this income considered for repayment. Enter monthly amount. Alimony, child support or separate maintenance income need not be revealed if you do not wish to have it considered as a basis for repaying this obligation.', 'cardealer' );?></p>
        		</div>
        		<br>
        		
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Other Income Amount (Monthly)', 'cardealer' );?></label>
        		<input type="text" name="other_income_ammount_monthly" class="form-control" id="other_income_ammount_monthly"/>
        		</div>
        		<div class="form-group">
        		<label><?php esc_html_e( 'Other Income (Source)', 'cardealer' );?></label>
        		<input type="text" name="other_income_source" class="form-control" id="other_income_source"/>
        		</div>
        		</div>
        		
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Please include any additional information or options that you would like :', 'cardealer' );?></label>
        		<textarea class="form-control" rows="4" name="additional_information" id="additional_information"></textarea>
        		</div>
        		</div>
                
			<div id="personal_application">
                <div class="col-sm-12"><br><br><h4 class="text-center">Joint Applicant Personal Information</h4><br></div>
                <div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'First Name', 'cardealer' );?>*</label>
        		<input type="text" name="first_name_joint" class="form-control" id="first_name_joint" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Middle Initial', 'cardealer' );?></label>
        		<input type="text" name="middle_initial_joint" class="form-control" id="middle_initial_joint" maxlength="5"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Last Name', 'cardealer' );?>*</label>
        		<input type="text" name="last_name_joint" class="form-control" id="last_name_joint" maxlength="25"/>
        		</div>
        		</div>
                <div class="col-md-3 col-sm-6 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Relationship to Applicant', 'cardealer' );?>*</label>
        		<input type="text" name="relationship_to_applicant" class="form-control" id="relationship_to_applicant"  />
        		</div>
        		</div>
   	            <div class="col-md-3 col-sm-6 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Street Address', 'cardealer' );?>*</label>
        		<input type="text" name="street_address_joint" class="form-control" id="street_address_joint" maxlength="250"/>
        		</div>
        		</div>
                
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'City', 'cardealer' );?>*</label>
        		<input type="text" name="city_joint" class="form-control" id="city_joint" maxlength="25"/>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'State', 'cardealer' );?>*</label>
        		<div class="selected-box">
        			<select class="selectpicker" name="state_joint" id="state_joint" >
        			<option value=""><?php esc_html_e( 'Select One:', 'cardealer' );?></option>
        			<option value="alabama"><?php esc_html_e( 'Alabama', 'cardealer' );?></option>
        			<option value="alaska"><?php esc_html_e( 'Alaska', 'cardealer' );?></option>
        			<option value="arizona"><?php esc_html_e( 'Arizona', 'cardealer' );?></option>
        			<option value="arkansas"><?php esc_html_e( 'Arkansas', 'cardealer' );?></option>
        			<option value="california"><?php esc_html_e( 'California', 'cardealer' );?></option>
        			<option value="colorado"><?php esc_html_e( 'Colorado', 'cardealer' );?></option>
        			<option value="connecticut"><?php esc_html_e( 'Connecticut', 'cardealer' );?></option>
        			<option value="delaware"><?php esc_html_e( 'Delaware', 'cardealer' );?></option>
        			<option value="district_of_columbia"><?php esc_html_e( 'District of Columbia', 'cardealer' );?></option>
        			<option value="florida"><?php esc_html_e( 'Florida', 'cardealer' );?></option>
        			<option value="georgia"><?php esc_html_e( 'Georgia', 'cardealer' );?></option>
        			<option value="hawaii"><?php esc_html_e( 'Hawaii', 'cardealer' );?></option>
        			<option value="idaho"><?php esc_html_e( 'Idaho', 'cardealer' );?></option>
        			<option value="iiiinois"><?php esc_html_e( 'Lllinois', 'cardealer' );?></option>
        			<option value="indiana"><?php esc_html_e( 'Indiana', 'cardealer' );?></option>
        			<option value="iowa"><?php esc_html_e( 'Iowa', 'cardealer' );?></option>
        			<option value="kansas"><?php esc_html_e( 'Kansas', 'cardealer' );?></option>
        			<option value="kentucky"><?php esc_html_e( 'Kentucky', 'cardealer' );?></option>
        			<option value="louisiana"><?php esc_html_e( 'Louisiana', 'cardealer' );?></option>
        			<option value="maine"><?php esc_html_e( 'Maine', 'cardealer' );?></option>
        			<option value="maryland"><?php esc_html_e( 'Maryland', 'cardealer' );?></option>
        			<option value="massachusetts"><?php esc_html_e( 'Massachusetts', 'cardealer' );?></option>
        			<option value="michigan"><?php esc_html_e( 'Michigan', 'cardealer' );?></option>
        			<option value="minnesota"><?php esc_html_e( 'Minnesota', 'cardealer' );?></option>
        			<option value="mississippi"><?php esc_html_e( 'Mississippi', 'cardealer' );?></option>
        			<option value="missouri"><?php esc_html_e( 'Missouri', 'cardealer' );?></option>
        			<option value="montana"><?php esc_html_e( 'Montana', 'cardealer' );?></option>
        			<option value="nebraska"><?php esc_html_e( 'Nebraska', 'cardealer' );?></option>
        			<option value="nevada"><?php esc_html_e( 'Nevada', 'cardealer' );?></option>
        			<option value="new_hampshire"><?php esc_html_e( 'New Hampshire', 'cardealer' );?></option>
        			<option value="new_jersey"><?php esc_html_e( 'New Jersey', 'cardealer' );?></option>
        			<option value="new_mexico"><?php esc_html_e( 'New Mexico', 'cardealer' );?></option>
        			<option value="new_york"><?php esc_html_e( 'New York', 'cardealer' );?></option>
        			<option value="north_carolina"><?php esc_html_e( 'North Carolina', 'cardealer' );?></option>
        			<option value="north_dakota"><?php esc_html_e( 'North Dakota', 'cardealer' );?></option>
        			<option value="ohio"><?php esc_html_e( 'Ohio', 'cardealer' );?></option>
        			<option value="oklahoma"><?php esc_html_e( 'Oklahoma', 'cardealer' );?></option>
        			<option value="oregon"><?php esc_html_e( 'Oregon', 'cardealer' );?></option>
        			<option value="pennsylvania"><?php esc_html_e( 'Pennsylvania', 'cardealer' );?></option>
        			<option value="rhode_island"><?php esc_html_e( 'Rhode Island', 'cardealer' );?></option>
        			<option value="south_carolina"><?php esc_html_e( 'South Carolina', 'cardealer' );?></option>
        			<option value="south_dakota"><?php esc_html_e( 'South Dakota', 'cardealer' );?></option>			
        			<option value="tennessee"><?php esc_html_e( 'Tennessee', 'cardealer' );?></option>
        			<option value="texas"><?php esc_html_e( 'Texas', 'cardealer' );?></option>
        			<option value="utah"><?php esc_html_e( 'Utah', 'cardealer' );?></option>
        			<option value="vermont"><?php esc_html_e( 'Vermont', 'cardealer' );?></option>
        			<option value="virginia"><?php esc_html_e( 'Virginia', 'cardealer' );?></option>
        			<option value="washington"><?php esc_html_e( 'Washington', 'cardealer' );?></option>
        			<option value="west_virginia"><?php esc_html_e( 'West Virginia', 'cardealer' );?></option>
        			<option value="wisconsin"><?php esc_html_e( 'Wisconsin', 'cardealer' );?></option>
        			<option value="wyoming"><?php esc_html_e( 'Wyoming', 'cardealer' );?></option>
        			</select>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-md-3 col-sm-3 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Zip', 'cardealer' );?>*</label>
        		<input type="text" name="zip_joint" class="form-control" id="zip_joint" maxlength="15"/>
        		</div>
        		</div>
                <div class="col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Preferred Email Address', 'cardealer' );?>*</label>
        		<input type="text" name="preferred_email_address_joint" class="form-control" id="preferred_email_address_joint" />
        		</div>
        		</div>
        
        		<div class="col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Daytime Phone Number', 'cardealer' );?>*</label>
        		<input type="text" name="daytime_phone_number_joint" class="form-control" id="daytime_phone_number_joint" maxlength="15"/>
        		</div>
        		</div>
        
        		<div class="col-sm-4 col-xs-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Mobile Number', 'cardealer' );?>*</label>
        		<input type="text" name="mobile_phone_number_joint" class="form-control" id="mobile_phone_number_joint" maxlength="15"/>
        		</div>
        		</div>
                <div class="container-fluid">
        		<div class="row">
        		<div class="col-sm-6"><div class="row">
        		<div class="finance-form-block clearfix">
        
        		<div class="col-sm-12">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Date of Birth', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_month_joint" id="date_of_birth_month_joint" >
        			<option value=""><?php esc_html_e( 'Month', 'cardealer' );?></option>
        			<?php for($i=01;$i<13;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_day_joint" id="date_of_birth_day_joint" >
        			<option value=""><?php esc_html_e( 'Day', 'cardealer' );?></option>
        			<?php for($i=01;$i<32;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-4">
        		<div class="selected-box">
        			<select class="selectpicker" name="date_of_birth_year_joint" id="date_of_birth_year_joint" >
        			<option value=""><?php esc_html_e( 'Year', 'cardealer' );?></option>
        			<?php for($i=1925;$i<2018;$i++){ ?>
        			<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Social Security Number (SSN)', 'cardealer' );?>*</label>
        		<input type="text" name="social_security_number_joint" class="form-control" id="social_security_number_joint" maxlength="15"/>
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Employer Name', 'cardealer' );?>*</label>
        		<input type="text" name="employer_name_joint" class="form-control" id="employer_name_joint" />
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Employer Phone', 'cardealer' );?>*</label>
        		<input type="text" name="employer_phone_joint" class="form-control" id="employer_phone_joint" />
        		</div>
        		</div>
        
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Job Title', 'cardealer' );?>*</label>
        		<input type="text" name="job_title_joint" class="form-control" id="job_title_joint" maxlength="25"/>
        		</div>
        		</div>

        		</div>
        		</div></div>
            
                <div class="col-sm-6"><div class="row">
        		<div class="finance-form-block clearfix">
            	<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Living Arrangements', 'cardealer' );?>*</label>
        		<div class="selected-box">
        			<select class="selectpicker" name="living_arrangements_joint" id="living_arrangements_joint" >
        			<option value=""><?php esc_html_e( 'Select One', 'cardealer' );?></option>
        			<option value="rent"><?php esc_html_e( 'Rent', 'cardealer' );?></option>
        			<option value="own"><?php esc_html_e( 'Own', 'cardealer' );?></option>
        			<option value="live_with_parents"><?php esc_html_e( 'Live With Parents', 'cardealer' );?></option>
        			</select>
        		</div>
                </div>
        		</div>
                
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Monthly Rent/Mortgage Payment', 'cardealer' );?>*</label>
        		<input type="text" name="monthly_rent_joint" class="form-control" id="monthly_rent_joint" />
        		</div>
        		</div>
                
        		<div class="col-sm-12">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Length of Time at Current Address', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_time_at_current_add_year_joint" id="length_of_time_at_current_add_year_joint" >
        			<option value=""><?php esc_html_e( 'Year(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Year', 'cardealer' );?>"><?php esc_html_e( '1 Year', 'cardealer' );?></option>
        			<?php for($i=2;$i<31;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i . ' Years' , 'cardealer' );?>"><?php echo esc_html__( $i . ' Years', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_time_at_current_add_month_joint" id="length_of_time_at_current_add_month_joint" >
        			<option value=""><?php esc_html_e( 'Month(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Month', 'cardealer' );?>"><?php esc_html_e( '1 Month', 'cardealer' );?></option>
        			<?php for($i=2;$i<12;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i . ' Months' , 'cardealer' );?>"><?php echo esc_html__( $i . ' Months', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
                </div>
        		</div>
        		</div>
                <div class="col-sm-8">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Length of Employment', 'cardealer' );?>*</label>
        		<div class="row">
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_employment_year_joint" id="length_of_employment_year_joint" >
        			<option value=""><?php esc_html_e( 'Year(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Year', 'cardealer' );?>"><?php esc_html_e( '1 Year', 'cardealer' );?></option>
        			<?php for($i=2;$i<31;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i . ' Years' , 'cardealer' );?>"><?php echo esc_html__( $i . ' Years', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		<div class="col-sm-6">
        		<div class="selected-box">
        			<select class="selectpicker" name="length_of_employment_month_joint" id="length_of_employment_month_joint" >
        			<option value=""><?php esc_html_e( 'Month(s)', 'cardealer' );?></option>
        			<option value="<?php esc_attr_e( '1 Month', 'cardealer' );?>"><?php esc_html_e( '1 Month', 'cardealer' );?></option>
        			<?php for($i=2;$i<12;$i++){ ?>
        			<option value="<?php echo esc_attr__( $i . ' Months' , 'cardealer' );?>"><?php echo esc_html__( $i . ' Months', 'cardealer' );?></option>
        			<?php } ?>
        			</select>
        		</div>
        		</div>
        		</div>
        		</div>
        		</div>
        
        		<div class="col-sm-4">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Annual Income', 'cardealer' );?>*</label>
        		<input type="text" name="annual_income_joint" class="form-control" id="annual_income_joint" />
        		</div>
        		</div>
        		</div></div>
        		</div>
        		</div>
        		</div>
                <div class="col-sm-12 form-title text-center">
        		<br><br><h4><?php esc_html_e( 'Joint Applicant Additional Income Information', 'cardealer' );?></h4><br>
        		<p><?php esc_html_e( 'Complete "Other Income" and "Source of Other Income" only if you want this income considered for repayment. Enter monthly amount. Alimony, child support or separate maintenance income need not be revealed if you do not wish to have it considered as a basis for repaying this obligation.', 'cardealer' );?></p>
        		</div>
        		<br>
        		
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Other Income Amount (Monthly)', 'cardealer' );?></label>
        		<input type="text" name="other_income_ammount_monthly_joint" class="form-control" id="other_income_ammount_monthly_joint"/>
        		</div>

        		<div class="form-group">
        		<label><?php esc_html_e( 'Other Income (Source)', 'cardealer' );?></label>
        		<input type="text" name="other_income_source_joint" class="form-control" id="other_income_source_joint" maxlength="25"/>
        		</div>
        		</div>
        		
        		<div class="col-sm-6">
        		<div class="form-group">
        		<label><?php esc_html_e( 'Please include any additional information or options that you would like :', 'cardealer' );?></label>
        		<textarea class="form-control" rows="4" name="additional_information_joint" id="additional_information_joint"></textarea>
        		</div>
        		</div>
                
            
            
            </div>
                <div class="col-sm-8 col-sm-offset-2 text-center">
        		<p><?php esc_html_e( 'By clicking on "Get Approved", I acknowledge and declare that I have read and agree with the Application Disclosure above. I certify that I have provided complete and true information in this application.', 'cardealer' );?></p>
        		</div>
        		<br>
        		
				<div class="col-sm-12 text-center">
					 <div class="form-group">
						<div id="recaptcha5" style="display:inline-block;"></div>
					</div>
				</div>
        		<div class="col-sm-12 text-center">
        		<br>
        		<button id="financial_form_request" name="submit" type="submit" value="Send" class="button red"><?php esc_html_e( 'Send your message', 'cardealer' );?></button>
        		<span class="financial_form_spining"></span>
        		<p class="financial_form_msg" style="display:none;"></p>
        		</div>
        		</div>
        		</div>
        		</div>
        		</div>
            </form>
            <?php
    	}
    	?>
		</div>
        </div>
        </div>
    </div>
</li>