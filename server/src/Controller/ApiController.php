<?php
/**
 * Created by PhpStorm.
 * User: antho
 * Date: 18/09/2018
 * Time: 15:57
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController {

    protected $statutCode = 200;

    /**
     * @return int
     */
    public function getStatutCode(): int {
        return $this->statutCode;
    }

    /**
     * @param int $statutCode
     * @return ApiController
     */
    public function setStatutCode(int $statutCode): self {
        $this->statutCode = $statutCode;
        return $this;
    }

    /**
     * @param array $data
     * @param array $headers
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []) {
        return new JsonResponse($data, $this->getStatutCode(), $headers);
    }

    /**
     * @param string $errors
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithErrors(string $errors, array $headers = []) {
        $data = ['errors' => $errors];
        return new JsonResponse($data, $this->getStatutCode(), $headers);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondWithUnauthorized(string $message = 'Not authorized') {
        return $this->setStatutCode(401)->respondWithErrors($message);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondValidationError(string $message = 'Validation errors') {
        return $this->setStatutCode(422)->respondWithErrors($message);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondNotFound(string $message = 'Not found') {
        return $this->setStatutCode(404)->respondWithErrors($message);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function respondCreated(array $data = []) {
        return $this->setStatutCode(201)->respond($data);
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool  {
        if (! isset( $_SERVER['HTTP_AUTHORIZATION'])) {
            return false;
        }

        $authType = null;
        $authData = null;

        // Extract the auth type and the data from the Authorization header.
        @list($authType, $authData) = explode(" ", $_SERVER['HTTP_AUTHORIZATION'], 2);

        // If the Authorization Header is not a bearer type, return a 401.
        if ($authType != 'Bearer') {
            return false;
        }

        // Attempt authorization with the provided token
        try {
            // Setup the JWT Verifier
            $jwtVerifier = (new \Okta\JwtVerifier\JwtVerifierBuilder())
                ->setAdaptor(new \Okta\JwtVerifier\Adaptors\SpomkyLabsJose())
                ->setAudience('api://default')
                ->setClientId('0oagauc9sdZmiDH0r0h7')
                ->setIssuer('https://dev-846151.oktapreview.com/oauth2/default')
                ->build();

            // Verify the JWT from the Authorization Header.
            $jwt = $jwtVerifier->verify($authData);
        } catch (\Exception $e) {
            // We encountered an error, return a 401.
            return false;
        }

        return true;
    }
}