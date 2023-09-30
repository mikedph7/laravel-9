<p align="center"><a href="https://autoklose.com" target="_blank"><img src="https://app.autoklose.com/images/svg/autoklose-logo-white.svg" width="400"></a></p>

## Instructions
The repository for the assignment is public and Github does not allow the creation of private forks for public repositories.

The correct way of creating a private fork by duplicating the repo is documented here.

**Install/Run app:**
- clone repo -> **git clone git@github.com:mikedph7/laravel-9.git**
- run on app dir -> **composer install**
- create databases namely '**forge**' and '**testing**'
- run on app dir -> **php artisan migrate**
- run on app dir -> **php artisan db:seed** (for our single user)
- get bearer token by running on app dir -> **php artisan token:generate 1** (save the token to be used as auth for send mail endpoint)
- run job queue -> **php artisan horizon**
- run unit test -> **./vendor/bin/phpunit**
  
**Requirements:**
- Elasticsearch
- Redis

**Endpoints**
- Send Email: /api/{user_name}/send POST
- Get List: /api/list GET
