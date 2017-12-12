<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Financial_Indicators extends WP_Widget_Chilean_Indicators
{
    public $apiUrl = 'http://indicadoresdeldia.cl/webservice/indicadores.json';

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
        echo '<div class="WP_Widget_Chilean_Indicators WP_Widget_Chilean_Financial_Indicators">';
        echo '<ul>';
        echo $this->printUF();
        echo $this->printDollar();
        echo '</ul>';
        echo '</div>';

    }

    public function printUF()
    {
        $key   = 'uf';
        $label = 'uf';
//        $value = money_format("%n", (float)$this->data()->indicador->uf);
        $value = $this->data()->indicador->uf;

        return $this->printValue($key, $value, $label);
    }


    public function printDollar()
    {
        $key   = 'dolar';
        $label = 'Dolar OBS.';

//        $value = money_format("%n", (float)$this->data()->moneda->dolar);
        $value=$this->data()->moneda->dolar;

        return $this->printValue($key, $value, $label);

    }


}