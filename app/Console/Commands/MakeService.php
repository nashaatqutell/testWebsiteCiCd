<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    protected $signature = 'make:service {name} {model}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $model = ucfirst($this->argument('model'));
        $modelNamespace = "App\\Models\\$model\\$model";
        $requestNamespace = "App\\Http\\Requests\\Dashboard\\$model\\";
        $path = app_path("Service/{$name}.php");

        if (file_exists($path)) {
            $this->error("Service {$name} already exists!");
            return false;
        }

        (new Filesystem)->ensureDirectoryExists(app_path('Services'));

        $stub = <<<EOT
        <?php

        namespace App\Service;

        use {$modelNamespace};
        use {$requestNamespace}Store{$model}Request;
        use {$requestNamespace}Update{$model}Request;

        class {$name}
        {
            public function index()
            {
                return {$model}::query()->latest()->paginate();
            }

            public function list():\Illuminate\Database\Eloquent\Collection
            {
                return {$model}::query()->latest()->get();
            }

            public function show({$model} \${$model}) : {$model}
            {
                return \${$model};
            }

            public function store(Store{$model}Request \$request) : {$model}
            {
                \${$model} = {$model}::query()->create(\$request->validated());
                \${$model}->storeImages(media: \$request->image);
                return \${$model};
            }

            public function update(Update{$model}Request \$request, {$model} \${$model}) : {$model}
            {
                \${$model}->update(\$request->validated());
                \${$model}->storeImages(media: \$request->image, update: true);
                return \${$model};
            }

            public function destroy({$model} \${$model}) : void
            {
                \${$model}->deleteMedia();
                \${$model}->delete();
            }

            public function changeStatus({$model} \${$model}) : {$model}
            {
                \${$model}->toggleActivation();
                return \${$model};
            }
        }
        EOT;

        // Create the service file
        file_put_contents($path, $stub);

        $this->info("Service {$name} created successfully.");
    }
}
