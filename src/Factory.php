<?php
/**
 * Factory
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
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
	 * @var array<callable>
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
		$this->fakes = [];

		\add_filter( 'pre_http_request', [ $this, 'pre_http_request' ], 10, 3 );
	}

	/**
	 * Fake.
	 *
	 * @link https://laravel.com/docs/8.x/http-client#faking-responses
	 * @link https://github.com/laravel/framework/blob/8.x/src/Illuminate/Support/Facades/Http.php#L9
	 * @link https://github.com/laravel/framework/blob/8.x/src/Illuminate/Http/Client/Factory.php#L121-L154
	 * @param string          $url      URL.
	 * @param string|callable $callback Callback.
	 * @return void
	 */
	public function fake( $url, $callback ) {
		if ( \is_string( $callback ) ) {
			$callback =
			/**
			 * Resposne from file.
			 *
			 * @param Request $request Request.
			 * @return array<string, mixed>
			 */
			// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
			function ( Request $request ) use ( $callback ) {
				return Response::array_from_file( $callback );
			};
		}

		$this->fakes[ $url ] = $callback;
	}

	/**
	 * Pre HTTP request
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L150-L164
	 *
	 * @param false|array<mixed>|\WP_Error $preempt Whether to preempt an HTTP request's return value. Default false.
	 * @param array<string, string>        $r       HTTP request arguments.
	 * @param string                       $url     The request URL.
	 * @return false|array<mixed>|\WP_Error
	 */
	public function pre_http_request( $preempt, $r, $url ) {
		if ( ! \array_key_exists( $url, $this->fakes ) ) {
			return $preempt;
		}

		$request = Request::from_args( $url, $r );

		$callback = $this->fakes[ $url ];

		return $callback( $request );
	}
}
