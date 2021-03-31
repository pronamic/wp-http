<?php
/**
 * Bootstrap tests
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Http
 */

// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_putenv
putenv( 'WP_PHPUNIT__TESTS_CONFIG=tests/wp-config.php' );

require_once __DIR__ . '/../vendor/autoload.php';

require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
