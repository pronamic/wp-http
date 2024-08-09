<?php
/**
 * CURL formatter.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

namespace Pronamic\WordPress\Http\Formatters;

use Pronamic\WordPress\Http\Request;

/**
 * CURL formatter.
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class CurlFormatter {
	/**
	 * Format.
	 *
	 * @param Request $request Request.
	 * @return string
	 */
	public function format( Request $request ) {
		$tab = "\t";
		$eol = ' \\' . \PHP_EOL;

		$command = \sprintf( 'curl --request %s %s', $request->method(), \escapeshellarg( $request->url() ) ) . $eol;

		foreach ( $request->headers() as $key => $value ) {
			$command .= $tab . \sprintf( '--header %s', \escapeshellarg( \sprintf( '%s: %s', $key, $value ) ) ) . $eol;
		}

		$args = $request->args();

		if ( \array_key_exists( 'user-agent', $args ) && \is_string( $args['user-agent'] ) ) {
			$command .= $tab . \sprintf( '--user-agent %s', \escapeshellarg( $args['user-agent'] ) ) . $eol;
		}

		if ( \array_key_exists( 'body', $args ) && \is_string( $args['body'] ) ) {
			$command .= $tab . \sprintf( '--data %s', \escapeshellarg( $args['body'] ) ) . $eol;
		}

		$command .= $tab . '--verbose';

		return $command;
	}
}
