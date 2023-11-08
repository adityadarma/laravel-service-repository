# Service and Repository pattern for laravel!

## Requirement

- Minimum PHP ^8.0

## Installation

You can install the package via composer for latest version
```bash
$ composer require adityadarma/laravel-service-repository
```

Install the base service part of core base service:

```bash
php artisan service-repository:install
```


### Usage

##### Service

```php
php artisan make:service
```

##### Repository

```php
php artisan make:repository name --model
```
- --model will create repository with construct model

##### Request

```php
php artisan make:request name --single
```

- --single will make all method to single file request (store, update, delete)

##### Model

```php
php artisan make:model --trait --repository
```

- --trait will file trait to use on model like accessor, mutator, relationship and scope
- --repository will create file repository with construct model