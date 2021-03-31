# WordPress HTTP

WordPress HTTP library.

## Usage

```php
$response = Http::request( $url, $args );

$data = $response->json();
```

## Testing

### Faking Responses

*.gitattributes*

```
*.http text eol=crlf
```

```
unix2dos *.http
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
