## PetShop Coding Test
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/peteleco/petshop/test.yml?branch=main&label=tests&style=flat-square)](https://github.com/peteleco/petshop/actions?query=workflow%3Atests+branch%3Amain)

## Setup
This application requires PHP, MySql, Nginx or Apache  to run.

#### Install Dependencies
```
composer install
# If you want to play with swagger
npm run install
npm run build
```

#### JWT configuration
You must create your pem keys and add the env var on your .env file
```
JWT_PRIVATE_KEY=/fullpath/jwt_keys/private_001.pem
JWT_PUBLIC_KEY=/fullpath/jwt_keys/public_01.pem
JWT_PASSPHRASE=petshop
```
#### Creating your keys
mkdir jwt_keys
openssl genrsa -out private_01.pem -aes256 4096
openssl rsa -pubout -in private_01.pem -out public_01.pem
openssl rsa -in private_01.pem -out private_001.pem



## Implemented endpoints 
- /v1/admin/create
- /v1/admin/login
  - with jwt and asymmetric keys 
- /v1/admin/user-listing
  - All filters were implemented, if filled must pass in validation
  - Pagination implemented
  - A dynamic filter was implemented,  if the property in the request is valid the filter builder will look for ->filterBy{property} method in the User builder class
- /api/swagger
  - Route with swagger endpoints
  
## Implementations
### Notifier Package 
The notifier package is installed you can see the integration working through the test
### Middlewares
two middleware were created
- EnforceJson, to avoid error when you forgot to set "accept" json header
- EnsureUserAdmin, to protect routes that only admin should access
### Data Objects
This app is using DataObjects instead of laravel Request/Resource this way is easier to use static types.  
### Filter Builder
- filterBy{property} means its filter by any condition
- findBy{property} means its finding by a specific condition
- search prefix means will return an collection
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

I'm using PEST PHP to test, and with you want to see all tests performing without running locally just check the [GitHub actions page](https://github.com/peteleco/petshop/actions).
````shell
artisan test
````

### Commands

#### Resetting the application
The command artisan `app:reset` will restart your application when executed. This command is set to run every midnight UTC. If you are running it locally, you can add the following code to your crontab.
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