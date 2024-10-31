<?php

namespace SchemaGen\Commands;

use Illuminate\Console\Command;
use SchemaGen\Parser;
use SchemaGen\CodeGenerator;

class GenerateCodeCommand extends Command
{
    protected $signature = 'generate:code {schema}';
    protected $description = 'Generate code from schema file';

    public function handle()
    {
        $schemaFile = $this->argument('schema');

        if (!file_exists($schemaFile)) {
            $this->error("Schema file not found: $schemaFile");
            return;
        }

        $schemaContent = file_get_contents($schemaFile);
        $parser = new Parser();
        $models = $parser->parse($schemaContent);

        $generator = new CodeGenerator();

        foreach ($models as $model) {
            $this->generateModelFiles($model, $generator);
        }
    }

    protected function generateModelFiles($model, $generator)
    {
        if ($model['type'] === 'model') {
            $modelContent = $generator->generateModel(['model' => $model]);
            file_put_contents('app/Models/' . $model['name'] . '.php', $modelContent);
            $this->info("Generated model: " . $model['name']);

            $migrationContent = $generator->generateMigration(['model' => $model]);
            $timestamp = date('Y_m_d_His');
            file_put_contents("database/migrations/{$timestamp}_create_" . strtolower($model['name']) . "_table.php", $migrationContent);
            $this->info("Generated migration: " . $model['name']);
        } elseif ($model['type'] === 'component') {
            $componentContent = $generator->generateComponent(['component' => $model]);
            file_put_contents('resources/js/components/' . $model['name'] . '.vue', $componentContent);
            $this->info("Generated component: " . $model['name']);
        }
    }
}
