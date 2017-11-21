<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Weather_Indicators extends WP_Widget_Chilean_Indicators
{
    public $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric&lang=%s';
    public $city;

    public function __construct()
    {
        $this->city = bp_get_profile_field_data(array(
            'field'   => 'Location',
            'user_id' => get_current_user_id()
        )) ?: 'Santiago, Chile';
        parent::__construct(
            'chilean-weather-indicators', //ID
            'Chilean Weather Indicators', //Nombre
            array(
                'classname'   => 'widget_chilean_weather_indicators',
                'description' => ''
            )
        );
    }

    public function getCacheFile()
    {
        preg_match("/(.+), (.+)/", $this->city, $match);
        $sufix = $match[2] . '_' . $match[1];

        return parent::getCacheFile($sufix);
    }

    public function widget($args, $instance)
    {
        $this->apiUrl = sprintf($this->apiUrl, $this->city, $instance['api'] ?: '631bfe41f6f68a1642e75ded0751ec31',
            $instance['lang'] ?: 'es');
        echo '<div class="WP_Widget_Chilean_Indicators WP_Widget_Chilean_Weather_Indicators">';
        echo '<ul>';
        echo $this->printWeather();
        echo '</ul>';
        echo '</div>';

    }

    public function printWeather()
    {
        $key   = 'weather';
        $label = $this->city;
        $value = ',' . $this->data()->main->temp . '°C ' . $this->data()->weather[0]->description;

        return $this->printValue($key, $value, $label);
    }

    public function update($new_instance, $old_instance)
    {
        return parent::update($new_instance, $old_instance); // TODO: Change the autogenerated stub
    }


}