<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Weather_Indicators extends WP_Widget_Chilean_Indicators {
	public $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric&lang=%s';
	public $city;

	public function __construct() {

		$this->city = function_exists( 'bp_get_profile_field_data' ) && bp_get_profile_field_data( array(
			'field'   => 'Location',
			'user_id' => get_current_user_id()
		) ) ?: 'Santiago, Chile';
		parent::__construct(
			'chilean-weather-indicators', //ID
			'Chilean Weather Indicators', //Nombre
			array(
				'classname'   => 'widget_chilean_weather_indicators',
				'description' => ''
			)
		);
	}

	public function getCacheKey( $sufix = '' ) {
		preg_match( "/(.+), (.+)/", $this->city, $match );
		$sufix = $match[2] . '_' . $match[1] . '_' . $sufix;

		return $sufix;
	}

	public function widget( $args, $instance ) {
		if ( isset( $instance['apikey'] ) && $instance['apikey'] ) {
			$this->apiUrl = sprintf( $this->apiUrl, $this->city,
				$instance['apikey'] ?: '631bfe41f6f68a1642e75ded0751ec31',
				$instance['lang'] ?: 'es' );
			echo '<div class="WP_Widget_Chilean_Indicators WP_Widget_Chilean_Weather_Indicators">';
			echo '<ul>';
			echo $this->printWeather();
			echo '</ul>';
			echo '</div>';
		} else {
			echo "You must set up your widget";
		}


	}

	public function printWeather() {
		$key   = 'weather';
		$label = $this->city;
		$value = ',' . $this->data()->main->temp . '°C ' . $this->data()->weather[0]->description;

		return $this->printValue( $key, $value, $label );
	}

	public function form( $instance ) {
		parent::form( $instance );

		if ( isset( $instance['apikey'] ) ) {
			$apikey = $instance['apikey'];
		} else {
			$apikey = '';
		}
		echo sprintf( '<p>'
		              . '<label for="%s">%s</label>'
		              . '<input class="widefat" id="%s" name="%s" type="text" value="%s" />'
		              . '<br>Para usar este Widget necesitas una apikey de openweathermap.org'
		              . '<br><a href="http://openweathermap.org" target="_blank">openweathermap.org</a></p>',
			$this->get_field_id( 'apikey' ),
			_e( 'apikey de openweathermap.org:' ),
			$this->get_field_id( 'apikey' ),
			$this->get_field_name( 'apikey' ),
			esc_attr( $apikey ) );
		#http://api.openweathermap.org/data/2.5/weather?appid=631bfe41f6f68a1642e75ded0751ec31&units=metric&lang=es&lat=-32.726&lon=-71.4151
		echo sprintf( '<p>'
		              . '<label for="%s">%s</label>'
		              . '<input class="widefat" id="%s" name="%s" type="text" value="%s" />'
			,
			$this->get_field_id( 'lat' ),
			'Latitude:',
			$this->get_field_id( 'lat' ),
			$this->get_field_name( 'lat' ),
			esc_attr( $apikey ) );
		echo sprintf( '<p>'
		              . '<label for="%s">%s</label>'
		              . '<input class="widefat" id="%s" name="%s" type="text" value="%s" />'
			,
			$this->get_field_id( 'lon' ),
			'Longitude:',
			$this->get_field_id( 'lon' ),
			$this->get_field_name( 'lon' ),
			esc_attr( $apikey ) );


	}

	public function update( $new_instance, $old_instance ) {
		return parent::update( $new_instance, $old_instance ); // TODO: Change the autogenerated stub
	}


}