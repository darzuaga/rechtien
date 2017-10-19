<?php
/**
 * Template Name: Team
 * Description: A Page Template that display team members.
 *
 * @package CarDealer
 * @author Potenza Global Solutions
 */
get_header();
//
get_template_part('template-parts/content','intro');

//team coding
$team_layout = ( isset($car_dealer_options['team_layout']) )? $car_dealer_options['team_layout'] : 'layout_1'; // Option inside theme option

$page_specific_layout = ( function_exists('get_field') )? get_field('enable_custom_team_layout') : false;
if($page_specific_layout) {
	$page_option_layout = get_field('team_layout'); // Optin inside page
	if( !empty($page_option_layout) && $page_option_layout != NULL )
		$team_layout = $page_option_layout;
}

$layouttype  = ($team_layout=='layout_1') ? 'layout_1' : 'layout_2';
get_template_part('template-parts/team/team',$layouttype);

get_footer();
?>