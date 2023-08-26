<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSwaggerDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate a current swagger api documentation';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $sources = config('swagger.sources');

        foreach ($sources as $version => $source) {
            $openapi = \OpenApi\Generator::scan([$source]);
            file_put_contents(public_path("api/{$version}/docs/swagger.json"), $openapi->toJson());
            $this->info("Documentation for api {$version} generated.");
        }

        return static::SUCCESS;
    }
}