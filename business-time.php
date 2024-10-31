<?php
/**
 * Plugin Name: Business Time
 * Plugin URI: http://www.hellomoon.be
 * Description: This plugin able you to display some schedule into your pages and posts by using custom shortcode.
 * Version: 1.0.8
 * Author: Jeremy Jamar
 * Author URI: http://www.hellomoon.be
 * License: GPL2
 */
	
require 'libs/schedule-opening-hours.class.php';

define('SD_TEXTDOMAIN','is-it-open');

add_action( 'init', 'schedule_init' );

function schedule_init() {
	load_plugin_textdomain(SD_TEXTDOMAIN,false, dirname( plugin_basename( __FILE__ ) ).'/languages/');
    add_filter( "mce_external_plugins", "schedule_add_buttons" );
    add_filter( 'mce_buttons', 'schedule_register_buttons' );
	add_action( 'admin_notices', 'schedule_add_admin_panel' );
	add_shortcode( 'schedule', 'schedule_shortcode' );
    wp_register_style( 'myPluginStylesheet', plugins_url('public/schedule.css', __FILE__) );
    wp_enqueue_style( 'myPluginStylesheet' );
}

function schedule_shortcode( $atts ){

	$schedule = new ScheduleOpeningHours();

	$schedule->setDaysName(array(
		__('Monday',SD_TEXTDOMAIN),
		__('Tuesday',SD_TEXTDOMAIN),
		__('Wednsday',SD_TEXTDOMAIN),
		__('Thursday',SD_TEXTDOMAIN),
		__('Friday',SD_TEXTDOMAIN),
		__('Saturday',SD_TEXTDOMAIN),
		__('Sunday',SD_TEXTDOMAIN)
	));

	$settings = shortcode_atts( array(
        'show-all-days' => null,
        'show-week-days' => null,
        'color' => null,
        'mo' => null,
        'tu' => null,
        'we' => null,
        'th' => null,
        'fr' => null,
        'sa' => null,
        'su' => null
    ), $atts );

	if( $settings['show-all-days'] === 'true' ){
		$schedule->displayAllDays();
	}	
	if( $settings['show-week-days'] === 'true' ){
		$schedule->displayWeekDays();
	}
	if( $settings['color'] != null ){
		$schedule->setColor($settings['color']);
	}
	foreach($schedule->getDaysShorcuts() as $day){
		if( $settings[$day] ){
			$schedule->setSchedule($day,$settings[$day]);
		}	
	}
	return $schedule->getSchedule();
}

function schedule_add_buttons( $plugin_array ) {
    $plugin_array['ScheduleIsItOpen'] =  plugin_dir_url( __FILE__ ) . '/admin/assets/js/schedule-tinymce.js';
    return $plugin_array;
}

function schedule_register_buttons( $buttons ) {
    array_push( $buttons, 'AddSchedule' );
    return $buttons;
}

function schedule_add_admin_panel() {
	global $pagenow;
	if( $pagenow == 'post.php' || $pagenow == 'post-new.php')
		echo '<div style="display:none" id="schedule-form-wrapper" data-button-name="'. __('Add a schedule',SD_TEXTDOMAIN) .'" data-panel-name="'. __('Add a schedule',SD_TEXTDOMAIN) .'">
			<div id="schedule-form">\
            <table id="schedule-table" class="form-table">\
            <tr>\
                <th><label for="schedule-mo">'. __('Monday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="mo" id="schedule-mo" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-tu">'. __('Tuesday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="tu" id="schedule-tu" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-we">'. __('Wednsday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="we" id="schedule-we" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-th">'. __('Thursday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="th" id="schedule-th" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-fr">'. __('Friday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="fr" id="schedule-fr" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-sa">'. __('Saturday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="sa" id="schedule-sa" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-su">'. __('Sunday',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="su" id="schedule-su" value="" /><br />
                <small>'. __('Leave blank if you want to hide this day.',SD_TEXTDOMAIN) .'</small>
            </tr>\
            <tr>\
                <th><label for="schedule-displayalldays">'. __('Display all days',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="checkbox" id="schedule-displayalldays" name="displayalldays" /><br />
            </tr>\
            <tr>\
                <th><label for="schedule-displayweekdays">'. __('Display week days',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="checkbox" id="schedule-displayweekdays" name="displayweekdays" /><br />
            </tr>\
            <tr>\
                <th><label for="schedule-color">'. __('Color',SD_TEXTDOMAIN) .'</label></th>\
                <td><input type="text" name="color" id="schedule-color" value="#" /><br />
                <small>'. __('Specify the color of the schedule in hexadecimal value like #333333.',SD_TEXTDOMAIN) .'<br /> '. __('Leave blank if you want to display default color.',SD_TEXTDOMAIN) .'</small>
            </tr>\
        </table>\
        <p class="submit">
            <input type="button" id="schedule-submit" class="button-primary" value="'. __('Insert Schedule',SD_TEXTDOMAIN) .'" name="submit" />
        </p>\
        </div>
        </div>';
}