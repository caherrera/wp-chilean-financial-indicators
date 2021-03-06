<?php
namespace ChileanIndicator\Widget;
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Financial_Indicators extends WP_Widget_Chilean_Indicators
{
    public $apiUrl = 'http://api.sbif.cl/api-sbifv3/recursos_api/[recurso]?apikey=[apikey]&formato=json';
	public $expire = 86400;


	/**
     * @link http://api.sbif.cl/uso-de-api-key.html
     * @var string
     */
    public $apiKey;

    public function __construct()
    {


        parent::__construct(
            'chilean-financial-indicators', //ID
            'Chilean Financial Indicators', //Nombre
            array(
                'classname'   => 'widget_chilean_financial_indicators',
                'description' => ''
            )
        );
    }

    public function widget($args, $instance)
    {
	    $instance = wp_parse_args( $instance, [ 'apikey' => '' ] );
        $this->apiKey = $instance['apikey'];
        echo '<div class="WP_Widget_Chilean_Indicators WP_Widget_Chilean_Financial_Indicators">';
        echo '<ul>';
        echo $this->printUF();
        echo $this->printDollar();
        echo '</ul>';
        echo '</div>';

    }

	public function printUF() {
		$key   = 'uf';
		$label = 'uf';
		$value = $this->data()->uf;

		return $this->printValue( $key, $value, $label );
	}


	public function printDollar() {
		$key   = 'dolar';
		$label = 'Dolar OBS.';
        $value = $this->data()->dolar;

        return $this->printValue($key, $value, $label);

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

		return sprintf("<li class=\"%s\"><span class=\"unit\">%s</span> $ %s</li>", $key, $label, number_format($value,2,',','.'));
	}

    public function form($instance)
    {
        parent::form($instance);

	    $instance = wp_parse_args( $instance, [ 'apikey' => '' ] );
	    $this->apiKey = $instance['apikey'];

        echo sprintf('<p>'
                     . '<label for="%s">%s</label>'
                     . '<input class="widefat" id="%s" name="%s" type="text" value="%s" />'
                     . '<br>Para usar este Widget necesitas una apikey de la sbif. Si no tienes revisa este link'
                     . '<br><a href="http://api.sbif.cl/uso-de-api-key.html" target="_blank">http://api.sbif.cl/uso-de-api-key.html</a></p>',
            $this->get_field_id('apikey'),
            _e('apikey de SBIF:'),
            $this->get_field_id('apikey'),
            $this->get_field_name('apikey'),
            esc_attr($this->apiKey));


    }

    public function sync($apiUrl = false)
    {
	    if ( $mindicador = parent::sync( 'https://mindicador.cl/api' ) ) {
		    $mindicador = json_decode( $mindicador );
		    $uf         = $mindicador->uf->valor;
		    $dolar      = $mindicador->dolar->valor;
	    }else {
		    $apiUrl = $apiUrl ?: $this->apiUrl;
		    $apiUrl = str_ireplace( "[apikey]", $this->apiKey, $apiUrl );
		    $uf     = parent::sync( str_ireplace( '[recurso]', 'uf', $apiUrl ) );
		    if ( $uf ) {
			    $uf = json_decode( $uf );
			    $uf = current( $uf->UFs );
			    $uf = $uf->Valor;
		    } else {
			    $uf = parent::sync( 'https://mindicador.cl/api/uf' );
			    $uf = json_decode( $uf );
			    $uf = current( $uf->serie );
			    $uf = $uf->valor;
		    }
		    $dolar = parent::sync( str_ireplace( '[recurso]', 'dolar', $apiUrl ) );
		    if ( $dolar ) {
			    $dolar = json_decode( $dolar );
			    $dolar = current( $dolar->Dolares );
			    $dolar = $dolar->Valor;
		    } else {
			    $dolar = parent::sync( 'https://mindicador.cl/api/dolar' );
			    $dolar = json_decode( $dolar );
			    $dolar = current( $dolar->serie );
			    $dolar = $dolar->valor;
		    }
	    }

        return json_encode([ 'uf' => $uf, 'dolar' => $dolar]);
    }

	public function getCacheKey($sufix = '')
	{
		return 'financial_indicators' . $sufix;
	}

}