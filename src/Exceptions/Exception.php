<?php
/**
 * Exception
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

namespace Pronamic\WordPress\Http\Exceptions;

use Pronamic\WordPress\Http\Request;

/**
 * Exception
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Exception extends \Exception {
	/**
	 * Request.
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * Construct exception.
	 *
	 * @param string  $message Message.
	 * @param Request $request Request.
	 */
	public function __construct( $message, $request ) {
		parent::__construct( $message );

		$this->request = $request;
	}

	/**
	 * Get request.
	 *
	 * @return Request
	 */
	public function get_request() {
		return $this->request;
	}
}
