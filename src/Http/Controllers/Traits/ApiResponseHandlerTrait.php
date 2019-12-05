<?php

namespace Audentio\LaravelBase\Http\Controllers\Traits;

use Audentio\LaravelBase\LaravelBase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\MessageBag;

trait ApiResponseHandlerTrait
{
    protected function notFound($message = null)
    {
        return $this->error('not_found', $message ?: __('error.notFound'), 404);
    }

    protected function validationError($errors)
    {
        if ($errors instanceof MessageBag) {
            $errors = $errors->getMessages();
        }
        return $this->error('form_validation', $errors, 400);
    }

    protected function invalidRequest($error = null)
    {
        return $this->error('invalid_request', $error ?: __('error.invalidRequest'), 400);
    }

    protected function invalidCredentials()
    {
        return $this->error('invalid_credentials', __('auth.failed'));
    }

    protected function invalidBearerToken($message = null)
    {
        return $this->error('invalid_token', $message ?: __('error.invalidToken'), 403);
    }

    protected function accountDisabled()
    {
        return $this->error('account_disabled', __('user.errors.accountDisabled'), 403);
    }

    protected function unauthorized($message = null)
    {
        return $this->error('unauthorized', $message ?: __('error.unauthorized'), 401);
    }

    protected function success($payload, $message=null)
    {
        return $this->response(true, $payload, $message);
    }

    protected function error($error, $message, $responseCode = 500)
    {
        return $this->response(false, $error, $message, $responseCode);
    }

    protected function response($success, $payload, $message=null, $responseCode=200)
    {
        $body = [
            'success' => $success,
            'message' => $message,
        ];
        if ($success) {
            $body += [
                'payload' => $payload,
            ];
        } else {
            $body += [
                'error' => $payload,
            ];
        }

        /** @var JsonResponse $response */
        $response = Response::json($body, $responseCode);

        foreach (LaravelBase::getCorsHeaders() as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }

}