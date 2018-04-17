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
    public $expire = 0;
    public $instance;

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
    	$this->instance=$instance;
        $data = $this->fetch();
        echo json_encode($data);
    }

    public function fetch()
    {
        if ($cache = wp_cache_get($key = $this->getCacheKey(), $group = get_class($this))) {
            return $cache;
        } else {
            $cache = json_decode($this->sync($this->apiUrl));
            wp_cache_set($key, $cache, $group, $this->expire);

            return $cache;
        }

    }

	public function getCacheKey() {

		$json = json_encode( $this->instance );

		return md5( $json );
	}


    /**
     * @return string
     */
    public function sync($apiUrl = false)
    {
        $apiUrl = $apiUrl ?: $this->apiUrl;
        if ( ! $apiUrl) {
            return '';
        }
        try {
            if (ini_get('allow_url_fopen')) {
                $json = @file_get_contents($apiUrl);
            } else {
                // De otra forma utilizamos cURL
                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                curl_close($curl);
            }
        } catch (Exception $e) {
            return '';
        }

        return $json;
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
    	echo '<p>&nbsp;</p>';
	    echo $this->formInput($instance
		    ,'title'
		    ,'New Title:'


	    );



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

    public function formInput($instance=[],$key,$title='',$description='',$default='',$class='widefat'){
	    if ( isset( $instance[$key] ) ) {
		    $value = $instance[$key];
	    } else {
		    $value = $default;
	    }
	    return sprintf( '<p>'
	                  . '<label for="%s"><strong>%s</strong></label>'
	                  . '<input class="'.$class.'" id="%s" name="%s" type="text" value="%s" />'
	                  . $description.'</p>',
		    $this->get_field_id( $key ),
		    _e( $title?:$key ),
		    $this->get_field_id( $key ),
		    $this->get_field_name( $key ),
		    esc_attr( $value ) );
    }


}