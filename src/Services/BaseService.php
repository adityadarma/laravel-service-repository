<?php

namespace App\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    private $data = null;
	private $message = null;
	private int $code = 200;
	private $error = null;

	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setCode($code)
	{
		$this->code = $code;

		return $this;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setError($error)
	{
		$this->error = $error;

		return $this;
	}

	public function getError()
	{
		return $this->error;
	}

    public function toJson()
    {
        return response()->json(
            array_filter([
                'message' => $this->message,
                'errors' => $this->error,
                'data' => $this->data,
            ]), $this->code);
    }

    public function toResource($resource)
    {
        if($this->data instanceof Collection) {
            $this->data =  $resource::collection($this->data);
        }elseif ($this->data instanceof Model) {
            $this->data = new $resource($this->data);
        }

        return $this->toJson();
    }

    public function exceptionResponse(Exception $exception, $message = 'Terjadi suatu kesalahan!')
    {
        // Query Exception
        if ($exception instanceof QueryException) {
            if ($exception->errorInfo[1] == 1451) {
                return $this->setMessage('Data masih terpakai di Data Lain!')
                            ->setCode($exception->getCode());
            }
        }

        // Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            if (request()->expectsJson()) {
                return $this->setMessage('Data tidak ditemukan!')
                            ->setCode(404);
            }
        }

        // Debuging
        if (config('app.debug')) {
            $message = (object) [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace()
            ];
            return $this->setMessage($exception->getMessage())
                        ->setError($message)
                        ->setCode($exception->getCode());
        }

        // Default
        return $this->setMessage($message)
                    ->setCode($exception->getCode());
    }
}
