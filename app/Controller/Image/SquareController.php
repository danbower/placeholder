<?php namespace App\Controller\Image;

use App\Controller\Controller;
use App\Image\Config\Build\BuildDirector;
use App\Image\Config\Build\StandardBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Renders square placeholder images.
 */
class SquareController extends Controller
{
    /**
     * @param Request $request
     * @param int $length
     *
     * @return Response
     */
    public function render(Request $request, $length)
    {
        $director = new BuildDirector(new StandardBuilder($length, $length, $request));
        $config = $director->getResult();

        $errors = $this->container->get('image.config.validator')->validate($config);

        if (!empty($errors)) {
            return new Response(implode($errors, '<br>'), 400);
        }

        $image = $this->container->get('image.drawer')->draw($config);

        return new Response($image->getData(), 200, [
            'Content-Type' => $image->getMimeType(),
        ]);
    }
}
