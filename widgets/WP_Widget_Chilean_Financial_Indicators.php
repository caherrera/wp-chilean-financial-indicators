<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

class WP_Widget_Chilean_Financial_Indicators extends WP_Widget_Chilean_Indicators
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





}