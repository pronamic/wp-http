<?php
/**
 * HTTP Request
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
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
	 * @var array<string, mixed>
	 */
	private $args;

	/**
	 * Construct request.
	 *
	 * @param string               $method Method.
	 * @param string               $url    URL.
	 * @param array<string, mixed> $args   Arguments.
	 */
	public function __construct( $method, $url, array $args = [] ) {
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
	 * @return array<string, mixed>
	 */
	public function args() {
		return $this->args;
	}

	/**
	 * Headers.
	 *
	 * @return array<string, string>
	 */
	public function headers() {
		if ( ! \array_key_exists( 'headers', $this->args ) ) {
			return [];
		}

		if ( ! \is_array( $this->args['headers'] ) ) {
			return [];
		}

		return $this->args['headers'];
	}

	/**
	 * Body.
	 *
	 * @return mixed
	 */
	public function body() {
		if ( \array_key_exists( 'body', $this->args ) ) {
			return $this->args['body'];
		}

		return null;
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

	/**
	 * Create request object from WordPress request arguments array.
	 *
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 * @return self
	 */
	public static function from_args( $url, $args ) {
		$method = 'GET';

		if ( \array_key_exists( 'method', $args ) && \is_string( $args['method'] ) ) {
			$method = $args['method'];
		}

		return new self( $method, $url, $args );
	}
}
