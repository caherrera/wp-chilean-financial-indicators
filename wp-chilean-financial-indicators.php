<?php
/*
Plugin Name: Chilean Financial Indicators
Plugin URI: https://github.com/caherrera/wp-chilean-financial-indicators
Description: Obtain chilean indicators from http://www.mindicador.cl/
Version: 0.1.0
Author: Carlos Herrera
Author URI: https://www.linkedin.com/in/carlosherreracaceres/
*/

class WP_Chilean_Financial_Indicators
{
    const DOMAIN = 'WP_Chilean_Financial_Indicators';
    private static $instance;

    private function __construct()
    {
        self::init();
    }

    static public function init()
    {

        add_action('widgets_init', function () {
            register_widget('WP_Widget_Chilean_Financial_Indicators');
            register_widget('WP_Widget_Chilean_Weather_Indicators');
        });
    }

    static public function autoloader($class)
    {
        if (preg_match('/WP_Widget_Chilean.*/', $class)) {
            $file = __DIR__ . "/widgets/$class.php";
        } elseif (preg_match('/WP_Chilean.*/', $class)) {
            $file = __DIR__ . "/widgets/$class.php";
        } else {
            return;
        }

        include_once($file);


    }

    static public function factory()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

global $WP_Chilean_Financial_Indicators;
if ( ! $WP_Chilean_Financial_Indicators instanceof WP_Chilean_Financial_Indicators) {

    $WP_Chilean_Financial_Indicators = WP_Chilean_Financial_Indicators::factory();
}
spl_autoload_register('WP_Chilean_Financial_Indicators::autoloader');