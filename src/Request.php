<?php
/**
 * HTTP Request
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\Http;

/**
 * HTTP Request
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Request {
	/**
	 * Method.
	 *
	 * @var string
	 */
	private $method;

	/**
	 * URL to retrieve.
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Request arguments.
	 *
	 * @var array
	 */
	private $args;

	/**
	 * Construct request.
	 *
	 * @param string $method Method.
	 * @param string $url    URL.
	 * @param array  $args   Arguments.
	 */
	public function __construct( $method, $url, $args = array() ) {
		$this->method = $method;
		$this->url    = $url;
		$this->args   = $args;
	}

	/**
	 * Method.
	 *
	 * @return string
	 */
	public function method() {
		return $this->method;
	}

	/**
	 * URL.
	 *
	 * @return string
	 */
	public function url() {
		return $this->url;
	}

	/**
	 * Arguments
	 *
	 * @return array
	 */
	public function args() {
		return $this->args;
	}

	/**
	 * Headers.
	 *
	 * @return array
	 */
	public function headers() {
		if ( ! \array_key_exists( 'headers', $this->args ) ) {
			return array();
		}

		if ( ! \is_array( $this->args['headers'] ) ) {
			return array();
		}

		return $this->args['headers'];
	}

	/**
	 * As cURL.
	 *
	 * @link https://github.com/wp-pay-gateways/omnikassa-2/blob/2.3.1/src/Client.php#L172-L195
	 * @return string
	 */
	public function as_curl() {
		$formatter = new Formatters\CurlFormatter();

		return $formatter->format( $this );
	}

	/**
	 * AS HTTPie.
	 *
	 * @link https://httpie.io/
	 * @return string
	 */
	public function as_httpie() {
		$formatter = new Formatters\HttpieFormatter();

		return $formatter->format( $this );
	}
}
