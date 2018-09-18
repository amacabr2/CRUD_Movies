<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 18/09/2018
 * Time: 15:54
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends ApiController {

    /**
     * @Route("/movies")
     */
    public function getMovies() {
        return $this->respond([
            'title' => 'Au hasard',
            'count' => 0
        ]);
    }
}