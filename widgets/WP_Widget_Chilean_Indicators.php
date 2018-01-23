<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Indicators extends WP_Widget
{
    public $apiUrl = 'http://indicadoresdeldia.cl/webservice/indicadores.json';
    public $data = null;

    public function __construct($id_base, $name, array $widget_options = array(), array $control_options = array())
    {
        setlocale(LC_MONETARY, 'es_CL.utf8');
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    public function widget($args, $instance)
    {
        $data = $this->fetch();
        echo json_encode($data);
    }

    public function fetch()
    {
        if ($cache = wp_cache_get($key = $this->getCacheKey(), $group = get_class($this))) {
            return $cache;
        } else {
            $cache = json_decode($this->sync($this->apiUrl));
            wp_cache_set($key, $cache, $group, 3600);

            return $cache;
        }

    }

    public function getCacheKey($sufix = '')
    {
        return $sufix;
    }

//    public function fetchOld()
//    {
//
//        $cacheFile = $this->getCacheFile();
//        if ($cacheFile) {
//            if ( ! is_dir(dirname($cacheFile))) {
//                mkdir(dirname($cacheFile));
//            }
//            if (file_exists($cacheFile)) {
//                $cache = file_get_contents($cacheFile);
//                if ($cache) {
//                    return json_decode($cache);
//                }
//            }
//        }
//        $response = $this->sync($this->apiUrl);
//        if ($cacheFile) {
//            file_put_contents($cacheFile, $response);
//        }
//
//
//        return json_decode($response);
//
//
//    }

    /**
     * @return string
     */
    public function sync($apiUrl = false)
    {
        $apiUrl = $apiUrl ?: $this->apiUrl;
        if ( ! $apiUrl) {
            return '';
        }
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

    public function getCacheName($sufix = '')
    {
        return __CLASS__ . '_' . $sufix;
    }

    public function data()
    {
        if ( ! $this->data) {
            $this->data = $this->fetch();
        }

        return $this->data;
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


    }

    /**
     * @param string $key
     * @param int $value
     * @param string $label
     *
     * @return string
     */
    protected function printValue($key, $value, $label = null)
    {

        return sprintf("<li class=\"%s\"><span class=\"unit\">%s</span> %s</li>", $key, $label, $value);
    }


}