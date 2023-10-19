# Service and Repository pattern for laravel!

## Requirement

- Minimum PHP ^8.0

## Installation

You can install the package via composer for latest version
```bash
$ composer require adityadarma/laravel-service-repository
```

Install the base service and trait handle error:

```bash
php artisan service-repository:install
```

# TEST
"repositories": {
    "dev-package": {
        "type": "path",
        "url": "packages/adityadarma/laravel-database-logging",
        "options": {
            "symlink": true
        }
    }
},
"minimum-stability": "dev",
