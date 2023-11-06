<?php

namespace App\Services;

use AdityaDarma\LaravelServiceRepository\Exception\CustomException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class BaseService
{
    private mixed $data = null;
    private ?string $message = null;
    private int $code = 200;
    private mixed $error = null;

    /**
     * Set data on service
     *
     * @param $data
     * @return static
     */
    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data on service
     *
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Set message on service
     *
     * @param string $message
     * @return static
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message on service
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set code on service
     *
     * @param integer $code
     * @return static
     */
    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code on service
     *
     * @return integer
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set error on service
     *
     * @param $error
     * @return static
     */
    public function setError($error): static
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error on service
     *
     * @return mixed
     */
    public function getError(): mixed
    {
        return $this->error;
    }

    /**
     * Convert to json data
     *
     * @return JsonResponse
     */
    public function toJson(): JsonResponse
    {
        return response()->json(
            array_filter([
                'message' => $this->message,
                'errors' => $this->error,
                'data' => $this->data,
            ]), $this->code);
    }

    /**
     * Convert to json data with resource
     *
     * @param $resource
     * @return JsonResponse
     */
    public function toResource($resource): JsonResponse
    {
        if($this->data instanceof Collection) {
            $this->data =  $resource::collection($this->data);
        }elseif ($this->data instanceof Model) {
            $this->data = new $resource($this->data);
        }

        return $this->toJson();
    }

    /**
     * Hadle exception error
     *
     * @param Exception $exception
     * @param string $message
     * @return BaseService
     */
    public function exceptionResponse(Exception $exception, string $message = 'Terjadi suatu kesalahan!'): BaseService
    {
        // Query Exception
        if ($exception instanceof QueryException) {
            if ($exception->errorInfo[1] == 1451) {
                $this->setMessage('Data masih terpakai di Data Lain!')
                    ->setCode($exception->getCode());
            }
        }

        // Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            if (request()->expectsJson()) {
                $this->setMessage('Data tidak ditemukan!')
                    ->setCode(404);
            }

            abort(404);
        }

        // Model Not Found
        if ($exception instanceof CustomException) {
            $message = $exception->getMessage();
        }

        // Debuging
        if (config('app.debug')) {
            $this->setMessage($exception->getMessage())
                ->setError([
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ])
                ->setCode($exception->getCode());
        }

        // Default
        $this->setMessage($message)
            ->setCode($exception->getCode());

        return $this;
    }
}
