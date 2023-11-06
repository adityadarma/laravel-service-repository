<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

trait JsonValidateResponse
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
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
