<?php

namespace ChileanIndicator\Widget;

use ChileanIndicator\Api\ApiWeather;

/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */
class WP_Widget_Chilean_Weather_Indicators extends WP_Widget_Chilean_Indicators {

	private $api;

	public function __construct() {

		$this->city = function_exists( 'bp_get_profile_field_data' )
		              && bp_get_profile_field_data( array(
			'field'   => 'Location',
			'user_id' => get_current_user_id()
		) ) ?: 'Santiago';
		$this->api  = new ApiWeather( [ 'city' => $this->city ] );
		parent::__construct(
			'chilean-weather-indicators', //ID
			'Chilean Weather Indicators', //Nombre
			array(
				'classname'   => 'widget_chilean_weather_indicators',
				'description' => ''
			)
		);
	}


	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, [ 'api' => '631bfe41f6f68a1642e75ded0751ec31', 'lang' => 'es' ] );
		$this->api->setKey( $instance['api'] );
		$this->api->setLang( $instance['lang'] );

		$_SESSION['WP_Widget_Chilean_Weather_Indicators'] = $this->api;

		echo '<div class="WP_Widget_Chilean_Indicators WP_Widget_Chilean_Weather_Indicators">';
		echo '<ul>';
		echo $this->api->printValue('weather','','');
		echo '</ul>';
		echo '</div>';

	}


	public function update( $new_instance, $old_instance ) {
		return parent::update( $new_instance, $old_instance ); // TODO: Change the autogenerated stub
	}


}