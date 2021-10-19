# WordPress HTTP

WordPress HTTP library.

## Usage

```php
$response = Http::request( $url, $args );

$data = $response->json();
```

## Testing

### Faking Responses

```php
$url = 'https://www.pronamic.nl/wp-json/wp/v2/types/post';

Http::fake( $url, __DIR__ . '/../http/pronamic-nl-wp-json-types-post.http' );

$response = \wp_remote_get( $url );

// or

$response = Http::get( $url );
```

### PHPUnit

```php
<?php

namespace YourNamespace;

use Pronamic\WordPress\Http\Factory;

class YourTest extends \WP_UnitTestCase {
	/**
	 * Setup.
	 */
	public function setUp() {
		parent::setUp();

		$this->factory = new Factory();
	}

	/**
	 * Test request.
	 */
	public function test_request() {
		$this->factory->fake( 'http://example.com/', __DIR__ . '/../http/example-com.http' );

		$result = \wp_remote_get( 'http://example.com/' );

		// asserts
	}
}

```

### CR LF

To store fake HTTP responses in `*.http` files and Git, keep the following in mind:

> HTTP/1.1 defines the sequence CR LF as the end-of-line marker for all protocol elements

https://tools.ietf.org/html/rfc2616#section-2.2

**`.gitattributes`**

```
*.http text eol=crlf
```

You can use a tool like `unix2dos` to convert the line endings to CR LF:

```
unix2dos *.http
```

If the line endings are not correct this can result in the following error:

```
Undefined offset: 2

wordpress/wp-includes/class-http.php:732
src/Factory.php:97
wordpress/wp-includes/class-wp-hook.php:292
wordpress/wp-includes/plugin.php:212
wordpress/wp-includes/class-http.php:257
wordpress/wp-includes/class-http.php:626
wordpress/wp-includes/http.php:162
src/Facades/Http.php:71
```

## Inspiration

- https://github.com/WordPress/WordPress/blob/5.7/wp-includes/class-http.php
- https://www.php-fig.org/psr/psr-7/
- https://github.com/guzzle/psr7
- https://github.com/jdgrimes/wp-http-testcase
- https://docs.guzzlephp.org/en/stable/testing.html
- https://github.com/guzzle/guzzle
- https://github.com/namshi/cuzzle
- https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html
- https://laravel.com/docs/8.x/http-client#faking-responses
- https://www.php-fig.org/psr/psr-18/

[![Pronamic - Work with us](https://github.com/pronamic/brand-resources/blob/main/banners/pronamic-work-with-us-leaderboard-728x90%404x.png)](https://www.pronamic.eu/contact/)
