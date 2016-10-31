<?php namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $response = new Response();
        $viewFile = __DIR__ . '/../../resources/views/index.html';
        $response->setETag(filemtime($viewFile));

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render($response, $viewFile);
    }

    /**
     * @param Response $response
     * @param string $view
     *
     * @return Response
     */
    protected function render(Response $response, $view)
    {
        ob_start();
        require($view);
        $response->setContent(ob_get_clean());
        ob_end_clean();

        $ttl = 60 * 60 * 24;
        $response->setCache([
            'public' => true,
            'max_age' => $ttl,
            's_maxage' => $ttl,
        ]);

        return $response;
    }
}
