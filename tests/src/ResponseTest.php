<?php
/**
 * HTTP Response Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

namespace Pronamic\WordPress\Http;

use Pronamic\WordPress\Http\Facades\Http;

/**
 * HTTP Response
 *
 * @link https://laravel.com/docs/8.x/http-client
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ResponseTest extends \WP_UnitTestCase {
	/**
	 * Test response.
	 */
	public function test_response() {
		$url = 'https://www.pronamic.nl/wp-json/wp/v2/posts';

		$response = Http::get( $url );

		$this->assertEquals( 'OK', $response->message() );
		$this->assertEquals( 200, $response->status() );
		$this->assertIsString( $response->body() );
		$this->assertIsArray( $response->json() );
	}

	/**
	 * Test exception.
	 */
	public function test_exception() {
		$url = 'https://www.pronamic-does-not-exist.nl/wp-json/wp/v2/posts';

		try {
			$response = Http::get( $url );
		} catch ( \Pronamic\WordPress\Http\Exceptions\Exception $exception ) {
			$request = $exception->get_request();

			$this->assertStringStartsWith( 'curl ', $request->as_curl() );
			$this->assertStringStartsWith( 'http ', $request->as_httpie() );
		}

		$url = 'https://www.pronamic-does-not-exist-2.nl/wp-json/wp/v2/posts';

		$this->expectException( \Pronamic\WordPress\Http\Exceptions\Exception::class );

		$response = Http::get( $url );
	}
}
