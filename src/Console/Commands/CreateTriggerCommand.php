<?php

namespace Triggers\Console\Commands\CreateTriggerCommand;


use Illuminate\Console\Command;

class CreateTriggerCommand extends Command
{
    protected $signature = 'trigger:create {table} {event} {name} {--when= : Trigger condition}';

    protected $description = 'Create a MySQL trigger';

    public function handle()
    {
        $table = $this->argument('table');
        $event = $this->argument('event');
        $name = $this->argument('name');
        $when = $this->option('when');

        $timestamp = date('Y_m_d_His');
        $filename = $timestamp . '_' . $name . '_' . $event . '.php';

        $stub = file_get_contents(__DIR__ . '/stubs/trigger.stub');

        $stub = str_replace(
            ['{{trigger_table}}', '{{trigger_event}}', '{{trigger_name}}', '{{trigger_when}}'],
            [$table, $event, $name, $when],
            $stub
        );

        $path = database_path('triggers');

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents($path . '/' . $filename, $stub);

        $this->info('Trigger created successfully!');
    }
}
