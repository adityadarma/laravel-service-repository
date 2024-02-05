# Service and Repository pattern for laravel!

## Requirement

- Minimum PHP ^8.0
- Laravel ^9.x

## Installation

You can install the package via composer for latest version
```bash
$ composer require adityadarma/laravel-service-repository
```

Install the base service part of core base service:

```bash
php artisan service-repository:install
```


## Usage

### *Service

#### Create service

```bash
php artisan make:service nameService
```

#### Used on controller

```php
protected NameService $nameService;

public function __construct(
    NameService $nameService
)
{
    $this->nameService = $nameService;
}

public function data()
{
    $this->nameService->functionName()->getData();
}

public function json(Request $request)
{
    $this->nameService->functionName()->toJson();
}

public function withResource(Request $request)
{
    $this->nameService->functionName()->resource(ClassResource::class)->toJson();
}
```

#### Use Service & Exception

Every all exception, must have handle to class CustomException

```php
public function nameMethod()
{
    try {
         .........
         if (false) {
            throw new CustomException('Error exception');
         }
        ..........
        return $this->setData($data)
            ->setMessage('Message data')
            ->setCode(200)
    } catch (Exception $e) {
        return $this->exceptionResponse($e);
    }
}
```

### *Repository

#### Create repository

```bash
php artisan make:repository nameRepository --model
```

- **--model** will create repository with construct model

You can use general function on trait "GeneralFunctionRepository".

#### Used on service

```php
protected NameRepository $nameRepository;

public function __construct(
    NameRepository $nameRepository
)
{
    $this->nameRepository = $nameRepository;
}

public function data()
{
    $this->nameRepository->functionName();
}
```

### *Request

```bash
php artisan make:request nameRequest --single
```

- **--single** will make all method to single file request (store, update, delete)

Command request is customed, have failedValidation to consistant API response.
I also added an argument, so that we can carry out validation in one FormRequest file. Add function messages to custom response attribute message

### *Model

```bash
php artisan make:model name --trait --repository
```

- **--trait** will file trait to use on model like accessor, mutator, relationship and scope
- **--repository** will create file repository with construct model

Command model is customed, we add 2 argument type. You can separate it into traits (accessor, mutator, relationship and scope) and add file repository.

## License

Laravel-logger is licensed under the MIT license. Enjoy!