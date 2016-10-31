<?php namespace App\Controller;

use App\Image\Config\Config;
use App\Image\Config\Build\BuildDirector;
use App\Image\Config\Build\StandardBuilder;
use App\Image\Config\Build\RandomisedBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Attempts to produce a response containing an image.
 */
class ImageController extends Controller
{
    /**
     * Attempt to render a square image.
     *
     * @param Request $request
     * @param int $length
     *
     * @return Response
     */
    public function renderSquare(Request $request, $length)
    {
        $director = new BuildDirector(new StandardBuilder($length, $length, $request));

        $response = $this->renderOrError($director->getResult());

        return $this->setCacheHeaders($response);
    }

    /**
     * Attempt to render a rectangular image.
     *
     * @param Request $request
     * @param int $width
     * @param int $height
     *
     * @return Response
     */
    public function renderRectangle(Request $request, $width, $height)
    {
        $director = new BuildDirector(new StandardBuilder($width, $height, $request));

        $response = $this->renderOrError($director->getResult());

        return $this->setCacheHeaders($response);
    }

    /**
     * Attempt to render a randomised image.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function renderRandom(Request $request)
    {
        $director = new BuildDirector(new RandomisedBuilder($request));

        return $this->renderOrError($director->getResult());
    }

    /**
     * Attempt to return a Response containing an image built up from a Config.
     *
     * @param Config $config
     *
     * @return Response
     */
    protected function renderOrError(Config $config)
    {
        $errors = $this->container->get('image.config.validator')->validate($config);

        if (!empty($errors)) {
            return new Response(implode($errors, '<br>'), 400);
        }

        $image = $this->container->get('image.drawer')->draw($config);

        return new Response($image->getData(), 200, [
            'Content-Type' => $image->getMimeType(),
        ]);
    }

    /**
     * Set cache headers on the Response.
     *
     * @param Response $response
     *
     * @return Response
     */
    protected function setCacheHeaders(Response $response)
    {
        $ttl = 60 * 60 * 24 * 30;

        $response->setCache([
            'public' => true,
            'max_age' => $ttl,
            's_maxage' => $ttl,
        ]);

        return $response;
    }
}
