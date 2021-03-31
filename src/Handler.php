<?php
/**
 * Handler
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\Http;

/**
 * Handler
 *
 * @author  Remco Tolsma
 * @version 1.0.0
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
	public function __construct( $url, $args = array() ) {
		$this->url  = $url;
		$this->args = $args;

		$this->args['pronamic_handler'] = $this;

		\add_filter( 'http_request_args', array( $this, 'http_request_args' ), 1000 );
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

		unset( $parsed_args['pronamic_handler'] );

		\remove_filter( 'http_request_args', array( $this, 'http_request_args' ), 1000 );

		$this->parsed_args = $parsed_args;

		return $parsed_args;
	}
}
