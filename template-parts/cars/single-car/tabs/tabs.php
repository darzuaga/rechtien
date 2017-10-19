<?php 
$carId = get_the_ID();
$location = get_post_meta($carId, 'vehicle_location', true);?>
<div id="tabs">
    <ul class="tabs">
		<?php
		if(!empty(get_post_meta($carId,'vehicle_overview',true))):?>
			<li data-tabs="tab1" class="active"><i aria-hidden="true" class="fa fa-sliders"></i>&nbsp;<?php esc_html_e('Vehicle Overview','cardealer')?></li>
		<?php 
		endif;
		if(!empty(wp_get_post_terms( get_the_ID(), 'car_features_options'))):?>
			<li data-tabs="tab2"><i aria-hidden="true" class="fa fa-list"></i>&nbsp;<?php esc_html_e('Features & Options','cardealer')?></li>
        <?php 
		endif;
		if(!empty(get_post_meta($carId,'technical_specifications',true))):?>
			<li data-tabs="tab3"><i aria-hidden="true" class="fa fa-list"></i>&nbsp;<?php esc_html_e('Technical Specifications','cardealer')?></li>    
        <?php		
		endif; 
		if(!empty(get_post_meta($carId,'general_information',true))):?>
			<li data-tabs="tab4"><i aria-hidden="true" class="fa fa-info-circle"></i>&nbsp;<?php esc_html_e('General Information','cardealer')?></li>
        <?php
		endif;
        if( !empty($location) ):?>
            <li class="cd-tab-map" data-tabs="tab5"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Vehicle Location','cardealer')?></li>
        <?php 
        endif; ?>
    </ul>
    <div id="tab1" class="tabcontent">        
        <?php echo get_post_meta($carId,'vehicle_overview',true)?>
    </div>
    <div id="tab2" class="tabcontent"> 
        <?php 
        $features_and_options = wp_get_post_terms( get_the_ID(), 'car_features_options');
        if(!empty($features_and_options)){
        ?>
        <ul class="list-style-1 list-col-3">                
            <?php
            foreach($features_and_options as $features){
                ?>            
                <li><i class="fa fa-check"></i> <?php echo esc_html($features->name);?></li>            
                <?php                            
            }        
            ?>
        </ul>
        <?php }?>
    </div>
    <div id="tab3" class="tabcontent">
        <?php echo get_post_meta($carId,'technical_specifications',true)?>
    </div>
    <div id="tab4" class="tabcontent">
        <?php echo get_post_meta($carId,'general_information',true)?>
    </div>
    
    <?php
    if( !empty($location) ):
        ?>
        <div id="tab5" class="tabcontent">
            <div class="acf-map">
            	<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
            </div>
        </div>
        <?php 
    endif; ?>        
</div>