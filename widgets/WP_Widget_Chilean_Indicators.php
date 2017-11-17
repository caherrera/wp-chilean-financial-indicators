<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Indicators extends WP_Widget
{
    public $apiUrl = 'http://www.mindicador.cl/api';

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    public function widget($args, $instance)
    {
        $data=$this->fetch();
        echo json_encode($data);
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

    public function fetch()
    {

        $today     = date('Y-m-d');
        $cacheFile = dirname(dirname(__FILE__)) . '/cache/' . __CLASS__ . '.'.$today.'.cache';
        if (file_exists($cacheFile)) {
            return json_decode(file_get_contents($cacheFile));
        }
        $response = $this->sync($this->apiUrl);
        file_put_contents($cacheFile, $response);

        return json_decode($response);


    }

    public function sync($apiUrl)
    {


        if (ini_get('allow_url_fopen')) {
            $json = file_get_contents($apiUrl);
        } else {
            // De otra forma utilizamos cURL
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
        }

        return $json;
    }


}