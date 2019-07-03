<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

namespace ChileanIndicator\Api;

class Api {
	public $apiUrl = 'http://indicadoresdeldia.cl/webservice/indicadores.json';
	public $data = null;
	public $expire = 0;
	public $instance;

	public function __construct( ) {

	}

	/**
	 * @return string
	 */
	public function getApiUrl(): string {
		return $this->apiUrl;
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

	/**
	 * @return int
	 */
	public function getExpire(): int {
		return $this->expire;
	}

	/**
	 * @param int $expire
	 *
	 * @return Api
	 */
	public function setExpire( int $expire ): Api {
		$this->expire = $expire;

		return $this;
	}



	public function fetch() {
		if ( $cache = wp_cache_get( $key = $this->getCacheKey(), $group = get_class( $this ) ) ) {
			return $cache;
		} else {
			$cache = json_decode( $this->sync( $this->getApiUrl() ) );
			wp_cache_set( $key, $cache, $group, $this->expire );

			return $cache;
		}

	}

	public function getCacheKey( $sufix = '' ) {

		$json = json_encode( $this->instance );

		return md5( $json );
	}


	/**
	 * @return string
	 */
	public function sync( $apiUrl = false ) {
		$apiUrl = $apiUrl ?: $this->apiUrl;
		if ( ! $apiUrl ) {
			return '';
		}
		try {
			if ( ini_get( 'allow_url_fopen' ) ) {
				$json = file_get_contents( $apiUrl );
			} else {
				// De otra forma utilizamos cURL
				$curl = curl_init( $apiUrl );
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$json = curl_exec( $curl );
				curl_close( $curl );
			}
		} catch ( Exception $e ) {
			return '';
		}

		return $json;
	}

	public function data() {
		if ( ! $this->data ) {
			$this->data = $this->fetch();
		}

		return $this->data;
	}



	/**
	 * @param string $key
	 * @param int    $value
	 * @param string $label
	 *
	 * @return string
	 */
	public function printValue( $key, $value, $label = null ) {

		return sprintf( "<li class=\"%s\"><span class=\"unit\">%s</span> %s</li>", $key, $label, $value );
	}


}