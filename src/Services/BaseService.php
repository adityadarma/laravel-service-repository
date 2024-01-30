<?php

namespace AdityaDarma\LaravelServiceRepository\Services;

use AdityaDarma\LaravelServiceRepository\Exception\CustomException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BaseService
{
    private mixed $data = null;
    private ?string $message = null;
    private int $code = 200;
    private mixed $error = null;
    private mixed $meta = null;
    private mixed $link = null;

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
                'meta' => $this->meta,
                'data' => $this->data,
                'link' => $this->link,
            ]), $this->code);
    }

    /**
     * Convert to json data with resource
     *
     * @param $resource
     * @return static
     */
    public function resource($resource): static
    {
        // Simple Paginate
        if ($this->data instanceof Paginator) {
            $this->meta = [
                'per_page' => $this->data->perPage(),
                'current_page' => $this->data->currentPage(),
            ];
            $this->data =  $resource::collection($this->data->items());
        }
        // Paginate
        elseif ($this->data instanceof LengthAwarePaginator) {
            $this->meta = [
                'total' => $this->data->total(),
                'count' => $this->data->count(),
                'per_page' => $this->data->perPage(),
                'current_page' => $this->data->currentPage(),
                'total_pages' => $this->data->lastPage()
            ];
            $this->data =  $resource::collection($this->data->items());
        }
        // Cursor Paginate
        elseif ($this->data instanceof CursorPaginator) {
            $this->meta = [
                'per_page' => $this->data->perPage(),
            ];
            $this->link = [
                'prev_page_url' => $this->data->previousPageUrl(),
                'next_page_url' => $this->data->nextPageUrl(),
            ];
            $this->data =  $resource::collection($this->data->items());
        }
        elseif($this->data instanceof Collection) {
            $this->data =  $resource::collection($this->data);
        }
        elseif ($this->data instanceof Model) {
            $this->data = new $resource($this->data);
        }

        return $this;
    }

    /**
     * Hadle exception error
     *
     * @param Exception $exception
     * @param string $message
     * @return BaseService
     */
    public function exceptionResponse(Exception $exception, string $message = 'Terjadi suatu kesalahan!'): static
    {
        $code = is_int($exception->getCode()) && ($exception->getCode() >= 100 && $exception->getCode() < 600) ? $exception->getCode() : 500;

        // Default
        $this->setMessage($message)
            ->setCode($code);

        // Query Exception
        if (($exception instanceof QueryException) && $exception->errorInfo[1] === 1451) {
            $this->setMessage('Data masih terpakai di Data Lain!')
                ->setCode($code);
        }

        // Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            if (request()->expectsJson()) {
                $this->setMessage('Data tidak ditemukan!')
                    ->setCode(404);
            }

            abort(404);
        }

        // Custom exception
        if ($exception instanceof CustomException) {
            $this->setMessage($exception->getMessage())
                ->setCode($code);
        }

        // Debuging
        if (config('app.debug')) {
            $this->setMessage($exception->getMessage())
                ->setError([
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ])
                ->setCode($code);
        }

        return $this;
    }
}
