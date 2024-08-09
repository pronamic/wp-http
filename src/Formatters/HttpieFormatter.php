<?php
/**
 * HTTPie formatter.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

namespace Pronamic\WordPress\Http\Formatters;

use Pronamic\WordPress\Http\Request;

/**
 * HTTPie formatter.
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class HttpieFormatter {
	/**
	 * Format request.
	 *
	 * @param Request $request Request.
	 * @return string
	 */
	public function format( Request $request ) {
		$command = 'http ' . $request->method() . ' ' . $request->url();

		foreach ( $request->headers() as $key => $value ) {
			$command .= \sprintf( ' %s:%s', $key, \escapeshellarg( $value ) );
		}

		$args = $request->args();

		if ( \array_key_exists( 'user-agent', $args ) && \is_string( $args['user-agent'] ) ) {
			$command .= \sprintf( ' User-Agent:%s', \escapeshellarg( $args['user-agent'] ) );
		}

		/**
		 * Body.
		 *
		 * @link https://github.com/httpie/httpie/issues/356
		 * @link https://github.com/httpie/httpie#redirected-input
		 */
		if ( \array_key_exists( 'body', $args ) && \is_string( $args['body'] ) ) {
			$command = \sprintf(
				'echo %s | %s',
				\escapeshellarg( $args['body'] ),
				$command
			);
		}

		return $command;
	}
}
