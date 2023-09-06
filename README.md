# PetShop Coding Test
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/peteleco/petshop/test.yml?branch=main&label=tests&style=flat-square)](https://github.com/peteleco/petshop/actions?query=workflow%3Atests+branch%3Amain)
Welcome to the PetShop Coding Test repository. This project serves as a PHP developer test for Buckhill.

## What was done
### Implemented endpoints
- /v1/admin/create
- /v1/admin/login
  - with jwt and asymmetric keys
- /v1/admin/user-listing
  - All filters are implemented and must pass validation if filled
  - Pagination is implemented
  - A dynamic filter was implemented,  if the property in the request is valid the filter builder will look for ->filterBy{property} method in the User builder class
- /api/swagger
  - Route with swagger endpoints

## Implementations
### JWT Authentication
The api authentication was implemented using the package https://github.com/lcobucci/jwt.
### Containers
- For this project was used docker-compose
- For the notifier package just docker
### Notifier Package
The Notifier package has been successfully installed, and you can confirm its integration by observing its functionality during testing.
### Seeds
 - Admin
 - Users
 -  Payment and OrderStatus to test the Notifier package effectively
### Commands
You can find the complete list of commands at the of this doc, but there are two primary commands:
- `artisan app:reset` : This command is used to reset the database and is scheduled for regular execution.
- `artisan swagger:generate` This command generate the swagger json file
### Swagger
Implemented using #Annotations
### Static & insights
Implemented using psr-12 and phpstan. 
Insights
- Code: 100 % 
- Complexity: 88.7%
- Architecture: 93.8%
- Style: 100 %
### Middlewares
Two middlewares were created:
- EnforceJson, to avoid errors when you forget to set the "accept" JSON header
- EnsureUserAdmin, to protect routes that only admins should access
### Data Objects
This app uses DataObjects instead of Laravel Request/Resource, making it easier to use static types.
### Filter Builder
- *filterBy{**property**}* means it filters by any condition.
- _findBy{**property**}_ means it finds by a specific condition.
- A search prefix means it will return a collection.
```php
    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByEmail(string $email): self
    {
        $this->where('email', 'like', '%' . $email . '%');
        return $this;
    }
    
    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function findByEmail(string $email): self
    {
        $this->where('email', $email);
        return $this;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,TModelClass>
     */
    public function searchByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->findByEmail($email)->get();
    }
```
### Testing
I'm using PEST PHP for testing, and if you want to see all tests running without running locally, just check the [GitHub actions page](https://github.com/peteleco/petshop/actions).
````shell
artisan test
````

## Setup
This application requires PHP, MySQL, Nginx, or Apache to run.

#### Install Dependencies
```
composer install
# If you want to play with swagger
npm run install
npm run build
```
### Docker
This is a basic setup to open the Swagger URL.
````shell
# initialize the service
docker-compose up -d

# i comment the line 37 on Dockerfile to avoid update in my local because i'm using valet for development
# install the depencies if you forget to uncomment the line 37
docker-compose exec app composer install

# run migration and seed
docker-compose exec app php /var/www/html/artisan app:reset

# Running tests
docker-compose exec app php artisan test

# Updating swagger
docker-compose exec app php artisan swagger:generate

# JWT KEYS
# the path for then is /var/www/html/jwt_keys
````
#### Accessing swagger API
http://localhost:8888/api/swagger
Don't forget to change the server to localhost

#### JWT configuration
You must create your PEM keys and add the environment variables to your .env file or use the test keys.
```
JWT_PRIVATE_KEY=/fullpath/jwt_keys/test_private_001.pem
JWT_PUBLIC_KEY=/fullpath/jwt_keys/test_public_01.pem
JWT_PASSPHRASE=petshop
```
#### Creating your keys
mkdir jwt_keys
openssl genrsa -out private_01.pem -aes256 4096
openssl rsa -pubout -in private_01.pem -out public_01.pem
openssl rsa -in private_01.pem -out private_001.pem

### Commands

#### Resetting the application
The `artisan app:reset` command will restart your application when executed. This command is set to run every midnight UTC. If you are running it locally, you can add the following code to your crontab.
In the docker machine this command is used by supervisor.
```
* * * * * {path to php}/php {path to application}/artisan schedule:run >> /dev/null 2>&1
```

#### Generate Swagger Doc
```
artisan swagger:generate
```

#### Composer console commands
Run all analyses
```shell
composer analyse
```
Run static analysis with [Larastan](https://github.com/nunomaduro/larastan)
```shell
composer analyse:static
```
Run insights with [PHP Insights](https://github.com/nunomaduro/phpinsights)
```shell
composer analyse:insights
```
Run style fixer [Laravel PINT](https://github.com/laravel/pint)
```shell
composer style:fix
```

### Packages
- [PEST](https://github.com/pestphp/pest)
- [Larastan](https://github.com/nunomaduro/larastan)
- [PHP Insights](https://github.com/nunomaduro/phpinsights)
- [Laravel PINT](https://github.com/laravel/pint)
- [Swagger PHP](https://github.com/zircote/swagger-php)
- [Swagger UI](https://github.com/swagger-api/swagger-ui)
- [Laravel Data](https://github.com/spatie/laravel-data)
- [JSON Web Token](https://github.com/lcobucci/jwt)
- [Laravel Test Assertions](https://github.com/jasonmccreary/laravel-test-assertions)
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
- [Notification service](https://github.com/peteleco/notifier)
-  [Pest Plugin Snapshots](https://github.com/spatie/pest-plugin-snapshots)
-  [PHP UNIT Snapshot](https://github.com/spatie/phpunit-snapshot-assertions)