## Petshop Coding Test

## Commands

### Resetting the application
The command artisan `app:reset` will restart your application when executed. This command is set to run every midnight UTC. If you are running it locally, you can add the following code to your crontab.
```
* * * * * {path to php}/php {path to application}/artisan schedule:run >> /dev/null 2>&1
```

### Generate Swagger Doc
```
artisan swagger:generate
```

### Composer console commands
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