<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Weather_Indicators extends WP_Widget_Chilean_Indicators
{
    public $apiUrl='';
    public function __construct() {

        parent::__construct(
            'chilean-weather-indicators', //ID
            'Chilean Weather Indicators', //Nombre
            array(
                'classname' => 'widget_chilean_weather_indicators',
                'description' => ''
            )
        );
    }



}