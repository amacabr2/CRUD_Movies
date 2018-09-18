<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 18/09/2018
 * Time: 15:54
 */

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends ApiController {

    /**
     * @Route("/movies", methods="GET")
     *
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(MovieRepository $movieRepository) {
        if (!$this->isAuthorized()) {
            return $this->respondWithUnauthorized();
        }

        $movies = $movieRepository->transformAll();
        return $this->respond($movies);
    }

    /**
     * @Route("/movies/{id}", methods="GET")
     *
     * @param int $id
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id, MovieRepository $movieRepository) {
        if (!$this->isAuthorized()) {
            return $this->respondWithUnauthorized();
        }

        $movie = $movieRepository->find($id);
        if (!$movie) {
            return $this->respondNotFound();
        }
        $movie = $movieRepository->transform($movie);
        return $this->respond($movie);
    }

    /**
     * @Route("/movies", methods="POST")
     *
     * @param Request $request
     * @param MovieRepository $movieRepository
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManager) {
        if (!$this->isAuthorized()) {
            return $this->respondWithUnauthorized();
        }

        $request = $this->transformJsonBody($request);
        if (!$request) {
            return $this->respondValidationError("Please provide a valid request");
        }

        if (!$request->get('title')) {
            return $this->respondValidationError('Please provide a title');
        }

        $movie = new Movie();
        $movie->setTitle($request->get('title'));
        $movie->setCount(0);
        $entityManager->persist($movie);
        $entityManager->flush();
        return $this->respondCreated($movieRepository->transform($movie));
    }

    /**
     * @Route("/movies/{id}/count", methods="GET")
     *
     * @param $id
     * @param EntityManagerInterface $em
     * @param MovieRepository $movieRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function increaseCount($id, EntityManagerInterface $em, MovieRepository $movieRepository) {
        if (!$this->isAuthorized()) {
            return $this->respondWithUnauthorized();
        }

        $movie = $movieRepository->find($id);
        if (! $movie) {
            return $this->respondNotFound();
        }

        $movie->setCount($movie->getCount() + 1);
        $em->persist($movie);
        $em->flush();

        return $this->respond([
            'count' => $movie->getCount()
        ]);
    }
}