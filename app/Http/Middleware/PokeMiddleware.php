<?php

namespace App\Http\Middleware;

use App\View\Components\Poke;
use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Illuminate\Http\Request;
use function csrf_field;
use Illuminate\Support\Facades\Blade;
use function strpos;
use function substr_replace;
use Symfony\Component\HttpFoundation\Response;

class PokeMiddleware extends Middleware
{


    /**
     * @param string $mode
     */
    public function __construct(protected string $mode)
    {
        //
    }


    /**
     * @param $request
     * @param Closure $next
     * @param string|null $force
     * @return mixed
     */
    public function handle($request, Closure $next, string $force = null): mixed
    {
        $response = $next($request);

        if ($this->shouldInject($request, $response, $force === 'force')) {
            $this->injectScript($response);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param bool $force
     * @return bool
     */
    public function shouldInject(Request $request, Response $response, bool $force): bool
    {
        // Don't render on blade, not successful or non HTML responses.
        if ($this->mode === 'blade' || !$response->isSuccessful() || !$request->acceptsHtml()) {
            return false;
        }

        // The "auto" mode means to globally check if this is injectable.
        if ($this->mode === 'auto') {
            return $this->hasCsrfInput($response);
        }

        // Otherwise, the mode is "middleware": signal a forceful injection or CSRF input.
        return $force || $this->hasCsrfInput($response);
    }

    /**
     * @param Response $response
     * @return bool
     */
    protected function hasCsrfInput(Response $response): bool
    {
        return strpos($response->content(), csrf_field());
    }


    /**
     * @param Response $response
     * @return void
     */
    protected function injectScript(Response $response): void
    {
        $content = $response->content();

        // With an offset of just 32 characters, we'll speed up the lookup
        // since the ending `</body>` tag can be found at the end of the
        // response. Usually the tag is not far from the response end.
        $endBodyPosition = strpos($content, '</body>', -32);

        // To inject the script automatically, we will do it before the ending
        // body tag. If it's not found, the response may not be valid HTML,
        // so we will bail out returning the original untouched content.
        if ($endBodyPosition) {
            $response->setContent(
                substr_replace($content, Blade::renderComponent(new Poke(true)), $endBodyPosition, 0)
            );
        }
    }
}
