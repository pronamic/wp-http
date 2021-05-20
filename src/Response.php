<?php
/**
 * HTTP Response
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\Http;

/**
 * HTTP Response
 *
 * @link https://laravel.com/docs/8.x/http-client
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Response {
	/**
	 * Remote request response array.
	 *
	 * @var array<string, mixed>
	 */
	private $array;

	/**
	 * Construct response array.
	 *
	 * @param array<string, mixed> $array WordPress remote request response array.
	 */
	public function __construct( $array ) {
		$this->array = $array;
	}

	/**
	 * Status.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_retrieve_response_code/
	 * @return int|string
	 */
	public function status() {
		return \wp_remote_retrieve_response_code( $this->array );
	}

	/**
	 * Message.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_retrieve_response_message/
	 * @return string
	 */
	public function message() {
		return \wp_remote_retrieve_response_message( $this->array );
	}

	/**
	 * Body.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_retrieve_body/
	 * @return string
	 */
	public function body() {
		return \wp_remote_retrieve_body( $this->array );
	}

	/**
	 * JSON.
	 *
	 * @return mixed
	 * @throws \Exception Throw exception on empty response.
	 */
	public function json() {
		$body = $this->body();

		/**
		 * On PHP 7 or higher the `json_decode` function will return `null` and
		 * `json_last_error` will return `4` (Syntax error). On PHP 5.6 or lower
		 * the `json_decode` will also return `null`, but json_last_error` will
		 * return `0` (No error). Therefore we check if the HTTP response body
		 * is an empty string.
		 *
		 * @link https://3v4l.org/
		 */
		if ( '' === $body ) {
			throw new \Exception(
				\sprintf(
					'Response is empty, HTTP response: "%s %s".',
					\wp_remote_retrieve_response_code( $this->array ),
					\wp_remote_retrieve_response_message( $this->array )
				)
			);
		}

		// JSON.
		$data = \json_decode( $body );

		// JSON error.
		$json_error = \json_last_error();

		if ( \JSON_ERROR_NONE !== $json_error ) {
			throw new \Exception(
				\sprintf(
					'Could not JSON decode response, HTTP response: "%s %s", HTTP body length: "%d", JSON error: "%s".',
					\wp_remote_retrieve_response_code( $this->array ),
					\wp_remote_retrieve_response_message( $this->array ),
					\strlen( $body ),
					\json_last_error_msg()
				),
				$json_error
			);
		}

		return $data;
	}

	/**
	 * SimpleXML.
	 *
	 * @link https://www.php.net/simplexml
	 * @link https://github.com/wp-pay/core/blob/f5fdc22e6a39071e8f057669b802178515ce3d25/src/Core/Util.php#L68-L118
	 * @since 1.1.0
	 * @return \SimpleXMLElement
	 * @throws \InvalidArgumentException If string could not be loaded in to a SimpleXMLElement object.
	 */
	public function simplexml() {
		$body = $this->body();

		// Suppress all XML errors.
		$use_errors = \libxml_use_internal_errors( true );

		// Load.
		$xml = \simplexml_load_string( $body );

		// Check result.
		if ( false !== $xml ) {
			// Set back to previous value.
			\libxml_use_internal_errors( $use_errors );

			return $xml;
		}

		// Error message.
		$messages = array(
			__( 'Could not load the XML string.', 'pronamic_ideal' ),
		);

		foreach ( \libxml_get_errors() as $error ) {
			$messages[] = \sprintf(
				'%s on line: %s, column: %s',
				$error->message,
				$error->line,
				$error->column
			);
		}

		// Clear errors.
		\libxml_clear_errors();

		// Set back to previous value.
		\libxml_use_internal_errors( $use_errors );

		// Throw exception.
		$message = \implode( \PHP_EOL, $messages );

		throw new \InvalidArgumentException( $message );
	}

	/**
	 * Get array.
	 *
	 * @return array<string, mixed>
	 */
	public function get_array() {
		return $this->array;
	}

	/**
	 * From file.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L417-L431
	 * @link https://github.com/WordPress/WordPress/blob/3.9.1/wp-includes/class-http.php#L433-L500
	 * @param string $file File.
	 * @return array<string, mixed>
	 * @throws \Exception Throws exceptions when reading file contents fails.
	 */
	public static function array_from_file( $file ) {
		$response = \file_get_contents( $file, true );

		if ( false === $response ) {
			throw new \Exception( \sprintf( 'Could not load HTTP response from file: %s', $file ) );
		}

		$processed_response = \WP_Http::processResponse( $response );

		$processed_headers = \WP_Http::processHeaders( $processed_response['headers'] );

		$processed_headers['body'] = $processed_response['body'];

		return $processed_headers;
	}
}
