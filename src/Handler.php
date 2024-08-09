<?php
/**
 * Handler
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

namespace Pronamic\WordPress\Http;

/**
 * Handler
 *
 * @author  Remco Tolsma
 * @version 1.0.1
 * @since   1.0.0
 */
class Handler {
	/**
	 * URL.
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Arguments.
	 *
	 * @var array<string, mixed>
	 */
	private $args;

	/**
	 * Parsed arguments.
	 *
	 * @var null|array<string, mixed>
	 */
	private $parsed_args;

	/**
	 * Construct handler.
	 *
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 */
	public function __construct( $url, $args = [] ) {
		$this->url  = $url;
		$this->args = $args;

		$this->args['pronamic_handler'] = $this;

		\add_filter( 'http_request_args', [ $this, 'http_request_args' ], 1000 );
	}

	/**
	 * Destruct.
	 *
	 * @link https://www.php.net/manual/en/language.oop5.decon.php
	 * @since 1.0.1
	 */
	public function __destruct() {
		\remove_filter( 'http_request_args', [ $this, 'http_request_args' ], 1000 );
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
	 * Method.
	 *
	 * @return string
	 */
	public function method() {
		$args = $this->args();

		if ( ! \array_key_exists( 'method', $args ) ) {
			return 'GET';
		}

		if ( ! \is_string( $args['method'] ) ) {
			return 'GET';
		}

		return $args['method'];
	}

	/**
	 * Arguments.
	 *
	 * @return array<string, mixed>
	 */
	public function args() {
		return null === $this->parsed_args ? $this->args : $this->parsed_args;
	}

	/**
	 * HTTP request arguments filter.
	 *
	 * In version `1.0.0` we removed the filter `http_request_args` in this filter callback:
	 * `\remove_filter( 'http_request_args', array( $this, 'http_request_args' ), 1000 );`
	 * This resulted in `500` errors if the Query Monitor plugin was activated, probably
	 * due to the HTTP log functionality of this plugin. Therefore, we moved the removal
	 * of this filter to the `__destruct()` function, this also ties in well with adding
	 * the filter in the `__construct()` function.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/5.7/wp-includes/class-http.php#L408-L419
	 * @link https://github.com/johnbillion/query-monitor/blob/3.6.8/collectors/http.php
	 *
	 * @param array<string, mixed> $parsed_args Parsed arguments.
	 * @return array<string, mixed>
	 */
	public function http_request_args( $parsed_args ) {
		if ( ! \array_key_exists( 'pronamic_handler', $parsed_args ) ) {
			return $parsed_args;
		}

		if ( $this !== $parsed_args['pronamic_handler'] ) {
			return $parsed_args;
		}

		$this->parsed_args = $parsed_args;

		return $parsed_args;
	}
}
