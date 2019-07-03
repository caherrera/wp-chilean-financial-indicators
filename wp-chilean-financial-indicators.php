<?php
/*
Plugin Name: Chilean Financial Indicators
Plugin URI: https://github.com/caherrera/wp-chilean-financial-indicators
Description: Obtain chilean indicators from http://www.mindicador.cl/
Version: 0.1.0
Author: Carlos Herrera
Author URI: https://www.linkedin.com/in/carlosherreracaceres/
*/

require_once __DIR__ . '/vendor/autoload.php';

global $WP_Chilean_Financial_Indicators;
if ( ! $WP_Chilean_Financial_Indicators instanceof ChileanIndicator\Init ) {

	try {
		$WP_Chilean_Financial_Indicators = ChileanIndicator\Init::factory();
		$WP_Chilean_Financial_Indicators->setDir( plugin_dir_url( __FILE__ ) );
	} catch ( Exception $e ) {
		wp_die( $e->getMessage() );
	}
}
