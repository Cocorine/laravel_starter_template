<?php

namespace App\Traits\Helpers;

use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ExceptionTrait
{

    public function apiExceptions($request, $e)
    {

        if ($this->isModel($e)) {
            return $this->ModelResponse($e);
        }


        if ($this->notAllowed($e)) {
            return $this->NotAllowedResponse($e);
        }

        if ($this->isHttp($e)) {
            return $this->HttpResponse($e);
        }

        if ($this->isAuthentication($e)) {
            return $this->AuthenticationResponse($e);
        }

        if ($this->isValidation($e, $request)) {
            return $this->ValidationResponse($e, $request);
        }

        if ($this->isTokenMismatch($e)) {
            return $this->TokenMismatchResponse($e);
        }

        if ($this->isError($e)) {
            return $this->ErrorResponse($e);
        }
    }

    protected function isError($e)
    {
        return $e instanceof ErrorException;
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function isAuthentication($e)
    {
        return $e instanceof AuthenticationException;
    }

    protected function isValidation($e)
    {
        return $e instanceof ValidationException;
    }

    protected function isTokenMismatch($e)
    {
        return $e instanceof TokenMismatchException;
    }

    protected function notAllowed($e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    protected function ModelResponse($e)
    {

        return response()->json(['status' => 'error', 'message' => 'Aucun résultat trouvé pour ', 'errors' => []], Response::HTTP_NOT_FOUND);

    }

    protected function NotAllowedResponse($e)
    {
        return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'errors' => []],  Response::HTTP_METHOD_NOT_ALLOWED);
    }

    protected function ErrorResponse($e)
    {
        return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'errors' => []],  Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function HttpResponse($e)
    {
        return response()->json(['status' => 'error', 'message' => "Route inconnue", 'errors' => []],  Response::HTTP_NOT_FOUND);
    }

    protected function AuthenticationResponse($e)
    {
        return response()->json(['status' => 'error', 'message' => "Vous n'êtes plus connecté", 'errors' => []],  Response::HTTP_UNAUTHORIZED);
    }

    protected function ValidationResponse($e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return response()->json(['status' => 'error', 'message' => $errors, 'errors' => []],  Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function TokenMismatchResponse($e)
    {

        $errors = $e->validator->errors()->getMessages();
        return response()->json(['status' => 'error', 'message' => 'Mauvaise http request méthode', 'errors' => []], 419);
    }
}
