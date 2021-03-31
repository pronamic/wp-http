<?php
/**
 * HTTPie formatter.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
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
	 * @return string
	 */
	public function format( Request $request ) {
		$command = 'http ' . $request->method() . ' ' . $request->url();

		foreach ( $request->headers() as $key => $value ) {
			$command = ' ' . $key . ':' . $value;
		}

		$args = $request->args();

		if ( \array_key_exists( 'user-agent', $args ) ) {
			$command .= ' User-Agent:' . $args['user-agent'];
		}

		return $command;
	}
}
