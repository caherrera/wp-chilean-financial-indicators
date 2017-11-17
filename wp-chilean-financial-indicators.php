<?php
/*
Plugin Name: Nice Debug
Plugin URI: https://github.com/caherrera/wp-chilean-financial-indicators
Description: obtain chilean indicators from http://www.mindicador.cl/
Version: 1.0
Author: Carlos Herrera
Author URI: https://www.linkedin.com/in/carlosherreracaceres/
*/

class WP_Chilean_Financial_Indicators
{
    private static $instance;

    private function __construct()
    {
        self::load();
        self::init();
    }

    static public function load()
    {
        require_once __DIR__ . '/WP_Widget_Chilean_Financial_Indicators.php';
    }

    static public function init()
    {
        
    }


    static public function factory()
    {
        if ( ! self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

global $WP_Chilean_Financial_Indicators;
if ( ! $WP_Chilean_Financial_Indicators instanceof WP_Chilean_Financial_Indicators) {
    $WP_Chilean_Financial_Indicators = WP_Chilean_Financial_Indicators::factory();
}