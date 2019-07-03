<?php
/**
 * Created by PhpStorm.
 * User: carlosherrera
 * Date: 17/11/17
 * Time: 12:04 PM
 */

namespace ChileanIndicator\Api;

class ApiFinancial extends Api {
	public $apiUrl = 'http://api.sbif.cl/api-sbifv3/recursos_api/[recurso]?apikey=[apikey]&formato=json';
	public $expire = 86400;


	public function printUF() {
		$key   = 'uf';
		$label = 'uf';
		$value = $this->data()->uf;

		return $this->printValue( $key, $value, $label );
	}

	/**
	 * @param string $key
	 * @param int    $value
	 * @param string $label
	 *
	 * @return string
	 */
	protected function printValue( $key, $value, $label = null ) {

		return sprintf( "<li class=\"%s\"><span class=\"unit\">%s</span> $ %s</li>", $key, $label, number_format( $value, 2, ',', '.' ) );
	}

	public function printDollar() {
		$key   = 'dolar';
		$label = 'Dolar OBS.';
		$value = $this->data()->dolar;

		return $this->printValue( $key, $value, $label );

	}


	public function sync( $apiUrl = false ) {
		if ( $mindicador = parent::sync( 'https://mindicador.cl/api' ) ) {
			$mindicador = json_decode( $mindicador );
			$uf         = $mindicador->uf->valor;
			$dolar      = $mindicador->dolar->valor;
		} else {
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

		return json_encode( [ 'uf' => $uf, 'dolar' => $dolar ] );
	}

	public function getCacheKey( $sufix = '' ) {
		return 'financial_indicators' . $sufix;
	}

}