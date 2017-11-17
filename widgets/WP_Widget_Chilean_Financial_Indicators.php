<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Financial_Indicators extends WP_Widget
{
    public function __construct() {

        parent::__construct(
            'chilean-financial-indicators', //ID
            'Chilean Financial Indicators', //Nombre
            array(
                'classname' => 'widget_chilean_financial_indicators',
                'description' => ''
            )
        );
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    public function widget($args, $instance)
    {
        echo 'hola';
    }

    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', WP_Chilean_Financial_Indicators::DOMAIN);
        }
        echo sprintf('<p>'
                     . '<label for="%s">%s</label>'
                     . '<input class="widefat" id="%s" name="%s" type="text" value="%s" />'
                     . '</p>',
            $this->get_field_id('title'),
            _e('Title:'),
            $this->get_field_id('title'),
            $this->get_field_name('title'),
            esc_attr($title));
        FORM;


    }

    public function sync() {
        

        if ( ini_get('allow_url_fopen') ) {
            $json = file_get_contents($apiUrl);
        } else {
            // De otra forma utilizamos cURL
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
        }

    }
}