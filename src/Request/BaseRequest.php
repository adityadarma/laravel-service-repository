<?php

namespace AdityaDarma\LaravelServiceRepository\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        if (request()->expectsJson()) {
            $errors = $validator->errors();
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Unprocessable Content',
                    'errors' => $errors
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        } else {
            $exception = $validator->getException();
            throw (new $exception($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}