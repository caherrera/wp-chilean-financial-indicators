<?php

namespace ChileanIndicator;

use ChileanIndicator\Api\ApiWeather;
use ChileanIndicator\Widget\WP_Widget_Chilean_Financial_Indicators;
use ChileanIndicator\Widget\WP_Widget_Chilean_Weather_Indicators;

class Init {
	const DOMAIN = 'WP_Chilean_Financial_Indicators';
	private static $instance;

	private function __construct() {
		self::init();
	}

	public function init() {

		add_action( 'widgets_init', function () {
			register_widget( WP_Widget_Chilean_Financial_Indicators::class );
			register_widget( WP_Widget_Chilean_Weather_Indicators::class );
		} );
		add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
		add_action( 'wp_ajax_wp_chilean_financial_indicators', [ $this, 'wp_chilean_financial_indicators' ] );

		if ( ! session_id() ) {
			session_start();
		}

	}

	static public function wp_chilean_financial_indicators() {

		$w    = new ApiWeather( $_SESSION['WP_Widget_Chilean_Weather_Indicators'] );
		$echo = $w->printWeather();
		echo $echo;
		die();
	}

	static public function after_setup_theme() {
//		wp_add_inline_script();
	}


//	static public function autoloader( $class ) {
//		if ( preg_match( '/WP_Widget_Chilean.*/', $class ) ) {
//			$file = __DIR__ . "/widgets/$class.php";
//		} elseif ( preg_match( '/WP_Chilean.*/', $class ) ) {
//			$file = __DIR__ . "/widgets/$class.php";
//		} else {
//			return;
//		}
//
//		include_once( $file );
//
//
//	}

	static public function factory() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}