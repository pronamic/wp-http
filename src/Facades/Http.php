<?php
/**
 * HTTP
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
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
 * @version 1.0.0
 * @since   1.0.0
 */
class Http {
	/**
	 * Result.
	 *
	 * @param array<string, mixed>|WP_Error $result  Remote request result.
	 * @param Handler                       $handler Handler.
	 * @return Response
	 * @throws \Pronamic\WordPress\Http\Exceptions\Exception Throw exception on request error.
	 */
	private static function result( $result, $handler ) {
		if ( $result instanceof \WP_Error ) {
			$exception = new \Pronamic\WordPress\Http\Exceptions\Exception(
				\esc_html( $result->get_error_message() ),
				new Request( $handler->method(), $handler->url(), $handler->args() )
			);

			throw $exception;
		}

		return new Response( $result );
	}

	/**
	 * Request.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_request/
	 * @link https://github.com/WordPress/WordPress/blob/5.7/wp-includes/class-http.php
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 * @return Response
	 */
	public static function request( $url, $args = [] ) {
		$handler = new Handler( $url, $args );

		return self::result( \wp_remote_request( $handler->url(), $handler->args() ), $handler );
	}

	/**
	 * GET.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_get/
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 * @return Response
	 */
	public static function get( $url, $args = [] ) {
		$handler = new Handler( $url, $args );

		return self::result( \wp_remote_get( $handler->url(), $handler->args() ), $handler );
	}

	/**
	 * POST.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_post/
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 * @return Response
	 */
	public static function post( $url, $args = [] ) {
		$handler = new Handler( $url, $args );

		return self::result( \wp_remote_post( $handler->url(), $handler->args() ), $handler );
	}

	/**
	 * HEAD.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_head/
	 * @param string               $url  URL.
	 * @param array<string, mixed> $args Arguments.
	 * @return Response
	 */
	public static function head( $url, $args = [] ) {
		$handler = new Handler( $url, $args );

		return self::result( \wp_remote_head( $handler->url(), $handler->args() ), $handler );
	}

	/**
	 * Fake.
	 *
	 * @param string $url  URL.
	 * @param string $file File with HTTP response.
	 * @return void
	 */
	public static function fake( $url, $file ) {
		$factory = Factory::instance();

		$factory->fake( $url, $file );
	}
}
