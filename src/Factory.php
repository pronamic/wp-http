<?php
/**
 * Factory
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\Http;

/**
 * Factory
 *
 * @link https://stackoverflow.com/questions/3459287/whats-the-difference-between-a-mock-stub
 * @link https://github.com/wp-pay-gateways/adyen/blob/1.3.0/tests/src/ClientTest.php
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Factory {
	/**
	 * Instance.
	 *
	 * @var self|null
	 */
	protected static $instance;

	/**
	 * Fakes.
	 *
	 * @var array<string, string>
	 */
	private $fakes;

	/**
	 * Instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( \is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct factory.
	 */
	public function __construct() {
		$this->fakes = array();

		\add_filter( 'pre_http_request', array( $this, 'pre_http_request' ), 10, 3 );
	}

	/**
	 * Fake.
	 *
	 * @param string $url  URL.
	 * @param string $file File with HTTP response.
	 * @return void
	 */
	public function fake( $url, $file ) {
		$this->fakes[ $url ] = $file;
	}

	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 *
	 * @param false|array<mixed>|\WP_Error $preempt Whether to preempt an HTTP request's return value. Default false.
	 * @param array<string, string>                $r       HTTP request arguments.
	 * @param string                               $url     The request URL.
	 * @return false|array<mixed>|\WP_Error
	 */
	public function pre_http_request( $preempt, $r, $url ) {
		if ( ! \array_key_exists( $url, $this->fakes ) ) {
			return $preempt;
		}

		$file = $this->fakes[ $url ];

		unset( $this->fakes[ $url ] );

		$response = \file_get_contents( $file, true );

		if ( false === $response ) {
			throw new \Exception( \sprintf( 'Could not read fake HTTP response for URL: %s from file: %s', $url, $file ) );
		}

		$processed_response = \WP_Http::processResponse( $response );

		$processed_headers = \WP_Http::processHeaders( $processed_response['headers'], $url );

		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}
}
