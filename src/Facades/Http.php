<?php
/**
 * HTTP
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\Http\Facades;

use Pronamic\WordPress\Http\Request;
use Pronamic\WordPress\Http\Response;
use Pronamic\WordPress\Http\Factory;
use Pronamic\WordPress\Http\Handler;
use WP_Error;

/**
 * HTTP
 *
 * @link https://laravel.com/docs/8.x/http-client
 * @link https://github.com/laravel/framework/blob/8.x/src/Illuminate/Support/Facades/Http.php
 * @author  Remco Tolsma
 * @version 2.5.0
 * @since   2.5.0
 */
class Http {
	/**
	 * Result.
	 *
	 * @param array|WP_Error $result  Remote request result.
	 * @param string         $handler Handler.
	 * @return Response
	 * @throws \Pronamic\WordPress\Http\Exceptions\Exception Throw exception on request error.
	 */
	private static function result( $result, $handler ) {
		if ( $result instanceof \WP_Error ) {
			throw new \Pronamic\WordPress\Http\Exceptions\Exception( $result->get_error_message(), new Request( $handler->method(), $handler->url(), $handler->args() ) );
		}

		return new Response( $result );
	}

	/**
	 * Call the WordPress API.
	 *
	 * @param string $function Function.
	 * @param string $url      URL.
	 * @param array  $args      Arguments.
	 * @return Response
	 */
	private static function wp( $function, $url, $args ) {
		$handler = new Handler( $url, $args );

		$parsed_args = wp_parse_args(
			$args,
			array(
				'pronamic_handler' => $handler,
			)
		);

		$result = self::result( $function( $url, $parsed_args ), $handler );

		return $result;
	}

	/**
	 * Request.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_request/
	 * @link https://github.com/WordPress/WordPress/blob/5.7/wp-includes/class-http.php
	 * @param string $url  URL.
	 * @param array  $args Arguments.
	 * @return Response
	 */
	public static function request( $url, $args = array() ) {
		return self::wp( '\wp_remote_request', $url, $args );
	}

	/**
	 * GET.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_get/
	 * @param string $url  URL.
	 * @param array  $args Arguments.
	 * @return Response
	 */
	public static function get( $url, $args = array() ) {
		return self::wp( '\wp_remote_get', $url, $args );
	}

	/**
	 * POST.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_post/
	 * @param string $url  URL.
	 * @param array  $args Arguments.
	 * @return Response
	 */
	public static function post( $url, $args = array() ) {
		return self::wp( '\wp_remote_post', $url, $args );
	}

	/**
	 * HEAD.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_head/
	 * @param string $url  URL.
	 * @param array  $args Arguments.
	 * @return Response
	 */
	public static function head( $url, $args = array() ) {
		return self::wp( '\wp_remote_head', $url, $args );
	}

	/**
	 * Fake.
	 *
	 * @param string $url  URL.
	 * @param string $file File with HTTP response.
	 */
	public static function fake( $url, $file ) {
		$factory = Factory::instance();

		$factory->fake( $url, $file );
	}
}
