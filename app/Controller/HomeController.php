<?php namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return new Response('home');
    }
}
