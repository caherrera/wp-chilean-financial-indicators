<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

namespace ChileanIndicator\Api;

class ApiWeather extends Api {
	public $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q=%s,CL&appid=%s&units=metric&lang=%s';
	public $city;
	public $key;
	public $lang;
	public $expire = 360;

	public function __construct( $obj ) {
		if ( is_object( $obj ) ) {
			$obj = (array) $obj;
		}
		$obj          = wp_parse_args( $obj, [
			'city'   => '',
			'key'    => '',
			'lang'   => '',
			'expire' => '1000',
		] );
		$this->city   = $obj['city'];
		$this->key    = $obj['key'];
		$this->lang   = $obj['lang'];
		$this->expire = $obj['expire'];
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @param mixed $city
	 *
	 * @return ApiWeather
	 */
	public function setCity( $city ) {
		$this->city = $city;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param mixed $key
	 *
	 * @return ApiWeather
	 */
	public function setKey( $key ) {
		$this->key = $key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLang() {
		return $this->lang;
	}

	/**
	 * @param mixed $lang
	 *
	 * @return ApiWeather
	 */
	public function setLang( $lang ) {
		$this->lang = $lang;

		return $this;
	}

	public function getCacheKey( $sufix = '' ) {
//        preg_match("/(.+), (.+)/", $this->city, $match);
//        $sufix = $match[2] . '_' . $match[1] . '_' . $sufix;

		return $this->city . '_' . $sufix;
	}

	public function printWeather() {
		$key   = 'weather';
		$label = $this->city;
		$this->getApiUrl();
		$value = ' ' . $this->data()->main->temp . '°C ' . $this->data()->weather[0]->description;

		return $this->printValue( $key, $value, $label );
	}

	/**
	 * @return string
	 */
	public function getApiUrl(): string {


		return sprintf( $this->apiUrl, $this->city, $this->key, $this->lang );
	}

	/**
	 * @param string $apiUrl
	 *
	 * @return Api
	 */
	public function setApiUrl( string $apiUrl ) {
		$this->apiUrl = $apiUrl;

		return $this;
	}


}